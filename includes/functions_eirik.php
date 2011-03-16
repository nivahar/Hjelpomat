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




echo get_user_email('1');

?>
