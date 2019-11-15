<?php
// $servername = '127.0.0.1';
// $username = 'root';
// $password = '';
// $dbname = 'quizDB';

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// //$conn = new mysqli('localhost', 'root', '', 'quizDB');
require_once('mySQLDataMapper.php');
require_once('config.php');
require_once('functions.php');
require_once('classes.php');

 // $conn = mysql_connect(DBHOST, DBUSER, DBPASS) or die('Could not connect to database server.');
 // mysql_select_db(DBNAME) or die('Could not select database.');

//DBHOST, DBUSER, DBPASS, DBNAME
//getting connection:
$connVar = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);
// reading the datatable and displaying:
// readTable("tabQuestions",$connVar);
$listOfAllQ = [];
$listOfAllQ = getAllQuestions("tabQuestions",$connVar);
foreach ($listOfAllQ as $question) {
  // code...
  $text = $question->get_qTxt();
  echo 'ID: '.$question->get_qId().' - Text: '.$text.' isAnswered: '.$question->get_qIsAnswered().'<br>';
  $answersList = $question->get_listAnswers();
  foreach ($answersList as $answer) {
    echo '&nbsp;'.'Answer: '.$answer->get_ansId().' - Text: '.$answer->get_ansTxt().' isValid: '.$answer->get_ansIsValid().'<br>';
  }
  echo '<br>';
}




function getAllQuestions($table, $connStr)
{
    $sql = "SELECT qId, qTxt, qIsTaken, qIsAnswered FROM ".$table;
    $result = $connStr->query($sql);
      if ($result->num_rows > 0) {
        $listQuestions = [];
            while($row = $result->fetch_assoc()) {
              //$listQuestions[] = new Question();
              $nextQuestion = new Question();
                $nextQuestion->qId = $row["qId"];
                $nextQuestion->qTxt = $row["qTxt"];
                $nextQuestion->qIsTaken = $row["qIsTaken"];
                $nextQuestion->qIsAnswered = $row["qIsAnswered"];

                //$sql = "SELECT ansId, ansTxt, ansQId, ansIsValid FROM tabanswers WHERE ansQId=".$row["qId"];
                //echo "Object: ".$nextQuestion->get_qTxt();

                //SELECT `ansId`, `ansTxt`, `ansQId`, `ansIsValid` FROM `tabanswers` WHERE 1
                $sql = "SELECT ansId, ansTxt, ansQId, ansIsValid FROM tabanswers WHERE ansQId=".$row["qId"];
                $resultAns = $connStr->query($sql);
                  if ($resultAns->num_rows > 0) {
                    $listAnswers = [];
                    while($rowAns = $resultAns->fetch_assoc()) {
                        $nextAns = new Answer();
                          $nextAns->ansId = $rowAns["ansId"];
                          $nextAns->ansTxt = $rowAns["ansTxt"];
                          $nextAns->ansQId = $rowAns["ansQId"];
                          $nextAns->ansIsValid = $rowAns["ansIsValid"];
                        $listAnswers[] = $nextAns;
                    }
                  }
              $nextQuestion->listAnswers = $listAnswers;
              $listQuestions[] = $nextQuestion;

          }

      } else {
          echo "0 results";
      }
      return $listQuestions;
}

// // Functions ============================
//
// function createConnection($dBHOST, $dBUSER, $dBPASS, $dBNAME) {
//   // Create connection
//   $conn = new mysqli($dBHOST, $dBUSER, $dBPASS, $dBNAME);
//   // Check connection
//   if ($conn->connect_error) {
//       die("Connection failed: " . $conn->connect_error);
//       return null;
//   }
//   return $conn;
// }
//
// function readTable($tableName, $connStr) {
//   //$sql = "SELECT qId, qTxt, qIsTaken, qIsAnswered FROM tabQuestions";
//   $sql = "SELECT qId, qTxt, qIsTaken, qIsAnswered FROM ".$tableName;
//   $result = $connStr->query($sql);
//     if ($result->num_rows > 0) {
//         // output data of each row
//           while($row = $result->fetch_assoc()) {
//               echo "  ----- <br>". "Question id: " . $row["qId"]. " - QText: " .
//               $row["qTxt"]. " - IsTaken: " . $row["qIsTaken"].
//               " - IsAnswered: " . $row["qIsAnswered"]."<br>";
//               //SELECT `ansId`, `ansTxt`, `ansQId`, `ansIsValid` FROM `tabanswers` WHERE 1
//               $sql = "SELECT ansId, ansTxt, ansQId, ansIsValid FROM tabanswers WHERE ansQId=".$row["qId"];
//               $resultAns = $connStr->query($sql);
//                 if ($resultAns->num_rows > 0) {
//                   while($rowAns = $resultAns->fetch_assoc()) {
//                       echo "  -->  Answer id: " . $rowAns["ansId"]. " Text: ". $rowAns["ansTxt"]."<br>";
//                   }
//                 }
//
//         }
//     } else {
//         echo "0 results";
//     }
// }

$connVar->close();

// require_once('config.php');

 // $conn = mysql_connect(DBHOST, DBUSER, DBPASS) or die('Could not connect to database server.');
 // mysql_select_db(DBNAME) or die('Could not select database.');

// Create connection
// $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
//
?>
