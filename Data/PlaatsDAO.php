<?php
//Data/PlaatsDAO
declare(strict_types=1);

namespace Data;

use PDO;
use Data\DBConfig;
use Entities\Plaats;
use PDOException;
use Exceptions\DatabaseException;


class PlaatsDAO
{

    public function getPlaatsById(int $id): ?Plaats
    {
        try {
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare("SELECT * FROM plaatsen WHERE plaatsId = :id");
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $resultSet = $stmt->fetch(PDO::FETCH_ASSOC);
            $plaats = new Plaats($id, $resultSet["plaats"], $resultSet["postcode"]);
            $dbh = null;
            return $plaats;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }
}
