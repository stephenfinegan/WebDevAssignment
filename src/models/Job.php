<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 29/04/2016
 * Time: 11:48
 */

/**
 * namespace for job model
 */
namespace StephenFinegan\models;

use Mattsmithdev\PdoCrud\DatabaseManager;
use Mattsmithdev\PdoCrud\DatabaseTable;

/**
 * CRUDS from database table jobs
 * Class Job
 * @package StephenFinegan\models
 */
class Job extends DatabaseTable
{
    /**
     * unique id
     * @var
     */
    private $id;

    /**
     * username
     * @var
     */
    private $username;

    /**
     * company name
     * @var
     */
    private $company;

    /**
     * job title
     * @var
     */
    private $title;

    /**
     * job description
     * @var
     */
    private $description;

    /**
     * job deadline
     * @var
     */
    private $deadline;

    /**
     * accepted jobs
     * @var
     */
    private $accepted;

    /**
     * returns unique id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * returns username
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * sets username
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * returns company
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * sets username
     * @param $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * returns title
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * sets title
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * returns description
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * sets description
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * return deadline
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * set deadline
     * @param $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * returns accepted jobs
     * @return mixed
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * sets accepted jobs
     * @param $accepted
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
    }

    /**
     * inserts job into the jobs database
     * @param $username
     * @param $company
     * @param $title
     * @param $description
     * @param $deadline
     */
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

    /**
     * gets all information from the jobs database table
     * @return array
     */
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

    /**
     * gets job from unique username
     * @param $username
     * @return mixed|null
     */
    public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM jobs WHERE username=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\StephenFinegan\\Models\\Job');
        $statement->execute();

        if ($CV = $statement->fetch()) {
            return $CV;
        } else {
            return null;
        }
    }

    /**
     * gets job by unique id
     * @param $id
     * @return mixed|null
     */
    public static function getOneById($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM jobs WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\StephenFinegan\\Models\\Job');
        $statement->execute();

        if ($job = $statement->fetch()) {
            return $job;
        } else {
            return null;
        }
    }

    /**
     * removes job by unique id
     * @param $id
     * @return bool|null
     */
    public static function removeOneById($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'DELETE FROM jobs WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\StephenFinegan\\Models\\Job');
        $statement->execute();

        if ($statement->fetch()) {
            return true;
        } else {
            return null;
        }
    }

    /**
     * accepts job by unique id
     * @param $id
     * @return bool|null
     */
    public static function acceptOneById($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'UPDATE jobs SET accepted=1 WHERE id=:id';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\StephenFinegan\\Models\\Job');
        $statement->execute();

        if ($statement->fetch()) {
            return true;
        } else {
            return null;
        }
    }
}
