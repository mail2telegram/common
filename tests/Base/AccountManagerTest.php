<?php

/** @noinspection PhpUnhandledExceptionInspection */

namespace Base;

use BaseTester;
use Codeception\Test\Unit;
use M2T\AccountManager;
use M2T\App;

class AccountManagerTest extends Unit
{
    protected BaseTester $tester;

    public function testBase(): void
    {
        /** @var AccountManager $manager */
        $manager = App::get(AccountManager::class);
        $account = $this->tester->accountProvider()[0];

        $result = $manager->save($account);
        $this->tester->assertTrue($result);
        $this->tester->seeInRedis('account:' . $account->chatId);

        $result = $manager->load($account->chatId);
        $this->tester->assertEquals($account, $result);

        $result = $manager->getChats();
        $this->tester->assertContains($account->chatId, $result, var_export($result, true));

        $result = $manager->delete($account->chatId);
        $this->tester->assertTrue($result);
        $this->tester->dontSeeInRedis('account:' . $account->chatId);
    }
}
