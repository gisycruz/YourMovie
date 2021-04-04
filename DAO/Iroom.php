<?php 
namespace DAO;

use Models\Room as Room;

interface Iroom
{
    function SaveRoomInBd(Room $Room);
    function getRoomFromDB();
    function getAllRoom();
    function GetRoomById($searchidRoom);
    function DeleteRoomInDB($id_room);
    function GetRoomsXCinemaFromBd($id_cinema);
    function GetRoomsFromCinema($id_cinema);
    function ModifyRoomInBd($name, $capacity, $ticketValue, $id_room);
}
?>