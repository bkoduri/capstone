<?php

class ProductDeployed
{

  public $pd_id;
  public $product_id;
  public $org_id;
  public $machine_id;
  public $machine_name;
//Get details from db as rows
  public function __construct($row) {
    $this->pd_id = isset($row['pd_id']) ? intval($row['pd_id']) : null;
//each column data is extracted
    $this->product_id = $row['product_id'];
    $this->org_id = $row['org_id'];
    $this->machine_id = $row['machine_id'];
    $this->machine_name = $row['machine_name'];
  }

  public function create() {
    $db = new PDO(DB_SERVER, DB_USER, DB_PW);
    $sql = 'INSERT INTO product_deployed (pd_id,product_id,org_id,machine_id,machine_name)
            VALUES (?,?,?,?,?)';
    $statement = $db->prepare($sql);
    $success = $statement->execute([
        $this->pd_id,
        $this->product_id,
        $this->org_id,
        $this->machine_id,
        $this->machine_name
    ]);
    if (!$success) {
      die ('Bad SQL on insert');
    }
    $this->pd_id = $db->lastInsertId();
  }

  public static function fetchAll() {
      // 1. Connect to the database
      $db = new PDO(DB_SERVER, DB_USER, DB_PW);
      // 2. Prepare the query
      $sql = 'SELECT * FROM product_deployed';
      $statement = $db->prepare($sql);
      // 3. Run the query
      $success = $statement->execute();
      // 4. Handle the results
      $arr = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $theProductDeployed =  new ProductDeployed($row);
        array_push($arr, $theProductDeployed);
      }

      return $arr;
    }

}
