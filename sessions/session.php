<?php
require_once(__DIR__ . "/../database/get_from_db.php");

  class Session {
    private array $messages;

    public function __construct() {
      if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
        if (!isset($_SESSION['csrf'])) {
          $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
      }

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

    public function getCSRF() {
      return $_SESSION['csrf'];
    }
  }
