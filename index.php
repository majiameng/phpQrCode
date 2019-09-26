<?php
/**
 * Name: 生成条形码或者二维码
 * Author: JiaMeng <666@majiameng.com>
 * Date: 2017/12/20 16:17
 * Description: index.php.
 */
include "phpcode/QrCode.php";
$number = 'https://blog.majiameng.com';
//一维码
//$qr = common\lib\phpcode\QrCode::getBarCode($number);
//二维码
$qr = common\lib\phpcode\QrCode::getQrCode($number);