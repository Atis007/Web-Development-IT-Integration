<?php
namespace Mvc\models;
require "libs/Model.php";

use Mvc\libs\Model;

class Category extends Model
{

    public function getAllCategory()
    {

        $sql = "SELECT * FROM category";
        $result = mysqli_query($this->connection, $sql) or die(mysqli_error($this->connection));

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createCategory($data)
    {

        $sql = "INSERT INTO category ('name') VALUES ('$data[name]')";

        $result = mysqli_query($this->connection, $sql) or die(mysqli_error($this->connection));

        return "success";
    }

}

?>

