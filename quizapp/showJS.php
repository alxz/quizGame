<?php
// // Create connection
require_once('config.php');
require_once('functions.php');
require_once('classes.php');
//startSession();

//DBHOST, DBUSER, DBPASS, DBNAME
//getting connection:
$connVar = createConnection (DBHOST, DBUSER, DBPASS, DBNAME);
// reading the datatable and displaying:
// readTable("tabQuestions",$connVar);
$listOfAllQ = [];
$listOfAllQ = getAllQuestions("tabquestions",$connVar);

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
// echo '<br>=====<br>';
$mazeMapArr = mazeStruc();
$jsonListAllQ = json_encode($jsonListAllQ);
//print_r($jsonListAllQ);
//echo '<br>Step before mazeQuestionsArr = mazeQuestionsArr() <br>';
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
  .myTable { background-color:#eee;border-collapse:collapse; }
  .myTable th { background-color:#000;color:white;width:50%; }
  .myTable td, .myTable th { padding:5px;border:1px solid #000; }
  </style>
</head>
<body>
<!-- partial:index.partial.html -->
<h1>Maze With Quizzes (test version) <a href="../../index.php" id="link" style="color: #FFFF00">... back to HOME</a>
&nbsp;&nbsp;&nbsp; <a href="./showDBcont.php" id="link" style="color: #FFFF00">View Saved Data</a></h1>
<p>Please enter your name: &nbsp;&nbsp;<input type="text" id="userId" value="JOHN0001" /></p>
<div id="questionWindow" class="question-container question-hide" >
  <div class="quiz-container">
    <div id="quiz">
    </div>
  </div>
  <!-- <button id="previous">Previous Question</button>
       <button id="next">Next Question</button>
  -->
  <button id="submit">Submit Quiz</button>
</div>
<div class="quiz-container">
  <div id="divRoom">
    <div id="tableNavigation">
      <table id="navigation" class="naviTab">  <br>
        <tr><td class="naviTab">&nbsp;</td>
            <td class="naviTab"><button class="navButton" onclick="moveUp()"> &nbsp;&nbsp;/\&nbsp;&nbsp; </button></td>
            <td class="naviTab">&nbsp;</td></tr>
        <tr><td class="naviTab"><button class="navButton" onclick="moveLeft()"> &nbsp;&nbsp;<br><<<br>&nbsp;&nbsp; </button></td>
            <td class="naviTab">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td class="naviTab"><button class="navButton" onclick="moveRight()"> &nbsp;&nbsp;<br>>><br>&nbsp;&nbsp; </button></td></tr>
        <tr><td class="naviTab">&nbsp;</td>
            <td class="naviTab"><button class="navButton" onclick="moveDown()"> &nbsp;&nbsp;\/&nbsp;&nbsp; </button></td>
            <td class="naviTab">&nbsp;</td></tr>
      </table>
    </div>
  </div>
</div>
<p>===========================================<br></p>
<div class="mapsCont">
  <div id="currentPosDiv" class="mazeContainerLeft"></div>
  <div id="mazeWDrsRmsMap" class="mazeContainerRight"></div>
  <div id="mazeMap" class="mazeContainerLeft"></div>
</div>

<p>===========================================<br></p>
<div id="results"></div>
<script type="text/JavaScript">var scoreData = {};</script>
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
  var mazeQuestionsArr = <?php echo $mazeQuestionsArr ?>; //questions and answers JSON array
  var mazeWDrsRms =<?php echo $mazeWithRoomsDoors ?>;
  var startTime, endTime;
  var posX = 0; //player position at X-axis
  var posY = 0; // player position at Y-axis
  var numCorrect = 0;
    var userName = "";
    var isCompleted = 0;
    var timeElapsedVar = 0;
    var isFinishedMaze = 0;
    var totalQuestAsked = 0;

  startTimer(); //to start the timer event
  showMaze(arrMazeInit, "mazeMap");
  showMazeGfx(mazeWDrsRms, "mazeWDrsRmsMap");
  showMazeObj(mazeQuestionsArr, "mazeQeustions");
  currentPos(posX,posY,"currentPosDiv");

  //initial Rooms
  function setRoom(image) {
    document.getElementById("divRoom").style.backgroundImage =  "url('"+ image + "')";

  }

  setRoom('./jpg/u0d0l0r0.jpg');

  function changeRoom(pY,pX) {
    posX = pX;
    posY = pY;
    //TODO dfind new room
    // mazeWDrsRms keeps values like: u1d1l1r1
    var imgObj = mazeWDrsRms[posY][posX];
    var imgName = 'u'+imgObj.U+'d'+imgObj.D+'l'+imgObj.L+'r'+imgObj.R;
    setRoom('./jpg/'+imgName+'.jpg');
    currentPos(posY,posX,"currentPosDiv");
  }

  function stayInRoom(pY,pX) {
    // posX = pX;
    // posY = pY;
    //TODO dfind new room
    // mazeWDrsRms keeps values like: u1d1l1r1
    var imgObj = mazeWDrsRms[posX][posY];
    var imgName = 'u'+imgObj.U+'d'+imgObj.D+'l'+imgObj.L+'r'+imgObj.R;
    setRoom('./jpg/'+imgName+'.jpg');
    currentPos(posY,posX,"currentPosDiv");
  }

    const questionWindow = document.getElementById("questionWindow");

        function moveRight() {
          let newX = posX+1;
          //let newY = posY;
          //TODO: check if you have next question
          // // TODO: Also check if the next room question is already answered
          if (posX < 3) {
            myQuestion(mazeQuestionsArr[posY][newX],posY,newX);
          }
        }

        function moveLeft() {
          let newX = posX-1;
          //let newY = posY;
          //TODO: check if you have next question
          // // TODO: Also check if the next room question is already answered
          if (posX > 0) {
            myQuestion(mazeQuestionsArr[posY][newX],posY,newX);
          }
        }

        function moveUp() {
          let newX = posX;
          let newY = posY-1;
          //TODO: check if you have next question
          // // TODO: Also check if the next room question is already answered
          if (posY > 0) {
            myQuestion(mazeQuestionsArr[newY][newX],newY,newX);
          }
        }

        function moveDown() {
          let newX = posX;
          let newY = posY+1;
          //TODO: check if you have next question
          // // TODO: Also check if the next room question is already answered
          if (posY < 3) {
            myQuestion(mazeQuestionsArr[newY][newX],newY,newX);
          }
        }

        function myQuestion(question,newY,newX) {
          if(question.IsAnswered === 1) {
            changeRoom(newY,newX) ;
            return;
          }
          if(question.qId === -1) {
            //changeRoom(newY,newX) ;
            //this room is empty - do not enter
            return;
          }
          if((newX == 0) && (newY == 0)) {
            // this is out start point!
            changeRoom(newY,newX) ;
            return;
          }

          questionWindow.style.display = "inline-block";
          var myQuestions = [question];
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
              for (ind in currentQuestion.listAnswers) {
                // ...add an HTML radio button
                answers.push(
                  `<label>
                     <input type="radio" name="question${questionNumber}" value="${ind}">
                      ${currentQuestion.listAnswers[ind].key} :
                      ${currentQuestion.listAnswers[ind].value}
                   </label>`
                );
              }

              // add this question and its answers to the output
              output.push(
                `<div class="slide">
                   <div class="question"> ${currentQuestion.qTxt} </div>
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

            // for each question...
            myQuestions.forEach((currentQuestion, questionNumber) => {
              // find selected answer
              totalQuestAsked ++;
              const answerContainer = answerContainers[questionNumber];
              const selector = `input[name=question${questionNumber}]:checked`;
              const userAnswer = parseInt((answerContainer.querySelector(selector) || {}).value);

              // if answer is correct
              if (userAnswer === currentQuestion.validAnswer) {
                // add to the number of correct answers
                numCorrect++;
                //ChangeBackgroungImageOfTab(quizContainer,"u0d0l0r0");
                // color the answers green
                answerContainer.style.color = "lightgreen";
                //hide if true
                setTimeout(function() {
                  questionWindow.style.display = "none";
                  question.IsAnswered = 1;
                  changeRoom(newY,newX);
                  if ((newY == 3) && (newX == 3) ) {
                      isCompleted = 1;
                      timeElapsedVar = endTimer();
                      isFinishedMaze = 1;
                      scoreData = [// outer level array literal
                       { // second level object literals
                         correctCount: numCorrect,
                         user: userName,
                         isFinished: isFinishedMaze,
                         elapsedTime: timeElapsedVar
                       }
                     ];
                      alert('Congratulations!!! \nThis is the end of your journey! \nYou won the prize!');
                      if (confirm('Are you sure you want to save this thing into the database?')) {
                            handleJSONData(scoreData);
                        } else {
                            // Do nothing!
                      }
                  }
                },1000);
                // Congratulations if this is the last room!!!

                //TODO: Change Rooms
              } else {
                // if answer is wrong or blank
                // color the answers red
                setTimeout(function() {
                  answerContainer.style.color = "red";
                  //1 TODO hide question
                  //2 TODO: show video
                  questionWindow.style.display = "none";
                  stayInRoom(posY,posX);
                },1000);
              }
            });

            //elementShowHide("result") ;
            // show number of correct answers out of total
            //resultsContainer.innerHTML = `${numCorrect} out of ${myQuestions.length}`; //totalQuestAsked
            resultsContainer.innerHTML = `${numCorrect} out of ${totalQuestAsked} in time elapsed: ${timeElapsedVar}`;
            //userName = document.getElementById("userId");
            //userName = 'user1001';
            userName = document.getElementById("userId").value;
            //isFinishedMaze = 0;
            timeElapsedVar = endTimer(); //fixing time elapsed
            // if (myQuestions.length == (numCorrect)) {
            //   isFinishedMaze = 1;
            // }
            if (isCompleted == 1){
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
            //numCorrect = 0;

          }

          function showSlide(n) {
            slides[currentSlide].classList.remove("active-slide");
            slides[n].classList.add("active-slide");
            currentSlide = n;
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

          const slides = document.querySelectorAll(".slide");
          let currentSlide = 0;

          showSlide(0);

          // on submit, show results
          submitButton.addEventListener("click", showResults);
        }

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

        function currentPos (passedY, passedX, targetDivId) {
          const displayDiv = document.getElementById(targetDivId);
          displayDiv.innerHTML = "Current Position:<br> " + passedX + " * " + passedY + "<br>"; //currentPos
          showMaze(arrMazeInit, "mazeMap");
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
                  if ((i == posY) & (j == posX)) {
                    result += "<td>X</td>";
                  } else {
                    result += "<td>"+myArray[i][j]+"&nbsp; </td>";
                  }

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
            var result = "<table id='table1' class='myTable' style='width: 90%;'>";
            var resultStr = "";
            for(var i=0; i<myArray.length; i++) {
                result += "<tr>";
                for(var j=0; j<myArray[i].length; j++){
                  //  result += "<td>"+myArray[i][j]+"&nbsp; </td>";
                  var obj = new Object(myArray[i][j]);
                  if (obj.qId == '-1') {
                    result = result + '<td> This room is EMPTY';
                    result += resultStr + '</td>';
                    resultStr = "";
                  } else {
                    result = result + '<td>';
                    resultStr = resultStr + 'Qid: ' + obj.qId + '; Text: ' + obj.qTxt + ' <br>';
                    resultStr = resultStr + 'validAnswer: ' + (parseInt(obj.validAnswer)+1)  + ' <br>' + ' listAnswers:<br>';

                    for (let key in obj.listAnswers) {
                      let value = obj.listAnswers[key];
                      //console.log(key, value);
                      resultStr = resultStr + 'Answer [' + (value.key) + '] value: ' + value.value + '<br>';
                    }
                    result += resultStr + '</td>';
                    resultStr = "";
                  }
                }
                result += "</tr>";
            }
            result += "</table>";
            return result;
        }

        //calculate time elapsed:
          // var ts = Math.round((new Date()).getTime() / 1000);
          // const elapsedTime = () => {
          //   'use strict';
          //   //const since   = 1491685200000, // Saturday, 08-Apr-17 21:00:00 UTC
          //     const since   = ts,
          //         elapsed = (new Date().getTime() - since) / 1000;
          //
          //   if (elapsed >= 0) {
          //     const diff = {};
          //
          //     diff.days    = Math.floor(elapsed / 86400);
          //     diff.hours   = Math.floor(elapsed / 3600 % 24);
          //     diff.minutes = Math.floor(elapsed / 60 % 60);
          //     diff.seconds = Math.floor(elapsed % 60);
          //
          //     let message = `Over ${diff.days}d ${diff.hours}h ${diff.minutes}m ${diff.seconds}s.`;
          //     message = message.replace(/(?:0. )+/, '');
          //     alert(message);
          //   }
          //   else {
          //     alert('Elapsed time lesser than 0, i.e. specified datetime is still in the future.');
          //   }
          // };
          // document.getElementById('counter').addEventListener('click', elapsedTime, false);

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

                    function playVideo (sourceURL) {
                      linkToVideo = '<video controls width="350" autoplay="true"><source src="' +sourceURL
                                +'" type="video/mp4"> Sorry, your browser doesn\'t support embedded videos.</video>';
                      const divVideos = document.getElementById('divVideo');
                            divVideos.innerHTML = "<br>"+linkToVideo+ "<br>";
                            const video = document.querySelector('video');
                          video.onended = function()  { eraseVideo();  };
                    }

                    function eraseVideo () {
                      const divVideos = document.getElementById('divVideo');
                            divVideos.innerHTML = "";
                    }

                    function setScoreData () {
                      currentScoreData = [// outer level array literal
                       { // second level object literals
                         correctCount: numCorrect,
                         user: userName,
                         isFinished: isFinishedMaze,
                         elapsedTime: timeElapsedVar
                       }
                     ];
                     return currentScoreData;
                    }

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
