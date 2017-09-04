<?php 
if( session_status() != PHP_SESSION_ACTIVE) session_start();
if( !isset( $_SESSION['name'] )) header('location: ../');
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pannello di controllo</title>
   <!-- FontAwesome -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
   <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- DataTable CSS library -->

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.css">

<!-- DataTable JavaScript library -->

<script type="text/javascript" charset="utf-8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>

<!-- DataTable JavaScript BS library -->

<script type="text/javascript" charset="utf-8" src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


 <!-- Slide CSS library -->

<link rel="stylesheet" type="text/css" href="slide.css">

<!-- Slide CSS library -->

<link rel="stylesheet" type="text/css" href="style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body >
<!--
					   <div class="dropdown">	
					 <label for="recipient-name" class="form-control-label">Immagini:</label></br>				 
					 <button class="btn btn-secondary dropdown-toggle " style=" background-color: #f9f9f9; font-style-color: black" id="ddmenu" type="button" data-toggle="dropdown">Scegli fra le disponibili
					 <span class="caret"> </span>
					 </button>
					 <ul class="dropdown-menu" id="dropdown-menu" onchange="dropd()">
					 
					  
					 
					 </ul>
					</div>
					
					-->
<div class="container">		
<div class="modal fade" id="PicForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h3 class="modal-title" id="info">Benvenuto, scelga il suo ambiente</h3>
				  </div>
				  <div class="modal-body">
								
				  <?php
								  
				  include("../init.php");
				  $query = "SELECT * from Dati_clienti c, Ambienti a where c.Azienda = a.Azienda and a.azienda= :az and c.Username = :name ";
				  $q = $con -> prepare ( $query);
				  $q -> execute ( array ( 'name' => $_SESSION['name'], 'az' => $_SESSION['azienda'] ) );
				  
				  foreach( $q as $fetch) {  		  
					  ?>
					  <div id="outliner">
					  <a href="panel.php?imp=<?php echo $fetch['Impianto'];?>"><img id="img" class="img-thumbnail" alt="" src="../adiot/images/<?php echo $fetch['Immagine'];?>" /></a>  
					  </div>
					  	  		  		  
				  <?php } ?>
					  		
					<span id="resulted"></span>
				  </div>
				</div>
			  </div>
			</div>
			</div>



<script>

$(document).ready( function () {
	$('#PicForm').modal('show');
});




</script>
</body>
</html>