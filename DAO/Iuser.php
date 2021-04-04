<?php
namespace DAO;

use Models\User as User;

interface Iuser{

    function GetByUserName($userName);
    function SaveUserInDB(User $user);
    function GetUserById($searchidUser);
    function ModifyUserInBd($id_user,$email, $password,$firstName,$lastName,$dni,$birthDate);
    function DeleteUserInDB($id_user);
}
?>