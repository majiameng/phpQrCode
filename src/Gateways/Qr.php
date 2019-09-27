<?php
/**
 * Class Smtp
 * @author Tinymeng <666@majiameng.com>
 * @date: 2019/9/25 18:51
 */
namespace tinymeng\code\Gateways;
use Exception;
use tinymeng\code\Gateways\qrcode\FrameFiller;
use tinymeng\code\Gateways\qrcode\Qrcode;
use tinymeng\code\Gateways\qrcode\QRencode;
use tinymeng\code\Gateways\qrcode\QRrawcode;
use tinymeng\code\Connector\Gateway;

define('saveFilePath',dirname(dirname(dirname(dirname(dirname(__DIR__))))).DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'qrcode'.DIRECTORY_SEPARATOR);
class Qr extends Gateway{

    public $version;
    public $width;
    public $data;
    
    /**
     * Function Name: create
     * @param $data
     * @param bool $filePath 是否保存为文件
     * @param string $matrixPointSize
     * @param string $errorCorrectionLevel in ['L','M','Q','H']
     * @return string
     * @author Tinymeng <666@majiameng.com>
     * @date: 2019/9/27 11:28
     */
    public function create($data,$filePath=false,$matrixPointSize=10,$errorCorrectionLevel='L'){
        if (trim($data) == ''){
            throw new Exception('data 不能为空！');
        }

        if (!in_array($errorCorrectionLevel, array('L','M','Q','H'))){
            $errorCorrectionLevel = 'L';
        }
        if (!empty($matrixPointSize)){
            $matrixPointSize = min(max((int)$matrixPointSize, 1), 10);
        }

        if($filePath){
            if($filename === true){
                $filePath = saveFilePath;
            }
            /** 文件是否存在 */
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }

            $filename = $filePath.$data.'.png';
            QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
            return $filename;
        }else{
            QRcode::png($data, false, $errorCorrectionLevel, $matrixPointSize, 2);
        }
    }
}