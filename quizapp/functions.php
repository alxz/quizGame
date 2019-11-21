<?php
require_once('classes.php');
// Functions ============================

function mazeStruc () {
  //$arrMaze = [];
  $arrMaze = array(
    0 => array ("0" => "1", "1" => "1", "2" => "1", "3" => "0"),
    1 => array ("0" => "1", "1" => "0", "2" => "1", "3" => "1"),
    2 => array ("0" => "1", "1" => "1", "2" => "0", "3" => "1"),
    3 => array ("0" => "0", "1" => "1", "2" => "1", "3" => "1")
  );
  return $arrMaze;
}

function mazeRoomsDoors ($arrMazeInit) {
  $arrRmsDrs = array();
  $idxRows = 0;
  $idxCols = 0;
  $upDoor = 0;
  $downDoor = 0;
  $leftDoor = 0;
  $rightDoor = 0;
  $colsCount = 0;
  $rowsCount = 0;
  foreach ($arrMazeInit as $key => $subArr) {
    //$idxRows showd be 0; $idxCols showld be 0
    $idxCols = 0;
    $arrCols = array();
    $colsCount = count($subArr);
    $rowsCount = count($arrMazeInit);
    //$key - is our rows index
    // echo 'key='.$key.' <br>';
    foreach ($subArr as $subKey => $subVal) {
      //$subKey - is our cols index
      // echo 'subKey='.$subKey.': ';
      //find the 'top' cell if empty or (1)?
      if ($key == 0) {
        $upDoor = 0;  // this is the first row so nothing above
        // echo 'U*; ';
      } elseif ($arrMazeInit[$key-1][$subKey] == 1) { ////check the row above:
          $upDoor = 1; //there is a room with a question above
          // echo 'U1; ';
      } else {
          $upDoor = 0; //the room above is empty
          // echo 'U0; ';
      }

      if ($subKey == 0) {
        $leftDoor = 0;  // this is the first row so nothing above
        // echo 'L*; ';
      } elseif ($arrMazeInit[$key][$subKey-1] == 1) { ////check the row above:
          $leftDoor = 1; //there is a room with a question above
          //echo 'L1; ';
      } else {
          $leftDoor = 0; //the room above is empty
        //  echo 'L0; ';
      }

      if ($subKey == $rowsCount-1) {
          $rightDoor = 0;  // this is the first row so nothing above
          //echo 'R*; ';
      } elseif ($arrMazeInit[$key][$subKey+1] == 1) { ////check the row above:
          $rightDoor = 1; //there is a room with a question above
          //echo 'R1; ';
      } else {
          $rightDoor = 0; //the room above is empty
          //echo 'R0; ';
      }

      if ($key == $colsCount-1) {
        $downDoor = 0;  // this is the first row so nothing above
      //  echo 'D*; ';
      } elseif ($arrMazeInit[$key+1][$subKey] == 1) { ////check the row above:
          $downDoor = 1; //there is a room with a question above
        //  echo 'D1; ';
      } else {
          $downDoor = 0; //the room above is empty
        //  echo 'D0; ';
      }
    //  $textStr = '[*'.$upDoor.'*] '.$leftDoor.'.:.'.$rightDoor.' [_'.$downDoor.'_]';
      //$arrCols[] = $textStr; //.'Size:'.$rowsCount; $downDoor

      if ($arrMazeInit[$key][$subKey]==0) {
        // if the current room is empty we don't use it at all:
        $arrCols[] = array( 'U' => 0, 'D' =>0, 'L' => 0, 'R' => 0);
      } else {
        $arrCols[] = array( 'U' => $upDoor, 'D' => $downDoor, 'L' => $leftDoor, 'R' => $rightDoor);
      }

      $idxCols++;
    }
    $arrRmsDrs[]= $arrCols;
    $idxRows++;
    //echo '<br>';
  }

  return $arrRmsDrs;
}

