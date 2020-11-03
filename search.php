<?php
require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create() // (2)
->build(); // (3)

if(isset($_GET['q'])) { // (4)

$q = $_GET['q'];

//-- Change Here -->
$query = $client->search([
'body' => [
'query' => [ // (5)
'bool' => [
'should' => [
'match' => ['name' => $q],
'match' => ['attributes' => $q]
]
]
]
]
]);
if($query['hits']['total'] >=1 ) { // (6)
$results = $query['hits']['hits'];
print_r($results);
}
}
//-- End Change here --

?>
<!-- HTML STARTS HERE -->
<html>  
    <head>
        <meta charset="utf-8">
        <title>Search Elasticsearch</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <form action="search.php" method="get" autocomplete="off">
            <label>
                Search for Something
                <input type="text" name="q">
            </label>
            <input type="submit" value="search">
        </form>
                       
        <div class="res">
            <a href="#id">Name</a>
        </div>
        <div class="res">Attributes</div>
    </body>
</html>

