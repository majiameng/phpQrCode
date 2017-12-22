# 生成条形码或者二维码


### 引用QrCode
```
include "phpcode/QrCode.php";
$number = 'https://blog.majiameng.com';
```

```
//一维码
common\lib\phpcode\QrCode::getBarCode($number);
```
//二维码
```
common\lib\phpcode\QrCode::getQrCode($number);
```