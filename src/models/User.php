<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 15/04/2016
 * Time: 17:20
 */

/**
 * namespace for user model
 */
namespace StephenFinegan\models;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

/**
 * class CRUDS from user database table
 * Class User
 * @package StephenFinegan\models
 */
class User extends DatabaseTable
{

    /**
     * constant that sets position as student
     */
    const POSITION_1=1;

    /**
     * constant that sets position 2 as lecturer
     */
    const POSITION_2=2;

    /**
     * constant that sets position 3 as employer
     */
    const POSITION_3=3;

    /**
     * unique id
     * @var
     */
    private $id;

    /**
     * users firstname
     * @var
     */
    private $firstname;

    /**
     * users surname
     * @var
     */
    private $surname;

    /**
     * username
     * @var
     */
    private $username;

    /**
     * hashed password
     * @var
     */
    private $hashedPassword;

    /**
     * users position
     * @var
     */
    private $position;

    /**
     * inserting new user into user table in database
     * @param Object $firstname
     * @param $surname
     * @param $username
     * @param $password
     * @param $position
     */
    public static function insert($firstname, $surname, $username, $hashedPassword, $position)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();
        $user = new User();
        $user->setHashedPassword($hashedPassword);
        $hashedPassword = $user->getHashedPassword();

        $sql = "INSERT INTO users VALUES (NULL, :firstname, :surname, :username, :hashedPassword, :position)";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, \PDO::PARAM_STR);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->bindParam(':hashedPassword', $hashedPassword, \PDO::PARAM_STR);
        $statement->bindParam(':position', $position, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();
    }

    /**
     * checking if username and password already exist
     * @param $username
     * @param $password
     * @return bool
     */
    public static function canFindMatchingUsernameAndPassword($username, $password)
    {
        $user = User::getOneByUsername($username);

        if (null == $user) {
            return false;
        }

        $hashedStoredPassword = $user->getHashedPassword();

        return password_verify($password, $hashedStoredPassword);
    }

    /**
     * getting a user by unique username
     * @param $username
     * @return mixed|null
     */
    public static function getOneByUsername($username)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM users WHERE username=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }

    /**
     * return unique id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * set unique id
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * return firstname
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * set firstname
     * @param $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * return surname
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * set surname
     * @param $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * return username
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * set username
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * return password
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * set password
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * return hashed password
     * @return mixed
     */
    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    /**
     * set hashed password
     * @param $password
     */
    public function setHashedPassword($password)
    {
        $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * return position
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }
}
