<?php 
namespace Models;

class Genre{
    
    private $id_genre;
    private $genreName;

    public function __construct($genreName){
        
        $this->genreName = $genreName;
    }


    public function getId_genre()
    {
        return $this->id_genre;
    }

    public function setId_genre($id_genre)
    {
        $this->id_genre = $id_genre;

    }


    public function getGenreName()
    {
        return $this->genreName;
    }


    public function setGenreName($genreName)
    {
        $this->genreName = $genreName;
    }
}