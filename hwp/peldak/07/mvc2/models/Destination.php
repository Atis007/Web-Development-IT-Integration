<?php
namespace Mvc\models;
require "libs/Model.php";

use Mvc\libs\Model;

class Destination extends Model
{

    public function getAllDestinations()
    {

        $sql = "SELECT * FROM destination";
        $result = mysqli_query($this->connection, $sql) or die(mysqli_error($this->connection));

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getDestinationCategory($id_category)
    {

        $sql = "SELECT * FROM destination WHERE id_category='$id_category'";
        $result = mysqli_query($this->connection, $sql) or die(mysqli_error($this->connection));

        return $result->fetch_all(MYSQLI_ASSOC);
    }

}

?>

