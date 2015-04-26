<?php 
set_include_path('./classes');
spl_autoload_register();


$domDocument = new DOMDocument();
$database = new Database();
$imdbHtml = new GetImdbHtml($domDocument);
$domXPath = new DomXPath($imdbHtml->domDocument);
$saveTopTen = new SaveTopTen($domXPath, $database);

?>