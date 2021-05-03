<?php

class Database
{

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "psychnova3";

    public function connect()
    {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);
        return $connection;
    }

    //returns data from database based on the provided query
    public function read($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if (!$result) {
            return false;
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function readOne($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if (!$result) {
            return false;
        } else {
            //if only one row
            if (mysqli_num_rows($result) == 1) {
                return mysqli_fetch_assoc($result);
            }
        }
    }

    public function readById($query, $id)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if (!$result) {
            return false;
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[$row[$id]] = $row;
        }

        return $data;
    }

    public function exists($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //saves data to the database and returns true if successful, otherwise false
    public function save($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if (!$result) {
            return false;
        } else {
            return true;
        }
    }
}

/*
$db = new Database();

$query = "select * from user";
$data = $db->read($query);

echo "<pre>";
print_r($data);
echo "</pre>";
*/
