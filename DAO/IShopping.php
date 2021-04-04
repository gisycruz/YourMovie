<?php 
namespace DAO;

use Models\Shopping as Shopping;

interface IShopping
{
    function addShopping(Shopping $shopping);
    function getAllShopping();
    function deleteShopping($id_shopping); 
    function sumNumberOfPurchasesOfaScreening($id_screening);
}
?>
