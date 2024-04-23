<?php
  class Session {
    private array $messages;

    public function __construct() {
      session_start();

      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      unset($_SESSION['messages']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
    }

    public function getEmail() : ?string {
      return isset($_SESSION['email']) ? $_SESSION['email'] : null;
    }

    public function setEmail(string $email) {
      $_SESSION['email'] = $email;
    }

    public function setId(int $id) {
      $_SESSION['idUser'] = $id;
    }

    public function setFirstName(string $firstName) {
      $_SESSION['firstName'] = $firstName;
    }

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }
  }
?>