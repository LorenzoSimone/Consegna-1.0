<?php




function ambienti(){
	
			include('../init.php');
			$val = array();
			$val[] = $_POST['azienda'];
			$val[] = $_POST['imp'];
			$val[] = $_POST['amb'];
			$val[] = $_POST['immagine'];
			
			$query  = $con->prepare("INSERT INTO Ambienti(Azienda,Impianto,Ambiente,Immagine) VALUES(?,?,?,?)");
			$query -> execute ( $val );
}

function clienti (){
	
			include('../init.php');
			$val = array();
			$val[] = $_POST['name'];
			$val[] = $_POST['psw'];
			$val[]= $_POST['azienda'];
			$val[]= $_POST['mail'];
			$val[]= $_POST['flag'];
			
			$query  = $con->prepare("INSERT INTO Dati_clienti(Username,Password,Azienda,Mail,Proprietario) VALUES(?,?,?,?,?)");
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
			
			$query  = $con->prepare("INSERT INTO Dati_iot(Username,Password,Admin,Sensorista,Ambientista) VALUES(?,?,?,?,?)");
			$query -> execute ( $val );
			
}

function impianti(){
			include('../init.php');
			$val  = array();
			$val[]= $_POST['azienda'];
			$val[]= $_POST['impianto'];
			$val[]= $_POST['sensore'];
			$val[]= $_POST['qta'];
			
			$query  = $con->prepare("INSERT INTO Impianti(Azienda,Impianto,CodiceS,Quantità) VALUES(?,?,?,?)");
			$query -> execute ( $val );
                        echo " Sensori inseriti con successo ";
			
}

function sensori(){
	
			include('../init.php');
			$val = array();
			$val[] =  $_POST['cod'];
			$val[] = $_POST['tipo'];
			$val[] = $_POST['marca'];
			$val[] = $_POST['anno'];
			
			$query  = $con->prepare("INSERT INTO Sensori(CodiceS,Tipo,Marca,Anno) VALUES(?,?,?,?)");
			$query -> execute ( $val );
		
}




switch( $_GET['table'] ){
		
		case "Ambienti":
			ambienti();		    
			break;
		   
		case "Dati_clienti":
		    clienti();
		    break;
		   
		case "Dati_iot":
		   iot();		   
		   break;
		   
		case "Impianti":
			
			impianti();
		    break;
		   
		case "Sensori":
		 
			sensori();
			break;
		   
        default:
           echo 'Error';		
	}




?>