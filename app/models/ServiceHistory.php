<?php

class ServiceHistory
{
  public $service_id;
  public $pd_id;
  public $service_date;
  public $summary;
  public $health_grade;
//Get details from db as rows
  public function __construct($row) {
    $this->service_id = isset($row['service_id']) ? intval($row['service_id']) : null;
//each column data is extracted
    $this->pd_id = $row['pd_id'];
    $this->service_date = $row['service_date'];
    $this->summary = $row['summary'];
    $this->health_grade = $row['health_grade'];
  }

  public function create() {
    $db = new PDO(DB_SERVER, DB_USER, DB_PW);
    $sql = 'INSERT INTO service_history (service_id,pd_id,service_date,summary,health_grade)
            VALUES (?,?,?,?,?)';
    $statement = $db->prepare($sql);
    $success = $statement->execute([
        $this->service_id,
        $this->pd_id,
        $this->service_date,
        $this->summary,
        $this->health_grade
    ]);
    if (!$success) {
      die ('Bad SQL on insert');
    }
    $this->service_id = $db->lastInsertId();
  }

  public static function fetchAll() {
      // 1. Connect to the database
      $db = new PDO(DB_SERVER, DB_USER, DB_PW);
      // 2. Prepare the query
      $sql = 'SELECT * FROM service_history';
      $statement = $db->prepare($sql);
      // 3. Run the query
      $success = $statement->execute();
      // 4. Handle the results
      $arr = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $theservice_history =  new ServiceHistory($row);
        array_push($arr, $theservice_history);
      }

      return $arr;
    }

}
