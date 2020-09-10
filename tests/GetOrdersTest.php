<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Seekx2y\LifeTimeSDK\LifeTime;
use PHPUnit\Framework\TestCase;

class GetOrdersTest extends TestCase
{
    public function testGetOrders()
    {
        $config = [
            'appId'     => '9999',
            'appSecret' => '0123456789',
            'url'       => 'http://erp.lamaplan.com.cn',
            'debug'     => true // 非必填，是否查看http请求详情
        ];
        $app    = new LifeTime($config);
        $res    = $app->orders('/GetInvoiceList', Carbon::parse('2020-04-08 13:22:57'), Carbon::parse('2020-04-08 13:22:57')->addHour());
        $this->assertObjectHasAttribute('code', $res);
        $this->assertEquals('200', $res->code);
        $this->assertObjectHasAttribute('data', $res);
        $this->assertNotEmpty($res->data);
    }
}