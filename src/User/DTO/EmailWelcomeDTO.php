<?php

namespace FinitiOne\User\DTO;

class EmailWelcomeDTO
{
    public string $email;
    public string $subject;
    public string $body;

    public function __construct(string $email, string $subject, string $body)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('invalid email');
        }
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;
    }

}