function mazeQuestionsArr($mazeInit,$listQuestions) {
    // we are building maze with questions based on the structure from $mazeInit
    $resultMaze = array();
    $roomsCount = 0;
    $jsonArr = json_decode($listQuestions);
    //print_r($listQuestions);
    //echo $jsonArr[0]->question;
    foreach ($jsonArr as $key => $value) {
      // // code...
      // echo '<br>key:'.$key." Q:".$jsonArr[$key]->question.'<br>';
      // echo '- '.$jsonArr[$key]->answers[0]->value.'<br>';
      // echo '- '.$jsonArr[$key]->answers[1]->value.'<br>';
      // echo '- '.$jsonArr[$key]->answers[2]->value.'<br>';
      // echo '- '.$jsonArr[$key]->answers[3]->value.'<br>';

      foreach ($value as $keyVal => $valueVal) {
        // code...
        //echo 'key: '.$key.' value: '.$valueVal.' and a $keyVal:'.$keyVal. ' <br>';
        //print_r($valueVal);
      }
      //echo 'key: '.$key.' value: '.$value["question"].' <br>';
      //echo "key/value: [$key -> $value]";
    }
    // echo '<br>';
    foreach ($mazeInit as $key => $value) {
      foreach ($value as $subKey => $subValue) {
        if ($subValue == '1') {
          $roomsCount++;
        }
      }
    }
  //  echo 'Debug: Number of Rooms with Questions; '.$roomsCount."<br>";
    $indexQ = 0;
    foreach ($mazeInit as $key => $value) {
      // code...
      $innerArr = array();
      foreach ($value as $subKey => $subValue) {
        // code...
        $qObj = new Question();
        if ($subValue == '1') {
          // code...
          // if ($indexQ >= ($roomsCount / 2)) {
          //   $indexQ = 0;
          // }
          if ($indexQ > 12) {
            $indexQ = 0;
          }
          //$strIndex = (string) $indexQ;
          //echo '$indexQ = '.$indexQ;
          //$innerArr[$subKey] = $jsonArr[$indexQ]->question;//$listQuestions[$indexQ];

          // $innerArr[] = array($jsonArr[$indexQ]->qId,
          //                       $jsonArr[$indexQ]->question,
          //                       $jsonArr[$indexQ]->answers,
          //                       $jsonArr[$indexQ]->correctAnswer);
          //echo '<br>qId: '.$jsonArr[$indexQ]->qId.'<br>';
          $qObj->qId = $jsonArr[$indexQ]->qId;
          $qObj->qTxt = $jsonArr[$indexQ]->question;
          $qObj->listAnswers = $jsonArr[$indexQ]->answers;
          $qObj->validAnswer = $jsonArr[$indexQ]->correctAnswer;
          $indexQ++;
          //$listQuestions
        } else {
          // code...
          //echo 'subValue: '.$subValue.'&nbsp;';
          //array_push($innerArr,array($subKey => ' ')); //null - nothing in the room
          // $innerArr[] = array();
          $qObj->qId = -1;
          $qObj->qTxt = "";
          $qObj->listAnswers = null;
          $qObj->validAnswer = -1;
        }
        // echo 'objId: '.$qObj->qId.'<br>';
        // echo 'objTXT: '.$qObj->qTxt.'<br>';
        // echo 'objValid: '.$qObj->validAnswer.'<br>';
        // echo '======<br>';
        $innerArr[] = $qObj;
      }
      $resultMaze[] = $innerArr;
      //echo '<br>';
    }

    // //echo '<br>Questions in the Rooms:<br><table style="border: 1px solid; margin: 10px; padding: 10px;">';
    // //$resultMaze = json_encode($resultMaze);
    // //echo print_r($resultMaze);
    //
    // foreach ($resultMaze as $key => $value) {
    //   // code...
    //   echo '<tr>';
    //   foreach ($value as $subKey => $subValue) {
    //     // code...
    //     //$qObj = new Question($subValue);
    //     //echo "subKey: ".$subKey."<br>";
    //     //echo print_r($subValue);
    //
    //     if ($subValue->qId == -1) {
    //       // code...
    //       echo '<td style="border: 1px solid; margin: 5px; padding: 5px;">empty room</td>';
    //     } else {
    //       echo '<td style="border: 1px solid; margin: 5px; padding: 5px;">';
    //       echo "qObjId: ".$subValue->qId."<br>";
    //       echo "qObjTXT: ".$subValue->qTxt."<br>";
    //       echo "qObjvalidAnswer: ".$subValue->validAnswer."<br>";
    //
    //       foreach ($subValue->listAnswers as $keyAns => $valueAns) {
    //         // code...
    //         echo $keyAns.') Answ: '.$valueAns->value.'<br>';
    //       }
    //       echo '</td>';
    //     }
    //
    //
    //     //echo "qObjAnswer: ".$subValue->listAnswers."<br>";
    //   }
    //   echo '</tr>';
    //   //echo '<br>';
    // }
    // echo '</table>';


    //
    // // //to display the array === debug only!
    // echo '<br>print_r:<br>';
    // //$resultMaze = json_encode($resultMaze);
    // //print_r($resultMaze);
    // echo '<br>Result array:<br>';
    // foreach ($resultMaze as $key =>$value) {
    //   // code...
    //   echo '<br>key: '.$key.' &nbsp;value: ';
    //   foreach ($value as $subKey => $subValue) {
    //     // code...
    //     //echo '<br>subValue: '.$subValue->question.'&nbsp;';
    //     //print_r($subValue);
    //     //$myObj = new Question($subValue);
    //     //echo '==================================';
    //     foreach ($subValue as $subSubKey => $subSubValue) {
    //       // code...
    //         foreach ($subSubValue as $key4 => $var4) {
    //           // code...
    //           echo '<br> key4: '.$key4.' &nbsp; '.$var4;
    //         }
    //     }
    //     // $nextQuestion = new Question($subValue);
    //     //
    //     //   echo 'QuestionId: '. $nextQuestion->qId;
    //     //   echo 'QuestionTXT: '. $nextQuestion->qTxt;
    //     //   echo 'QuestionIsTaken: '. $nextQuestion->qIsTaken;
    //     //   echo 'QuestionIsAns: '. $nextQuestion->qIsAnswered ;
    //
    //     //echo 'Question: '.$myObj->qTxt;
    //     echo '<br>';
    //   }
    //   echo '<br>';
    // }
    return $resultMaze;
}

