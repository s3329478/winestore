<!DOCTYPE  HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  
	"http://www.w3.org/TR/html4/loose.dtd"> 
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="winestore.css" />
		<title>Search Winestore Database</title>
	</head>
	<body>
		<h3>Search Winestore Databse</h3>
		<p>Please enter a search query</p>
		<!-- Search Form
			still requires winery name, region, variety, year range
			min. stock, min. ordered -->
		<form method="get" action="index.php" id="searchform">
			<input type="text" name="wineName" />
			<input type="text" name="wineryName" />
			<input type="submit" name="submit" value="Search" />
		</form>
	</body>
</html>

<?php
// Only run if search terms entered
if (!empty($_GET)){
	// Connect to MySQL server
	require_once('connect.php');

	// Get search input -- Only made for wine name currently
	$wineName = $_GET['wineName'];
	// Get results from database based on query
	$results = mysql_query("SELECT * FROM wine WHERE wine_name like '%$wineName%'");
	// Display results if any returned
	if(mysql_num_rows($results) > 0) 
	{
		while($row = mysql_fetch_array($results))
		{
			//Display Wine Name, Type, Year -- NEED TO ADD MORE
			$resultWineName = $row['wine_name'];
			$resultWineType = $row['wine_type'];
			$resultYear = $row['year'];

			echo "<ul class='nobullets'>\n";
			echo "<li>" . $resultWineName . "	" . $resultWineType . "	" . $resultYear . "</p>";
			echo "</ul>";
		}
	}
	else
	{
		echo "No results";
	}
}
?>