<?php
//Data/PlaatsDAO
declare(strict_types=1);

namespace Data;

use PDO;
use Data\DBConfig;
use Entities\Plaats;
use PDOException;
use Exceptions\DatabaseException;


class PlaatsDAO {
    
    public function create($postcode, $plaatsNaam): ?Plaats {
        $plaats = $this->getPlaats($postcode);
        if (is_null($plaats)) { 
	       $sql = "insert into plaatsen (postcode, plaats) values (:postcode, :plaats)";
	       $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
	       $stmt = $dbh->prepare($sql);
           $stmt->bindValue(":postcode", $postcode);
           $stmt->bindValue(":plaats", $plaatsNaam);
           $stmt->execute();	
	       $plaatsId = $dbh->lastInsertId();
	
           $plaats = new Plaats((int)$plaatsId, $postcode, $plaatsNaam);

           $dbh = null;    
	       return $plaats;
        }else{
           return $plaats;
        }
    }

    public function getPlaats($postcode): ?Plaats
    {
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $sql = "select * from plaatsen where postcode = :postcode";
            $statement = $dbh->prepare($sql);
            $statement->bindValue(":postcode", $postcode);
            $statement->execute();
            $row = $statement->fetch(\PDO::FETCH_ASSOC);
            if ($row) {
                return new Plaats(
                    (int)$row["plaatsId"],
                    $row["postcode"],
                    $row["plaats"]
                );
            }else{
                return null;
            }

    }
   


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
