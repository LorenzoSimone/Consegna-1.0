<?php 
include("../init.php");					  
if( session_status() != PHP_SESSION_ACTIVE) session_start();

$azienda = $_POST['azienda'];
$_SESSION['Azienda'] = $azienda;
$query =  "SELECT Impianto FROM Ambienti WHERE Azienda = ? ORDER BY Impianto;";
$res = $con -> prepare ( $query );
$res -> execute ( array( $azienda ) );

foreach ( $res as $fetch ){
	
	$arr[] = $fetch['Impianto'];}
	
echo ( json_encode($arr) );
?>