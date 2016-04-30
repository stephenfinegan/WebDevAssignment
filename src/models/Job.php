<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 29/04/2016
 * Time: 11:48
 */

namespace StephenFinegan\Models;


use Mattsmithdev\PdoCrud\DatabaseManager;
use Mattsmithdev\PdoCrud\DatabaseTable;

class Job extends DatabaseTable {

    private $id;
    private $username;
    private $company;
    private $title;
    private $description;
    private $deadline;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    public static function insertJob($username, $company, $title, $description, $deadline)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $statement = $connection->prepare('INSERT into jobs (username, company, title, description, deadline)
        VALUES (:username, :company,:title, :description, :deadline)');
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->bindParam(':company', $company, \PDO::PARAM_STR);
        $statement->bindParam(':title', $title, \PDO::PARAM_STR);
        $statement->bindParam(':description', $description, \PDO::PARAM_STR);
        $statement->bindParam(':deadline', $deadline, \PDO::PARAM_STR);
        $statement->execute();
    }

    public static function getAll()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM jobs';
        $statement = $connection->prepare($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        $objects = $statement->fetchAll();
        return $objects;
    }

    public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM jobs WHERE username=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS,'\\StephenFinegan\\Models\\Job');
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }

    public static function getOneById($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM jobs WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS,'\\StephenFinegan\\Models\\Job');
        $statement->execute();

        if ($job = $statement->fetch()) {
            return $job;
        } else {
            return null;
        }
    }

    public static function removeOneById($id){
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'DELETE FROM jobs WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS,'\\StephenFinegan\\Models\\Job');
        $statement->execute();

        if ($statement->fetch()) {
            return true;
        } else {
            return null;
        }
    }
}