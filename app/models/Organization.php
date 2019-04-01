<?php

class Organization
{
  public $org_id;
  public $org_name;
  public $contact;
  public $description;
  public $industry;
//Get details from db as rows
  public function __construct($row) {
    $this->org_id = isset($row['org_id']) ? intval($row['org_id']) : null;
//each column data is extracted
    $this->org_name = $row['org_name'];
    $this->contact = $row['contact'];
    $this->description = $row['description'];
    $this->industry = $row['industry'];
  }

  public function create() {
    $db = new PDO(DB_SERVER, DB_USER, DB_PW);
    $sql = 'INSERT INTO customer (org_id,org_name,contact,description,industry)
            VALUES (?,?,?,?,?)';
    $statement = $db->prepare($sql);
    $success = $statement->execute([
        $this->org_id,
        $this->org_name,
        $this->contact,
        $this->description,
        $this->industry
    ]);
    if (!$success) {
      die ('Bad SQL on insert');
    }
    $this->org_id = $db->lastInsertId();
  }

  public static function fetchAll() {
      // 1. Connect to the database
      $db = new PDO(DB_SERVER, DB_USER, DB_PW);
      // 2. Prepare the query
      $sql = 'SELECT * FROM organization';
      $statement = $db->prepare($sql);
      // 3. Run the query
      $success = $statement->execute();
      // 4. Handle the results
      $arr = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $thecustomer =  new Organization($row);
        array_push($arr, $thecustomer);
      }

      return $arr;
    }

  public static function getCustomerById(int $org_id) {
    // 1. Connect to the database
    $db = new PDO(DB_SERVER, DB_USER, DB_PW);

    // 2. Prepare the query
    $sql = 'SELECT * FROM customer WHERE org_id = ?';

    $statement = $db->prepare($sql);

    // 3. Run the query
    $success = $statement->execute(
        [$org_id]
    );

    // 4. Handle the results
    $arr = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      // 4.a. For each row, make a new work object
      $customerItem =  new Customer($row);

      array_push($arr, $customerItem);
    }

    // 4.b. return the array of work objects

    return $arr;
  }
}
