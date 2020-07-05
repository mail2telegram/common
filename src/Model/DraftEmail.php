<?php


namespace M2T\Model;


class DraftEmail
{
    public string $from;
    public string $to;
    public string $subject;
    public string $message;

    public function __construct(
        string $from = '',
        string $to = '',
        string $subject = '',
        string $message = ''
    )
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
    }
}
