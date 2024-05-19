<?php
require_once(__DIR__.'/../database/product.class.php');

echo Product::ajaxGetProducts($_GET);
