<?php

require '../../app/common.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $product= new Product($_POST);

  $product->create();

  echo json_encode($product);
  exit;
}
$products = Product::fetchAll();
$json = json_encode($products, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $json;
