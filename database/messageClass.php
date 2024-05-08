<?php

class Message {
    private int $id;
    private string $messageDate;
    private string $sender;
    private int $chat;
    private string $content;
    private bool $seen;

    public function __construct(int $id, string $messageDate, string $sender, int $chat, string $content, bool $seen) {
        $this->id = $id;
        $this->messageDate = $messageDate;
        $this->sender = $sender;
        $this->chat = $chat;
        $this->content = $content;
        $this->seen = $seen;
    }

    
}