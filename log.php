<?php 

include "init.php";
session_start();
$username= $_POST["username"];
$Password = $_POST["pass"];

$qiot = $con->prepare('SELECT * FROM Dati_iot WHERE Username = :name and Password = :pw ');
$qiot->execute(array('name' => $username, 'pw' => $Password));

foreach ($qiot as $result) {
	$_SESSION['name'] = $result['Username'];
	if( $result['Admin'] == 1 ) $_SESSION['priv'] = 1;
	else if ( $result['Ambientista'] == 1 ) $_SESSION['priv'] = 2;
	else $_SESSION['priv'] = 3;
	
header("location: adiot/panel.php");}
    
$clst = $con->prepare('SELECT * FROM Dati_clienti WHERE Username = :name and Password = :pw ');
$clst->execute(array('name' => $username, 'pw' => $Password));

foreach ($clst as $resc) {
	 $v = 1;
	 $_SESSION['name'] = $resc['Username'];
	 $_SESSION['azienda']= $resc['Azienda'];
	 $_SESSION['mail']= $resc['Mail'];
	 $_SESSION['prop']= $resc['Proprietario'];
	 header("location: cli/clients.php");
	
}

if ( !isset($v) ){
 echo 'Username o Password errata';
}	
?>