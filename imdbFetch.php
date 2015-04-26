<?php 
set_include_path('./classes');
spl_autoload_register();

$database = new Database();
$imdbHtml = new GetImdbHtml();
$saveTopTen = new SaveTopTen($imdbHtml, $database);

//$saveTopTen->saveDate();
$saveTopTen->saveTopTen();
?>