<?php

/** @noinspection PhpUnhandledExceptionInspection */

namespace Unit;

use Codeception\Test\Unit;
use M2T\AccountManager;
use M2T\App;
use UnitTester;

class AccountManagerTest extends Unit
{
    protected UnitTester $tester;

    public function testBase(): void
    {
        /** @var AccountManager $manager */
        $manager = App::get(AccountManager::class);
        $account = $this->tester->accountProvider();

        $result = $manager->save($account);
        $this->tester->assertTrue($result);

        $result = $manager->load($account->chatId);
        $this->tester->assertEquals($account, $result);

        $result = $manager->getChats();
        $this->tester->assertContains($account->chatId, $result, var_export($result, true));

        $result = $manager->delete($account->chatId);
        $this->tester->assertTrue($result);
    }
}
