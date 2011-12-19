<?php
require_once 'config/global.inc.php';
require_once PATH_CLASS. '/database.class.php';
require_once PATH_CONFIG. '/connect.db.inc.php';
$db = new DB_MySQL($db_server,$db_database,$db_user,$db_passwd);

function select_all_fahrzeug ($db, $id){
	$vorname = "";
	$nachname = "";
	$kennzeichen = "";
	$km = "";
	if (empty($id)){
	$db->query('SELECT * FROM Fahrzeug');
	}else{
	$db->query("SELECT last_km FROM last_increment WHERE fahrzeug_id = '$id' ");
	}
	if ($db->fetchnumrows() != '0'){
		$row = $db->fetcharray();
		$kennzeichen = $row['Kennzeichen']; 
		$km = $row['startkm']; 
		$id = $row['entity_id'];
		$string = $row['Fahrer'];
		$array = explode(" ", $string);
		$vorname = $array[0];
		$nachname = $array[1];
	}
	return  array($vorname,$nachname,$kennzeichen,$km,$id,$string); 
}

function last_increment ($db,$id){
	$startkm = "";
	$db->query("SELECT last_km FROM last_increment WHERE fahrzeug_id = '$id' ");
	if ($db->fetchnumrows() != '0'){
		$row = $db->fetcharray();
		$startkm = $row['last_km'];
	}
	return $startkm; 
}

function select_start($db,$id){
	$db->query("SELECT * FROM Start WHERE fahrzeug_id = '$id'");
	$ort = "";
	$strasse = "";
	if ($db->fetchnumrows() != '0'){
		$row = $db->fetcharray();
		$ort = $row['start_ort']; 
		$strasse = $row['ziel_strasse']; 
	}
	return  array($ort,$strasse); 
}

function select_ziel($db,$id){
$db->query("SELECT * FROM Ziel WHERE fahrzeug_id = '$id' ORDER by id DESC LIMIT 1");
	$ort = "";
	$strasse = "";
if ($db->fetchnumrows() != '0'){
	$row = $db->fetcharray();
		$ort = $row['ziel_ort']; 
		$strasse = $row['ziel_strasse']; 
	}
	return  array($ort,$strasse); 
}

function start_to_ziel($db,$id){
$db->query("SELECT Start.*, Ziel.* FROM `Start`, `Ziel` WHERE Start.id = Ziel.id AND Start.fahrzeug_id = '$id' AND Ziel.fahrzeug_id = '$id'"); 
	if ($db->fetchnumrows() != '0'){
	$return = array();
	while($row = $db->fetchRow())
	//print_r($row);
	$return[] = $row;

	
	}
	return $return;
		
}

function insert_fahrzeug($db,$id,$vorname,$nachname,$Fahrer,$kennzeichen,$km){
$db->query("INSERT INTO Fahrzeug(entity_id, Kennzeichen, Fahrer, startkm) 
			VALUES(NULL, '$kennzeichen', '$Fahrer','$km')"); 
}
function insert_last_increment($db,$id,$km){
$db->query("INSERT INTO last_increment(fahrzeug_id, last_km) 
			VALUES('$id', '$km')"); 
}
function insert_Start($db,$id,$datum,$zeit,$ort,$strasse,$tacho,$km,$grund){
$db->query("INSERT INTO Start(id, fahrzeug_id, start_datum, start_zeit,start_ort,start_strasse,start_km,km,Grund) 
			VALUES(NULL, '$id', '$datum','$zeit','$ort','$strasse','$tacho','$km','$grund')"); 
}
function insert_ziel($db,$id,$zieldatum,$zielzeit,$zielort,$zielstrasse,$last_increment_km){
$db->query("INSERT INTO Ziel(id, fahrzeug_id, ziel_datum, ziel_zeit,ziel_ort,ziel_strasse,ziel_km) 
			VALUES(NULL, '$id', '$zieldatum','$zielzeit','$zielort','$zielstrasse','$last_increment_km')"); 			
}

function calc_last_increment($tacho,$km){
return $last_increment_km = $tacho + $km;
}
function update_last_increment($db,$id,$last_increment_km){
$db->query("UPDATE  last_increment SET last_km='$last_increment_km' WHERE fahrzeug_id ='$id'"); 
}

function insert_fav($db,$fav_name,$fav_ort,$fav_strasse,$fav_km){
$db->query("INSERT INTO favoriten(fav_id, fav_name, fav_ort, fav_strasse,fav_km) 
			VALUES(NULL, '$fav_name', '$fav_ort','$fav_strasse','$fav_km')"); 
}

function select_favoriten($db,$id){
if ($id !=0){
	$db->query("SELECT * FROM favoriten WHERE fav_id = '$id'");
	}else{
	$db->query('SELECT * FROM favoriten');
	}
	if ($db->fetchnumrows() != '0'){
	$return = array();
	while($row = $db->fetchRow())
	//print_r($row);
	$return[] = $row;
	}
	return $return;
		
}

?>