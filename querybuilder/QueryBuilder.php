<?php
class QueryBuilder
{

    private $pdo;

    /**
     * QueryBuilder constructor.
     * @param array $_config - конфигурация базы данных
     */
    public function __construct(array $_config)
    {
        $this->pdo = new PDO('mysql:host='.$_config["host"].';dbname='.$_config["database"].';charset=utf8',
            $_config["username"],
            $_config["password"]);
    }

    /**
     * @param $table_name - имя таблицы в базе
     * @param null $params  -   дополнительные параметры запроса
     * @return array - все данные из таблицы
     */
    public function select($table_name, $params = null)
    {
        $sql  = "SELECT * FROM {$table_name}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // обработка параметров ограничений $params не реализована для экономии времени
    }

    /**
     * @param $table_name - имя таблицы в базе
     * @param null $params - ассоциативный массив данных
     * @return integer - ID последней записи в таблице
     */
    public function insert($table_name, $params)
    {
        $fields = implode(',', array_keys($params)); //делаем строку с названием полей в таблице через запятую
        $placeholder = ":" .implode(', :', array_keys($params)); // подготовка мест для данных

        $sql = "INSERT INTO {$table_name} ({$fields}) VALUES ({$placeholder})";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $this->pdo->lastInsertId();
    }

    /**
     * @param $table_name - имя таблицы в базе
     * @param null $params  -   дополнительные параметры запроса
     * @param integer $id - номер записи в таблице
     */
    public function update($table_name, $params, $id)
    {
         $sub_sql = "";
        foreach ($params as $key => $value)
        {
            $sub_sql.= "{$key} = :{$key}, ";
        }
        $sub_sql = rtrim($sub_sql, ", ");

        $sql = "UPDATE {$table_name} SET {$sub_sql} WHERE id = {$id}";
        $stmt = $this->pdo->prepare($sql);

        foreach($params as $key => $value)
        {
            $stmt->bindValue(":".$key, $value);
        }
        $stmt->execute();
    }

    /**
     * @param $table_name - имя таблицы в базе
     * @param integer $id  - номер записи в таблице
     */
    public function delete($table_name, $id)
    {
        $sql = "DELETE FROM {$table_name} WHERE id = {$id}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }
}