<?php
Session_start();
if( !isset($_SESSION['name'])) header('location: ../');
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

<!-- Script Chart JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<link rel="stylesheet" type="text/css" href="slide.css"/>
    <!-- Custom CSS -->
    <link href="../adiot/simple-sidebar.css" rel="stylesheet">
	<!-- Custom CSS -->
    

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
					<a href="panel.php"  class="list-group-item"><i class="glyphicon glyphicon-scale menu-icon"></i>  <span id="dip" class="side-text"></span></a>				
					<a href="clients.php" class="list-group-item"><i class="glyphicon glyphicon-cloud menu-icon"></i>  <span id="cli" class="side-text"></span></a>
					<a href="#" class="list-group-item"><i class="glyphicon glyphicon-record menu-icon"></i>  <span id="c1" class="side-text"></span></a>
					<a href="../adiot/logout.php" class="list-group-item"><i class="glyphicon glyphicon-off menu-icon"></i>  <span id="logout" class="side-text"></span></a>
				</div>
			</div>
			


<div id = "doughchart">
<canvas id="myChart" width="300px" height="300px"></canvas>
</div>

<div id = "doughchart">
<canvas id="priorChart" width="300px" height="300px"></canvas>
</div>

<div id = "linechart">
<canvas id="LineChart" width="300px" height="300px"></canvas>
</div>
	
            </div>		

	<!-- Menu Checkbox -->
		<dl class="dropdown"> 
  
    <dt>
    <a href="#">
      <span class="hida">Filtra</span>    
      <p class="multiSel"></p>  
    </a>
    </dt>
  
    <dd>
        <div class="mutliSelect">
            <ul>
			<?php
					  
					  include("../init.php");
					  $query = "SELECT DISTINCT CodiceS FROM Impianti WHERE Impianto = '".$_SESSION['imp']."';";
					  $res = $con->query( $query );
					  foreach ($res as $fetch) {
						  $sens = htmlspecialchars($fetch['CodiceS']);
						  ?>
						  <li><input type="checkbox" value= <?php echo $sens;?> /><?php echo $sens;?></li>
					  <?php } ?>              
            </ul>
        </div>
    </dd>
  <button id="up" >Aggiorna</button>
</dl>



       
    <!-- Menu Toggle Script -->
    <script>
	
		
	$(".dropdown dt a").on('click', function() {
	  $(".dropdown dd ul").slideToggle('fast');
	});

	$(".dropdown dd ul li a").on('click', function() {
	  $(".dropdown dd ul").hide();
	});

	function getSelectedValue(id) {
	  return $("#" + id).find("dt a span.value").html();
	}

	$(document).bind('click', function(e) {
	  var $clicked = $(e.target);
	  if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
	});

	$('.mutliSelect input[type="checkbox"]').on('click', function() {

	  var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
		title = $(this).val();

	  if ($(this).is(':checked')) {
		$('.multiSel').append( $(this).val() + " + ");
		$(".hida").hide();
	  } else {
		$('.multiSel').text( $('.multiSel').text().replace($(this).val() + " + ","") ); 
		var ret = $(".hida");

	  }
	});
	

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
		
	var miChart;
	var LineChart;
	var priorChart;
	
	$.ajax(
        {
        url: "prior.php",
        method: "GET",
        dataType : 'json',	
        success: function (result) {
		priorChart = new Chart( $("#priorChart"), {
		type: 'doughnut',
		data: {
		  labels: ["Priorità Alta", "Priorità Media", "Priorità Bassa"],
		  datasets: [
			{
			  label: "Priorità Rilevazioni",
			  backgroundColor: ["#cc7771","#e8d179","#6BBE92"],
			  borderColor : ["#152e44","#152e44","#152e44"],
			  data: [result[0],result[1],result[2]]
			}
		  ]
		},
		options: {
						maintainAspectRatio: false,
						legend:{
						display:false},						
						title:{
						display:true,
						text: "Priorità Rilevazioni"
						}
				}
		});
		
		
		}
		});
		
	$.ajax(
        {
        url: "linech.php",
        method: "GET",
        dataType : 'json',
        success: function (result) {			
			
		LineChart = new Chart ( $("#LineChart"), {
		type: 'line',
		data : {
        labels: result.data,
        datasets: [
           {
            label: "Valore Misurazione:" + $('.multiSel').text(),
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(107,190,46,0.4)",
            borderColor: "rgba(107,190,46,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(107,190,46,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(107,190,46,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 5,
            pointHitRadius: 10,
            data: result.mis
        }
        ]},
		options: {
						maintainAspectRatio: false,
						responsive : false,
						legend:{
						display:false}
						
				}
    });
	
		}
		});
	
	
    $.ajax(
        {
        url: "doughnut.php",
        method: "GET",
        dataType : 'json',	
        success: function (result) {
		miChart = new Chart( $("#myChart"), {
		type: 'doughnut',
		data: {
		  labels: ["Messaggi con Errore", "Messaggi Validi"],
		  datasets: [
			{
			  label: "%Errore Rilevazioni ",
			  backgroundColor: ["#cc7771","#6BBE92"],
			  borderColor : ["#152e44","#152e44"],
			  data: [result[0].count,result[1].count]
			}
		  ]
		},
		options: {
						maintainAspectRatio: false,
						legend:{
						display:false},						
						title:{
						display:true,
						text: "%Errore Rilevazioni Sensori"
						}
				}
		});
		
		
		}
		});
		
	 $('#up').on('click',function(){
		var str = $('.multiSel').text().split(" + ").slice(0,-1);
		var JsonString = JSON.stringify(str);
		
		$.ajax(
        {
        url: "prior.php",
        method: "POST",
        dataType : 'json',
		data: {'sens': JsonString} ,
        success: function (result) {
			
		priorChart.data.datasets[0].data[0]= result[0];
		priorChart.data.datasets[0].data[1]= result[1];
		priorChart.data.datasets[0].data[2]= result[2];
        priorChart.update();
		
		
		}
		});
		
		$.ajax(
        {
        url: "doughnut.php",
        method: "POST",
        dataType : 'json',
		data: {'sens': JsonString} ,
		
        success: function (result) {

		miChart.data.datasets[0].data[0]= result[0].count;
		miChart.data.datasets[0].data[1]= result[1].count;
        miChart.update();
		
		}
	 });
	 
		$.ajax(
        {
        url: "linech.php",
        method: "POST",
        dataType : 'json',
		data: {'sens': JsonString} ,
		
        success: function (result) {

		LineChart.data.datasets[0].data= result.mis;
		LineChart.data.datasets[0].labels= result.data;
        LineChart.update();
		
		}
	 });
	 
	 
	 
	 
	 });	
	
 
     $('#table tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();

        $('#EditForm').modal('show');
        $('#info').text("Sensore Selezionato: " + data[1] + " - " + data[2]);
		$('#user_id').val(data[0]);
        $('#user_codice').val(data[1]);
		$('#user_tipo').val(data[2]);
		$('#user_marca').val(data[3]);
		$('#user_anno').val(data[4]);
			
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


	});
	
	
	

		

    </script>

</body>

</html>