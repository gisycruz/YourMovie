<?php 
namespace DAO;

use Exception;
use Models\Genre as Genre;
use DAO\Connection as Connection;

    class GenreBdDAO{

        private $tableName = "genre";
        private $connection;
        private $listGenres;
       

        public function SaveGenreInDB(Genre $genre) {

            $sql = "INSERT INTO genre (id_genre, genreName) VALUES (:id_genre, :genreName)";
    
            $parameters["id_genre"] = $genre->getId_genre();
            $parameters["genreName"] = $genre->getGenreName();
    
            try {
                $this->connection = Connection::GetInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        protected function mapear($value) {
            
            $value = is_array($value) ? $value : [];
    
            $resp = array_map(function($p){
                $genre = new Genre($p["genreName"]);
                $genre->setId_genre($p["id_genre"]);
                return $genre;
            }, $value);
    
            return count($resp) > 1 ? $resp : $resp['0'];
        }

        public static function MapearGenre($id_genre) {

            $auxGenreBdDAO = new GenreBdDAO();

            return $auxGenreBdDAO->GetGenreByIdFromDb($id_genre);

        }
      
        public function GetGenreByIdFromDb($id_genre) {
    
            $query = "SELECT" . " id_genre, genreName FROM " . $this->tableName . " WHERE (id_genre = :id_genre) ";
    
            $parameters["id_genre"] = $id_genre;
    
            try{
    
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters);

            } catch (Exception $ex) {
                throw $ex;
            }

            $return = $this->mapear($results);
    
            return $return;
        }

        public function GetGenresFromAPI() {

            $this->retrieveAPI();
            
            return $this->listGenres;
        }
    
        private function retrieveAPI() //Trae los generos de la API
        {
            
            $genres = [];
    
            $listGenres = array();
    
            $jsonContent = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=edb67d13cecee476561844a5ab40881c&language=en-U");
    
                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();
    
                $arrayDeGeneros = $arrayToDecode["genres"]; // Decodifico el array de genres
    
                //Lo recorro y cargo un genre en un array por cada posicion del array
                foreach ($arrayDeGeneros as $genre) 
                {       
                    $genreId = $genre["id"];
                    $genre = new Genre($genre["name"]);
                    $genre->setId_genre($genreId);

                    array_push($listGenres, $genre);
                    $this->listGenres = $listGenres;

                    $this->SaveGenreInDB($genre);
    
                }
                //Cambio el array que trae la api por uno con la duracion como atributo añadido
                $arrayToDecode["results"] = $listGenres;
                //Al finalizar guardo el array que traje al principio en un json
                $jsonContent = json_encode($arrayToDecode, JSON_PRETTY_PRINT);
                file_put_contents($this->fileJsonMovie, $jsonContent);
    
        }

        


    }



?>