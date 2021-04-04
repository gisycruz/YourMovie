<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder
define("FRONT_ROOT", "/YourMovie/");
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
define("IMG_PATH", VIEWS_PATH . "img/");
define("IMG", FRONT_ROOT.IMG_PATH);
define("IMG_CARD", FRONT_ROOT.IMG_PATH."logos/");

//Database Constants
define("DB_HOST", "localhost");
define("DB_NAME", "yourmovie");
define("DB_USER", "root");
define("DB_PASS", "");

//API Constants
define("API_URL", 'https://api.themoviedb.org/3/');
define('KEY','edb67d13cecee476561844a5ab40881c');
define("MOVIE_BACKDROP", 'http://image.tmdb.org/t/p/original'); 
define("MOVIE_POSTER", 'http://image.tmdb.org/t/p/w300'); 
//Email
define('EMAIL','yourmovie.tp.utn@gmail.com');
define('EMAILPASS','yourmovie');
?>




