# 壹生科技（辣妈计划） SDK

Based on [foundation-sdk](https://github.com/HanSon/foundation-sdk)

## Requirement
- PHP >= 7.1
- **[composer](https://getcomposer.org/)**

## Installation
```
composer require seek-x2y/life-time-sdk -vvv
```
## Usage
```php
$config = [
    ''
    'debug' => true // // 是否查看http请求详情
];

$api = new LifeTime($this->config);
$res = $api['orders']->getOrderList();
var_dump($res);
```

## License

MIT
