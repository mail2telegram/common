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

    public static function getKey(int $chatId) : int
    {
        return "account:{$chatId}";
    }

    public function save(Account $account): bool
    {
        return $this->redis->set(static::getKey($account->chatId), serialize($account));
    }

    public function load(int $chatId): ?Account
    {
        $data = $this->redis->get(static::getKey($chatId));
        return $data ? unserialize($data, [Account::class]) : null;
    }

    public function get(int $chatId) : Account
    {
        $account = $this->load($chatId);
        return $account == null ? new Account($chatId) : $account;
    }

    public function delete(int $chatId): bool
    {
        return 1 === $this->redis->del(static::getKey($chatId));
    }

    /**
     * @return int[]
     */
    public function getChats(): array
    {
        return array_map(fn($el) => (int) ltrim($el, 'account:'), $this->redis->keys('account:*'));
    }
}
