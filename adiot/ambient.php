<?php 
if( session_status() != PHP_SESSION_ACTIVE) session_start();
if( !isset( $_SESSION['name'] )) header('location: ../');
if( isset($_POST['upload']) ){
	$image = $_FILES['image']['name'];
	move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $_FILES["image"]["name"]);  	
}

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


    <!-- Custom CSS -->
    <link href="simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body >

<div id ="sidebar" class="sidebar-nav panel panel-default toggled">
			<!--<div id="toggle" class="panel-heading"><span id="user"><i class="glyphicon glyphicon-th-list menu-icon"></i></span></div> -->
				<div class="list-group"> 					
					<a href="panel.php" class="list-group-item"><i class="glyphicon glyphicon-user menu-icon"></i>  <span id="dip" class="side-text"></span></a>				
					<a href="senspanel.php" class="list-group-item"><i  class="glyphicon glyphicon-scale menu-icon">  </i><span id="sens" class="side-text"></span></a>
					<a href="clients.php" class="list-group-item"><i class="glyphicon glyphicon-briefcase menu-icon"></i>  <span id="cli" class="side-text"></span></a>
					<a href="ambient.php" class="list-group-item"><i class="glyphicon glyphicon-globe menu-icon"></i>  <span id="c1" class="side-text"></span></a>
					<a href="install.php" class="list-group-item"><i class="glyphicon glyphicon-save menu-icon"></i>  <span id="imp" class="side-text"></span></a>
					<a href="logout.php" class="list-group-item"><i class="glyphicon glyphicon-off menu-icon"></i>  <span id="logout" class="side-text"></span></a>
				</div>
			</div>

    <div id="wrapper">
	
        <!-- Page Content -->
		
		<!-- Da Rifare --> 
		
		
		<!-- Modal Add Form (Add new item in the table)-->
                <div id="addform">
		<button type="button" id="AddForm" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Aggiungi Ambiente</button>
                </div>								
	        
			<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="UserMessage"><b>Nuovo Ambiente </b></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<form id="saveform" action="add.php?table=Ambienti" method="post">
					
					  
					   <div class="dropdown">	
					 <label for="recipient-name" class="form-control-label">Azienda:</label></br>				 
					 <button class="btn btn-secondary dropdown-toggle " style=" background-color: #f9f9f9; font-style-color: black" id="ddmenu" type="button" data-toggle="dropdown">Scegli fra le disponibili
					 <span class="caret"> </span>
					 </button>
					 <ul class="dropdown-menu" id="dropdown-menu" onchange="dropd()">
					 
					  <?php
					  
					  include("../init.php");
					  $query = "SELECT DISTINCT Azienda from Dati_clienti ORDER BY Azienda;";
					  $res = $con->query( $query );
					  foreach ($res as $fetch) {
						  $azienda = htmlspecialchars($fetch['Azienda']);
						  ?>
						  <li><a href="#"><?php echo $azienda;?> </a></li>
						  
						  
					  <?php } ?>
					 
					 </ul>
					</div>
					  
					  <div class="form-group">
						<label for="recipient-name" class="form-control-label">Impianto:</label>
						<input type="text" class="form-control" id="add_impianto" name="psw" required>
					  </div>
					  
					  <div class="form-group">
						<label for="recipient-name" class="form-control-label">Ambiente:</label>
						<input type="text" class="form-control" id="add_ambiente" name="psw" required>
					  </div>
					  
					</form>
					
					<!-- image input -->
					  
					<!-- image-preview-filename input [CUT FROM HERE]-->
					<label for="recipient-name" class="form-control-label">Foto Ambiente:</label>
					<iframe name="foo" style="display:none;"></iframe>
					<form  action="ambient.php" method="post" enctype="multipart/form-data" target="foo">
					<input type="hidden" name="size" value="1000000000">
					<div class="input-group image-preview">
						<input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
						<span class="input-group-btn">
							<!-- image-preview-clear button -->
							<button type="button" class="btn btn-default image-preview-clear" style="display:none;">
								<span class="glyphicon glyphicon-remove"></span> Rimuovi
							</button>
							<!-- image-preview-input -->
							<div class="btn btn-default image-preview-input">
								<span class="glyphicon glyphicon-folder-open"></span>
								<span class="image-preview-input-title">Ricerca</span>
								<input type="file" accept="image/png, image/jpeg, image/gif" name="image"/> 
							</div>
							
							<button class="btn btn-default up" type="submit" name="upload"><span class="glyphicon glyphicon-save"></span></button>
							
								
						</span>
					</div><!-- /input-group image-preview [TO HERE]--> 
					</form>
					<span id="result"></span>
				  </div></br>
				  <div class="modal-footer">

					<button type="button" id="save" class="btn btn-success" disabled>Salva Modifiche</button>
				  </div>
				</div>
			  </div>
			</div>
					
		<!-- Modal Selection Form ( When selecting an item in the table )-->
		
			<div class="modal fade" id="EditForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="info"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<form id="editform" action="edit.php" method="post">
					
				
					  <div class="form-group" style="display:none;">
						<label for="recipient-name" class="form-control-label">Id:</label>
						<input type="text" class="form-control" id="user_id" required>
					  </div>
					  
					  
					  <div class="form-group">
						<label for="recipient-name" class="form-control-label">Azienda:</label>
						<input type="text" class="form-control" id="user_azienda" required>
					  </div>
					  
					  <div class="form-group">
						<label for="recipient-name" class="form-control-label">Impianto:</label>
						<input type="text" class="form-control" id="user_impianto" required>
					  </div>
					  
					  <div class="form-group">
						<label for="recipient-name" class="form-control-label">Ambiente:</label>
						<input type="text" class="form-control" id="user_ambiente" required>
					  </div>
					  
					  <label for="recipient-name" class="form-control-label">Foto Ambiente:</label><br>
					  <img src="" id = "img" class="img-thumbnail" alt="" width="150" height="150">
					  
					</form>
					<span id="resulted"></span>
				  </div>
				  <div class="modal-footer">	
					<button type="button" id="remove" class="btn btn-danger">Rimuovi Ambiente</button>
					<button type="button" id="edit" class="btn btn-success">Salva Modifiche</button>
				  </div>
				</div>
			  </div>
			</div>
		
			
			
                <div class="row">
                    <div class="col-lg-12"></br>
       					<table id="table" class="table table-hover table-striped">
							<thead>
								<tr>
									<th>Id</th>
									<th>Azienda</th>
									<th>Impianto</th>
									<th>Ambiente</th>                                                                 																	
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
                                       
                    
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Menu Toggle Script -->
    <script>
	
	$('#dropdown-menu li').on("click" , function() {
		$('#ddmenu').text($(this).text() );
	});
		
	
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    
    $("#handle").click(function(e) {
        $('.tenda').slideToggle();
    });

    $(document).ready( function () {
    var table=$('#table').DataTable({
    
    "ajax": "ambientj.php?table=Ambienti",
    "bInfo": false,
    "bPaginate":false,
    "columnDefs": [{
    "targets" : 0,
     visible : false
}],   
    "language": {
    "sEmptyTable":     "Nessun dato presente nella tabella",
    "sInfo":           "  Vista da _START_ a _END_ di _TOTAL_ elementi",
    "sInfoEmpty":      "  Vista da 0 a 0 di 0 elementi",
    "sInfoFiltered":   "(filtrati da _MAX_ elementi totali)",
    "sInfoPostFix":    "",
    "sInfoThousands":  ".",
    "sLengthMenu":     "Visualizza _MENU_ elementi",
    "sLoadingRecords": "Caricamento...",
    "sProcessing":     "Elaborazione...",
    "sSearch":         "",
     searchPlaceholder: "Ricerca",
    "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
    "oAria": {
        "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
        "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
    }}});
	
	
	
     $('#table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

        $('#EditForm').modal('show');
        $('#info').text("Impianto Selezionato: " + data[2] );
		$('#user_id').val(data[0]);
        $('#user_azienda').val(data[1]);
		$('#user_impianto').val(data[2]);
		$('#user_ambiente').val(data[3]);
		$('#img').attr('src', "images/" + data[4]);
		
			
    });

	$('#sidebar,.list-group-item').mouseover( function(){
		if(  $('#sidebar').hasClass("toggled")){
		$('#sidebar').removeClass("toggled");       
        $('#sidebar').animate( { width: '180px', height: '100%' } ,500);
		$('#wrapper').animate( { marginLeft: '190px'} ,500);
		$('#table').animate( { width: '99.2%'} ,500);
        $('#body').animate( { marginLeft: '200px' } ,500); 
		$("#body:animated").promise().done(function() {
		$('#dip').text("Dipendenti");
        $('#cli').text("Clienti");
        $('#sens').text(" Sensori");
        $('#c1').text("Acquisizioni");
        $('#imp').text("Installazione");
		$('#logout').text("LogOut");});}});	
	
	$('#sidebar').mouseleave( function(){
		if(  !$('#sidebar').hasClass("toggled")){
		$('#sidebar').addClass("toggled");
		$('#dip').text("");
        $('#cli').text("");
        $('#sens').text("");
        $('#c1').text("");
        $('#imp').text("");
	    $('#logout').text("");
		$('#sidebar').animate( { width: '50px', height: '100%' } ,500);
		$('#wrapper').animate( { marginLeft: '60px'} ,500);
        $('#body').animate( { marginLeft: '70px' } ,500);
		 
		
	}	});     
	
	
	$('#edit').click( function(){
		
		var id = $('#user_id').val();
		var azienda = $('#user_azienda').val();
		var imp = $('#user_impianto').val();
		var amb = $('#user_ambiente').val();
		
		
		var obj = {
			"id" : id,
			"azienda" : azienda,
			"imp" : imp,
			"amb" : amb
			};
			
		$.post( "edit.php?table=Ambienti" , obj, function(info){ $("#resulted").html(info); });
		$('#EditForm').modal('hide');
		location.reload();
		
	
		
	});
	
	$('#remove').click( function(){
		
		var id = $('#user_id').val();
		var obj = {
			"id": id
		}
		
		$.post( "delete.php?table=Ambienti" , obj, function(info){ $("#resulted").html(info); });
		$('#EditForm').modal('hide');
		location.reload();
	
	});
	
	
	

	$('#AddForm').click( function() {
		
	$('#add').modal('show');});
	
    $('#save').click( function() {
		
		var azienda = $('#ddmenu').text();		
		var impianto = $('#add_impianto').val();
		var ambiente = $('#add_ambiente').val();
		var immagine = $('.image-preview-filename').val();
		
		var obj = {
			"azienda" : azienda,
			"imp" : impianto,
			"amb" : ambiente,
			"immagine" : immagine
			};
			
		$.post( $('#saveform').attr("action") , obj, function(info){ $("#result").html(info); });
	
		$('#AddForm').modal('hide');
		location.reload();

	});
	
	$('.up').on('click', function(){
		
		alert('Immagine inserita con successo');
		$('#save').prop('disabled',false);		
		
	});
	
	
	$(document).on('click', '#close-preview', function(){ 
	
    $('.image-preview').popover('hide');
	
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
		 
		   
        }, 
         function () {
           $('.image-preview').popover('hide');
        }
    );    
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
	
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Anteprima</strong>"+$(closebtn)[0].outerHTML,
        content: "Nessuna Immagine",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
		
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Ricerca"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });      
		
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Cambia");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
});
	});
    </script>
</body>

</html>