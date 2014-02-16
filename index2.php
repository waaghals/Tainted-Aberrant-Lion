<?php
ini_set('display_errors','1');
include "lib.googlemap.php";

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$gmap = new GoogleMap();
$gmap ->setCenterLocation("netherlands");
$gmap ->setStyle("width:100%; height:100%;");

echo $gmap->getHtml();
?>
