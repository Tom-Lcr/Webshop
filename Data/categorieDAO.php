<?php

declare(strict_types=1);

namespace Data;

use PDO;
use Data\DBConfig;
use Entities\Categorie;
use PDOException;
use Exceptions\DatabaseException;

class CategorieDAO
{
    public function getAllCategorieen(): ?array
    {
        $sql = "select * from categorieen";
        try {
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $resultSet = $dbh->query($sql);
            $lijst = array();
            foreach ($resultSet as $rij) {
                $lijst[$rij["id"]] = new Categorie((int)$rij["categorieId"], $rij["naam"], $rij["hoofdCategorieId"]);
            }
            $dbh = null;
            return $lijst;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    //geeft lijst van ids van de categorieën die een subcategorie zijn van het hoofdcategorieId
    public function getSubcategorieIds(int $hoofdCategorieId): array
    {
        $sql = "SELECT categorieId FROM categorieen WHERE hoofdCategorieId = :hoofdCategorieId";
        try {
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(':hoofdCategorieId' => $hoofdCategorieId));
            $resultSet =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            $lijst = array();
            foreach ($resultSet as $rij) {
                array_push($lijst, $rij["categorieId"]);
            }
            $dbh = null;
            return $lijst;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }
    //geeft lijst van categorieën die een subcategorie zijn van het hoofdcategorieId
    public function getSubcategorieen(int $hoofdCategorieId): array
    {
        $sql = "SELECT * FROM categorieen WHERE hoofdCategorieId = :hoofdCategorieId";
        try {
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(':hoofdCategorieId' => $hoofdCategorieId));
            $resultSet =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            $lijst = array();
            foreach ($resultSet as $rij) {
                $lijst[$rij["id"]] = new Categorie((int)$rij["categorieId"], $rij["naam"], $rij["hoofdCategorieId"]);
            }
            $dbh = null;
            return $lijst;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    public function getHoofdcategorieen(): array
    {
        $sql = "SELECT * FROM categorieen WHERE hoofdCategorieId = NULL";
        try {
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $resultSet =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            $lijst = array();
            foreach ($resultSet as $rij) {
                $lijst[$rij["id"]] = new Categorie((int)$rij["categorieId"], $rij["naam"], $rij["hoofdCategorieId"]);
            }
            $dbh = null;
            return $lijst;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }
}
