<?php
require_once(__DIR__ . "/../database/get_from_db.php");

  class Session {
    private array $messages;

    public function __construct() {
      session_start();

      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      unset($_SESSION['messages']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['user']);    
    }

    public function logout() {
      session_destroy();
    }
    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }

    public function setUser($user) {
      $_SESSION['user'] = $user;
    }

    public function getUser() : ?User {
      return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
  }
