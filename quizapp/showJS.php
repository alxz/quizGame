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
<div class="topRow">
  <div id="userNameInput" class="divCurrentPos">
      Your name: &nbsp;&nbsp;<input type="text" id="userId" value="JOHN0001" /></div>
  <div id="currentPosDiv" class="divCurrentPos"></div>
</div>
<br><br>
<div id="video"
     class="video-container"
     style="display: none">
     <span class="video-close" onclick="hideVideo()"> [X] </span>
     <p><br>
        <h1><span id="vidScrTxt" class="vidScrMessage">Sorry, wrong answer!!!</span></h1>
        <br><br>
     </p>
     <video id="vplayer" class="video-player"
            controls width="450">
            <source src="video/vid00001.mp4" type="video/mp4"> Sorry, your browser doesn\'t support embedded videos.</video>
</div>
<div id="finScr"
     class="finScr-container"
     style="display: none">
     <br><br><br><p><h1><span id="finScrTxt" class="finMessage">Congratulations!</span></h1></p><br><br><br>
     <textarea rows="4" cols="50">
      Please enter your comments here.
      </textarea><br><br><br>
      <button id="finSubmit">Submit</button> &nbsp;&nbsp;&nbsp; <button id="finExit" onclick="window.close();">Exit</button>
</div>
<div id="questionWindow" class="question-container question-hide" >
  <div class="quiz-container">
    <div id="quiz"></div>
  </div>
  <button id="submit">Submit Quiz</button>
</div>
<div class="quiz-container">
  <div id="divRoom">
    <!-- DivTable.com -->
      <div class="divTable" style="width: 100%;" >
        <div class="divTableBody">
          <div class="divTableRow">
              <div class="divTableCell">&nbsp;</div>
              <div class="divTableCellCentral"><button class="navButtonUpDown" onclick="moveUp()">&nbsp;/\&nbsp;</button></div>
              <div class="divTableCell">&nbsp;</div>
          </div>
          <div class="divTableRow">
            <div class="divTableCellSide"><button class="navButton" onclick="moveLeft()"> <br> <br>  &nbsp; <br> <<  <br> <br> &nbsp; <br> </button></div>
            <div class="divTableCellCentral"><br> <canvas id="canvas"></canvas></div>
            <div class="divTableCellSide"><button class="navButton" onclick="moveRight()"> <br> <br>  &nbsp; <br> >>  <br> <br> &nbsp;<br> </button></div>
          </div>
          <div class="divTableRow">
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCellCentral"><button class="navButtonUpDown" onclick="moveDown()">&nbsp;\/&nbsp;</button></div>
            <div class="divTableCell">&nbsp;</div></div>
          </div>
        </div>
      </div>
    <!-- DivTable.com -->
  </div>
</div>
<div id="mazeWDrsRmsMap" class="mazeContainerRight"></div>
<p>===========================================<br></p>
<div class="mapsCont">
  <div id="mazeMap" class="mazeContainerLeft"></div>
</div>
<p>===========================================<br></p>
<div id="results"></div>
  <script type="text/JavaScript">var scoreData = {};</script>
<div id="result"></div>
<div>
  <div id="mazeQeustions" class="mazeQuestions"></div>
