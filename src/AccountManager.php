<?php

namespace M2T;

use M2T\Model\Account;
use M2T\Model\Email;
use Redis;

class AccountManager
{
    protected Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    protected static function getKey(int $chatId): string
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

    public function delete(int $chatId): bool
    {
        return 1 === $this->redis->del(static::getKey($chatId));
    }

    public function mailboxExist(Account $account, string $email): bool
    {
        foreach ($account->emails as $existEmail) {
            if ($email === $existEmail->email) {
                return true;
            }
        }
        return false;
    }

    public function mailboxGet(Account $account, string $email): ?Email
    {
        foreach ($account->emails as $mailbox) {
            if ($email === $mailbox->email) {
                return $mailbox;
            }
        }
        return null;
    }

    public function mailboxGetByHash(Account $account, string $hash): ?Email
    {
        foreach ($account->emails as $mailbox) {
            if ($hash === md5($mailbox->email)) {
                return $mailbox;
            }
        }
        return null;
    }

    public function mailboxDelete(Account $account, string $email): bool
    {
        foreach ($account->emails as $key => $mailbox) {
            if ($email === $mailbox->email) {
                unset($account->emails[$key]);
                $account->emails = array_values($account->emails);
                return $this->save($account);
            }
        }
        return false;
    }

    /**
     * @return int[]
     */
    public function getChats(): array
    {
        return array_map(fn($el) => (int) ltrim($el, 'account:'), $this->redis->keys('account:*'));
    }
}
