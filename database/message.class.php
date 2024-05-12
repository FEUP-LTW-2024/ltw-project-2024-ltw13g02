<?php

class Message {
    public int $id;
    public string $messageDate;
    public string $sender;
    public int $chat;
    public string $content;
    public bool $seen;

    public function __construct(int $id, string $messageDate, string $sender, int $chat, string $content, bool $seen) {
        $this->id = $id;
        $this->messageDate = $messageDate;
        $this->sender = $sender;
        $this->chat = $chat;
        $this->content = $content;
        $this->seen = $seen;
    }
}