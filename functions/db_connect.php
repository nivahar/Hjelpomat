
<?php

function db_connect()
{

// Server
$server = 'ansatt.tusenfryd.no';

//  Kobling
$link = mssql_connect($server, 'hjelpomat', 'uOd2b3cQA326Qp0A2AgmZ5emb1kRuz8n');

if (!$link) {
    die('Something went wrong while connecting to MSSQL');
}
}
?>


