<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Seekx2y\LifeTimeSDK\LifeTime;
use PHPUnit\Framework\TestCase;

class PostExpressInfoTest extends TestCase
{
    public function testPostExpressInfo()
    {
        $config = [
            'appId'     => '9999',
            'appSecret' => '0123456789',
            'url'       => 'http://erp.lamaplan.com.cn',
            'debug'     => true // 非必填，是否查看http请求详情
        ];
        $app    = new LifeTime($config);
        $params = '[{ "SkucodeId": 0, "SupplierOrderId": "551906241006224480790-1M", "SkuCode": "A1146001080807", "SkuQuantity": 1, "ShipCompanyName": "圆通", "ShipCompanyCode": "YTO", "TackingNo": "A123456" },{ "SkucodeId": 0, "SupplierOrderId": "551906241006224480790-1M", "SkuCode": "A114600111111", "SkuQuantity": 1, "ShipCompanyName": "圆通", "ShipCompanyCode": "YTO", "TackingNo": "B321456" }]';
        $params = json_decode($params, true);
        $res    = $app->postExpressInfo($params);
        $this->assertObjectHasAttribute('code', $res);
        $this->assertEquals('200', $res->code);
        $this->assertObjectHasAttribute('data', $res);
        $this->assertNotEmpty($res->data);
    }
}