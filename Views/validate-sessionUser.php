<?php
 
  if(!isset($_SESSION["loginUser"])){
    header("location:../login.php");  
  }
?>