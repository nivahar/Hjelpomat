<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 
include('functions.inc.php');
        //Database kobling
        connect_to_tf();

        // TEMP
$title = 'en liten tittel';
$category_id = '2';
$descrition = 'dfghjk iyiu oiuiouo oiyuoyiuy ';


        // tbl.help_case
        //Sette inn data unik fo helpdesk, input fra funksjon
           $sql = "INSERT INTO [tbl.help_case](help_case_title,case_problem_type,help_case_description) VALUES('$title','$category_id','$descrition')";
        //Utføre sql kommando
            mssql_query($sql);



            // Trenger ID til å putte i hovedtabell
            $sql = 'SELECT SCOPE_IDENTITY() AS ID';
            $help_id = mssql_query($sql);
            $id = mssql_fetch_array($help_id);
            $help_case_id = $id["ID"];



         // tbl.main_case
            $dato = 'GETDATE()';
//TEMP
$reg_user = '1';
$reg_employee = '1';
         
            $sql = "INSERT INTO [tbl.main_case](created_date,reg_user,reg_employee,id_help_case)VALUES ($dato,'$reg_user','$reg_employee','$help_case_id')";
            //Lagre data i tbl.man_case
            mssql_query($sql);
*/


include('functions.inc.php');
/*
function helpdesk_list(){
//Database kobling
        connect_to_tf();

       // Spørring
       $sql = "SELECT [id_main_case]
      , CAST([created_date] as CHAR(10)) AS [created_date]
      ,[reg_user]
      ,[reg_employee]
      ,[id_help_case]
      ,[help_case_title]
      ,[case_problem_type]
      ,[help_case_description]
      ,[help_case_solution]
      ,[help_case_status]
      ,[is_help_case]
      FROM [v.help_case]";
       // Kjør spørring
       $data = mssql_query($sql);
     
       while($row = mssql_fetch_array($data)){
         //lager tabell
           echo "<tr><td>".$row['id_main_case']."</td><td>".
                           $row['created_date']."</td><td>".
                           $row['reg_user']."</td><td>".
                           $row['reg_employee']."</td><td>".
                           $row['id_help_case']."</td><td>".
                           $row['help_case_title']."</td><td>".
                           $row['case_problem_type']."</td><td>".
                           $row['help_case_description']."</td><td>".
                           $row['help_case_solution']."</td><td>".
                           $row['help_case_status']."</td><td>".
                           $row['is_help_case']."</td><td>".
                "</td></tr>";
       }
// funk end
}
echo helpdesk_list();
*/
?>
