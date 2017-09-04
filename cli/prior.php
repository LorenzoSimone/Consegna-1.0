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
}}


$query =  "SELECT Limite, Misurazione FROM Rilevazioni WHERE Impianto = ? ".$add ." ;";
$res = $con -> prepare ( $query );
$res -> execute ( array( $imp ) );

$arr[0] = 0;
$arr[1] = 0;
$arr[2] = 0;

foreach ( $res as $fetch ){
	
	if(   $fetch['Misurazione'] <   $fetch['Limite']){
		  if(   $fetch['Misurazione'] + 5 >   $fetch['Limite']) $arr[0]++;
		  else if(   $fetch['Misurazione'] + 10 >   $fetch['Limite']) $arr[1]++;
		  else $arr[2]++;
	  }
	  else{
		  
		  if(   $fetch['Misurazione'] - 5 <   $fetch['Limite']) $arr[0]++;
		  else if(   $fetch['Misurazione'] - 10 <   $fetch['Limite']) $arr[1]++;
		  else $arr[2]++;    
}}
	  
	
echo ( json_encode($arr) );
?>