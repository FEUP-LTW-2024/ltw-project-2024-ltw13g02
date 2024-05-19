<?php
require_once(__DIR__.'/../database/product.class.php');
require_once(__DIR__ . '/../vendor/autoload.php');


$types = getTypesofCategory($_GET['category']);

$final = '';

for ($i = 0; $i < count($types); $i++) {
    $characteristics = getCharacteristicsofType($types[$i]['idType']); 
    $final .= '<select id="characteristic' . $i + 1 . '" name="characteristic' . $i + 1 . '" class="characteristic" oninput="myFunction()">';
    $final .= "<option value=''>" . $types[$i]['type_name'] . "</option> ";
        foreach($characteristics as $c) {
            $final .= "<option value=" . $c['idCharacteristic'] . ">" . $c['characteristic'] . "</option>";
        } 
    $final .= "</select>";
} 
file_put_contents(__DIR__ ."debug.txt", $final);
echo $final;