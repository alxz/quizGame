<?php
require_once('config.php');
require_once('functions.php');
//<form method="post" action="showDBcont.php">

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>To review the table(s) data</title>
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
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

<h1>Show the content of a mySQL DB
<a href="../../index.php" id="link" style="color: #FFFF00">... back to HOME</a></h1>
<div>
  <div>
    <p>Please select a table name to display: &nbsp;&nbsp;&nbsp;
    <select name="tabsFromDB" id="tabsFromDB" onchange="SubmitForm('');">
      <?php echo displayAllTAbles(); ?>
    </select>
    </p>
    <p>Selected name: &nbsp;<input type="text" id="tabName" value="tabquestions" name="tabName" /></p>
  </div>
  <div id="dbShow">
  </div>
</div>
<button type="submit" value="Submit Request" name="submit">Submit Request</button>
&nbsp; &nbsp; &nbsp;
<button onclick="history.go(-1);">Back </button>
</form>
</body>
</html>

<?php
//echo displayAllTAbles(); //displayAllTAbles - to place a selection of tables
function display()
{
  $outVar = "<br>";
    $tabName = $_POST['tabName'];
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
    //echo $outVar;
?>
        <script type="text/JavaScript">
          var toDisplay = '<?php echo $outVar ?>';
          var resultsContainer = document.getElementById("dbShow");
          resultsContainer.innerHTML = `${toDisplay}`;

          var selectedValue = document.getElementById('tabsFromDB').value;
          //alert ('selected: '+selectedValue);
          resultsContainer = document.getElementById('tabName');
          resultsContainer.value = `${selectedValue}`;

          function SubmitForm(formId) {
              //var oForm = document.getElementById(formId);
              //tabName
              var resultsContainer = document.getElementById('tabName');
              var selectedValue = document.getElementById('tabsFromDB').value;
              resultsContainer.value = `${selectedValue}`;
              // if (oForm) {
              //     oForm.submit();
              // }
              // else {
              //     alert("DEBUG - could not find element " + formId);
              // }
          }
        </script>
<?php
}
if(isset($_POST['submit']))
{
  display();

}
// if(isset($_POST['tabsFromDB'])) {
//   $selectionMade = $_POST['tabsFromDB'];
//   echo $selectionMade;
// }
?>
