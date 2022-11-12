<!DOCTYPE html>
<html lang="en">
<head><title>Add new movie!</title></head>
<link rel="stylesheet" type="text/css" href="style1.css">



<body>

   <form name="Application_Form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

       <div class="banner">
           <h1>New Movie</h1>
       </div>

       <div class="item"> Title:<span>*</span>           <input type="text"   name="title"     title="title" required></div>
       <div class="item"> Director:<span>*</span>        <input type="text"   name="director"  title="director" required></div>
       <div class="item"> Cast:                          <input type="text"   name="cast"      title="cast" ></div>
       <div class="item"> Country:<span>*</span>         <input type="text"   name="country"   title="country"  required></div>
       <div class="item"> Release Year:                  <input type="number" name="release_Year" min="1900" max="2020" step="1" title="release_Year"></div>
       <div class="item"> Listed In:                     <input type="text"   name="listed_In" title="listed_In"></div>
    <br>
    <br>

    <div class="container">
        Duration In Minutes

        <datalist id="tickmarks">

            <option>20</option>
            <option>40</option>
            <option>60</option>
            <option>80</option>
            <option>100</option>
            <option>120</option>
            <option>140</option>
            <option>160</option>
            <option>180</option>
            <option>200</option>
        </datalist>
        <output id="output" for="duration">20</output> <!-- Just to display selected value -->
    </div>

       <div class="btn-block">
    <button name="Send" type="submit">Send</button><br><br>
    <button name="reset" type="reset">Reset Page</button><br><br>
    <p> <a href="Index.php">Back to main page</a> </p>
       </div>

  </form>

<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["Name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["Name"]);
    }
}

if (isset($_POST["Send"])) {
    $server = "";
    $user = "";
    $pass = "";
    $database = "";
    $c = array("Database" => $database, "UID" => $user, "PWD" => $pass);
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($server, $c);

    if($conn === false)
    {
        echo "error";
        die(print_r(sqlsrv_errors(), true));
    }

    $Title=$_POST['title'];
    $Director=$_POST['director'];
    $Cast=$_POST['cast'];
    $Country=$_POST['country'];
    $Release_Year=$_POST['release_Year'];
    $Duration=$_POST['duration'];
    $Listed_In=$_POST['listed_In'];



    $sql = "SELECT count(*)
      FROM Netflix";

    $result=sqlsrv_query($conn,$sql);
    $row_count = sqlsrv_fetch_array( $result );
    $var =$row_count[0]++;


    $sql="INSERT INTO Netflix(title,director,cast,country,release_year,duration,listed_in) 
          VALUES ( '{$Title}' , '{$Director}' , '{$Cast}' , '{$Country}' , '{$Release_Year}',
                   '{$Duration}' , '{$Listed_In}')";
    $result=sqlsrv_query($conn,$sql);
    if ($result===false){

        echo "Something went wrong! Please check your information and try again<br>";

    }
    if ($result==true){

        echo "The Application was added to the database successfully.<br>";
    }
}

?>



</body>
</html>
