<?php

class Product {
  public $product_id;
  public $product_name;
  public $category;

  public function __construct($row) {
    $this->product_id = isset($row['product_id']) ? intval($row['product_id']) : null;
    $this->product_name = $row['product_name'];
    $this->category = $row['category'];
  }

  public function create() {
    // 1. Create new db connection
    $db = new PDO(DB_SERVER, DB_USER, DB_PW);
    // 2. Prepare the query
    $sql = 'INSERT into product (product_id, product_name, category)
            VALUES              (?     ,?        ,?      )';
    $statement = $db->prepare($sql);
    // 3. Run the query
    $success = $statement->execute([
      $this->product_id,
      $this->product_name,
      $this->category
    ]);
    if (!$success) {
      die ('Bad SQL on insert');
    }
    $this->product_id = $db->lastInsertId();
  }

  public static function fetchAll() {
    // 1. Create db connection
    $db = new PDO(DB_SERVER, DB_USER, DB_PW);

    // 2. Prepare the query
    $sql = 'SELECT * FROM product';

    $statement = $db->prepare($sql);

    //3. Run the results
    $success = $statement->execute();

    // 4. Handle the results
    $arr = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $theProduct = new Product($row);
      array_push($arr, $theProduct);
    }
    return $arr;
  }
}