function createConnection($dBHOST, $dBUSER, $dBPASS, $dBNAME) {
  // Create connection
  $conn = new mysqli($dBHOST, $dBUSER, $dBPASS, $dBNAME);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      return null;
  }
  return $conn;
}

function readTable($tableName, $connStr) {
  //$sql = "SELECT qId, qTxt, qIsTaken, qIsAnswered FROM tabQuestions";
  $sql = "SELECT qId, qTxt, qIsTaken, qIsAnswered FROM ".$tableName;
  $result = $connStr->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        echo "<table border='1' style='background-color: pale; border-color: red blue gold teal; padding: 10px;'>";
          while($row = $result->fetch_assoc()) {
              echo "<tr> <td colspan='4' style='padding: 10px;'>". "Question id: " . $row["qId"]. " - QText: " .
              $row["qTxt"]. " - IsTaken: " . $row["qIsTaken"].
              " - IsAnswered: " . $row["qIsAnswered"]."</td></tr>";
              //SELECT `ansId`, `ansTxt`, `ansQId`, `ansIsValid` FROM `tabanswers` WHERE 1
              $sql = "SELECT ansId, ansTxt, ansQId, ansIsValid FROM tabanswers WHERE ansQId=".$row["qId"];
              $resultAns = $connStr->query($sql);
                if ($resultAns->num_rows > 0) {
                  echo "<tr>";
                  while($rowAns = $resultAns->fetch_assoc()) {
                      echo "<td style='padding: 10px;'>" ."AnswerId: " . $rowAns["ansId"]. "<br> Text: ". $rowAns["ansTxt"]."</td>";
                  }
                  echo "</tr>";
                }

        }
        echo "</table>";
    } else {
        echo "0 results";
    }
}

function displayAllTAbles() {
  //to create a select HTML object with tables names
  $outVar = "";
    $conn = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection with the database failed: </br>" . $conn->connect_error);
    }

    if($result = $conn->query('SHOW TABLES')){
      while($row = $result->fetch_array()){
        $tables[] = $row[0];
      }
    }
    // $outVar = '<select name=\"tabsFromDB\" onchange=\"this.form.submit();\">';
    foreach($tables as $key => $value) {
      // code...
        $outVar .= '<option value="'.$value.'">'.$value.'</option>';
    }
    //echo 'outVar: '.$outVar."<br>";
    //$outVar = $outVar . "</select>";

return $outVar;
}

function getUserRetriesCountFromDB($user) {
  //to retrieve users retries from DB table - historical counts
  $conn = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);
  $userTable = 'tabusers';
  $userId = $user;
  $totalCount = 0;
  // Check connection
  if ($conn->connect_error) {
      die("Connection with the database failed: </br>" . $conn->connect_error);
  }
  //echo '<br>UserId passed: '.$userId;
  $sql = "SELECT * FROM `$userTable` WHERE uIUN='$userId'";
  //echo '<br>SQLSTR: '.$sql.'<br>';
  if ($result = mysqli_query($conn,$sql)) {
    // sqli requiest...
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        // go over returned results
        //echo '<br>User retry found: '.$row['uRetryCount'];
        $totalCount ++;
      }
    }
  }
  // $result = $connStr->query($sql);
  return $totalCount;

}

function uuid()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}
?>
