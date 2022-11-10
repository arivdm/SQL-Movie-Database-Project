<!DOCTYPE html>
<html lang="English">

<head><title> The Netflix Info Website</title>

</head>





<body style="background-color: lightseagreen">

<h1 style="text-align: center">Welcome to Netflix Info!</h1>
<p style="text-align: center">Are you a movie buff? This site is just for you! It has
    all the information you could ever want on all your favourite movies! <br>
</p>
<style>
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<p style="text-align: center"> <img src="https://media.netflix.com/dist/img/meta-image-netflix-symbol-black.png" width="1000" height="350" alt="Problem Uploading Image" ></p>

<p style="text-align: center">

    <a href="AddMovieFile.php">Movie File Uploader!</a><br>
    <a href="AddMovie.php">Add Your Movie Here!</a><br>


</p>
<p style="text-align: center">All your favourite non-American,single director
    & longest movies by year in descending order: <br>
<?php

// Connecting to the database
$server = "tcp:techniondbcourse01.database.windows.net,1433";
$user = "van0ari";
$pass = "Qwerty12!";
$database = "van0ari";
    $c = array("Database" => $database, "UID" => $user, "PWD" => $pass);
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($server, $c);
    if($conn === false)
    {
        echo "error";
        die(print_r(sqlsrv_errors(), true));
    }
	//echo "connected to DB"; //debug
     // In case of success

echo "<center>";
echo "<table border=\"2\">";
echo "<tr><th>Year</th><th>Title</th><th>Duration</th></tr>";


$query = "
SELECT N.release_year, N.title,N.duration
FROM Netflix N
WHERE N.country NOT LIKE ('%United States%') AND N.director NOT LIKE ('%,%')

  AND N.title NOT IN (SELECT N2.title
                      FROM Netflix N2, Netflix N3
                      WHERE (N3.title != N2.title AND N3.duration > N2.duration
                          AND N2.release_year = N3.release_year)
                        AND  N3.country NOT LIKE ('%United States%') AND N2.country NOT LIKE ('%United States%')
                        AND N3.director NOT LIKE ('%,%')AND N2.director NOT LIKE ('%,%'))

GROUP BY N.release_year, N.title, N.duration
ORDER BY N.release_year DESC ";

$result=sqlsrv_query($conn,$query);
$var=0;
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
{
    $Release_Year=$row['release_year'];
    $Title = $row['title'];
    $Duration = $row['duration'];
    echo "<tr><td>$Release_Year</td><td>$Title</td><td>$Duration</td></tr>";


}
echo "</table>"

?>

</body>
</html>