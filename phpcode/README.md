# php生成条形码或者二维码

### Install

```
composer require tinymeng/code dev-master -vvv
```

> 类库使用的命名空间为`\\tinymeng\\code`

### 一维码(条形码)
```
use tinymeng\code\Generate;
$generate = Generate::bar();

/** 直接输出图片 */
$generate->create("123456789");

/** 直接输出图片下面显示数字 */
//$generate->create("123456789",true);

/** 条形码存入本地并输出存储路径 */
//$file_path = $generate->create("123456789",true);
//var_dump($file_path);
```


```php
```

### 二维码生成
```
use tinymeng\code\Generate;
$generate = Generate::qr();

/** 直接输出图片 */
$generate->create("123456789");


/** 二维码存入本地并输出存储路径 */
//$file_path = $generate->create("123456789",true);
//var_dump($file_path);

```
