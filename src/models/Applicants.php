<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 02/05/2016
 * Time: 16:15
 */

/**
 *namespace for applicants model
 */
namespace StephenFinegan\models;

use Mattsmithdev\PdoCrud\DatabaseManager;
use Mattsmithdev\PdoCrud\DatabaseTable;

/**
 * This class CRUDS from a database table applicants.
 * Class Applicants
 * @package StephenFinegan\models
 */
class Applicants extends DatabaseTable
{
    /**
     * unique id
     * @var
     */
    private $id;

    /**
     * students name
     * @var
     */
    private $studentID;

    /**
     * job id
     * @var
     */
    private $jobID;

    /**
     * returns if
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * sets id
     * @param $id
     */
    public function setID($id)
    {
        $this->id= $id;
    }

    /**
     * returns student id
     * @return mixed
     */
    public function getStudentId()
    {
        return $this->studentID;
    }

    /**
     * sets the students id
     * @param $studentID
     */
    public function setStudentID($studentID)
    {
        $this->studentID= $studentID;
    }

    /**
     * returns job id
     * @return mixed
     */
    public function getJobId()
    {
        return $this->jobID;
    }

    /**
     * sets job id
     * @param $jobID
     */
    public function setJobID($jobID)
    {
        $this->jobID= $jobID;
    }

    /**
     * user apply's for job adds students name and job id into database table applications
     * @param $jobID
     * @param $studentID
     */
    public static function apply($jobID, $studentID)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = "INSERT INTO applications VALUES ( NULL, :studentID, :jobID)";
        $statement = $connection->prepare($sql);
        $statement->bindParam(":jobID", $jobID, \PDO::PARAM_STR);
        $statement->bindParam(":studentID", $studentID, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();
    }

    /**
     * returns application from database that match job id and student id
     * @param $studentID
     * @param $jobID
     * @return mixed|null
     */
    public static function getApplicantsByUsernameAndId($studentID, $jobID)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = "SELECT * FROM applications WHERE jobId = :jobId AND studentID LIKE :studentID";
        $statement = $connection->prepare($sql);
        $statement->bindParam(":jobId", $jobId, \PDO::PARAM_INT);
        $statement->bindParam(":studentID", $applicant, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($application = $statement->fetch()) {
            return $application;
        } else {
            return null;
        }
    }

    /**
     * returns applications for a job that matches the job id
     * @param $jobId
     * @return array|null
     */
    public static function getApplicantsById($jobId)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = "SELECT * FROM applications WHERE jobId = :id";
        $statement = $connection->prepare($sql);
        $statement->bindParam(":id", $jobId, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($application = $statement->fetchAll()) {
            return $application;
        } else {
            return null;
        }
    }
}
