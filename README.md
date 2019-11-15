# quizGame
Quiz based game with a little bit of maze adventures...

*** Sorry, still in development - information may be changed! ***

You start the game in the START position (0;0) - currently is the top-left cell of the matrix. The goal is to reach the last bottom-right cell - finish position (FINISH). Each ROOM in the MAZE (cell in the MAZE matrix) has one question (with 4 answers, only 1 correct answer).
To advance to the next step you will need to answer a question. If your answer is correct you enter the cell (next room). If you fail the quest you stay in the same ROOM (also, you should be able to see a little video which may help you to find the correct answer)... When you go back to the ROOM which you have been already, there is no question asked (no repetition). Currently there is only two trails (2 paths) from START to FINISH (may be more, depending on the MAZE initial configuration). Upon completion of the MAZE your score and time elapsed information should be captured in the DB table.

Technical:
This is a combination of JAVASCRIPT and PHP technologies. Backend DB MySQL (MariaDB). Planning to have some animation with HTML5/JS libraries.

To Install:
1) Install/Configure your web server (for example Apache/Nginx at XAMP/MAMP/OpenServer etc) with PHP (5.6.x/7x) support and MySQL DB;
2) Configure MySQL DB access (check 'config.php' for access credentials);
3) Copy the source files into your web application folder.
4) Start with index.php (currently it is only 'showJS.php' file to start);
5) Play the game.
