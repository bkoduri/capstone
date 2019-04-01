<?php

require '../../app/common.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $pdSeries = new PdSeries($_POST);

  $pdSeries->create();

  echo json_encode($pdSeries);
  exit;
}

//For GET request
$pdSeriess = PdSeries::fetchAll();
$json = json_encode($pdSeriess, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $json;
