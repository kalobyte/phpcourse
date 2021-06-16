<?php

namespace App;
use Aura\SqlQuery\QueryFactory;
use PDO;


//require "./vendor/autoload.php";



class QueryBuilder
{
private $db;
private $queryFactory;

public function __construct(array $_config)
    {
        $this->pdo = new PDO('mysql:host='.$_config["host"].';dbname='.$_config["database"].';charset=utf8',
            $_config["username"],
            $_config["password"]);
        $this->queryFactory = new QueryFactory('mysql', QueryFactory::COMMON);
    }

    public function select($table)
    {
        $select  = $this->queryFactory->newSelect();
        $select->cols(["*"])->from($table);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectById($table, $id)
    {
        $select  = $this->queryFactory->newSelect();
        $select
            ->cols(["*"])
            ->from($table)
            ->where('id = :id')
            ->bindValue("id", $id);;

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data)
    {
        $insert = $this->queryFactory->newInsert();
        $insert->into($table)->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());

        $sth->execute($insert->getBindValues());

        $name = $insert->getLastInsertIdName('id');
        return $this->pdo->lastInsertId($name);
    }

    public function update($table, $data, $id)
    {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($data)
            ->where('id = :id')
            ->bindValue("id", $id);

        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function delete($table, $id)
    {
        $delete = $this->queryFactory->newDelete();
        $delete->from($table)
            ->where('id = :id')
            ->bindValue("id", $id);

        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }
}