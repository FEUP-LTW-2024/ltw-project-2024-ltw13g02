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

    public function getId(): int {
        return $this->id;
    }
    public function getMessageDate(): string {
        return $this->messageDate;
    }
    public function getSender(): string {
        return $this->sender;
    }
    public function getChat(): string {
        return $this->chat;
    }
    public function getContent(): string {
        return $this->content;
    }
    public function getSeen(): bool {
        return $this->seen;
    }
}