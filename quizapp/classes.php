<?php
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
?>
