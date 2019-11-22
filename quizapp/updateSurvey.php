<?php
// require_once('config.php');
//
// $servername = DBHOST;
// $username = DBUSER;
// $password = DBPASS;
// $dbname = DBNAME;
require_once('functions.php');
require_once('classes.php');
require_once('config.php');

/*
DB TABLES STRUCTURE:
SELECT `uId`, `uIUN`, `uFName`, `uLName`, `uRetryCount`, `uTimer`,
  `uTotalScore`, `uIsFinished`, `timestart`, `timefinish`, `listofquestions`,
  `comment` FROM `tabusers`
*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quizdb";
// how to access data sent using JSON
$jsondata = file_get_contents("php://input");
/*\\\\\\\\\\\\\\\
    surveyData = [
     {
       userIun: userIUN,
       stars: starsCount,
       comments: commentsStr,
       sessionId : sessionID
     }
    ];
\\\\\\\\\\\\\\\*/

// http://php.net/manual/en/function.json-decode.php
$resultSet = json_decode( $jsondata, true ); // 2nd arg true to convert objects to associative arrays
echo " Starting update Survey! <br>";
if ($resultSet[0]['sessionId'] == "") {
  $sessionId = "Unknown Session ID";
} else {
  $sessionId = $resultSet[0]['sessionId']; // Current Session ID
}
//$connVar = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);
//$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// SELECT `uId`, `uIUN`, `uFName`, `uLName`, `uRetryCount`, `uTimer`, `uTotalScore`, `uIsFinished` FROM `tabUsers` WHERE 1
echo " SeesionID: ".$sessionId."<br>";
echo " alert('sessionId is: '+".$sessionId.");";
$userIUN = $resultSet[0]['userIun']; //uIUN,
$userFName = $resultSet[0]['userIun'];//uFName,
$userLName = $resultSet[0]['userIun']; //uLName,
$starsCount = $resultSet[0]['stars']; //stars count
$comments = $resultSet[0]['comments']; //Comments goes here
$comments = "1)Stars: " . $starsCount. " ; " . $comments;
// Create connection
//$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "Update tabusers SET comment = '$comments' WHERE sessionid = '$sessionId'";

if (mysqli_query($conn, $sql)) {
    echo "<br> New record created successfully <br>";
    echo " alert('New record created successfully!');";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    echo " alert('Error is: '+".mysqli_error($conn).");";
}

mysqli_close($conn);
?>
