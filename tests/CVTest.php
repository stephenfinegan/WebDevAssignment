<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 02/05/2016
 * Time: 21:44
 */

namespace StephenFineganTests;


use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;
use StephenFinegan\Models\CV;

class CVTest extends \PHPUnit_Extensions_Database_TestCase
{
    public function testCreateObject()
    {
        // Arrange
        $CV = new CV();
        // Act
        // Assert
        $this->assertNotNull($CV);
    }

    public function testSetGetFirstName()
    {
        // Arrange
        $cv = new CV();
        $cv->setFirstname('stephen');
        $expectedResult = 'stephen';
        // Act
        $result = $cv->getFirstname();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testSetGetSecondName()
    {
        // Arrange
        $cv = new CV();
        $cv->setSurname('finegan');
        $expectedResult = 'finegan';
        // Act
        $result = $cv->getSurname();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testSetGetEmail()
    {
        // Arrange
        $cv = new CV();
        $cv->setEmail('finegan@gmail.com');
        $expectedResult = 'finegan@gmail.com';
        // Act
        $result = $cv->getEmail();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testSetGetNumber()
    {
        // Arrange
        $cv = new CV();
        $cv->setNumber('012345');
        $expectedResult = '012345';
        // Act
        $result = $cv->getNumber();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testSetGetPicture()
    {
        // Arrange
        $cv = new CV();
        $cv->setPicture('finegan.jpg');
        $expectedResult = 'finegan.jpg';
        // Act
        $result = $cv->getPicture();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testSetGetAddress()
    {
        // Arrange
        $cv = new CV();
        $cv->setAddress('10 fairways');
        $expectedResult = '10 fairways';
        // Act
        $result = $cv->getAddress();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testTown()
    {
        // Arrange
        $cv = new CV();
        $cv->setTown('finglas');
        $expectedResult = 'finglas';
        // Act
        $result = $cv->getTown();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testSetGetPreviousJobs()
    {
        // Arrange
        $cv = new CV();
        $cv->setPreviousJobs('spar');
        $expectedResult = 'spar';
        // Act
        $result = $cv->getPreviousJobs();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testSetGetQualifications()
    {
        // Arrange
        $cv = new CV();
        $cv->setQualifications('programmer');
        $expectedResult = 'programmer';
        // Act
        $result = $cv->getQualifications();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testRowsFromSeedData()
    {
        // arrange
        $numRowsAtStart = 1;
        $expectedResult = $numRowsAtStart;
        // act
        // assert
        $this->assertEquals($expectedResult, $this->getConnection()->getRowCount('cvs'));
    }


    public function testGetOneByUsername()
    {
        // Arrange
        $cv = CV::getOneByUsername("student");
        $expectedResult = "student";
        // Act
        $result = $cv->getUsername();
        // Assert
        $this->assertEquals($expectedResult, $result);
    }
    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
        $host = DB_HOST;
        $dbName = DB_NAME;
        $dbUser = DB_USER;
        $dbPass = DB_PASS;
        // mysql
        $dsn = 'mysql:host=' . $host . ';dbName=' . $dbName;
        $db = new \PDO($dsn, $dbUser, $dbPass);
        $connection = $this->createDefaultDBConnection($db, $dbName);
        return $connection;
    }
    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        $seedFilePath = __DIR__ . '/databaseXml/seed.xml';
        return $this->createXMLDataSet($seedFilePath);
    }
}