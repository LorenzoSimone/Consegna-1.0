<?php
    /*
     * Script:    DataTables server-side script for PHP and MySQL
     * Copyright: 2010 - Allan Jardine, 2012 - Chris Wright
     * License:   GPL v2 or BSD (3-point)
     */
     
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */
     
    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
	include '../init.php';
	session_start();

	
	switch( $_GET['table'] ){
		
		case "Ambienti":
		   $aColumns = array( 'Id','Azienda','Impianto','Ambiente','Immagine');
		   
		   break;
		   
		case "Rilevazioni":
		   $aColumns = array( 'Id','Azienda','Impianto','CodiceS','Data','Ora','Misurazione','Limite','Messaggio');
		   break;
		   
		case "Dati_clienti":
		   $aColumns = array( 'Id','Username', 'Password','Azienda','Mail','Proprietario');
		   break;
		   
		case "Dati_iot":
		   $aColumns = array( 'Id','Username', 'Password','Admin','Sensorista','Ambientista');
		   break;
		   
		case "Impianti":
		   $aColumns = array( 'Id','Azienda', 'Impianto','CodiceS','Quantità');
		   break;
		   
		case "Sensori":
		   $aColumns = array( 'Id','CodiceS', 'Tipo','Marca','Anno');
		   break;
		   
        default:
           echo "Error";		
	}
     
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "Id";
     
    /* DB table to use */
    $sTable = $_GET['table'];
     
    /* Database connection information */
    
     
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */
     
    /*
     * Local functions
     */
    
		
	function htmlspecial_array($variable) {
    foreach ($variable as $value) {
        if (!is_array($value)) { $value = htmlspecialchars($value); }
        else { htmlspecial_array($value); }
    }
	}
	function array_count_values_of($value, $array) {
    $counts = array_count_values($array);
    return $counts[$value];
	}
 
 
    /*
     * Paging
     */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
            intval( $_GET['iDisplayLength'] );
    }
     
     
    /*
     * Ordering
     */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
            }
        }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
    }
     
     
    /*
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = "";
	$sWhPlace = array();
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";	
		$mark= '?';
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$mark."%' OR ";
				$sWhPlace[] = mysql_real_escape_string( $_GET['sSearch'] );
            }
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
     
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
			$mark= '?';
            if ( $sWhere == "" )
            {
				$sWhPlace = array();
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".$mark."%' ";
			$sWhPlace[] = mysql_real_escape_string( $_GET['sSearch'] );
			
        }
    }
     
     
    /*
     * SQL queries
     * Get data to display
     */
	
    $sQuery = $con->prepare(htmlspecialchars(("
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable 
        $sWhere 	
        $sOrder
        $sLimit
    ")));
	$sQuery->execute( $sWhPlace );
    $result = $sQuery->fetchAll(PDO::FETCH_NUM);
	
    /* Data set length after filtering 
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = mysqli_query(  $gaSql['link'], $sQuery) or fatal_error( 'MySQL Error: ' . mysqli_errno( $gaSql['link'] ) );
    $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];*/
	
	 $iFilteredTotal=2;
     
    /* Total data set length 
    $sQuery = "
        SELECT COUNT(".$sIndexColumn.")
        FROM   $sTable
    ";
    $rResultTotal = mysqli_query( $gaSql['link'],$sQuery ) or fatal_error( 'MySQL Error: ' . mysqli_errno($gaSql['link']) );
    $aResultTotal = mysqli_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0]; */
	
	$iTotal=2;
	
     
     
    /*
     * Output
     */
	
	
    $output = array(
        "iTotalRecords" => htmlspecialchars($iTotal),
        "iTotalDisplayRecords" => htmlspecialchars($iFilteredTotal),
        "aaData" => array_values($result)
    );
	 
   
    echo ( htmlspecialchars( json_encode($output) , ENT_NOQUOTES ));
?>