<?php
namespace tinymeng\code;

use \tinymeng\tools\Strings;
/**
 * Class Name: PHP 生成二维码Code类
 * @author Tinymeng <666@majiameng.com>
 * @date: 2019/9/26 16:49
 * @method static \tinymeng\code\Gateways\Bar bar(array $config=[]) 条形码
 * @method static \tinymeng\code\Gateways\Qr qr(array $config=[]) 二维码
 * @package tinymeng\mailer
 */
define('saveFilePath',dirname(dirname(dirname(dirname(__DIR__)))).DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'tinymeng'.DIRECTORY_SEPARATOR.'code'.DIRECTORY_SEPARATOR);

class Generate
{
    /**
     * Description:  init
     * @author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param $gateway
     * @param null $config
     * @return mixed
     * @throws \Exception
     */
    protected static function init($gateway, $config = null)
    {
        $class = __NAMESPACE__ . '\\Gateways\\' . Strings::uFirst($gateway);
        if (class_exists($class)) {
            $app = new $class($config);
            return $app;
        }
        throw new \Exception("发送QR Code基类 [$gateway] 不存在");
    }

    /**
     * Description:  __callStatic
     * @author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param $gateway
     * @param $config
     * @return mixed
     */
    public static function __callStatic($gateway, $config)
    {
        return self::init($gateway, ...$config);
    }

}
