<?php

namespace Seekx2y\LifeTimeSDK;

use Carbon\Carbon;
use Hanson\Foundation\Foundation;
use Seekx2y\LifeTimeSDK\Exceptions\ParamValidException;
use Seekx2y\LifeTimeSDK\Exceptions\TimeException;

class LifeTime extends Foundation
{
    protected $providers = [
        ServiceProvider::class
    ];

    public function __construct($config)
    {
        Carbon::setLocale('zh');
        $config['debug'] = $config['debug'] ?? false;
        parent::__construct($config);
    }

    /**
     * @param string $api URI   /GetInvoiceList 按SKU查询    /GetInvoiceListMerge  按订单
     * @param Carbon $startTime
     * @param Carbon $endTime 拉取发货单的结束时间与开始时间不能 相差两个小时以上
     * @param string $orderNo 若是此参数有值，将按此参数拉取，时间 段将不起作用
     * @return mixed
     * @throws TimeException
     * @throws ParamValidException
     */
    public function orders(string $api, Carbon $startTime = null, Carbon $endTime = null, string $orderNo = null)
    {
        if (empty($orderNo)) {
            if (empty($startTime) && empty($endTime)) {
                throw new ParamValidException('参数中开始时间、结束时间或者订单编号不能同时为空');
            } elseif (!empty($startTime) && empty($endTime)) {
                $endTime = $startTime->addMinutes(119);
            } elseif (empty($startTime) && !empty($endTime)) {
                $startTime = $endTime->subMinutes(119);
            } elseif ($startTime->diffInHours($endTime) > 2) {
                throw new TimeException('拉取发货单的结束时间与开始时间不能相差两个小时以上');
            }
            $params = [
                'StartDateTime' => $startTime->format('YmdHis'),
                'EndDateTime'   => $endTime->format('YmdHis'),
            ];
        } else {
            $params = ['SupplierOrderId' => $orderNo];
        }
        return $this->api->request($api, $params, $params);
    }


    /**
     * @return mixed
     */
    public function shipCompanies()
    {
        return $this->api->request('/GetShipCompany');
    }


    /**
     * 发货，推送物流
     * @param array $expressInfo
     * "ExpressList": [{
     * "SkucodeId": 0,
     * "SupplierOrderId": "551906241006224480790-1M",
     * "SkuCode": "A1146001080807",
     * "SkuQuantity": 1,
     * "ShipCompanyName": "圆通",
     * "ShipCompanyCode": "YTO",
     * "TackingNo": "A123456"
     * }]
     * @return mixed
     */
    public function postExpressInfo(array $expressInfo)
    {
        $params = ['ExpressList' => $expressInfo];

        return $this->api->request('/PostExpressInfo', $params, [], 'post');
    }

    /**
     * 撤销发货
     * @param string $orderNo
     * @param string $skuCode
     * @return mixed
     */
    public function clearShipInfo(string $orderNo, string $skuCode)
    {
        $params     = [
            'SupplierOrderId' => $orderNo,
            'SkuCode'         => $skuCode
        ];
        $signParams = ['SupplierOrderId' => $orderNo,];

        return $this->api->request('/PostClearShippingInfo', $params, $signParams, 'post');
    }
}