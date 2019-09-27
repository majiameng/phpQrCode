<?php
namespace tinymeng\code\Connector;

use tinymeng\tools\Strings;

/**
 * Class Name: Gateway
 * @author Tinymeng <666@majiameng.com>
 * @date: 2019/9/27 11:46
 * @package tinymeng\code\Connector
 */
abstract class Gateway implements GatewayInterface
{
    /**
     * 配置参数
     * @var array
     */
    protected $config;

    /**
     * 是否开启debug
     * @var bool
     */
    protected $debug = false;

    /**
     * Gateway constructor.
     * @param null $config
     * @throws \Exception
     */
    public function __construct($config = [])
    {
        //默认参数
        $_config = [
            'debug'=>false
        ];
        $this->config = $config;
//        $this->config = array_replace_recursive($_config,$config);
    }

    /**
     * Function Name: 开启debug
     * @param boolean $debug
     * @author Tinymeng <666@majiameng.com>
     * @date: 2019/9/26 10:44
     */
    public function setDebug($debug){
        $this->debug = $debug;
    }

}
