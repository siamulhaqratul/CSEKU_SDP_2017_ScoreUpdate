<?php
   
   include'core/init.php';
   Session::remove();
   header("Location:login.php");
?>