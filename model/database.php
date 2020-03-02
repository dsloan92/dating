<?php

/*CREATE TABLE member (
    member_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fname varchar(255),
    lname varchar(255),
    age int,
    gender varchar(1),
    phone varchar(12),
    email varchar(255),
    state varchar(2),
    seeking varchar(50),
    bio varchar (255),
    premium tinyint
);*/

/*CREATE TABLE interest (
    interest_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    interest varchar (255),
    type varchar (50)

);*/

/*CREATE TABLE member_interest (
    member_id int,
    interest_id int,
    FOREIGN KEY (member_id) REFERENCES member(member_id),
    FOREIGN KEY (interest_id) REFERENCES interest(interest_id)
);*/

require_once ("config-student.php");

class Database
{
    //PDO object
    private $_dbh;

    function __construct()
    {
        try {
            //Create a new PDO connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            //echo "Connected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    function connect()
    {

    }

    function insertMember($member)
    {

        //1. Define the query
        $sql = "INSERT INTO member (fname, lname, age, gender, phone, email, state, seeking, bio, premium)
                VALUES(:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium)";

        //2.prepare the statement (compiles)
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':fname', $member->getFname());
        $statement->bindParam(':lname', $member->getLname());
        $statement->bindParam(':age', $member->getAge());
        $statement->bindParam(':gender', $member->getGender());
        $statement->bindParam(':phone', $member->getPhone());
        $statement->bindParam(':email', $member->getEmail());
        $statement->bindParam(':state', $member->getState());
        $statement->bindParam(':seeking', $member->getSeeking());
        $statement->bindParam(':bio', $member->getBio());
        $statement->bindParam(':premium', $member->getPremium());

        //4. Execute the statement
        $statement->execute();

        //Get the key of the last inserted row
        $id = $this->_dbh->lastInsertId();
        return $id;


    }

    function getMembers()
    {
        //1. define the query
        $sql = "SELECT * FROM member
                ORDER BY last, first";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameter
        //no parameter for this function

        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;


    }

    function getMember($member_id)
    {
            //1. define the query
        $sql = "SELECT * FROM member WHERE member_id = :member_id";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameter
        $statement->bindParam(":member_id", $member_id);

        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;


    }

    function getInterests($member_id_)
    {
        //1. define the query
        $sql = "SELECT member.*, interest.interest FROM member, member_interest, interest
                WHERE member_id = :member_id";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameter
        $statement->bindParam(":member_id", $member_id);

        //4. Execute the statement
        $statement->execute();

        //5. Get the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;


    }

    function newInterest($member_id, $interest_id){
        $sql = "Insert INTO member_interest
                VALUES (:memberID, :interestID)";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam('memberID', $member_id);
        $statement->bindParam('interestID', $interest_id);

        $statement->execute();


    }

}
