<?php 
include("../init.php");					  
if( session_status() != PHP_SESSION_ACTIVE) session_start();

$imp = $_SESSION['imp'];
$sens = -10;
$add = '';
if( isset( $_POST['sens']) ){
$sens = json_decode( $_POST['sens'],false);
if(count($sens)>1){
	
	$add.= "AND ( ";	
	
	foreach( $sens as $s ){
		$add.= "CodiceS= " ."'".$s ."'" . " OR ";					
	}
	
	$add = substr( $add, 0, -4);
	$add.= " )";
}
else if( (count($sens))==1){
	$add.= "AND CodiceS = '" .$sens[0]. "'";
}
}

$query =  "SELECT Data, Misurazione FROM Rilevazioni WHERE Impianto = ? ".$add."ORDER BY Data";
$res = $con -> prepare ( $query );
$res -> execute ( array( $imp ) );

foreach ( $res as $fetch ){
	
	$arr['mis'][] = $fetch['Misurazione'];
	$arr['data'][] = $fetch['Data'];}
	
echo ( json_encode($arr) );
?>