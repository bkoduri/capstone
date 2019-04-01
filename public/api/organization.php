<?php

require '../../app/common.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $organization = new Organization($_POST);

  $organization->create();

  echo json_encode($organization);
  exit;
}

//For GET request
$organizations = Organization::fetchAll();
$json = json_encode($organizations, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $json;
