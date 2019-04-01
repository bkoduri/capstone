<?php

require '../../app/common.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $customer = new Customer($_POST);

  $customer->create();

  echo json_encode($customer);
  exit;
}

//For GET request
$customers = Customer::fetchAll();
$json = json_encode($customers, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $json;