</div>
<div id="divDebug"></div>
<!-- <button id="counter">Check elapsed time</button>
<p><a href="#" onclick="handleJSONData(scoreData); return false;">Click</a> to send your results.</p>
-->
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
    var questionsListStr = "";
    var commentsStr = "Have a nice day!";

  // required for canvas animation:
  {
    var canWidth = 150;
    var canHeight = 150;
    //the with and height of our spritesheet
    var spriteWidth = 210;
    var spriteHeight = 80;
    // the position where the frame will be drawn
    var x = canWidth / 2;
    var y = canHeight /2;

    var isMove = false;
    var trackLeft = 1;
    var trackRight = 0;
    var trackUp = 1;
    var trackDown = 0;

    var srcX; //x and y coordinates of the canvas to get the single frame
    var srcY; //x and y coordinates of the canvas to get the single frame

    var goLeft = false; //tracking the movement left and write
    var goRight = true; //Assuming that at start the character will move right side
    var goUp = false;
    var goDown = false;
    var speed = 5; //Speed of the movement

    var cols = 7;//we are having 2 rows and 7 cols in the current sprite sheet
    var rows = 2;
    //To get the width of a single sprite we divided the width of sprite with the number of cols
    //because all the sprites are of equal width and height
    var width = spriteWidth / cols;
    var height = spriteHeight / rows;
    //Each row contains 8 frame and at start we will display the first frame (assuming the index from 0)
    var currentFrame = 0;
    var frameCount = 7; //The total frame is 7

    var canvas = document.getElementById('canvas'); //Getting the canvas from the DOM
    //setting width and height of the canvas
    canvas.width = canWidth;
    canvas.height = canHeight;
    var ctx = canvas.getContext('2d'); //Establishing a context to the canvas
    var character = new Image();  ///Creating an Image object for our character
    character.src = "./png/dude.png"; //Setting the source to the image file

    function moveSpriteRight() {
      isMove = true;
      goLeft = false;
      goRight = true;
      goUp = false;
      goDown = false;
      character.src = "./png/dude.png";
    }
    function moveSpriteLeft() {
      isMove = true;
      goLeft = true;
      goRight = false;
      goUp = false;
      goDown = false;
      character.src = "./png/dude.png";
    }

    function moveSpriteUp() {
      console.log('Up pressed, y = ' + y);
      isMove = true;
      goLeft = false;
      goRight = false;
      goUp = true;
      goDown = false;
      character.src = "./png/DrMarioFaceArrier7x2.png";
    }
    function moveSpriteDown() {
      console.log('Down pressed, y = ' + y);
      isMove = true;
      goLeft = false;
      goRight = false;
      goUp = false;
      goDown = true;
      character.src = "./png/DrMarioFaceArrier7x2.png";
    }

    function justStop() {
      isMove = false;
      srcY = 0;
      ctx.clearRect(x,y,width,height);
      character.src = "./png/DrMarioFaceArrier7x2.png"; //dudeFaceRear
      currentFrame = 0;
      srcX = currentFrame * width;
    }

    function updateFrame() {
      if (isMove == false) {
        return ;
      }
      ctx.clearRect(x,y,width,height);
      currentFrame = ++ currentFrame % cols; //Updating the frame index
      srcX = currentFrame * width; //Calculating the x coordinate for spritesheet

      if ((goLeft) && x>0) {
        x-=speed;
        srcY = trackLeft * height;
      } else if ((goRight) && x<canWidth-width) {
        x+=speed;
        srcY = trackRight * height;
      } else if ((goRight) && x == canWidth-width) {
        //x-=speed;
        isMove = false;
        goLeft = false;
        goRight = false;
      } else if ((goLeft) && x == 0) {
        //x+=speed;
        isMove = false;
        goLeft = false;
        goRight = false;
      } else if ((goUp) && y>0) {
        y-=speed;
        srcY = trackUp * height;
      } else if ((goDown) && y<canHeight-height) {
        y+=speed;
        srcY = trackDown * height;
      } else if (y == canHeight-height) {
        //y-=speed;
        isMove = false;
        goUp = false;
        goDown = false;
      } else if (y == 0) {
        //y+=speed;
        isMove = false;
        goUp = false;
        goDown = false;
      }
    }

    function resetAndClearSprite() {
      // clear sprite:
      ctx.clearRect(x,y,width,height);
      // reset the x,y position coordinates:
       x = canWidth / 2;
       y = canHeight /2;
    }

    function drawImage() {
      updateFrame(); //Updating the frame
      //Drawing the image
      ctx.drawImage(character, srcX, srcY, width, height, x, y, width, height);
    }
    setInterval(function() {
      drawImage();
    }, 100);

    //moveSpriteRight();
  }

  startTimer(); //to start the timer event
  showMaze(arrMazeInit, "mazeMap");
  showMazeGfx(mazeWDrsRms, "mazeWDrsRmsMap");
  //showMazeObj(mazeQuestionsArr, "mazeQeustions");
  currentPos(posY,posX,"currentPosDiv");

  //initial Rooms
  setRoom('./jpg/u0d1l0r1.jpg');
  const questionWindow = document.getElementById("questionWindow");
  const video = document.getElementById("video");
  const vplayer = document.getElementById("vplayer");
  const finScr = document.getElementById("finScr");
  // finScr.style.display = "";
      highlighMapPos(1,1,0,0);
  function setRoom(image) {
    document.getElementById("divRoom").style.backgroundImage =  "url('"+ image + "')";
  }

  function changeRoom(pY,pX) {
    highlighMapPos(posY,posX,pY,pX); //to identify the position of the player and show at the map preview
    posX = pX;
    posY = pY;
    //TODO dfind new room
    // mazeWDrsRms keeps values like: u1d1l1r1
    var imgObj = mazeWDrsRms[posY][posX];
    var imgName = 'u'+imgObj.U+'d'+imgObj.D+'l'+imgObj.L+'r'+imgObj.R;
    setRoom('./jpg/'+imgName+'.jpg');
    currentPos(posY,posX,"currentPosDiv");
  }

  function highlighMapPos(oldY,oldX,pY,pX) {
    document.getElementById('y' + oldY + 'x' + oldX).style.border = "";
    document.getElementById('y' + pY + 'x' + pX).style.border = "2px solid magenta";
  }

  function stayInRoom(pY,pX) {
    // posX = pX;
    // posY = pY;
    //TODO dfind new room
    // mazeWDrsRms keeps values like: u1d1l1r1
    var imgObj = mazeWDrsRms[pY][pX];
    var imgName = 'u'+imgObj.U+'d'+imgObj.D+'l'+imgObj.L+'r'+imgObj.R;
    setRoom('./jpg/'+imgName+'.jpg');
    currentPos(pY,pX,"currentPosDiv");
  }

  function moveRight() {
    let newX = posX+1;
    //let newY = posY;
    //TODO: check if you have next question
    // // TODO: Also check if the next room question is already answered
    if (posX < 3) {
      myQuestion(mazeQuestionsArr[posY][newX],posY,newX);
      //isMove = true;
      moveSpriteRight();
    }
  }

  function moveLeft() {
    let newX = posX-1;
    //let newY = posY;
    //TODO: check if you have next question
    // // TODO: Also check if the next room question is already answered
    if (posX > 0) {
      myQuestion(mazeQuestionsArr[posY][newX],posY,newX);
      //isMove = true;
      moveSpriteLeft();
    }
  }

  function moveUp() {
    let newX = posX;
    let newY = posY-1;
    //TODO: check if you have next question
    // // TODO: Also check if the next room question is already answered
    if (posY > 0) {
      myQuestion(mazeQuestionsArr[newY][newX],newY,newX);
      moveSpriteUp();
    }
  }

  function moveDown() {
    let newX = posX;
    let newY = posY+1;
    //TODO: check if you have next question
    // // TODO: Also check if the next room question is already answered
    if (posY < 3) {
      myQuestion(mazeQuestionsArr[newY][newX],newY,newX);
      moveSpriteDown();
    }
  }
  function hideVideo() {
    video.style.display = "none";
    vplayer.pause();
  }

  function showVideo() {
    video.style.display = "";
    vplayer.play();
  }

  function showFinalScreen() {
    finScr.style.display = "";
  }

  // function animateMove(startX, startY, stepX, stepY, poleSign) {
  //   var elem = document.getElementById("animate");
  //   var xpos = startX;
  //   var ypos = startY;
  //   var id = setInterval(frame, 5);
  //   function frame() {
  //     if ((stepX == 0 ) && (stepY ==  0)) {
  //       clearInterval(id);
  //       return;
  //     }
  //     if ((stepX !== 0 ) && (stepY === 0)) {
  //       if (xpos === (xpos + (stepX * poleSign)) ) {
  //             clearInterval(id);
  //           } else {
  //             xpos = xpos + 1 * (poleSign);
  //             elem.style.left = xpos + 'px';
  //             elem.style.top = ypos;
  //             stepX --;
  //           }
  //     }
  //     if ((stepX === 0 ) && (stepY !== 0)) {
  //       if (ypos === (ypos + (stepY * poleSign)) ) {
  //             clearInterval(id);
  //           } else {
  //             ypos = ypos + 1 * (poleSign);
  //             elem.style.left = xpos;
  //             elem.style.top = ypos + 'px';
  //             stepY --;
  //           }
  //     }
  //   }
  // }

  // function setAnimImage(image) {
  //   document.getElementById("animate").style.backgroundImage =  "url('"+ image + "')";
  // }
