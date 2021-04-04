<?php
namespace Models;

class Movie {

    private $id_movie;
    private $title;
    private $language;
    private $url_image;
    private $overview;
    private $duration;
    private $genre;

    public function __construct($id_movie, $title, $language, $url_image, $overview, $duration, Genre $genre)
	{
        $this->id_movie = $id_movie;
        $this->title = $title;
        $this->language = $language;
        $this->url_image = $url_image;
        $this->overview = $overview;
        $this->duration = $duration;
        $this->genre = $genre;
    }
    
    public function getId_movie()
    {
        return $this->id_movie;
    }

    public function setId_movie($id_movie)
    {
        $this->id_movie = $id_movie;

    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;

    }

    public function getUrlImage()
    {
        return $this->url_image;
    }

    public function setUrlImage($url_image)
    {
        $this->$url_image = $url_image;

    }

    public function getOverview()
    {
        return $this->overview;
    }

    public function setOverview($overview)
    {
        $this->overview = $overview;

    }
    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
    
    public function getGenre()
    {
        return $this->genre;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
    }
}

?>