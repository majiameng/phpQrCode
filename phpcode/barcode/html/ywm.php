<?php
/**
 * Created by PhpStorm.
 * User: fx2
 * Date: 2017-09-12
 * Time: 15:00
 */

require_once('../class/BCGColor.php');
require_once('../class/BCGDrawing.php');
require_once('../class/BCGcode128.barcode.php');

$colorFront = new BCGColor(0, 0, 0);
$colorBack = new BCGColor(255, 255, 255);

// Barcode Part
$code = new BCGcode128();
$code->setScale(2);
$code->setColor($colorFront, $colorBack);
$code->parse('465465465465465');
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
//ofcourse we need rights to create temp dir
if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);
// Drawing Part
$filename = $PNG_TEMP_DIR.'test.png';
$drawing = new BCGDrawing($filename, $colorBack);
$drawing->setBarcode($code);
$drawing->draw();

//header('Content-Type: image/png');

$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
?>

