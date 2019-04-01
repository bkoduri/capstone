<?php

require '../../app/common.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $serviceHistory = new ServiceHistory($_POST);

  $serviceHistory->create();

  echo json_encode($serviceHistory);
  exit;
}

//For GET request
$serviceHistorys = ServiceHistory::fetchAll();
$json = json_encode($serviceHistorys, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $json;
