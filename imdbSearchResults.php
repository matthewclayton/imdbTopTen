<?php
set_include_path('./classes');
spl_autoload_register();

$memCache = new Memcached();
$cache = new Cache($memCache);
$database = new Database();
$imdbTopTen = new ImdbTopTen($database, $cache);

$movieData = $imdbTopTen->getMovieData();

include ('views/movieList.phtml');

?>