//==================================================
// ===========  function myQuestion  ===============
//==================================================
        function myQuestion(question,newY,newX) {
          if(question.IsAnswered === 1) {
            changeRoom(newY,newX) ;
            resetAndClearSprite();
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
          justStop(); //stop the sprite animation
          questionWindow.style.display = "inline-block";
          var myQuestions = [question];

          function buildQuiz() {
            // we'll need a place to store the HTML output
            const output = [];
            // for each question...
            myQuestions.forEach((currentQuestion, questionNumber) => {
              questionsListStr += "q:" + currentQuestion.qId + ", ";
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

                //ChangeBackgroungImageOfTab(quizContainer,"u0d0l0r0");
                // color the answers green
                answerContainer.style.color = "lightgreen";
                //hide if true
                setTimeout(function() {
                  questionWindow.style.display = "none";
                  question.IsAnswered = 1;
                  changeRoom(newY,newX);
                  // add to the number of correct answers
                  numCorrect++;

                  console.log('When Correct answer: numCorrect = ' + numCorrect + ' [posY,posX: (' + posY + ',' + posX+ ')] ' +
                                ' [newY,newX: (' + newY + ',' + newX+ ') ]');
                  //console.log('When Correct answer: numCorrect = ' + numCorrect + ' newY,newX: (' + newY + ',' + newX+ ') ');
                  if ((newY == 3) && (newX == 3) ) {
                      isCompleted = 1;
                      timeElapsedVar = endTimer();
                      isFinishedMaze = 1;
                      scoreData = [// outer level array literal
                       { // second level object literals
                         correctCount: numCorrect,
                         user: userName,
                         isFinished: isFinishedMaze,
                         elapsedTime: timeElapsedVar,
                         timestart: startTime,
                         timefinish: endTime,
                         listofquestions: questionsListStr,
                         comments: commentsStr
                       }
                     ];
                      //alert('Congratulations!!! \nThis is the end of your journey! \nYour score will be recorded!');
                      handleJSONData(scoreData); //to set the data setScoreData ()
                      showFinalScreen();
                      document.getElementById("finScrTxt").textContent = "Congratulations!!! "
                                    + "This is the end of your journey! "
                                     + "Your score will be recorded! ";
                      //'Congratulations!!! \nThis is the end of your journey! \nYour score will be recorded!'
                      // if (confirm('Are you sure you want to save this thing into the database?')) {
                      //       handleJSONData(scoreData);
                      //   } else {
                      //       // Do nothing!
                      // }
                  }
                },1000);
                myQuestions = []; //myQuestions = [question];

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
                  console.log('When wrong answer: numCorrect = ' + numCorrect + ' posY,posX: (' + posY + ',' + posX+ ') ');
                  console.log('When wrong answer: numCorrect = ' + numCorrect + ' newY,newX: (' + newY + ',' + newX+ ') ');
                  showVideo();

                },1000);
              }
            });

            // show number of correct answers out of total
            resultsContainer.innerHTML = `${numCorrect} out of ${totalQuestAsked} in time elapsed: ${timeElapsedVar}`;
            // isMove = true; //let it moves - sprite
            userName = document.getElementById("userId").value;

            resetAndClearSprite(); //to clear and reset sprite coordinate

            //isFinishedMaze = 0;
            timeElapsedVar = endTimer(); //fixing time elapsed
            if (isCompleted == 1){
              isFinishedMaze = 1;
            }
             scoreData = [// outer level array literal
              { // second level object literals
                correctCount: numCorrect,
                user: userName,
                isFinished: isFinishedMaze,
                elapsedTime: timeElapsedVar,
                timestart: startTime,
                timefinish: endTime,
                listofquestions: questionsListStr,
                comments: commentsStr
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
          displayDiv.innerHTML = "Current Position: " + passedX + " * " + passedY; //currentPos
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
                    // if (resultStr == "u0d0l0r0") {
                    //   result += '<td>&nbsp;</td>';
                    // } else {
                    //   result += '<td><img src="./jpg/'+ resultStr +'.jpg" alt="[]" height="60" width="80"></td>';
                    // }
                    tabCellXId = 'y' + i + 'x' + j;
                    result += '<td id="' + tabCellXId + '"><img src="./jpg/'+ resultStr +'.jpg" alt="[]" height="40" width="50"></td>';
                    // if ((i === posY) && (j === posY)) {
                    //   strShowPlayerPos = "0";
                    //   document.getElementById("tabCellX").style.border = "thick solid #0000FF";
                    // }
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
                    //
                    // function playVideo (sourceURL) {
                    //   linkToVideo = '<video controls width="350" autoplay="true"><source src="' +sourceURL
                    //             +'" type="video/mp4"> Sorry, your browser doesn\'t support embedded videos.</video>';
                    //   const divVideos = document.getElementById('divVideo');
                    //         divVideos.innerHTML = "<br>"+linkToVideo+ "<br>";
                    //         const video = document.querySelector('video');
                    //       video.onended = function()  { eraseVideo();  };
                    // }
                    //
                    // function eraseVideo () {
                    //   const divVideos = document.getElementById('divVideo');
                    //         divVideos.innerHTML = "";
                    // }

                    function setScoreData () {
                      currentScoreData = [// outer level array literal
                       { // second level object literals
                         correctCount: numCorrect,
                         user: userName,
                         isFinished: isFinishedMaze,
                         elapsedTime: timeElapsedVar,
                         timestart: startTime,
                         timefinish: endTime,
                         listofquestions: questionsListStr,
                         comments: commentsStr
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

/*
Section for backup and temp pieces :)
<iframe id="vmeoplayer" class="video-player"
                  src="https://player.vimeo.com/video/303102987" width="450" height="350" frameborder="1"
                  webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
const vmeoplayer = document.getElementById("vmeoplayer");
*/

?>
