

<html>
	<head>
	
	

		<title>Search Engine</title>
		  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VisImageNavigator</title>

    <!-- Bootstrap core CSS -->
    <link href="public/stylesheets/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="public/stylesheets/bio_style.css" rel="stylesheet">
    <link href="public/stylesheets/myPagination.css" rel="stylesheet">
    <link rel="stylesheet" href="public/stylesheets/ion.rangeSlider.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
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
			<form action="search.php" method="post">
				<div class="row">
						<div class="col-10">
							<input type="text" name="q" id="search" placeholder="search at josndata" class="form-control" required> 
						</div>
						<div class="col-2">
							<button type="submit" class="btn btn-primary" name="searchButton">Search</button><br>
						</div>

			
					</div>
		
				<div  style="background: #F8F9F9; border-radius: 5px;">
					
				
						<div class="row py-2">
							<div class="col-6">
							
							
							
								
							
								<label>Search in datajosn by:</label>
								<select " name="s" style=" height: 25px;cursor: pointer; " id="s">
								
								<option value="1" selected>patentID</option>
								<option value="2" >Figure ID</option>
								
								
								</select>


		 
						
							</div>

							
							
						</div>

						
					</form>
				</div>
			</div>
		</div>
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item active">
      <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
    </li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>


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
echo "<div class='row'>";
require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create() // (2)
->build(); // (3)

if(isset($_POST['searchButton'])) { // (4)

$q = $_POST['q'];

$searchby=$_POST['s'];



$q=preg_replace("/<|>/i", "",$q);


if($searchby=="1")
{
//-- Change Here -->
$query = $client->search([
'body' => [
'query' => [ // (5)
'bool' => [
'should' => [
'match' => ['patentID'  => $q],
//'match' => ['aspect'  => $q],


]
]
]
]
]);

}

if($searchby=="2")
{
//-- Change Here -->
$query = $client->search([
'body' => [
'query' => [ // (5)
'bool' => [
'should' => [
'match' => ['figid'  => $q],
//'match' => ['aspect'  => $q],


]
]
]
]
]);

}


if($query['hits']['total'] >=1 ) { // (6)
$results = $query['hits']['hits'];
$x = 0;
 foreach ($results as $i)
 {
	 
	// if($searchby=="2")$qq=$i['_source']['figid '];
	 


$qq=$i['_source']['patentID'];
$dd=$i['_source']['description'];
//for ($x = 0; $x <= 6; $x++)
//{
?>



	<div class="col-3" style="border: 1px solid black">
		<a href='../jsonFiles/dataset/<?php echo "$qq"."-D0000".$x.".png"; ?>' target='_blank'>
			<img src='../jsonFiles/dataset/<?php echo "$qq"."-D0000".$x.".png"; ?>'  width='50%'  />
			
			
			
		</a>
		
		<div style="text-align='center;background-color:00ee99'">
		
		
		
		<?php
		echo $dd;
		?>
		
	</div>
	</div>
	<br />
	<br />
	<br />
	
<?php
//echo "<br />";
//}
	$x++;
 }
 

//print_r($results);
echo count($results);
//echo $x;

}
}
//"aspect": "bottom pl"
//USD0871916-20200107

	if(isset($_POST['advanceSearchButton'])){
		$Rname = $_POST['Rname'];
		$Rtype = $_POST['Rtype'];
		$Rname=preg_replace("/<|>/i", "",$Rname);
		$Rtype=preg_replace("/<|>/i", "",$Rtype);



		//-- Change Here -->
		$query = $client->search([
		'body' => [
		'query' => [ // (5)
		'bool' => [
		'should' => [
		'match' => ['patentID'  => $Rname],
		'match' => ['aspect'  => $Rtype],


		]
		]
		]
		]
		]);
		if($query['hits']['total'] >=1 ) { // (6)
		$results = $query['hits']['hits'];
		$x = 0;
		 foreach ($results as $i)
		 {
			$qq=$i['_source']['patentID'];
		//$qq2=$i['_source']['patentID'];
		
		/*if($Rname != ""){
		
		?>
			<p>
				<a href='../jsonFiles/dataset/<?php echo "$qq"."-D0000".$x.".png"; ?>'>
					<img src='../jsonFiles/dataset/<?php echo "$qq"."-D0000".$x.".png"; ?>'  width="12%" />
				</a>
			</p>
		<?php
		}*/
		if($Rname !="" || $Rtype != ""){
		?>
			<div class="col-3"  style="border: 1px solid black">
				<a href='../jsonFiles/dataset/<?php echo "$qq"."-D0000".$x.".png"; ?>'>
					<img src='../jsonFiles/dataset/<?php echo "$qq"."-D0000".$x.".png"; ?>'  width="90%"  height="250px" />
				</a>
			</div>
			
		<?php
		}
		
			$x++;
		 }
		}
	}
echo "</div>";

?>


