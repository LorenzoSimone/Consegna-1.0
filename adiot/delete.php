<?php
include('../init.php');

switch( $_GET['table'] ){
		
		case "Ambienti":
		   $sTable = 'Ambienti';
		   break;
		   
		case "Dati_clienti":
		   $sTable = 'Dati_clienti';
		   break;
		   
		case "Dati_iot":
		   $sTable = 'Dati_iot';
		   break;
		   
		case "Impianti":
		   $sTable = 'Impianti';
		   break;
		   
		case "Sensori":
		   $sTable = 'Sensori';
		   break;
		   
        default:
		   $sTable = 'ERR';		   
	}
	
$val = array();
$val[]   = $_POST['id'];
$query  = $con->prepare("DELETE FROM $sTable  WHERE id = ?;");
$query -> execute ( $val );
?>