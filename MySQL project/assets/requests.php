<?php

class Requests
{
    public function __construct(
        $conn,
        $table,
        $where = false,
        $value = false,
        $limit = false
    )
    {
        $this->conn = $conn;
        $this->table = $table;
        $this->where = $where;
        $this->value = $value;
        $this->limit = $limit;
    }

    public function select()
    {
        if ($this->where == false and $this->value == false and $this->limit == false) {
            return $this->conn->query("SELECT * FROM {$this->table}");
        } elseif ($this->where == false and $this->value == false and $this->limit != false) {
            return $this->conn->query("SELECT * FROM {$this->table} LIMIT {$this->limit}");
        } elseif ($this->where != false and $this->value != false and $this->limit == false) {
            return $this->conn->query("SELECT * FROM {$this->table} WHERE `{$this->where}` = {$this->value}");
        } elseif ($this->where != false and $this->value != false and $this->limit != false) {
            return $this->conn->query("SELECT * FROM {$this->table} WHERE `{$this->where}` = {$this->value} LIMIT {$this->limit}");
        }
    }

    public function insert()
    {
        $sql = "INSERT INTO `{$this->table}` ({$this->where}) VALUES ({$this->value})";
        return $this->conn->exec($sql);
    }
}