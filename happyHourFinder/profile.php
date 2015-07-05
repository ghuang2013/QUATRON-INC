<?php

session_start();

if(!$_SESSION){
    echo "Please log in ";
    exit;
}

echo $_SESSION['username'];


