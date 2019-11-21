<?php
require_once('config.php');

class Question {
  // Properties
  //qId, qTxt, qIsTaken, qIsAnswered FROM tabQuestions";
  public $qId;
  public $qTxt;
  public $qIsTaken;
  public $qIsAnswered;
  public $listAnswers;
  public $validAnswer;

  // Methods
  function set_qId($qId) {
    $this->qId = $qId;
  }
  function get_qId() {
    return $this->qId;
  }
  function set_qTxt($qTxt) {
    $this->qTxt = $qTxt;
  }
  function get_qTxt() {
    return $this->qTxt;
  }

  function set_qIsTaken($qIsTaken) {
    $this->qIsTaken= $qIsTaken;
  }
  function get_qIsTaken() {
    return $this->qIsTaken;
  }
  function set_qIsAnswered($qIsAnswered) {
    $this->qIsAnswered = $qIsAnswered;
  }
  function get_qIsAnswered() {
    return $this->qIsAnswered;
  }
  //$listAnswers
  function set_listAnswers($listAnswers) {
    $this->listAnswers = $listAnswers;
  }
  function get_listAnswers() {
    return $this->listAnswers;
  }

  function set_validAnswer($validAnswer) {
    $this->validAnswer = $validAnswer;
  }
  function get_validAnswer() {
    return $this->validAnswer;
  }
}

class Answer {
  // Properties
  // `ansId`, `ansTxt`, `ansQId`, `ansIsValid` FROM tabanswers";
  public $ansId;
  public $ansTxt;
  public $ansQId;
  public $ansIsValid;

  // Methods
  function set_ansId($ansId) {
    $this->ansId = $ansId;
  }
  function get_ansId() {
    return $this->ansId;
  }
  function set_ansTxt($ansTxt) {
    $this->ansTxt = $ansTxt;
  }
  function get_ansTxt() {
    return $this->ansTxt;
  }

  function set_ansQId($ansQId) {
    $this->ansQId= $ansQId;
  }
  function get_ansQId() {
    return $this->ansQId;
  }
  function set_ansIsValid($ansIsValid) {
    $this->ansIsValid = $ansIsValid;
  }
  function get_ansIsValid() {
    return $this->ansIsValid;
  }
}

/**
 * DatabaseObject
 */
// class DatabaseObject extends Object
// {
//
//   function __construct($connStr)
//   {
//     // code...
//     //$connStr = new mysqli($dBHOST, $dBUSER, $dBPASS, $dBNAME);
//     // Check connection
//     if ($connStr->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//         return null;
//     }
//     // $con = new PDO("mysql:host=localhost;dbname=mydata;charset=utf8','username', 'password');
//   }
// }


// /***
//  * Created by PhpStorm.
//  ***/
// class MySessionHandler implements SessionHandlerInterface {
//         private $database = null;
//
//         public function __construct($sessionDBconnectionUrl){
//             /***
//              * Just setting up my own database connection. Use yours as you need.
//              ***/
//                 //require_once "class.database.include.php";
//                 //createConnection
//                 //createConnection($dBHOST, $dBUSER, $dBPASS, $dBNAME)
//                 // Create connection
//                 // $sessionDBconnectionUrl = new mysqli($dBHOST, $dBUSER, $dBPASS, $dBNAME);
//                 // // Check connection
//                 // if ($conn->connect_error) {
//                 //     die("Connection failed: " . $conn->connect_error);
//                 //     return null;
//                 // }
//
//                 $this->database = new DatabaseObject($sessionDBconnectionUrl);
//
//             // Set handler to overide SESSION
//             session_set_save_handler(
//                 array($this, "open"),
//                 array($this, "close"),
//                 array($this, "read"),
//                 array($this, "write"),
//                 array($this, "destroy"),
//                 array($this, "gc")
//             );
//             register_shutdown_function('session_write_close');
//             session_start();
//         }
//
//         /** * Open   */
//         public function open($savepath, $id){
//             // If successful
//             $this->database->getSelect("SELECT `data` FROM sessions WHERE id = ? LIMIT 1",$id,TRUE);
//             if($this->database->selectRowsFoundCounter() == 1){
//                 // Return True
//                 return true;
//             }
//             // Return False
//             return false;
//         }
//         /**
//          * Read
//          */
//         public function read($id)
//         {
//             // Set query
//             $readRow = $this->database->getSelect('SELECT `data` FROM sessions WHERE id = ? LIMIT 1', $id,TRUE);
//             if ($this->database->selectRowsFoundCounter() > 0) {
//                 return $readRow['data'];
//             } else {
//                 return '';
//             }
//         }
//
//         /**
//          * Write
//          */
//         public function write($id, $data)
//         {
//             // Create time stamp
//             $access = time();
//
//             // Set query
//             $dataReplace[0] = $id;
//             $dataReplace[1] = $access;
//             $dataReplace[2] = $data;
//             if ($this->database->noReturnQuery('REPLACE INTO sessions(id,access,`data`) VALUES (?, ?, ?)', $dataReplace)) {
//                 return true;
//             } else {
//                 return false;
//             }
//         }
//
//         /**
//          * Destroy
//          */
//         public function destroy($id)
//         {
//             // Set query
//             if ($this->database->noReturnQuery('DELETE FROM sessions WHERE id = ? LIMIT 1', $id)) {
//                 return true;
//             } else {
//
//                 return false;
//             }
//         }
//         /**
//          * Close
//          */
//         public function close(){
//             // Close the database connection
//             if($this->database->dbiLink->close){
//                 // Return True
//                 return true;
//             }
//             // Return False
//             return false;
//         }
//
//         /**
//          * Garbage Collection
//          */
//         public function gc($max)
//         {
//             // Calculate what is to be deemed old
//             $old = time() - $max;
//
//             if ($this->database->noReturnQuery('DELETE FROM sessions WHERE access < ?', $old)) {
//                 return true;
//             } else {
//                 return false;
//             }
//         }
//
//         public function __destruct()
//         {
//             $this->close();
//         }
//
//     }

?>
