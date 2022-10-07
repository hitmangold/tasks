<?php

class Query
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
        $select = "SELECT * FROM {$this->table}";
        if ($this->where == false and $this->value == false and $this->limit == false) {
            return $this->conn->query($select);
        } elseif ($this->where == false and $this->value == false and $this->limit != false) {
            return $this->conn->query($select . " LIMIT {$this->limit}");
        } elseif ($this->where != false and $this->value != false and $this->limit == false) {
            return $this->conn->query($select . " WHERE `{$this->where}` = {$this->value}");
        } elseif ($this->where != false and $this->value != false and $this->limit != false) {
            return $this->conn->query($select . " WHERE `{$this->where}` = {$this->value} LIMIT {$this->limit}");
        }
    }

    public function insert()
    {
        $sql = "INSERT INTO `{$this->table}` ({$this->where}) VALUES ({$this->value})";
        return $this->conn->exec($sql);
    }
}