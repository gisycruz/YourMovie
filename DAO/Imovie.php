<?php 
namespace DAO;

use Models\Movie as Movie;

interface Imovie{
    
    function SaveMovieInDB(Movie $movie);
    function getAllMovies();
    function getAllMoviesWithScreening();
    function GetMoviesWithOutScreening($id_room);
    function retrieveAPI();
    function GetNowPlayingFromAPI();
    function MigrateMoviesToDB();
    function GetUpcomingMoviesFromAPI();
    function GetPageOfIncomingMovieFromAPI($id_movie);
}
?>