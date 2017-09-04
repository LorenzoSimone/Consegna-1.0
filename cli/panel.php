<?php
Session_start();
if( !isset($_SESSION['name'])) header('location: ../');
if( !isset($_SESSION['imp']))  $_SESSION['imp'] = $_GET['imp'];
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
    <link href="../adiot/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>


<div id ="sidebar" class="sidebar-nav panel panel-default toggled">
			<!--<div id="toggle" class="panel-heading"><span id="user"><i class="glyphicon glyphicon-th-list menu-icon"></i></span></div> -->
				<div class="list-group"> 					
					<a href="#" class="list-group-item"><i class="glyphicon glyphicon-scale menu-icon"></i>  <span id="dip" class="side-text"></span></a>				
					<a href="clients.php" class="list-group-item"><i class="glyphicon glyphicon-cloud menu-icon"></i>  <span id="cli" class="side-text"></span></a>
					<a href="dash.php" class="list-group-item"><i class="glyphicon glyphicon-record menu-icon"></i>  <span id="c1" class="side-text"></span></a>
					<a href="../adiot/logout.php" class="list-group-item"><i class="glyphicon glyphicon-off menu-icon"></i>  <span id="logout" class="side-text"></span></a>
				</div>
			</div>

	
<div id="wrapper" >
 <!-- EditForm -->
	<div class="modal fade" id="EditForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h3 class="modal-title" id="info"></h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<form id="editform" action="../adiot/edit.php?table=Rilevazioni" method="post">
					
				
					  <div class="form-group" style="display:none;">
						<label for="recipient-name" class="form-control-label">CodiceS:</label>
						<input type="text" class="form-control" id="user_id" required>
					  </div>
					  					  
					  <div class="form-group">
						<label for="recipient-name" class="form-control-label">Valore Limite:</label>
						<input type="text" class="form-control" id="user_azienda" required>
					  </div>
					  					  
					</form>
					<span id="resulted"></span>
				  </div>
				  <div class="modal-footer">	
					<button type="button" id="edit" class="btn btn-success">Aggiungi</button>
				  </div>
				</div>
			  </div>
			</div>
        <!-- Page Content -->				
                <div class="row" style="margin-top: -20px;">
                    <div class="col-lg-12"></br>
       					<table id="table" class="table table-hover table-striped">
							<thead>
								<tr>
									<th>Id</th>	
									<th>Azienda</th>
									<th>Impianto</th>									
									<th>CodiceS</th>									
									<th>Data</th>
									<th>Ora</th>                                                                        									
									<th>Misurazione</th>
                                    <th>Limite</th>
									<th>Messaggio</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
                    </div>
                </div>
            </div>
       
    <!-- Menu Toggle Script -->
    <script>
	
	
	$('#dropdown-menu li').on("click" , function() {
		$(ddmenu).text ($(this).text() );
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
    
    "ajax": "../adiot/ambientj.php?table=Rilevazioni",
    "bInfo": false,
    "bPaginate":false,
     "columnDefs": [{
		"targets" : [0,1,2],
	visible : false},{
    "targets": [8],
    "render": function ( data, type, row ) {
      if(data.indexOf("ERR") != -1) return '<img src="../adiot/icons/err.png"></img>' + " " + data.replace("ERR","");
	  
	  if( row[6] < row[7]){
		  if( row[6] + 5 > row[7]) return '<img src="../adiot/icons/high.png"</img>' + " Priorità Alta " + "[ " + data + " ]";
		  else if( row[6] + 10 > row[7]) return '<img src="../adiot/icons/medium.png"></img>' + " Priorità Media " + "[ " + data + " ]";
		  else return '<img src="../adiot/icons/low.png"></img>' + " Priorità Bassa " + "[ " + data + " ]";  
	  }
	  else{
		  
		  if( row[6] - 5 < row[7]) return '<img src="../adiot/icons/high.png"</img>' + " Priorità Alta " + "[ " + data + " ]";
		  else if( row[6] - 10 < row[7]) return '<img src="../adiot/icons/medium.png"></img>' + " Priorità Media " + "[ " + data + " ]";
		  else return '<img src="../adiot/icons/low.png"></img>' + " Priorità Bassa " + "[ " + data + " ]";    
	  }
	  
    }},{
	
		"targets": [6],
		"render": function ( data, type, row ) {
			if( row[3].indexOf("TMP") > -1 ) return data + "°";
			else if ( row[3].indexOf("UMD") > -1 ) return data + "%";
			return data;
	}},{
	
		"targets": [7],
		"render": function ( data, type, row ) {
			if( row[3].indexOf("TMP") > -1 ) return data + "°";
			else if ( row[3].indexOf("UMD") > -1 ) return data + "%";
			return data;
	}}],
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
	
	table.search( <?php echo htmlspecialchars( json_encode($_SESSION['imp']), ENT_NOQUOTES ) ?> );  	 
   
	 
     $('#table tbody').on('click', 'tr', function () {
		 
        var data = table.row( this ).data();
        $('#EditForm').modal('show');
        $('#info').text("Aggiungi un valore limite per il sensore " + data[3]);
		$('#user_id').val(data[3]);
        $('#user_azienda').val(data[7]);		
    });


	$('#sidebar,.list-group-item').mouseover( function(){
		if(  $('#sidebar').hasClass("toggled")){
		$('#sidebar').removeClass("toggled");       
        $('#sidebar').animate( { width: '180px', height: '100%' } ,500);
		$('#wrapper').animate( { marginLeft: '190px'} ,500);
		$('#table').animate( { width: '99.2%'} ,500);
        $('#body').animate( { marginLeft: '200px' } ,500); 
		$("#body:animated").promise().done(function() {
		$('#dip').text("Rilevazioni");
        $('#cli').text("Ambienti");
        $('#c1').text("DashBoard");
		$('#logout').text("LogOut");});}});
	   
		
        
	
	
	
	$('#sidebar').mouseleave( function(){
		if(  !$('#sidebar').hasClass("toggled")){
		$('#sidebar').addClass("toggled");
		$('#dip').text("");
        $('#cli').text("");
        $('#c1').text("");
	    $('#logout').text("");
		$('#sidebar').animate( { width: '50px', height: '100%' } ,500);
		$('#wrapper').animate( { marginLeft: '60px'} ,500);
        $('#body').animate( { marginLeft: '70px' } ,500);
		 
		
	}	});


	$('#edit').click( function(){
		
		var cod = $('#user_id').val();
		var val = $('#user_azienda').val();
		
		var obj = {
			"sens" : cod,
			"val" : val
			};
			
		$.post( $('#editform').attr("action") , obj, function(info){ $("#resulted").html(info); });
		$('#EditForm').modal('hide');
		location.reload();
		
	});
	});
		

    </script>

</body>

</html>