<?php

namespace M2T\Model;

class Account
{
    /** @var Mailbox[] */
    public array $emails;
    public int $chatId;

    public function __construct(
        int $chatId,
        array $emails = []
    ) {
        $this->chatId = $chatId;
        $this->emails = $emails;
    }
}
