<?php
require_once(__DIR__.'/../database/product.class.php');
require_once(__DIR__ . '/../vendor/autoload.php');

echo Product::ajaxGetProducts($_GET);
