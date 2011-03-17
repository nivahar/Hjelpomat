<div style="clear: both"></div> 
	
</div> 
<div style="clear: both"></div></div> 
<div style="clear: both"></div> 
<div id="footer"> 
 
		<div id="footer-content"> 
		<?php
			if($_SESSION['loggedin'])
			{
				echo 'Innlogget som '.$_SESSION['user_name'].'. ';
				echo '<a href="?logout">Logg ut.</a>';
			}
		?>
				
			<span class="info"> 
				Utviklet for TusenFryd AS
			</span> 
		
			<span class="credits"> 
				av <a href="http://27.fjeldweb.no" target="_blank">Gruppe 27</a>. 
			</span> 
 
		</div> 
 
	</div> 
	
 
 
</body> 
</html>
<?php
	mssql_close($dbConnection);
?>