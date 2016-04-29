<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 15/04/2016
 * Time: 17:20
 */

namespace StephenFinegan\Models;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class User extends DatabaseTable{

    const POSITION_1=1;
    const POSITION_2=2;
    const POSITION_3=3;

    private $id;
    private $firstname;
    private $surname;
    private $username;
    private $password;
    private $hashedPassword;
    private $position;

    /**
     * @param Object $firstname
     * @param $surname
     * @param $username
     * @param $password
     * @param $position
     */
    public static function insert($firstname, $surname, $username, $password, $position)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();
        $user = new User();
        $user->setHashedPassword($password);
        $hashedPassword = $user->getHashedPassword();

        $sql = "INSERT INTO users VALUES (NULL, :firstname, :surname, :username, :password, :hashedPassword, :position)";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, \PDO::PARAM_STR);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->bindParam(':password', $password, \PDO::PARAM_STR);
        $statement->bindParam(':hashedPassword', $hashedPassword, \PDO::PARAM_STR);
        $statement->bindParam(':position', $position, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();
    }

    public static function canFindMatchingUsernameAndPassword($username, $password)
    {
        $user = User::getOneByUsername($username);

        if (null == $user) {
            return false;
        }

        $hashedStoredPassword = $user->getHashedPassword();

        return password_verify($password, $hashedStoredPassword);
    }

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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname){
        $this->firstname = $firstname;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname){
        $this->surname = $surname;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username){
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    public function setHashedPassword($password)
    {
        $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getPosition()
    {
        return $this->position;
    }

}