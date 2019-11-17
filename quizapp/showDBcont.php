<?php
require_once('config.php');
require_once('functions.php');


echo '<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Simple JavaScript Quiz (ES6) V4 (Stylized)</title>
  <link rel="stylesheet" href="./style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
  <script src="jquery-3.4.1.min.js"></script>
</head>
<style>
.data-table{
	border: 1px solid black;
	margin: 20px;
	padding: 20px;
}
table {
  border-collapse: collapse;
  width: 90%;
}
th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
</style>
<body>
<form method="post" action="showDBcont.php">
<h1>Show the content of a mySQL DB
<a href="../../index.php" id="link" style="color: #FFFF00">... back to HOME</a>
&nbsp;&nbsp;&nbsp; <a href="./showJS.php" id="link" style="color: #FFFF00">Back To The Game</a></h1>
</h1>
<p>Please enter quizDB table name: &nbsp;<input type="text" id="tabName" value="tabquestions" name="tabName" /></p>
<input type="submit" name="showdb" value="Show DB Tables">
<input type="submit" name="submit" value="View Table">
<div>
  <div id="dbShow"></div>
</div>
</form>
<br><br>
</body>
</html>';

function display()
{
  $outVar = "";

    //$outVar = "Display: ".$_POST['tabName'];
    $tabName = $_POST['tabName'];
    $conn = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);
    //$link = mysql_connect("sql2.njit.edu", "username", "password");

    // Check connection
    if ($conn->connect_error) {
        die("Connection with the database failed: </br>" . $conn->connect_error);
    }

    if($result = $conn->query('SHOW TABLES')){
      while($row = $result->fetch_array()){
        $tables[] = $row[0];
      }
    }

    $outVar = $outVar .'Current Tables: <br>';
    foreach($tables as $key => $value) {
      // code...
        $outVar = $outVar . $value.'<br>';
    }
    echo $outVar;
    //$outVar
    //create connection
    //$connection = mysqli_connect($host, $user, $pass, $db_name);
    $connection = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);

    //test if connection failed
    if(mysqli_connect_errno()){
        die("connection failed: "
            . mysqli_connect_error()
            . " (" . mysqli_connect_errno()
            . ")");
    }
    //echo '<br> ... still alive<br>';
    //get results from database
    $query = "SELECT * FROM ".$tabName;
    $result = mysqli_query($connection,$query);
    $run = $connection->query($query) or die("Last error: {$connection->error}\n");
    $all_property = array();  //declare an array for saving property
    //echo '<br> ... still alive<br>';
    //showing property
    echo '<br><table class="data-table" ><tr class="data-heading">';  //initialize table tag
    while ($property = mysqli_fetch_field($result)) {
        echo '<td>' . $property->name . '</td>';  //get field name for header
        array_push($all_property, $property->name);  //save those to array
    }
    echo '</tr>'; //end tr tag

    //showing all data
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        foreach ($all_property as $item) {
            echo '<td>' . $row[$item] . '</td>'; //get items using property value
        }
        echo '</tr>';
    }
    echo "</table>";

}

// function showTables() {
//   $outVar = displayAllTAbles();
//   echo "<br> outVar: <br>".$outVar;
//   //tabsFromDB - is select name;
// }
?>
        <script type="text/JavaScript">
          var toDisplay = '<?php echo $outVar ?>';
          const resultsContainer = document.getElementById("dbShow");
          resultsContainer.innerHTML = `${toDisplay}`;
        </script>

<?php

if(isset($_POST['submit']))
{
   display();
}
if(isset($_POST['showdb']))
{
  $outVar = displayAllTAbles();
  echo "<br> outVar: <br>".$outVar;
?>
  <script type="text/JavaScript">
    var toDisplay = '<?php echo $outVar ?>';
    const resultsContainer = document.getElementById("dbShow");
    resultsContainer.innerHTML = `${toDisplay}`;
  </script>
<?php
};
?>
<?php
function displayThisTable ($tableToDisplay) {
  $outputStr = "";
    //create connection
    //$connection = mysqli_connect($host, $user, $pass, $db_name);
    $connection = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);
    //test if connection failed
    if(mysqli_connect_errno()){
        die("connection failed: "
            . mysqli_connect_error()
            . " (" . mysqli_connect_errno()
            . ")");
    }
    //echo '<br> ... still alive<br>';
    //get results from database
    $query = "SELECT * FROM ".$tableToDisplay;
    $result = mysqli_query($connection,$query);
    $run = $connection->query($query) or die("Last error: {$connection->error}\n");
    $all_property = array();  //declare an array for saving property
    //echo '<br> ... still alive<br>';
    //showing property
    $outputStr = '<table class="data-table" ><tr class="data-heading">';  //initialize table tag
    $outTempStr = "";
    while ($property = mysqli_fetch_field($result)) {
        $outTempStr += '<td>' . $property->name . '</td>';  //get field name for header
        array_push($all_property, $property->name);  //save those to array
    }
    $outputStr += $outTempStr + '</tr>'; //end tr tag
    $outRowStr = "";
    //showing all data
    while ($row = mysqli_fetch_array($result)) {
        $outRowStr +=  "<tr>";
        $outItemStr = "";
        foreach ($all_property as $item) {
            $outItemStr +=  '<td>' . $row[$item] . '</td>'; //get items using property value
        }
        $outRowStr +=  $outItemStr + '</tr>';
    }
    $outputStr +=  $outRowStr + "</table>";
}
 ?>
