<?php
	require_once('includes/head.inc.php');
?>
		
<?php
	if($_SESSION['loggedin'])
	{
		include_once('includes/body.inc.php');
		include_once(page($_GET['page'], $_GET['sub']));
	}
	else
	{
		include_once('login.php');
	}
?>

<?php
	include_once('includes/foot.inc.php');
?>