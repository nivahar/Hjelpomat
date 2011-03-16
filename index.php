<?php
	require_once('includes/head.inc.php');
	include_once('includes/body.inc.php');
?>
		
<?php
	include_once(page($_GET['page'], $_GET['sub']));
?>

<?php
	include_once('includes/foot.inc.php');
?>