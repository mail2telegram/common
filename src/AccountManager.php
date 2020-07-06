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

    public function get(int $chatId): Account
    {
        $account = $this->load($chatId);
        return $account ?? new Account($chatId);
    }

    public function delete(int $chatId): bool
    {
        return 1 === $this->redis->del(static::getKey($chatId));
    }

    public function setAllEmailsNotSelected(Account $account): bool
    {
        foreach ($account->emails as $email) {
            $email->selected = false;
        }
        return $this->save($account);
    }

    public function checkExistEmail(Account $account, string $email): bool
    {
        foreach ($account->emails as $existEmail) {
            if ($email === $existEmail->email) {
                return true;
            }
        }
        return false;
    }

    public function getSelectedEmail(Account $account): ?Email
    {
        foreach ($account->emails as $existEmail) {
            if ($existEmail->selected) {
                return $existEmail;
            }
        }
        return null;
    }

    public function getEmail(Account $account, string $email): ?Email
    {
        foreach ($account->emails as $existEmail) {
            if ($email === $existEmail->email) {
                return $existEmail;
            }
        }
        return null;
    }

    public function deleteEmail(Account $account, string $email): bool
    {
        foreach ($account->emails as $key => $existEmail) {
            if ($email === $existEmail->email) {
                unset($account->emails[$key]);
                $account->emails = array_values($account->emails);
                $this->save($account);
                return true;
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
