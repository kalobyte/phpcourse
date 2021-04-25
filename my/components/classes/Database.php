<?php

Class Database
{
    private static $instance = null;
    private $pdo, $query, $results, $count, $error = false;

    private function __construct()
    {
        $this->pdo = new PDO('mysql:host='.Config::get("mysql.host").';dbname='.Config::get("mysql.database").';charset=utf8', Config::get("mysql.username"), Config::get("mysql.password"));

    }

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query($sql, $params =[])
    {
        $this->error = false;

        $this->query = $this->pdo->prepare($sql);

        if(count($params))
        {
            $i = 1;
            foreach($params as $param)
            {
                $this->query->bindValue($i, $param);
                $i++;
            }

        }

        if(!$this->query->execute())
        {
            $this->error = true;
        }
        else
        {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);

            $this->count = $this->query->rowCount();
        }


        return $this;
    }

    public function error()
    {
        return $this->error;
    }

    public function results()
    {
        return $this->results;
    }

    public  function count()
    {
        return $this->count;
    }

    public function get($table, $where = [])
    {
        return $this->action("select *", $table, $where);
    }

    public function delete($table, $where =[])
    {
        return $this->action("delete", $table, $where);
    }

    private function action($action, $table, $where = [])
    {
        if(count($where)===3)
        {
            $operators = ['<', '>', '=', '<=', '=>'];
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators))
            {
                $sql = "{$action} from {$table} where {$field} {$operator} ?";
                if(!$this->query($sql, [$value])->error())
                {
                    return $this;
                }
            }
        }
        return false;
    }

    public function insert($table, $fields = [])
    {
        $values = '';
        foreach($fields as $field)
        {
            $values.='?,';
        }
        $val = rtrim($values, ',');

        $sql = "insert into {$table} (`".implode("`, `", array_keys($fields)). "`) values ({$val})";

        if(!$this->query($sql,$fields)->error())
        {
            return true;
        }

        return false;
    }

    public function update($table, $id, $fields = [])
    {
        $set ='';
        foreach($fields as $key => $field)
        {
            $set .= "{$key} = ?,";
        }
        $set = rtrim($set, ',');

        $sql = "update {$table} set {$set} where id = {$id}";
        if(!$this->query($sql,$fields)->error())
        {
            return true;
        }

        return false;
    }

    public function first()
    {
        return $this->results()[0];
    }
}

?>