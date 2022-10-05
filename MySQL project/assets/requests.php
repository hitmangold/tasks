<?php
class Requests{
    public function __construct($conn,$table,$where=False,$value=False,$limit=False){
        $this->conn = $conn;
        $this->table = $table;
        $this->where = $where;
        $this->value = $value;
        $this->limit = $limit;
    }
    public function select(){
        if($this->where == False and $this->value == False and $this->limit == False){
            return $this->conn->query("SELECT * FROM {$this->table}");
        }
        else if($this->where == False and $this->value == False and $this->limit != False){
            return $this->conn->query("SELECT * FROM {$this->table} LIMIT {$this->limit}");
        }
        else if($this->where != False and $this->value != False and $this->limit == False){
            return $this->conn->query("SELECT * FROM {$this->table} WHERE `{$this->where}` = {$this->value}");
        }
        else if($this->where != False and $this->value != False and $this->limit != False){
            return $this->conn->query("SELECT * FROM {$this->table} WHERE `{$this->where}` = {$this->value} LIMIT {$this->limit}");
        }
    }
    public function insert(){
        $sql = "INSERT INTO `{$this->table}` ({$this->where}) VALUES ({$this->value})";
        return $this->conn->exec($sql);
    }
}