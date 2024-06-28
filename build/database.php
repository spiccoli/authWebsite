<?php
if ( empty($_POST["name"])) {   
    die ("Invalid Name");
}

if(! filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
    die ("Invalid email");
}

print_r($_POST);