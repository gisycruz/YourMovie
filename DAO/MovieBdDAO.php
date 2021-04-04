<?php
namespace DAO;

use Models\Movie as Movie;
use DAO\Imovie as Imovie;
use DAO\Connection as Connection;
use FFI\Exception;

class MovieBdDao implements Imovie {

    private $listMovie = array();
    private $tableName = "movie";
    
    public function SaveMovieInDB(Movie $movie) {

        $sql = "INSERT INTO movie (id_movie, title, language, url_image, overview, duration, idgenre) VALUES (:id_movie, :title, :language, :url_image, :overview, :duration, :idgenre)";

        $parameters["id_movie"] = $movie->getId_movie();
        $parameters["title"] = $movie->getTitle();
        $parameters["language"] = $movie->getLanguage();
        $parameters["url_image"] = $movie->getUrlImage();
        $parameters["overview"] = $movie->getOverview();
        $parameters["duration"] = $movie->getDuration();
        $parameters["idgenre"] = $movie->getGenre()->getId_genre();

        try {
            $this->connection = Connection::GetInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters);

        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    private function getMoviesFromDB() {
        
        $query = "SELECT * FROM " . $this->tableName;

        try {

            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

        } catch (Exception $ex) {
            throw $ex;
        }
        
        return $result;
    
    }

    public function getAllMovies() {

        $moviesArray = $this->getMoviesFromDB();

        if(!empty($moviesArray)) {

            $result = $this->mapear($moviesArray);

            if(is_array($result)) {

                $this->listMovie = $result;
            }
            else {
                $arrayResult[0] = $result;
                $this->listMovie = $arrayResult;
            }
            return $this->listMovie;
        }
        else {
            return $errorArray[0] = "Error al leer la base de datos.";
        }

    }

    private function GetMovieById($idMovieABuscar)
    {
        $movie = null;

        $query = "SELECT * FROM " . $this->tableName . " WHERE (id_movie = :id_movie) ";

        $parameters["id_movie"] = $idMovieABuscar;

        try{

            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, $parameters);
        
        } catch (Exception $ex) {
            throw $ex;
        }
        
        $movie = $this->mapear($results);


        return $movie;
    }  

    public static function MapearMovie($idMovieAMapear) {

        $movieDAOBdAux = new MovieBdDao();

        return $movieDAOBdAux->GetMovieById($idMovieAMapear);
    }


    protected function mapear($value) {

    $value = is_array($value) ? $value : [];

    $resp = array_map(function($p){
        return new Movie($p['id_movie'], $p['title'], $p['language'], $p['url_image'], $p['overview'], $p['duration'], GenreBdDAO::MapearGenre($p['idgenre']));
    }, $value);

    return count($resp) > 1 ? $resp : $resp['0'];
   }

   public function getMoviesWithScreeningFromDB() {
        
    $query = "SELECT DISTINCT m.id_movie,s.id_screening, m.title, m.language, m.url_image, m.duration, m.overview, m.idgenre FROM movie m INNER JOIN SCREENING s ON s.idmovie = m.id_movie";
    
    try {
        $this->connection = Connection::GetInstance();
        $result = $this->connection->Execute($query);

    } catch (Exception $ex) {
        throw $ex;
    }
    
    return $result;

}
 

