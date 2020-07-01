<?php

/** @noinspection PhpUnhandledExceptionInspection */

namespace Unit;

use Codeception\Test\Unit;
use M2T\AccountManager;
use Redis;
use UnitTester;

class AccountManagerTest extends Unit
{
    protected UnitTester $tester;

    public function testBase(): void
    {
        $account = $this->tester->accountProvider()[0];
        $redis = $this->createStub(Redis::class);
        $redis->method('set')->willReturn(true);
        $redis->method('get')->willReturn(serialize($account));
        $redis->method('del')->willReturn(1);
        $redis->method('keys')->willReturn(['account:' . $account->chatId]);
        $manager = new AccountManager($redis);

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
