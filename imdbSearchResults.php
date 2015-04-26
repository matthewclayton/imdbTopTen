<?php
set_include_path('./classes');
spl_autoload_register();


//if (isset($_POST['imdbDate'])) {
$cache = new Cache();
$database = new Database();
$imdbTopTen = new ImdbTopTen($database, $cache);
//}

$imdbTopTen->setDateData();
$imdbTopTen->t();


?>