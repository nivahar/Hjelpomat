<?php
	if($_SESSION['loggedin'])
	{
		if($_SESSION['user_level'] > 1)
		{
			echo '<p>Du er en administrator, gratulerer!</p>';
		}
		else
		{
			echo '<p>Du har ikke tilstrekkelige rettigheter til å vise denne siden.</p>';
		}
	}
	else
	{
		echo '<p>Du er ikke <a href="/">logget inn</a>!</p>';
	}
?>