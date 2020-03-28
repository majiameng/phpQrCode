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

class Qr extends Gateway{

    public $version;
    public $width;
    public $data;

    /**
     * Function Name: create
     * @param $data
     * @param bool $filePath 图片保存路径,false=>直接输出图片流
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
            if($filePath === true){
                $filePath = saveFilePath;
            }else{
                if(substr($filePath,-1) != DIRECTORY_SEPARATOR){
                    $filePath .= DIRECTORY_SEPARATOR;
                }
            }
            /** 文件是否存在 */
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }

            if(is_int($data)){
                $file_name = 'qr'.$data.'.png';
            }else{
                $file_name = 'qr'.date('YmdHis').rand(1111,9999).'.png';
            }
            $filename = $filePath.$file_name;
            QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
            return $filename;
        }else{
            QRcode::png($data, false, $errorCorrectionLevel, $matrixPointSize, 2);
        }
    }
}
