<?php

namespace Tests\Unit;

use Seekx2y\LifeTimeSDK\LifeTime;
use PHPUnit\Framework\TestCase;

class ClearShipInfoTest extends TestCase
{
    public function testClearShipInfo()
    {
        $config = [
            'appId'     => '9999',
            'appSecret' => '0123456789',
            'url'       => 'http://erp.lamaplan.com.cn',
            'debug'     => true // 非必填，是否查看http请求详情
        ];
        $app    = new LifeTime($config);
        $res    = $app->clearShipInfo('551906170906124027047-1M', 'A1146001080807');
        $this->assertObjectHasAttribute('code', $res);
        $this->assertEquals('200', $res->code);
        $this->assertObjectHasAttribute('data', $res);
        $this->assertNotEmpty($res->data);
    }
}