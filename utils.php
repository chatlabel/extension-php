<?php

function checkDomainAccess(){
  // Limitando acesso somente revenda especifica acessa a extensão.
  $allowed = array('http://localhost:3000/'); 

  if(!isset($_SERVER['HTTP_REFERER']) || !in_array($_SERVER['HTTP_REFERER'], $allowed)){
    var_dump($_SERVER['HTTP_REFERER']);
    echo 'Unrestricted access';
    exit;
  }
}


?>