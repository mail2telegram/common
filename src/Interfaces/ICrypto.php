<?php

namespace M2T\Interfaces;

interface ICrypto
{
    public function encrypt(string $data): string;

    public function decrypt(string $encrypted): string;
}
