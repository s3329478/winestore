<!DOCTYPE  HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  
	"http://www.w3.org/TR/html4/loose.dtd"> 
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="winestore.css" />
		<title>Search Winestore Database</title>
	</head>
	<body>
		<h3 class='header'>Search Winestore Databse</h3>
		<p class='header'>Please enter a search query</p>
		<!-- Search Form
			still requires winery name, region, variety, year range
			min. stock, min. ordered -->
		<form class='search' method="get" action="search.php" id="searchform">
			<table class='search'>
				<tr><td>Wine Name:</td><td><input type="text" name="wineName" /></td></tr>
				<tr><td>Winery Name:</td><td><input type="text" name="wineryName" /></td></tr>
				<?php include 'select.php'; ?>
				<tr><td>Min Stock:</td><td><input type="text" name="minStock" /></td></tr>
				<tr><td>Max Stock:</td><td><input type="text" name="maxStock" /></td></tr>
				<tr><td>Min Price:</td><td><input type="text" name="minPrice" /></td></tr>
				<tr><td>Max Price:</td><td><input type="text" name="maxPrice" /></td></tr>
				<tr><td><input type="submit" name="submit" value="Search" /></td></tr>
			</table>
		</form>
		<br />
		<br />
	</body>
</html>