<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="winestore.css" />
		<title>Results</title>
	</head>
	<body>
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
				echo "<table class='results'>
					<tr>
						<td class='results'>Wine Name</td>
						<td class='results'>Grape Variety</td>
						<td class='results'>Year</td>
						<td class='results'>Winery</td>
						<td class='results'>Region</td>
						<td class='results'>Cost</td>
						<td class='results'>Stock</td>
						<td class='results'>Total Sold</td>
						<td class='results'>Revenue</td>
					</tr>";

				while($row = mysql_fetch_array($results))
				{
					//Display Wine Name, Type, Year -- NEED TO ADD MORE
					$resultWineName = $row['wine_name'];
					$resultWineType = $row['wine_type'];
					$resultYear = $row['year'];


					echo "<tr>
						<td class='results'>" . $resultWineName . "</td>
						<td class='results'>" . $resultWineType . "</td>
						<td class='results'>" . $resultYear . "</td>
						<td class='results'>" . "#Winery#" . "</td>
						<td class='results'>" . "#Region#" . "</td>
						<td class='results'>" . "#Cost#" . "</td>
						<td class='results'>" . "#Stock#" . "</td>
						<td class='results'>" . "#Total Sold#" . "</td>
						<td class='results'>" . "#Revenue#" . "</td>
						</tr>";
				}

				echo "</table>";
				echo "<p>Your search returned " . mysql_num_rows($results) . " results.</p>"; 
			}
			else
			{
				echo "No results";
			}
		}
		?>
	</body>
</html>