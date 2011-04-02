<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *
include('functions.inc.php');

/*
 * GET MAIL ADDRESS FROM USER ID
 *
function get_user_email($user_id){
connect_to_tf();

$sql="SELECT user_email from [tbl.user] where id_user = $user_id;";
if(!$data=mssql_query($sql)){
    return FALSE;
    exit;
}
$mail=mssql_fetch_array($data);
return $mail['user_email'];

}

function send_case_email(){
    
}
*/

require 'db_secure.php';
	// Legger logindata i et array.
	$dbLogin = db_login();
	$dbConnection = mssql_connect($dbLogin['address'], $dbLogin['user'], $dbLogin['pass']);

	// Setter database
	if(!mssql_select_db('hjelpomat', $dbConnection))
	{
		die('Kunne ikke koble til database');
	}


/*

$sql = "select id_help_case_status, help_case_status_description  from [tbl.help_case_status]";
if(!$data=mssql_query($sql)){
     return FALSE;
    exit;
}


echo "<select>";

    


$list=mssql_fetch_array($data);

print_r($list);

foreach ($list as $row => $value) {

  

echo "<option value=\"".$list['id_help_case_status']."\">".$list['help_case_status_description']."</option>";


}

  // $test = "<option value=\"".$row['id_help_case_status']."\">".$row['help_case_status_description']."</option>";
  

echo "</select>";

echo "<br/>";
print_r($list);
//}


//echo test_select();
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */



$sql = "SELECT   A.help_problem_type_description AS level_1, B.id_help_problem_type AS ID, B.help_problem_type_description AS level_2
  FROM [hjelpomat].[dbo].[tbl.help_problem_type] AS A
  INNER JOIN [hjelpomat].[dbo].[tbl.help_problem_type] AS B ON (A.id_help_problem_type = B.parent_help_problem_id)
  Order by A.parent_help_problem_id asc";
//Sjekk av gjennomført spørring
if(!$data=mssql_query($sql)){
     return FALSE;
    exit;
}
// Start av dropdown
$start = "<select>";
// Henter alle verdier
$tekst = "";
while($list=mssql_fetch_array($data)){
$tekst.= "<option value=\"".$list['ID']."\">".$list['level_1']." - ".$list['level_2']."</option>";


}
//Slutt på dropdown
$slutt = "</select>";

echo $start.$tekst.$slutt;







?>
