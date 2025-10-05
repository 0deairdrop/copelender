<?php 
require_once 'common/header.php';
unset($_SESSION['user']);
session_destroy();

header("Location: index");