<?php
session_start();
class DBConnections
{

    private $db;
    private $conn;
    private $mysqli;

    function  __construct()
    {
        $hostname_login = "localhost"; //host
        $database_login = "tcaredb"; //dbname
        $username_login = "tcareUser";//db username
        $password_login = "tcarePassword28;"; //db password
        $this->conn = mysqli_connect($hostname_login, $username_login, $password_login, $database_login) or trigger_error(mysqli_error($this->getConnection()),E_USER_ERROR);
    }

    function getConnection()
    {
        return $this->conn;
    }


    public function executeQuery($qry)
    {
        $res=mysqli_query($this->conn,$qry) or die(mysqli_error($this->getConnection()));
        return $res;

    }

    public function fetchData($qry)
    {
        $res=mysqli_query($this->conn, $qry) or die(mysqli_error($this->getConnection()));
        $rs=mysqli_fetch_assoc($res);
        return $rs;
    }

    public function fetchArrayData($qry)
    {
        $res=mysqli_query($this->conn, $qry) or die(mysqli_error($this->getConnection()));
        $rs=mysqli_fetch_array($res, MYSQLI_ASSOC);
        return $rs;
    }

    function getNumOfRows($qry)
    {
        $res=mysqli_query($this->conn, $qry) or  die(mysqli_error($this->getConnection()));
        $num=mysqli_num_rows($res);
        return $num;
    }


    function checkIfExists($table,$field,$value)
    {
        $res = mysql_query("SELECT * FROM $table WHERE $field = '$value'") or die(mysqli_error($this->getConnection()));
        if(mysql_num_rows($res)>0)
            return true;
        else
            return false;
    }

}//end class Connection

?>