<?php /** @noinspection SqlInsertValues */

namespace HummNGIN\Repository;

use Error;
use HummNGIN\Models\DynamicModel;
use HummNGIN\Util\Debug;
use PDO;
use PDOStatement;

class DynamicRepository extends BaseRepository
{
    private string $table_name;

    private PDO $pdo;

    /**
     * @param string $table_name
     */
    public function __construct(string $table_name)
    {
        parent::__construct();
        $this->table_name = $table_name;

        $this->pdo = $this->database->connect();
    }


    public function getOne(string $value_name, string $value): ?DynamicModel
    {


        $stmt = $this->pdo->prepare(
            'SELECT * FROM ' . $this->table_name . ' WHERE ' . $value_name . ' = :' . $value_name . ';'
        );
        $stmt->bindParam(':' . $value_name, $value, PDO::PARAM_STR);
        $stmt->execute();

        $db_result = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($db_result == false) {
            return null;
        }
        Debug::Database(['sql' => $stmt->queryString, 'response' => json_encode($db_result, JSON_PRETTY_PRINT)]);


        return new DynamicModel(
            $this->table_name,
            $db_result
        );

    }

    public function updateAt(array $update_dict, int $id)
    {
        if ($id <= 0) {
            throw new Error("ID cannot be less or equal to 0");
        }

        $where_dict = (['id' => $id]);

        $statements = $this->ConvertWhere(['id' => $id]);
        $values = $this->ConvertSet($update_dict);

        $sql = "UPDATE $this->table_name SET $values WHERE $statements";

        $stmt = $this->pdo->prepare($sql);

        $stmt = $this->BindParams(['WHERE' => $where_dict, 'SET' => $update_dict], $stmt);

        if (!$stmt->execute())
            throw new Error(json_encode($stmt->errorInfo()));

        if ($stmt->rowCount() == 0) {
            throw new Error("Object with `id` == $id  was not found in " . $this->tableName() . " or there was no change table.");
        }
    }

    function ConvertWhere(array $key_value): string
    {
        $statements = [];
        foreach ($key_value as $key => $value) {
            $statements[] = "$key = :WHERE_$key";
        }
        return implode(" AND ", $statements);
    }

    function ConvertSet(array $key_value): string
    {
        $statements = [];
        foreach ($key_value as $key => $value) {
            $statements[] = "$key = :SET_$key";
        }
        return implode(" , ", $statements);
    }

    function BindParams(array $keys, $stmt): PDOStatement
    {
        foreach ($keys['WHERE'] as $key => $value) {
            $stmt->bindValue(':WHERE_' . $key, $value, PDO::PARAM_STR);
        }

        foreach ($keys['SET'] as $key => $value) {
            $stmt->bindValue(':SET_' . $key, $value, PDO::PARAM_STR);
        }
        return $stmt;
    }

    public function tableName(): string
    {
        return $this->table_name;
    }

    public function join(string $table_name, string $col1_name, $col2_name): ?DynamicModel
    {


        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM ' . $this->table_name . ' RIGHT JOIN ' . $table_name . ' ON ' . $this->table_name . '.' . $col1_name . ' =  ' . $table_name . '.' . $col2_name . ';'
        );

        $stmt->execute();

        $db_result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($db_result == false) {
            return null;
        }

