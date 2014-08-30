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

			// Get search input
			$wineName = $_GET['wineName'];
			$wineryName = $_GET['wineryName'];
			if ($_GET['region'] != "All")
				$region = $_GET['region'];
			if ($_GET['variety'] != "All")
				$variety = $_GET['variety'];
			if ($_GET['minYear'] != "All")
				$minYear = $_GET['minYear'];
			if ($_GET['maxYear'] != "All")
				$maxYear = $_GET['maxYear'];
			$minStock = $_GET['minStock'];
			$maxStock = $_GET['maxStock'];
			$minPrice = $_GET['minPrice'];
			$maxPrice = $_GET['maxPrice'];
			
			// Set validity variable
			$valid = true;

			// Check if any terms have been entered
			if(empty($wineName) && empty($wineryName) && empty($region) && empty($variety) && 
				empty($minYear) && empty($maxYear) && empty($minStock) && empty($maxStock) &&
				empty($minPrice) && empty($maxPrice)) {
				echo "No search terms entered. <br />";
				$valid = false;
			}

			//  Start query
			$query = 
				"SELECT 
					wine.wine_name
					,grape_variety.variety 
					,wine.year
					,winery.winery_name 
					,region.region_name 
					,inventory.cost
					,inventory.on_hand
					,(SELECT SUM(items.qty) FROM items WHERE items.wine_id = wine.wine_id) AS total_sold 
					,(SELECT SUM(items.price) FROM items WHERE items.wine_id = wine.wine_id) AS revenue
				FROM wine 
					JOIN wine_variety ON wine.wine_id = wine_variety.wine_id 
					JOIN grape_variety ON wine_variety.variety_id = grape_variety.variety_id 
					JOIN winery ON wine.winery_id = winery.winery_id 
					JOIN region ON winery.region_id = region.region_id 
					JOIN inventory ON wine.wine_id = inventory.wine_id 
					JOIN items ON wine.wine_id = items.wine_id
				WHERE wine.wine_id = inventory.wine_id";

			// Add search terms for each input if entered
			if(!empty($wineName))
				$query .= " AND wine.wine_name LIKE \"%$wineName%\"";
			if(!empty($wineryName))
				$query .= " AND winery.winery_name LIKE \"%$wineryName%\"";
			if(!empty($region))
				$query .= " AND region.region_name = \"$region\"";
			if(!empty($variety))
				$query .= " AND grape_variety.variety = \"$variety\"";
			if(!empty($minYear) && is_numeric($minYear))
				$query .= " AND wine.year >= \"$minYear\"";
			if(!empty($maxYear) && is_numeric($maxYear))
				$query .= " AND  wine.year <= \"$maxYear\"";
			if(!empty($minStock) && is_numeric($minStock))
				$query .= " AND inventory.on_hand >= \"$minStock\"";
			if(!empty($maxStock) && is_numeric($maxStock))
				$query .= " AND inventory.on_hand <= \"$maxStock\"";
			if(!empty($minPrice) && is_numeric($minPrice))
				$query .= " AND inventory.cost >= \"$minPrice\"";
			if(!empty($maxPrice) && is_numeric($maxPrice))
				$query .= " AND inventory.cost <= \"$maxPrice\"";

			// Finish query
			$query .= " GROUP BY items.wine_id 
				ORDER BY wine.wine_name,grape_variety.variety,wine.year";

			// Gather results from query
			$results = mysql_query($query);
			// Display results if any returned
			if(mysql_num_rows($results) > 0 && $valid == true) 
			{
				echo "<table class='results'>
					<tr>
						<td class='results'><b><u>Wine Name</u></b></td>
						<td class='results'><b><u>Grape Variety</u></b></td>
						<td class='results'><b><u>Year</u></b></td>
						<td class='results'><b><u>Winery</u></b></td>
						<td class='results'><b><u>Region</u></b></td>
						<td class='results'><b><u>Cost</u></b></td>
						<td class='results'><b><u>Stock</u></b></td>
						<td class='results'><b><u>Total Sold</u></b></td>
						<td class='results'><b><u>Revenue</u></b></td>
					</tr>";

				while($row = mysql_fetch_array($results))
				{
					//Display Wine Name, Type, Year -- NEED TO ADD MORE
					$resultWineName = $row['wine_name'];
					$resultWineType = $row['variety'];
					$resultYear = $row['year'];
					$winery = $row['winery_name'];
					$region = $row['region_name'];
					$cost = $row['cost'];
					$stock = $row['on_hand'];
					$totalSold = $row['total_sold'];
					$revenue = $row['revenue'];


					echo "<tr>
						<td class='results'>" . $resultWineName . "</td>
						<td class='results'>" . $resultWineType . "</td>
						<td class='results'>" . $resultYear . "</td>
						<td class='results'>" . $winery . "</td>
						<td class='results'>" . $region . "</td>
						<td class='results'>$" . $cost . "</td>
						<td class='results'>" . $stock . "</td>
						<td class='results'>" . $totalSold . "</td>
						<td class='results'>$" . $revenue . "</td>
						</tr>";
				}
				echo "</table>";
				echo "<p>Your search returned " . mysql_num_rows($results) . " results.</p>"; 
			}
			else
			{
				echo "<br />No results.";
			}
		}
		?>
	</body>
</html>