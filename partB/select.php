<?php
require "connect.php";

// function to select distinct values from table
function selectDistinct ($connection, $tableName, $attributeName, $pulldownName, $defaultValue) {

	// SQL query to select distinct values
	$distinctQuery = "SELECT DISTINCT {$attributeName} FROM
{$tableName} ORDER BY {$attributeName}";

	// Run the distinctQuery on the databaseName
	if (!($resultId = @ mysql_query ($distinctQuery, $connection)))
		showerror();

	// Open the drop down box
	print "\n<select name=\"{$pulldownName}\">";

	// Check if a defaultValue is set. If not, start “Variety” with empty select
	if (!(isset($defaultValue))) 
	{
		// Change defaultValue to something else so it only runs once
		$defaultValue = "--";
		print "\n\t<option selected value=\"All\">All";
	}
	// Retrieve each row from the query
	while ($row = @ mysql_fetch_array($resultId))
	{
	// Get the value for the attribute to be displayed
	$result = $row[$attributeName];
	
	// Print this selected value for region select
	if ($result == $defaultValue)
		print "\n\t<option selected value=\"{$result}\">{$result}";
	else
	// No, just show as an option
		print "\n\t<option value=\"{$result}\">{$result}";
	print "</option>";
	}
	print "\n</select>";
}

// Connect to the server
if (!($connection = @ mysql_connect(DB_HOST, DB_USER, DB_PW))) {
	showerror();
}

if (!mysql_select_db(DB_NAME, $connection)) {
	showerror();
}

// Print Region title
print "\n<tr><td>Region:</td><td>";
// Select list of regions available to select
selectDistinct($connection, "region", "region_name", "region", "All");
print "\n</td></tr>\n<tr><td>Variety:</td><td>";
// Select list of grape varieties available to select
selectDistinct($connection, "grape_variety", "variety", "variety");
print "\n</td></tr>\n<tr><td>Min Year:</td><td>";
// Select year from distinct year values
selectDistinct($connection, "wine", "year", "minYear");
print "\n</td></tr>\n<tr><td>Max Year:</td><td>";
// Select year again for maximum value
selectDistinct($connection, "wine", "year", "maxYear");
print "\n</td></tr>";

?>


