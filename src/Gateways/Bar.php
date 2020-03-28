<?php
/**
 * Class Bar
 * @author Tinymeng <666@majiameng.com>
 * @date: 2019/9/25 18:51
 */
namespace tinymeng\code\Gateways;
use tinymeng\code\Connector\Gateway;
use tinymeng\code\Gateways\barcode\BCGColor;
use tinymeng\code\Gateways\barcode\BCGcode128;
use tinymeng\code\Gateways\barcode\BCGDrawing;

class Bar extends Gateway{

    /**
     * Function Name: create
     * @param $data
     * @param bool $showfront 是否显示数字
     * @param bool $filePath  保存文件路径
     * @param int $size 大小
     * @param int $height 高度
     * @throws barcode\BCGArgumentException
     * @throws barcode\BCGDrawException
     * @author Tinymeng <666@majiameng.com>
     * @date: 2019/9/27 11:28
     */
    public function create($data,$showfront=false,$filePath=false,$size=2,$height=20){
        if (trim($data) == ''){
            throw new Exception('data 不能为空！');
        }

        $colorFront = new BCGColor(0, 0, 0);
        $colorBack = new BCGColor(255, 255, 255);
        $code = new BCGcode128();
        $code->setScale($size);//大小
        $code->setThickness($height);//高度
        if($showfront === false){
            $code->setFont(0);//是否显示数字
        }
        $code->setColor($colorFront, $colorBack);
        $code->parse($data);

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
                $file_name = 'bar'.$data.'.png';
            }else{
                $file_name = 'bar'.date('YmdHis').rand(1111,9999).'.png';
            }
            $filename = $filePath.$file_name.'.png';
            $drawing = new BCGDrawing($filename, $colorBack);
            $drawing->setBarcode($code);
            $drawing->draw();
            $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
            return $filename;
        }else{
            $drawing = new BCGDrawing(false, $colorBack);
            $drawing->setBarcode($code);
            $drawing->draw();
            header('Content-Type: image/png');
            $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
        }
    }
}
