<?php

/** @noinspection PhpIllegalPsrClassPathInspection */
/** @noinspection PhpUnhandledExceptionInspection */

use M2T\AccountManager;
use M2T\App;
use M2T\Model\Account;
use Codeception\Test\Unit;

class AccountManagerBaseTest extends Unit
{
    protected BaseTester $tester;
    protected Redis $redis;
    protected Account $account;

    public function __construct()
    {
        parent::__construct();
        new App();
        $this->account = App::get('test')['accounts'][0];
        $this->redis = App::get(Redis::class);
    }

    public function testBase(): void
    {
        $manager = new AccountManager($this->redis);
        $account = $this->account;

        $result = $manager->save($account);
        $this->tester->assertTrue($result);
        $this->tester->seeInRedis('account:' . $account->chatId);

        $result = $manager->load($account->chatId);
        $this->tester->assertEquals($account, $result);

        $result = $manager->getChats();
        $this->tester->assertIsInt($result[0]);

        $result = $manager->delete($account->chatId);
        $this->tester->assertTrue($result);
        $this->tester->dontSeeInRedis('account:' . $account->chatId);
    }
}
