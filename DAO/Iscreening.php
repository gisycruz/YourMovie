<?php 
namespace DAO;

use Models\Screening as Screening;

interface Iscreening
{
    function SaveScreeningInBd(Screening $screening);
    function getAllScreening();
    function GetScreeningsFromARoom($id_room);
    function GetScreeningsFromAMovie($id_movie);
    function DeleteScreeningInDB($id_screening);
    function GetScreeningById($searchidScreening);
    function GetScreeningsFromDateAndTime($id_room , $date_screening, $hour_screening);
    function unoccupiedSeatsFromScreening($id_screening);
    function screenigWhitSeatFree($id_screening);

    //function GetGenresOfScreenings();
    //function GetDatesOfScreenings();
    //function GetScreeningsFromDate($date_screening);
}
?>