<?php


namespace Seekx2y\LifeTimeSDK;

use Carbon\Carbon;
use Hanson\Foundation\AbstractAPI;

class Api extends AbstractAPI
{
    private $timestamp;
    private $config;

    /**
     * Api constructor.
     * @param $config
     */
    public function __construct(array $config)
    {
        $this->config    = $config;
        $this->timestamp = Carbon::now('PRC')->format('YmdHis');
    }


    public function makeSign(array $params = null)
    {
        $str = $this->config['appId'] . $this->config['appSecret'] . $this->timestamp;
        ksort($params);
        foreach ($params as $val) {
            if (is_string($val)) {
                $str .= $val;
            }
        }

        return strtoupper(md5($str));
    }

    /**
     * @param string $interfaceName
     * @param array $params
     * @param array $signParams 签名参数
     * @param string $method
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Hanson\Foundation\Exception\HttpException
     */
    public function request(string $interfaceName, array &$params = null, array $signParams = [], string $method = 'GET')
    {
        $data = [
            'AppId'     => $this->config['appId'],
            'TimeStamp' => $this->timestamp,
            'Sign'      => $this->makeSign($signParams),
        ];
        if(isset($params)){
            $data = array_merge($params, $data);
        }
        if ($method == 'GET') {
            $response = $this->getHttp()->get($this->config['url'] . '/v2/api/SupplierOrder' . $interfaceName, $data);
        } else {
            $response = $this->getHttp()->json($this->config['url'] . '/v2/api/SupplierOrder' . $interfaceName, $data);
        }

        return json_decode(strval($response->getBody()));
    }
}