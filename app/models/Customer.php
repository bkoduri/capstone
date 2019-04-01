<?php

class Customer
{
  public $customer_id;
  public $customer_name;
  public $street;
  public $city;
  public $state;
  public $zip;
//Get details from db as rows
  public function __construct($row) {
    $this->customer_id = isset($row['customer_id']) ? intval($row['customer_id']) : null;
//each column data is extracted
    $this->customer_name = $row['customer_name'];
    $this->street = $row['street'];
    $this->city = $row['city'];
    $this->state = $row['state'];
    $this->zip = $row['zip'];
  }

  public function create() {
    $db = new PDO(DB_SERVER, DB_USER, DB_PW);
    $sql = 'INSERT INTO customer (customer_id,customer_name,street,city,state,zip)
            VALUES (?,?,?,?,?,?)';
    $statement = $db->prepare($sql);
    $success = $statement->execute([
        $this->customer_id,
        $this->customer_name,
        $this->street,
        $this->city,
        $this->state,
        $this->zip,
    ]);
    if (!$success) {
      die ('Bad SQL on insert');
    }
    $this->customer_id = $db->lastInsertId();
  }

  public static function fetchAll() {
      // 1. Connect to the database
      $db = new PDO(DB_SERVER, DB_USER, DB_PW);
      // 2. Prepare the query
      $sql = 'SELECT * FROM customer';
      $statement = $db->prepare($sql);
      // 3. Run the query
      $success = $statement->execute();
      // 4. Handle the results
      $arr = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $thecustomer =  new Customer($row);
        array_push($arr, $thecustomer);
      }

      return $arr;
    }

  public static function getCustomerById(int $customer_id) {
    // 1. Connect to the database
    $db = new PDO(DB_SERVER, DB_USER, DB_PW);

    // 2. Prepare the query
    $sql = 'SELECT * FROM customer WHERE customer_id = ?';

    $statement = $db->prepare($sql);

    // 3. Run the query
    $success = $statement->execute(
        [$customer_id]
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
