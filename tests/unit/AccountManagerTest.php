<?php

/** @noinspection PhpIllegalPsrClassPathInspection */
/** @noinspection PhpUnhandledExceptionInspection */

use Codeception\Test\Unit;
use M2T\AccountManager;
use M2T\Model\Account;
use M2T\Model\Email;

class AccountManagerTest extends Unit
{
    protected UnitTester $tester;
    protected Redis $redis;
    protected Account $account;

    public function __construct()
    {
        parent::__construct();
        $this->account = new Account(
            123456,
            [
                new Email(
                    'mail2telegram.app@gmail.com',
                    'XXX',
                    'imap.gmail.com',
                    993,
                    'ssl',
                    'smtp.gmail.com',
                    465,
                    'ssl'
                ),
            ]
        );
        $this->redis = $this->createStub(Redis::class);
        $this->redis->method('set')->willReturn(true);
        $this->redis->method('get')->willReturn(serialize($this->account));
        $this->redis->method('del')->willReturn(1);
        $this->redis->method('keys')->willReturn(['account:123456']);
    }

    public function testBase(): void
    {
        $manager = new AccountManager($this->redis);
        $account = $this->account;

        $result = $manager->save($account);
        $this->tester->assertTrue($result);

        $result = $manager->load($account->chatId);
        $this->tester->assertEquals($account, $result);

        $result = $manager->getChats();
        $this->tester->assertContains(123456, $result, var_export($result, true));

        $result = $manager->delete($account->chatId);
        $this->tester->assertTrue($result);
    }
}
