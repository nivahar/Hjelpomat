<?php
	session_start();
	require_once('includes/head.inc.php');
?>
		
<?php
	include_once(page($_GET['page']));
?>

<?php
	include_once('includes/foot.inc.php');
?>