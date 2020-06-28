<?php

namespace M2T;

use M2T\Model\Account;
use Redis;

class AccountManager
{
    protected Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    public function save(Account $account): bool
    {
        return $this->redis->set("account:{$account->chatId}", serialize($account));
    }

    public function load(int $chatId): ?Account
    {
        $data = $this->redis->get("account:{$chatId}");
        return $data ? unserialize($data, [Account::class]) : null;
    }

    public function delete(int $chatId): bool
    {
        return 1 === $this->redis->del("account:{$chatId}");
    }

    /**
     * @return int[]
     */
    public function getChats(): array
    {
        return array_map(fn($el) => (int) ltrim($el), $this->redis->keys('account:*'));
    }
}
