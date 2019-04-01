<?php

require '../../app/common.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $productDeployed = new ProductDeployed($_POST);

  $productDeployed->create();

  echo json_encode($productDeployed);
  exit;
}
// $siteId = intval($_GET['siteId'] ?? 0);
//For GET request
$productDeployeds = ProductDeployed::fetchAll();
$json = json_encode($productDeployeds, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $json;
