<?php
/**
 * Created by PhpStorm.
 * User: majiameng <666@majiameng.com>
 * Date: 2017-09-12
 * Time: 17:07
 */
namespace common\lib\phpcode;
require_once('barcode/class/BCGColor.php');
require_once('barcode/class/BCGDrawing.php');
require_once('barcode/class/BCGcode128.barcode.php');
require_once('qrcode/core/qrlib.php');
use yii\web\BadRequestHttpException;

class QrCode {

    /**
     * @param $number ‘eg.54654654654’
     * @param bool $filePath 'eg. /home/www/uploads/' 默认直接输出文件流到浏览器
     * @param int $size '大小,eg.1到4'
     * @param int $height '高度 eg.20到90’
     * @param bool $showfront ‘是否显示字体’
     * @return string
     * @throws \BCGArgumentException
     * @throws \BCGDrawException
     * 获取条形码
     */
    public static function getBarCode($number,$filePath=false,$size=2,$height=20,$showfront=false){
        // Barcode Part
        $colorFront = new \BCGColor(0, 0, 0);
        $colorBack = new \BCGColor(255, 255, 255);
        $code = new \BCGcode128();
        $code->setScale($size);//大小
        $code->setThickness($height);//高度
        if($showfront === false){
            $code->setFont(0);//是否显示数字
        }
        $code->setColor($colorFront, $colorBack);
        $code->parse($number);
        if($filePath){
            $barCodePath = '/barcode/';
            $filePath = $filePath .$barCodePath;
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }
            // Drawing Part
            $filename = $filePath.$number.'.png';
            $drawing = new \BCGDrawing($filename, $colorBack);
            $drawing->setBarcode($code);
            $drawing->draw();
            $drawing->finish(\BCGDrawing::IMG_FORMAT_PNG);
            return $barCodePath .$number.'.png';
        }else{
            $drawing = new \BCGDrawing(false, $colorBack);
            $drawing->setBarcode($code);
            $drawing->draw();
            header('Content-Type: image/png');
            $drawing->finish(\BCGDrawing::IMG_FORMAT_PNG);
        }

    }

    /**
     * @param $data '二维码数据信息'
     * @param bool $filePath 'eg. /home/www/uploads/' 默认直接输出文件流到浏览器
     * @param string $size 'eg.1到10 大小'
     * @param string $level '容错率，eg. L|M|Q|H'
     * @return string
     * @throws BadRequestHttpException
     * 获取二维码图片
     */
    public static function getQrCode($data,$filePath=false,$size='10',$level='L'){
        $cache = dirname(__FILE__).DIRECTORY_SEPARATOR.'qrcode/core/cache'.DIRECTORY_SEPARATOR;
        if (!is_dir($cache)) {
            mkdir($cache, 0777, true);
        }
        $errorCorrectionLevel = 'L';
        if (isset($level) && in_array($level, array('L','M','Q','H')))
            $errorCorrectionLevel = $level;
        $matrixPointSize = 4;
        if (isset($size))
            $matrixPointSize = min(max((int)$size, 1), 10);
        if($filePath){
            $qrCodePath = '/qrcode/';
            $filePath = $filePath .$qrCodePath;

            //ofcourse we need rights to create temp dir
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }
            if (isset($data)) {

                //it's very important!
                if (trim($data) == '')
                    throw new BadRequestHttpException('data 不能为空！');

                // user data
                $filename = $filePath.$data.'.png';
                \QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
                return $qrCodePath .$data.'.png';
            }
        }else{
            if (isset($data)) {
                //it's very important!
                if (trim($data) == '')
                    throw new BadRequestHttpException('data 不能为空！');
                \QRcode::png($data, false, $errorCorrectionLevel, $matrixPointSize, 2);
            }
        }

    }
}