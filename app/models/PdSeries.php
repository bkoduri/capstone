<?php

class PdSeries
{
  public $pd_id;
  public $collected_time;
  public $rpm;
  public $coolant_temp;
  public $soot_buildup;
  public $average_consumption;
//Get details from db as rows
  public function __construct($row) {
    $this->pd_id = $row['pd_id'];
//each column data is extracted
    $this->collected_time = $row['collected_time'];
    $this->rpm = $row['rpm'];
    $this->coolant_temp = $row['coolant_temp'];
    $this->soot_buildup = $row['soot_buildup'];
    $this->average_consumption = $row['average_consumption'];  }

  public function create() {
    $db = new PDO(DB_SERVER, DB_USER, DB_PW);
    $sql = 'INSERT INTO pd_time_series (pd_id,collected_time,rpm,coolant_temp,soot_buildup,average_consumption)
            VALUES (?,?,?,?,?,?)';
    $statement = $db->prepare($sql);
    $success = $statement->execute([
        $this->pd_id,
        $this->collected_time,
        $this->rpm ,
        $this->coolant_temp,
        $this->soot_buildup,
        $this->average_consumption
    ]);
    if (!$success) {
      die ('Bad SQL on insert');
    }
}
  public static function fetchAll() {
      // 1. Connect to the database
      $db = new PDO(DB_SERVER, DB_USER, DB_PW);
      // 2. Prepare the query
      $sql = 'SELECT * FROM pd_time_series';
      $statement = $db->prepare($sql);
      // 3. Run the query
      $success = $statement->execute();
      // 4. Handle the results
      $arr = [];
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $thePdSeries =  new PdSeries($row);
        array_push($arr, $thePdSeries);
      }

      return $arr;
    }

}
