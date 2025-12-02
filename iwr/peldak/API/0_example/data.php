<?php
$name = $_GET['name'] ?? "";
$id = $_GET['id'] ?? 0;

//if(empty($name)){
//    echo "Invalid request.";
//}
//else{
//    echo "Name is $name";
//}


if(empty($name) || empty($id)){
    echo "Invalid request.";
}
else{
    echo "Name is $name and id $id.";
}

/*

This file is used together with an .htaccess configuration to demonstrate

how URL rewriting works in Apache.

The .htaccess file contains RewriteRule directives that transform

“pretty”/clean URLs (e.g., /data/vts or /data/vts/123) into internal PHP

requests such as:

 data.php?name=vts

 or

 data.php?name=vts&id=123

This technique is commonly used to:

- create user-friendly URLs,
- hide query parameters,
- implement simple routing logic,
- improve SEO,
- and provide cleaner application structure.

If the incoming URL does not match any RewriteRule pattern, Apache will return a 404 Not Found error (or load a custom 404 page, if configured).
*/