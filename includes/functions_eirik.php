<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include('functions.inc.php');

/*
 * GET MAIL ADDRESS FROM USER ID
 */
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



/*
 * GET NUMBER OF HELPCASE CASES
 */
function get_count_helpdesk(){
connect_to_tf();

$sql="SELECT COUNT(id_main_case) AS helpdesk_cases from [v.help_case];";
if(!$data=mssql_query($sql)){
    return FALSE;
    exit;
}
$mail=mssql_fetch_array($data);
return $mail['helpdesk_cases'];

}

/*
 * GET NUMBER OF FOOD CASES
 */
function get_count_helpdesk(){
connect_to_tf();

$sql="SELECT COUNT(id_main_case) AS food_cases from [v.food_case];";
if(!$data=mssql_query($sql)){
    return FALSE;
    exit;
}
$mail=mssql_fetch_array($data);
return $mail['food_cases'];

}



?>
