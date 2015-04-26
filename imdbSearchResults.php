<?php
set_include_path('./classes');
spl_autoload_register();

$cache = new Cache();
$database = new Database();
$imdbTopTen = new ImdbTopTen($database, $cache);

$movieData = $imdbTopTen->getMovieData();

include ('views/movieList.phtml');

?>