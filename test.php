<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $arr= array("data"=>"oke","id"=>"12");
    print_r($arr);
    $json = json_encode($arr);
    print_r($json);
    echo "<br>";
    $iya = json_decode($json);
    print_r($iya);
    
?>