        return new DynamicModel(
            $table_name,
            $db_result
        );


    }

    public function joinWhere(string $table_name, string $col1_name, $col2_name, string $value_name, string $value): ?array
    {
        $sql = 'SELECT * FROM ' . $this->table_name .
            ' RIGHT JOIN ' . $table_name .
            ' ON ' . $this->table_name . '.' . $col1_name . ' = ' . $table_name . '.' . $col2_name .
            ' WHERE ' . $value_name . ' = :' . $value_name . ';';

        Debug::Debug('llll', $sql);

        $stmt = $this->database->connect()->prepare($sql
        );
        $stmt->bindParam(':' . $value_name, $value, PDO::PARAM_STR);
        $stmt->execute();


        $model_array = array();


        if ($stmt->rowCount() > 0) {
            // output data of each row
            while ($row = $stmt->fetch()) {

                $model_array[] = new DynamicModel(
                    $this->table_name,
                    $row
                );

            }
        } else {
            return null;
        }

        return $model_array;
    }

    public function sqlBind(string $sql, array $key_value): array
    {

        $stmt = $this->database->connect()->prepare(
            $sql
        );

        foreach ($key_value as $key => $value) {
            $stmt->bindParam(':' . $key, $value, PDO::PARAM_STR);
        }


        $stmt->execute();

        $model_array = array();

        $debug_rows = array();

        if ($stmt->rowCount() > 0) {
            // output data of each row
            while ($row = $stmt->fetch()) {
                $debug_rows[] = $row;

                $model_array[] = new DynamicModel(
                    $this->table_name,
                    $row
                );

            }
        } else {
            echo null;
        }
        Debug::Database(['sql' => $stmt->queryString, 'response' => json_encode($debug_rows, JSON_PRETTY_PRINT)]);
        return $model_array;
    }

    public function where(array $key_value, string $order_by = "id", $order = "ASC"): array
    {

        $statements = [];

        foreach ($key_value as $key => $value) {
            $statements[] = "$key = :$key";
        }

        $whereString = implode(" AND ", $statements);


        if (count(explode(" ", $order_by)) > 1) {
            throw new Error("Not valid order column names", 500);
        }

        if (!in_array($order, ['ASC', 'DESC'])) {
            throw new Error("Ordering is only ASC or DESC not `$order`", 500);
        }

        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM ' . $this->table_name . ' WHERE ' . $whereString . ' ORDER BY ' . $order_by . ' ' . $order . ';'
        );

        foreach ($key_value as $key => $value) {
            $stmt->bindParam(':' . $key, $value, PDO::PARAM_STR);
        }


        $stmt->execute();

        $model_array = array();

        $debug_rows = array();

        if ($stmt->rowCount() > 0) {
            // output data of each row
            while ($row = $stmt->fetch()) {
                $debug_rows[] = $row;

                $model_array[] = new DynamicModel(
                    $this->table_name,
                    $row
                );

            }
        } else {
            echo null;
        }
        Debug::Database(['sql' => $stmt->queryString, 'response' => json_encode($debug_rows, JSON_PRETTY_PRINT)]);
        return $model_array;


    }

    public function get(string $value_name, string $value, string $order_by = "id", $order = "ASC"): array
    {

        if (count(explode(" ", $order_by)) > 1) {
            throw new Error("Not valid order column names", 500);
        }

        if (!in_array($order, ['ASC', 'DESC'])) {
            throw new Error("Ordering is only ASC or DESC not `$order`", 500);
        }

        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM ' . $this->table_name . ' WHERE ' . $value_name . ' = :' . $value_name . ' ORDER BY ' . $order_by . ' ' . $order . ';'
        );

        $stmt->bindParam(':' . $value_name, $value, PDO::PARAM_STR);

        $stmt->execute();

        $model_array = array();

        $debug_rows = array();

        if ($stmt->rowCount() > 0) {
            // output data of each row
            while ($row = $stmt->fetch()) {
                $debug_rows[] = $row;

                array_push($model_array, new DynamicModel(
                    $this->table_name,
                    $row
                ));

            }
        } else {
            echo null;
        }
        Debug::Database(['sql' => $stmt->queryString, 'response' => json_encode($debug_rows, JSON_PRETTY_PRINT)]);
        return $model_array;


    }

    public function add(DynamicModel $user)
    {
        $sql_vars = implode(",", $user->getVarNames());
        $sql_vars_helper = implode(',', array_fill(0, count($user->getVarNames()), '?'));

        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (' . $sql_vars . ')
            VALUES (' . $sql_vars_helper . ')
        ');

        $stmt->execute([$user->getVars()]);
    }

    public function getAll(string $order_by = "id", $order = "ASC")
    {
        if (count(explode(" ", $order_by)) > 1) {
            throw new Error("Not valid order column names", 500);
        }

        if (!in_array($order, ['ASC', 'DESC'])) {
            throw new Error("Ordering is only ASC or DESC not `$order`", 500);
        }

        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM ' . $this->table_name . ' ORDER BY ' . $order_by . ' ' . $order . ';'
        );

        $stmt->execute();

        $model_array = array();

        $debug_rows = array();

        if ($stmt->rowCount() > 0) {
            // output data of each row
            while ($row = $stmt->fetch()) {
                $debug_rows[] = $row;

                $model_array[] = new DynamicModel(
                    $this->table_name,
                    $row
                );

            }
        } else {
            echo null;
        }
        Debug::Database(['sql' => $stmt->queryString, 'response' => json_encode($debug_rows, JSON_PRETTY_PRINT)]);
        return $model_array;
    }

    public function insertOne(mixed $data_dict)
    {
        if (count($data_dict) <= 0) {
            throw new Error("Cannot insert empty object");
        }

        $values = $this->ConvertSet($data_dict);

        $sql = "INSERT INTO $this->table_name VALUES $values;";

        $stmt = $this->pdo->prepare($sql);

        $stmt = $this->BindParams(['SET' => $values], $stmt);

        if (!$stmt->execute())
            throw new Error(json_encode($stmt->errorInfo()));

        if ($stmt->rowCount() == 0) {
            throw new Error("Nothing inserted.");
        }

        return $this->pdo->lastInsertId();

    }
}