   public function getAllMoviesWithScreening(){

    $moviesArray = $this->getMoviesWithScreeningFromDB();
    
    if(!empty($moviesArray)) {
        
        $result = $this->mapear($moviesArray);
        if(is_array($result)) {
            $this->listMovie = $result;
        }
        else {
            $arrayResult[0] = $result;
            $this->listMovie = $arrayResult;
        }

        return $this->listMovie;
    }
    else {
        return $errorArray[0] = "Error al leer la base de datos.";
    }

}

 

private function GetMoviesWithOutScreeningFromDb($id_room) {

    /*CONSULTO LAS PELICULAS QUE NO TIENEN SCREENING O QUE SI TIENEN PERTENECEN A ESTE ROOM (A-a1)*/ 

    $query =    "SELECT DISTINCT m.id_movie, m.title, m.language, m.url_image, m.duration, m.overview, m.idgenre
                 FROM movie m
                 LEFT JOIN screening s
                 ON m.id_movie = s.idmovie
                 WHERE (s.idmovie is null) OR (s.idroom = :id_room);";

    $parameters["id_room"] = $id_room;

    try {
        $this->connection = Connection::GetInstance();
        return $this->connection->Execute($query, $parameters);

    } catch (Exception $ex) {
        throw $ex;
    }

}

public function GetMoviesWithOutScreening($id_room) {

    $moviesArray = $this->GetMoviesWithOutScreeningFromDb($id_room);

    if(!empty($moviesArray)) {
            
        $result = $this->mapear($moviesArray);
        
        if(is_array($result)) {

            
            $this->listMovie = $result;
        }
        else {
            
            $arrayResult[0] = $result;
            $this->listMovie = $arrayResult;
        }
        
        return $this->listMovie;
    }
    else {
        return $errorArray[0] = "Error al leer la base de datos.";
    }
    
}
public function GetNowPlayingFromAPI(){

    $this->retrieveAPI();

    return $this->listMovie;
}

public function retrieveAPI() //Trae las peliculas "now_playing" de la API
{
    
    $moviesWithDuration = [];

    $listMovies = array();

    $jsonContent = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=1b6861e202a1e52c6537b73132864511&language=en-US&page=1");

        $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

        $arrayDePelis = $arrayToDecode["results"]; // Decodifico el array de resultados, porque la api trae otro que se llama "DATA"

        //Lo recorro y cargo una movie en un array por cada posicion del array
        foreach ($arrayDePelis as $movie) 
        {        
                $movieDuration = $this->GetMovieDuration($movie["id"]);

                $movie["duration"] = $movieDuration;
                
                array_push($moviesWithDuration, $movie);

                $genres = $movie["genre_ids"];
                $genre = $genres[0];
                
                $movie = new Movie($movie["id"], $movie["original_title"], $movie["original_language"], $movie["poster_path"], $movie["overview"], $movieDuration, GenreBdDAO::MapearGenre($genre));            
                array_push($listMovies, $movie);
                $this->listMovie = $listMovies;
                $this->SaveMovieInDB($movie);

        }
        //Cambio el array que trae la api por uno con la duracion como atributo añadido
        $arrayToDecode["results"] = $moviesWithDuration;
        //Al finalizar guardo el array que traje al principio en un json
        $jsonContent = json_encode($arrayToDecode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileJsonMovie, $jsonContent);

}
private function GetMovieDuration($idMovie) {
    $jsonContent = file_get_contents("https://api.themoviedb.org/3/movie/".$idMovie."?api_key=1b6861e202a1e52c6537b73132864511&language=en-US");
    $movie = ($jsonContent) ? json_decode($jsonContent, true) : array();
    return $movie["runtime"];
}

public function MigrateMoviesToDB() {

    $this->movieDAO = new MovieDao();

    $this->listMovie = $this->movieDAO->getAPI();

    foreach($this->listMovie as $movie) {

        $numberOfMovies = $this->SaveMovieInDB($movie);
    }
    return $numberOfMovies;
}

public static function GetInstance()
        {
            if(self::$instance == null)
                self::$instance = new CinemaBdDao();

            return self::$instance;
        }

    public function GetUpcomingMoviesFromAPI() {

        return $this->GetUpcomingMoviesFromAPIDB();
    }

    private function GetUpcomingMoviesFromAPIDB() {

        $listMovies = array();

        $value = strval(random_int(4,10));

        $jsonContent = file_get_contents("https://api.themoviedb.org/3/movie/upcoming?api_key=edb67d13cecee476561844a5ab40881c&language=en-US&page=".$value);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            $arrayDePelis = $arrayToDecode["results"]; // Decodifico el array de resultados, porque la api trae otro que se llama "DATA"
            $count = 0;
            //Lo recorro y cargo una movie en un array por cada posicion del array
            foreach ($arrayDePelis as $movie) 
            {        
                    if($count == 6){
                        break;
                    }

                    $movieDuration = $this->GetMovieDuration($movie["id"]);
                    $movie["duration"] = $movieDuration;

                    $genres = $movie["genre_ids"];
                    if(!empty($genres)){
                     
                        $genre = $genres[0];
                    
                    }
                    else {
                        $genre = 10770;
                    }
                    $movie = new Movie($movie["id"], $movie["original_title"], $movie["original_language"], $movie["poster_path"], $movie["overview"], $movieDuration, GenreBdDAO::MapearGenre($genre));               

                    array_push($listMovies, $movie);
                    
                    $count++;
                    

            }

            return $listMovies;
            //Cambio el array que trae la api por uno con la duracion como atributo añadido
            /* $arrayToDecode["results"] = $moviesWithDuration; */
            //Al finalizar guardo el array que traje al principio en un json
            /* $jsonContent = json_encode($arrayToDecode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileJsonMovie, $jsonContent); */
        
    
        }
        
    public function GetPageOfIncomingMovieFromAPI($id_movie) {
        $jsonContent = file_get_contents("https://api.themoviedb.org/3/movie/".$id_movie."?api_key=edb67d13cecee476561844a5ab40881c&language=en-US");

        $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

        if(!empty($arrayToDecode["homepage"])){

            return $arrayToDecode["homepage"];
            
        }
        else
        {
            return "";
        }
    }
}
