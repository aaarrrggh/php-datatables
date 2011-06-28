<?php

require 'classes/DBManager.php';

$connection = new mysqli('localhost', 'root', 'root', 'php-datatables');

$manager = new DBManager($connection);

$tables = $manager->getDBTableNames();

?>

<h1>Generate Dummy Entity Object</h1>

<p>To create an entity object based on a database table, please select the table below:</p>

<ul>
<?php foreach ($tables as $table) {?>

<p><a href="generate.php?tableName=<?php echo $table ?>"><?php echo $table; ?></a></p>

<?php } ?>
</ul>
