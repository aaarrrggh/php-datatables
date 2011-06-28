<?php

require 'classes/DBManager.php';

$connection = new mysqli('localhost', 'root', 'root', 'php-datatables');

$manager = new DBManager($connection);

$tableName = $_GET['tableName'];

echo $manager->generateEntityObjectForTable($tableName);