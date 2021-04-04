<?php
namespace DAO;
use Models\Genre as Genre;

interface Igenre{
    function SaveGenreInDB(Genre $genre);
    function GetGenreByIdFromDb($id_genre);
    function GetGenresFromAPI();

}
    
    ?>