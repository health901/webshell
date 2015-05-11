<?php

require 'function.php';
require 'class.php';
$config = array(
    'defaultController' => 'dir', #默认页
    'shellEncode' => 'GBK', #目标机命令行编码格式
);
$app = new app($config);
$app->run()->show();
