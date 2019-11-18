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

// http://php.net/manual/en/function.json-decode.php
$resultSet = json_decode( $jsondata, true ); // 2nd arg true to convert objects to associative arrays
$isFinished = 0;
$isFinishedTxt = 'No';
if ($resultSet[0]['isFinished'] > 0) {
  // code...
  $isFinished = 1;
  $isFinishedTxt = 'Yes';
}
// more info at http://www.dyn-web.com/tutorials/php-js/json/decode.php
echo 'Your score: '.$resultSet[0]['correctCount'].
      '; <br>User Name: '.$resultSet[0]['user'].
      '; <br>Finished?: '.$isFinishedTxt;


//$connVar = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);
//$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// SELECT `uId`, `uIUN`, `uFName`, `uLName`, `uRetryCount`, `uTimer`, `uTotalScore`, `uIsFinished` FROM `tabUsers` WHERE 1

$userIUN = $resultSet[0]['user']; //uIUN,
$userFName = $resultSet[0]['user'];//uFName,
$userLName = $resultSet[0]['user']; //uLName,

$timeElapsed = $resultSet[0]['elapsedTime']; // uTimer,
$scoreTotal = $resultSet[0]['correctCount']; //uTotalScore,
//$isFinished = 1; //uIsFinished
$reultsCount = getUserRetriesCountFromDB($userIUN);
echo '<br>Previous results count: '.$reultsCount;
$retyCount = $reultsCount + 1; //uRetryCount,

$timeStarted = $resultSet[0]['timestart']; // date+time when started. text,
$timeFinish = $resultSet[0]['timefinish']; // date+time when finished. text,
$listOfQuestions = $resultSet[0]['listofquestions']; //listofquestions
$comments = $resultSet[0]['comments']; //Comments goes here

// Create connection
//$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO tabusers (uIUN, uFName, uLName, uRetryCount, uTimer, uTotalScore, uIsFinished, timestart, timefinish, listofquestions, comment)
VALUES ('$userIUN', '$userFName', '$userLName', $retyCount, $timeElapsed, $scoreTotal, $isFinished, '$timeStarted', '$timeFinish', '$listOfQuestions', '$comments')";

if (mysqli_query($conn, $sql)) {
    //echo "<br> New record created successfully <br>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>
