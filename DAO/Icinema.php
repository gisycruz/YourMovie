<?php 
namespace DAO;

use Models\Cinema as Cinema;

interface Icinema
{
function getCinemasFromDB();
function getAllCinema();
function GetCinemaById($idCinemaABuscar);
function SaveCinemaInDB(Cinema $cinema);
function DeleteCinemaInDB($id_cinema);
function ModifyCinemaInBd($id_cinema, $name, $address);
    
}
?>