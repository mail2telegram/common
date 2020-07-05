<?php

namespace M2T\Model;

/**
 * @property Email[] $emails
 * @property DraftEmail|null $draftEmail
 * */
class Account
{
    public array $emails;
    public int $chatId;
    public ?string $step;
    public ?string $strategy;
    public ?DraftEmail $draftEmail;

    public function __construct(
        int $chatId,
        array $emails = [],
        ?string $step = null,
        ?string $strategy = null,
        ?string $draftEmail = null
    ) {
        $this->chatId = $chatId;
        $this->emails = $emails;
        $this->step = $step;
        $this->strategy = $strategy;
        $this->draftEmail = $draftEmail;
    }
}
