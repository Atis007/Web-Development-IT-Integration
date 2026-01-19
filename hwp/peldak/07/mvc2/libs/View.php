<?php

namespace Mvc\libs;

class View
{

    public function render($name, $data = [])
    {
        include_once __DIR__ . '/../views/' . $name . '.php';
    }

    function assign($key, $val)
    {
        $this->data[$key] = $val;
    }

}