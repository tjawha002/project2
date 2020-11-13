

<html>
	<head>
		<title>Search Engine</title>
	</head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="js/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<style type="text/css">
		.login-icon {
			background-color: #0275d8;
			color: white;
			font-weight: bold;
			font-size: 20px;
			padding: 5px;
			text-align: center;
			border-radius: 20px;

		}
	</style>

	<body>
		<div class="container">
		<div class="row py-5">
			<div class="col-10 mx-auto">
			<form action="search.php" method="get" autocomplete="on">
				<form method="post">
					<div class="row">
						<div class="col-10">
							<input type="text" name="q" id="search" placeholder="search at josndata" class="form-control" required> 
						</div>
						<div class="col-2">
							<button type="submit" class="btn btn-primary" name="searchButton">Search</button><br>
						</div>

						<div class="col-12">
							<a data-toggle="collapse" href="#advanceSearch">Advance Search</a>
						</div>
					</div>
				</form>
				<div class="collapse col-10 py-3" id="advanceSearch" style="background: #F8F9F9; border-radius: 5px;">
					
					<form method="post">
						<div class="row py-2">
							<div class="col-6">
								<label>search in datajosn :</label>
								<input type="text" name="Rname" class="form-control">
							</div>
							
						</div>

						<div class="row py-2">
							<div class="col-6">
								<label>Search in datajosn :</label>
								<input type="text" name="Rtype" class="form-control">
							</div>

							
							
						</div>

						<button type="submit" class="btn btn-success" name="advanceSearchButton">Advance Search</button>
						
					</form>
				</div>
			</div>
		</div>

		<div class="row">
			<dir class="col-10 mx-auto">
				
				<div id="paginate_data">
				
				</div>
			</div>
		</div>
		</div>
	</body>
</html>

<?php

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create() // (2)
->build(); // (3)

if(isset($_GET['q'])) { // (4)

$q = $_GET['q'];




$q=preg_replace("/<|>/i", "",$q);



//-- Change Here -->
$query = $client->search([
'body' => [
'query' => [ // (5)
'bool' => [
'should' => [
'match' => ['patentID'  => $q],


]
]
]
]
]);
if($query['hits']['total'] >=1 ) { // (6)
$results = $query['hits']['hits'];

 foreach ($results as $i)
 {
$qq=$i['_source']['patentID'];

for ($x = 0; $x <= 6; $x++)
{
?>

	<img src='../jsonFiles/dataset/<?php echo "$qq"."-D0000".$x.".png"; ?>'  width="12%" />


<?php
//echo "<br />";
}
 }
 

//print_r($results);
echo count($results);

}
}

?>


