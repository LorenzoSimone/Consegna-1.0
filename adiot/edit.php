<?php

include('../init.php');

function rilevazioni(){
	
			include('../init.php');
			$val = array();
			
			$val[] = $_POST['val'];
			$val[] = $_POST['sens'];
			

			$query  = $con->prepare("UPDATE Rilevazioni SET Limite=? WHERE CodiceS=? ;");
			$query -> execute ( $val );	
	
}

function ambienti(){
			include('../init.php');
			$val = array();
			
			$val[] = $_POST['azienda'];
			$val[] = $_POST['imp'];
			$val[] = $_POST['amb'];
			$val[] =  $_POST['id'];
			
			$query  = $con->prepare("UPDATE Ambienti SET Azienda=?, Impianto  = ?, Ambiente = ?
			WHERE Id = ?;");
			$query -> execute ( $val );
			
}

function clienti (){
			include('../init.php');
			$val = array();
			
			$val[] = $_POST['name'];
			$val[] = $_POST['psw'];
			$val[] = $_POST['azienda'];
			$val[] = $_POST['mail'];
			$val[] = $_POST['flag'];
			$val[] =  $_POST['id'];
			
			$query  = $con->prepare("UPDATE Dati_clienti SET Username=?, 
			Password  = ?, Azienda = ?, 
			Mail = ?, Proprietario = ? where Id = ?;");
			$query -> execute ( $val );
			
}

function iot(){	
			include('../init.php');
			$val = array();
			
			$val[] = $_POST['name'];
			$val[] = $_POST['psw'];
			$val[] = $_POST['adm'];
			$val[] = $_POST['sens'];
			$val[] = $_POST['amb'];
			$val[] = $_POST['id'];
			
			$query  = $con->prepare("UPDATE Dati_iot SET 
			Username=?, 
			Password  = ?, 
			Admin = ?, 
			Sensorista = ?, 
			Ambientista = ? where Id = ?;");
			$query -> execute ( $val );
			
}

function impianti(){
	
			include('../init.php');
			$val = array();
			
			$val[] = $_POST['id'];
			$val[] = $_POST['azienda'];
			$val[] = $_POST['impianto'];
			$val[] = $_POST['sensore'];
			$val[] = $_POST['qta'];
			$val[] = $_POST['id'];
			
			$query  = $con->prepare("UPDATE Impianti SET Azienda=?, 
			Impianto  = ?, 
			CodiceS = ?, 
			Quantità = ? WHERE Id = ?;");
			$query -> execute ( $val );
			
}

function sensori(){
	
		    include('../init.php');
			$val   = array();
			
			$val[] = $_POST['cod'];
			$val[] = $_POST['tipo'];
			$val[] = $_POST['marca'];
			$val[] = $_POST['anno'];
			$val[] = $_POST['id'];
			
			$query  = $con->prepare("UPDATE Sensori 
			SET CodiceS = ?, 
			Tipo  = ?, 
			Marca = ?, 
			Anno = ? where Id = ?;");
			$query -> execute ( $val );		
			
}

switch( $_GET['table'] ){
		
		case 'Ambienti':
		    ambienti();
			break;
		   
		case 'Dati_clienti':
		    clienti();
		    break;
		   
		case 'Dati_iot':
		   iot();
		   break;
		   
		case 'Impianti':
		    impianti();
		    break;
		   
		case 'Sensori':
		    sensori();
			break;
		
		case 'Rilevazioni':
		    rilevazioni();
			break;
				   
        default:
           echo 'Error';		
	}

?>