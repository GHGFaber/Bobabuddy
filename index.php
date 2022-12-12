<?php
require_once("config.php");
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $PROJECT_NAME ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1><?= $PROJECT_NAME?></h1>
<div id= "yuh">
        <h1> Hello, Please Sign in Below </h1>
    </div>
<h2>
<ul>
    <li><a href="index.mysqli.php">Examples with mysqli</a></li>
    <li><a href="index.pdo.php">Examples with PDO</a></li>
    <li><a href="login.php">Client Sign In</a></li>
</ul>
