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
//$jsonListAllQ = shuffle($jsonListAllQ);
// print_r($jsonListAllQ);
shuffle($jsonListAllQ);
// echo '<br>=====<br>';
// print_r($jsonListAllQ);
$mazeMapArr = mazeStruc();
//$mazeQuestionsArr = json_encode($mazeMapArr);
$jsonListAllQ = json_encode($jsonListAllQ);
$mazeQuestionsArr = mazeQuestionsArr($mazeMapArr,$jsonListAllQ); //here we create eral Maze with Questions as Object(Text, etc)
$mazeWithRoomsDoors = mazeRoomsDoors($mazeMapArr);

//echo $jsonListAllQ;
$arrMazeInit = json_encode($mazeMapArr);
$mazeQuestionsArr = json_encode($mazeQuestionsArr);

$mazeWithRoomsDoors = json_encode($mazeWithRoomsDoors);

echo '<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Simple JavaScript Quiz (ES6) V4 (Stylized)</title>
  <link rel="stylesheet" href="./style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
  <script src="jquery-3.4.1.min.js"></script>
  <script src="js/dw_xhr.js" type="text/javascript"></script>
  <style>
  .mazeContainerLeft {
  	width:45%;
  	margin:1%;
  	text-align:center;
  	float:left;
  }
  .mazeContainerRight {
  	width:45%;
  	margin:1%;
  	text-align:center;
  	float:left;
  }
  .myTable { background-color:#eee;border-collapse:collapse; }
  .myTable th { background-color:#000;color:white;width:50%; }
  .myTable td, .myTable th { padding:5px;border:1px solid #000; }
  </style>
</head>
<body>
<!-- partial:index.partial.html -->
<h1>Quiz on Important Facts <a href="../index.php" id="link" style="color: #FFFF00">... back to HOME</a></h1>
<p>Please enter your name: &nbsp;&nbsp;<input type="text" id="userId" value="JOHN0001" /></p>
<div class="quiz-container">
  <div id="quiz"></div>
</div>
<button id="previous">Previous Question</button>
<button id="next">Next Question</button>
<button id="submit">Submit Quiz</button>
<p>===========================================<br></p>
<div>
  <div id="mazeMap" class="mazeContainerLeft"></div>
  <div id="mazeWDrsRmsMap" class="mazeContainerRight"></div>
</div>
<p>===========================================<br></p>
<div id="results"></div>
<script type="text/JavaScript">var scoreData = 0;</script>
<p><a href="#" onclick="handleJSONData(scoreData); return false;">Click</a> to send your results.</p>

<div id="result"></div>
<div>
  <div id="mazeQeustions" class="mazeQuestions"></div>
</div>
<div id="divDebug"></div>
<button id="counter">Check elapsed time</button>
';
?>

  <script type="text/JavaScript">
  var listQuestions = <?php echo $jsonListAllQ ?>;
  var arrMazeInit = <?php echo $arrMazeInit ?>;
  var mazeQuestionsArr = <?php echo $mazeQuestionsArr ?>;
  var mazeWDrsRms =<?php echo $mazeWithRoomsDoors ?>;
  var startTime, endTime;

  startTimer(); //to start the timer event
  showMaze(arrMazeInit, "mazeMap");
  showMazeGfx(mazeWDrsRms, "mazeWDrsRmsMap");
  //showMazeObj(mazeQuestionsArr, "mazeQeustions");

  var numCorrect = 0;
  //var userName = 'user1001';
  var userName = "";
    // if (customerName!= null) {
    //     document.getElementById("welcome").innerHTML =
    //     "Hello " + customerName + "! How are you today?";
    // }
        (function() {
          var myQuestions = listQuestions;
          // function shuffle(array) {
          //   array.sort(() => Math.random() - 0.5); //randomize the list - we don't need it if already shuffled
          // }
          // shuffle(myQuestions);
          function buildQuiz() {
            // we'll need a place to store the HTML output
            const output = [];
            // for each question...
            myQuestions.forEach((currentQuestion, questionNumber) => {
              // we'll want to store the list of answer choices
              const answers = [];

              // and for each available answer...
              for (ind in currentQuestion.answers) {
                // ...add an HTML radio button
                answers.push(
                  `<label>
                     <input type="radio" name="question${questionNumber}" value="${ind}">
                      ${currentQuestion.answers[ind].key} :
                      ${currentQuestion.answers[ind].value}
                   </label>`
                );
              }

              // add this question and its answers to the output
              output.push(
                `<div class="slide">
                   <div class="question"> ${currentQuestion.question} </div>
                   <div class="answers"> ${answers.join("")} </div>
                 </div>`
              );
            });

            // finally combine our output list into one string of HTML and put it on the page
            quizContainer.innerHTML = output.join("");
          }

          function showResults() {
            // gather answer containers from our quiz
            const answerContainers = quizContainer.querySelectorAll(".answers");

            // keep track of user's answers
            numCorrect = 0;

            // for each question...
            myQuestions.forEach((currentQuestion, questionNumber) => {
              // find selected answer
              const answerContainer = answerContainers[questionNumber];
              const selector = `input[name=question${questionNumber}]:checked`;
              const userAnswer = parseInt((answerContainer.querySelector(selector) || {}).value);

              // if answer is correct
              if (userAnswer === currentQuestion.correctAnswer) {
                // add to the number of correct answers
                numCorrect++;
                //ChangeBackgroungImageOfTab(quizContainer,"u0d0l0r0");
                // color the answers green
                answerContainers[questionNumber].style.color = "lightgreen";
              } else {
                // if answer is wrong or blank
                // color the answers red
                answerContainers[questionNumber].style.color = "red";
                //ChangeBackgroungImageOfTab(quizContainer,"u9d9l9r9");
              }
            });

            //elementShowHide("result") ;
            // show number of correct answers out of total
            resultsContainer.innerHTML = `${numCorrect} out of ${myQuestions.length}`;
            //userName = document.getElementById("userId");
            //userName = 'user1001';
            userName = document.getElementById("userId").value;
            isFinishedMaze = 0;
            var timeElapsedVar = endTimer();
            if (myQuestions.length == (numCorrect)) {
              isFinishedMaze = 1;
            }
             scoreData = [// outer level array literal
              { // second level object literals
                correctCount: numCorrect,
                user: userName,
                isFinished: isFinishedMaze,
                elapsedTime: timeElapsedVar
              }
            ];
            numCorrect = 0;

          }

          function showSlide(n) {
            slides[currentSlide].classList.remove("active-slide");
            slides[n].classList.add("active-slide");
            currentSlide = n;

            if (currentSlide === 0) {
              previousButton.style.display = "none";
            } else {
              previousButton.style.display = "inline-block";
            }

            if (currentSlide === slides.length - 1) {
              nextButton.style.display = "none";
              submitButton.style.display = "inline-block";
            } else {
              nextButton.style.display = "inline-block";
              submitButton.style.display = "none";
            }
          }

          function showNextSlide() {
            showSlide(currentSlide + 1);
          }

          function showPreviousSlide() {
            showSlide(currentSlide - 1);
          }

          const quizContainer = document.getElementById("quiz");
          const resultsContainer = document.getElementById("results");
          const submitButton = document.getElementById("submit");

          // display quiz right away
          buildQuiz();

          const previousButton = document.getElementById("previous");
          const nextButton = document.getElementById("next");
          const slides = document.querySelectorAll(".slide");
          let currentSlide = 0;

          showSlide(0);

          // on submit, show results
          submitButton.addEventListener("click", showResults);
          previousButton.addEventListener("click", showPreviousSlide);
          nextButton.addEventListener("click", showNextSlide);

        })();
        function handleJSONData( data ) {

            // callback object defines functions that handle success and failure of request
            var callback = {
                success: function(req) {
                    document.getElementById('result').innerHTML = req.responseText;
                },
                failure: function(req) {
                    document.getElementById('result').innerHTML = 'An error has occurred.';
                }
            }

            // arguments: url, callback object, request method, data (stringified), data type
            dw_makeXHRRequest( 'resultShow.php', callback, 'POST', JSON.stringify(data), 'application/json' );
        }

        function elementShowHide(elementId) {
          var x = document.getElementById(elementId);
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }

        function showMaze (mazePassed,targetId) {
          //here we are going to display the maze table/array
          //const mazeDiv = document.getElementById("mazeMap");
          const mazeDiv = document.getElementById(targetId);
          var maze = mazePassed;
          mazeDiv.innerHTML = "MAP: "+targetId+ "<br>"+makeTableHTML(maze);
          // document.getElementById(mazePassed).className = "mazeContainerLeft";
            //mazeDiv.innerHTML = `${numCorrect} out of ${myQuestions.length}`;
        }

        function makeTableHTML(myArray) {
            var result = "<table id='table1' class='myTable'>";
            for(var i=0; i<myArray.length; i++) {
                result += "<tr>";
                for(var j=0; j<myArray[i].length; j++){
                    result += "<td>"+myArray[i][j]+"&nbsp; </td>";
                }
                result += "</tr>";
            }
            result += "</table>";
            return result;
        }

        function showMazeGfx (mazePassed,targetId) {
          //here we are going to display the maze table/array
          //const mazeDiv = document.getElementById("mazeMap");
          const mazeDiv = document.getElementById(targetId);
          var maze = mazePassed;
          mazeDiv.innerHTML = "Map: "+targetId+ "<br>"+makeTableHTMLGfx(maze);
          // document.getElementById(mazePassed).className = "mazeContainerLeft";
            //mazeDiv.innerHTML = `${numCorrect} out of ${myQuestions.length}`;
        }

        function makeTableHTMLGfx(myArray) {
            var result = "<pre><table id='table1'>";
            var resultStr ="";
            for(var i=0; i<myArray.length; i++) {
                result += "<tr>";
                for(var j=0; j<myArray[i].length; j++){
                    //result += "<td>"+myArray[i][j]+"</td>";
                    var obj = new Object(myArray[i][j]);
                    for(var key in obj)
                    {
                      var value = obj[key];
                      resultStr += (key.toLowerCase() + value + '');
                    }
                    if (resultStr == "u0d0l0r0") {
                      result += '<td>&nbsp;</td>';
                    } else {
                      result += '<td><img src="./jpg/'+ resultStr +'.jpg" alt="[]" height="60" width="80"></td>';
                    }
                    //result += '<td><img src="./jpg/'+ resultStr +'.jpg" alt="[]" height="60" width="80"></td>';
                    resultStr = "";
                }
                result += '';
            }
            result += "</table></pre>";
            return result;
        }

        function showMazeObj (mazePassed,targetId) {
          //here we are going to display the maze table/array
          //const mazeDiv = document.getElementById("mazeMap");
          const mazeDiv = document.getElementById(targetId);
          var maze = mazePassed;
          mazeDiv.innerHTML = "MAP: "+targetId+ "<br>"+makeTableHTMLObj(maze);
          // document.getElementById(mazePassed).className = "mazeContainerLeft";
            //mazeDiv.innerHTML = `${numCorrect} out of ${myQuestions.length}`;
        }

        function makeTableHTMLObj(myArray) {
            var result = "<table id='table1' class='myTable'>";
            var resultStr = "";
            for(var i=0; i<myArray.length; i++) {
                result += "<tr>";
                for(var j=0; j<myArray[i].length; j++){
                  //  result += "<td>"+myArray[i][j]+"&nbsp; </td>";
                  var obj = new Object(myArray[i][j]);
                    result = result + '<td>';
                  for(var key in obj)
                  {
                    var value = obj[key];
                      for (var subKey in value) {
                        var subValue = value[subKey];
                        //resultStr = resultStr + ' ' + ('value: ' + value + ' subKey:' + subKey + ' ' + 'subValue: ' + subValue);
                      }
                    //result += ('key: '+key + ' value:' + value + ' ');
                  }
                  result += resultStr + '</td>';
                  resultStr = "";
                }
                result += "</tr>";
            }
            result += "</table>";
            return result;
        }

        //calculate time elapsed:
        var ts = Math.round((new Date()).getTime() / 1000);
        const elapsedTime = () => {
          'use strict';

          //const since   = 1491685200000, // Saturday, 08-Apr-17 21:00:00 UTC
            const since   = ts,
                elapsed = (new Date().getTime() - since) / 1000;

          if (elapsed >= 0) {
            const diff = {};

            diff.days    = Math.floor(elapsed / 86400);
            diff.hours   = Math.floor(elapsed / 3600 % 24);
            diff.minutes = Math.floor(elapsed / 60 % 60);
            diff.seconds = Math.floor(elapsed % 60);

            let message = `Over ${diff.days}d ${diff.hours}h ${diff.minutes}m ${diff.seconds}s.`;
            message = message.replace(/(?:0. )+/, '');
            alert(message);
          }
          else {
            alert('Elapsed time lesser than 0, i.e. specified datetime is still in the future.');
          }
        };

        document.getElementById('counter').addEventListener('click', elapsedTime, false);



        //calculate time elapsed:
          function startTimer() {
            startTime = new Date();
          };

          function endTimer() {
            endTime = new Date();
            var timeDiff = endTime - startTime; //in ms
            // strip the ms
            timeDiff /= 1000;

            // get seconds
            var seconds = Math.round(timeDiff);
            //console.log(seconds + " seconds");
            return seconds;
          }


          // // change background
          // function ChangeBackgroungImageOfTab(tabName, imagePrefix)
          //     {
          //         var urlString = 'url(jpg/' + imagePrefix + '.jpg)';
          //         document.getElementById(tabName).style.backgroundImage =  urlString;
          //     }
      </script>

<?php

echo '</body></html>';

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
?>
