<?php
include 'config.php';

$sql = "SELECT * FROM 3e_project WHERE project_name LIKE '%".mysqli_escape_string($mysqli,$_REQUEST['term'])."%'";


$query = $mysqli->query($sql);

while($row = $query->fetch_assoc())
{
	$results[] = array(
		'label' => $row['project_name'],
		'code' => $row['project_code'],
		'name' => $row['project_name']
		);
}

echo json_encode($results);
?>