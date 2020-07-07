<?php

namespace M2T\Model;

class Email
{
    public string $email;
    public string $pwd;
    public string $imapHost;
    public int $imapPort;
    public string $imapSocketType;
    public string $smtpHost;
    public int $smtpPort;
    public string $smtpSocketType;

    public function __construct(
        string $email,
        string $pwd,
        string $imapHost,
        string $imapPort,
        string $imapSocketType,
        string $smtpHost,
        string $smtpPort,
        string $smtpSocketType
    ) {
        $this->email = $email;
        $this->pwd = $pwd;
        $this->imapHost = $imapHost;
        $this->imapPort = $imapPort;
        $this->imapSocketType = $imapSocketType;
        $this->smtpHost = $smtpHost;
        $this->smtpPort = $smtpPort;
        $this->smtpSocketType = $smtpSocketType;
    }

    public function getSettings(): string
    {
        return
            '<strong>email:</strong> ' . $this->email . PHP_EOL .
            '<strong>password:</strong> ***' . PHP_EOL .
            '<strong>imapHost:</strong> ' . $this->imapHost . PHP_EOL .
            '<strong>imapPort:</strong> ' . $this->imapPort . PHP_EOL .
            '<strong>imapSocketType:</strong> ' . $this->imapSocketType . PHP_EOL .
            '<strong>smtpHost:</strong> ' . $this->smtpHost . PHP_EOL .
            '<strong>smtpPort:</strong> ' . $this->smtpPort . PHP_EOL .
            '<strong>smtpSocketType:</strong> ' . $this->smtpSocketType;
    }
}
