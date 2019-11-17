<?php

require_once('../mySQLDataMapper.php');
require_once('../config.php');
require_once('../functions.php');
require_once('../classes.php');

//getting connection:
$connVar = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);
// reading the datatable and displaying:
// readTable("tabQuestions",$connVar);
$listOfAllQ = [];
$listOfAllQ = getAllQuestions("tabQuestions",$connVar);

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

$connVar->close();

$jsonListAllQ = [];
foreach ($listOfAllQ as $question) {
    // code...
    //going over a llist of questions to create a JSON array:
    $qId = $question->get_qId();
    $text = $question->get_qTxt();
    $jsonListAllAns = [];
    $answers = $question->get_listAnswers();
    $ansIndex = 0;
    $correctAns = 0;
    foreach ($answers as $answer) {
        // code...
        $arrAnswers = array('key'=>$ansIndex+1,'value'=>$answer->get_ansTxt());
        $jsonListAllAns[] = $arrAnswers;
        if ($answer->get_ansIsValid() == 1) {
            // code...
            $correctAns = $ansIndex;
        }
        $ansIndex++;
    }
    $arr = array ('qId'=>$qId , 'question'=>$text , 'answers'=>$jsonListAllAns, 'correctAnswer'=> $correctAns);
    $jsonListAllQ[] = $arr;
}


shuffle($jsonListAllQ);

header('Content-Type: application/json');
echo json_encode($jsonListAllQ);

