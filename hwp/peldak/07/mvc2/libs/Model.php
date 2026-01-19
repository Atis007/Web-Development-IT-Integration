<?php

namespace Mvc\libs;

class Model
{

    function __construct()
    {
        $this->connection = Database::connect();
    }

}