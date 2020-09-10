<?php

namespace Tests\Unit;

use Seekx2y\LifeTimeSDK\LifeTime;
use PHPUnit\Framework\TestCase;

class GetShipCompanyTest extends TestCase
{
    public function testGetShipCompanies()
    {
        $config = [
            'appId'     => '9999',
            'appSecret' => '0123456789',
            'url'       => 'http://erp.lamaplan.com.cn',
            'debug'     => true // 非必填，是否查看http请求详情
        ];
        $app    = new LifeTime($config);
        $res    = $app->shipCompanies();
        $this->assertObjectHasAttribute('code', $res);
        $this->assertEquals('200', $res->code);
        $this->assertObjectHasAttribute('data', $res);
        $this->assertNotEmpty($res->data);
    }
}