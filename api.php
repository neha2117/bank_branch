<html>
<head>
  <title>Bank Branch</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!----Script for searching the data from the table---->
  <script>
  	$(document).ready(function(){
  		$("#myInput").on("keyup", function() {
  			var value = $(this).val().toLowerCase();
    		$("#myTable tr").filter(function() {
      			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      		});
  		});
	});
	</script>
</head>
<body>
	<div class="container-fluid" style="margin-top: 50px;">
		<form class="form-inline text-center">
  			<div class="form-group">
    			<label for="dropdown">City</label>
    			<select class="form-control" name="city" onchange="this.form.submit()">
    				<option value="" disabled selected>--select--</option>
  					<option value="BANGALORE">BANGALORE</option>
  					<option value="UDAIPUR">UDAIPUR</option>
  					<option value="JAIPUR">JAIPUR</option>
  					<option value="DELHI">DELHI</option>
  					<option value="AHMEDABAD">AHMEDABAD</option>
				</select>
  			</div>
  			<div class="form-group">
    			<label for="search">Search</label>
    			<input id="myInput" type="text" class="form-control" placeholder="Search..">
  			</div>
		</form>
	</div>

<div class="table-responsive">
	<?php
		//If user select the city then only shows the branches of bank.
		if(isset($_GET["city"])) 
		{
			//Get the value of selected city and assign it into $city.
       		$city = $_GET["city"];
       		//callAPI is a function in which 3 arguments are passed and function return the $return which is assign into $get_data.
			$get_data = callAPI('GET', 'https://app.fyle.in/api/bank_branches?city='.$city.'&offset=0&limit=50', false);
			//json_decode is a function which helps to decode the json data into object.
			//Here $response is a object.
			$response = json_decode($get_data);
			?>
			<h1 class="text-center"><?php echo "BRANCH OF ".$city; ?></h1>	
			<table class="table table-hover">
  				<thead>
  					<tr>
  						<th>IFSC</th>
  						<th>Bank ID</th>
  						<th>Bank Name</th>
  						<th>Branch</th>
  						<th>Address</th>
  						<th>City</th>
  						<th>District</th>
  						<th>State</th>
  					</tr>
  				</thead>
  				<tbody id="myTable">
  					<?php 
  					//Fetching the data from the object $response.
  					foreach ($response as $data) { ?>
  						<tr>
  							<td><?php echo $data->ifsc ?></td>
  							<td><?php echo $data->bank_id ?></td>
  							<td><?php echo $data->bank_name ?></td>
  							<td><?php echo $data->branch ?></td>
  							<td><?php echo $data->address ?></td>
  							<td><?php echo $data->city ?></td>
  							<td><?php echo $data->district ?></td>
  							<td><?php echo $data->state ?></td>
  						</tr>
  					<?php } ?>
  			</tbody>
  		</table>
  	<?php }
  	//If the user is not selected any city. 
  	else { ?>
  		<h1 class="text-center"><?php echo "No Bank"; ?></h1>
  	<?php } ?>
  </div>
</body>
</html>

<?php
function callAPI($method, $url, $data){
   $curl = curl_init();
   if($method == 'GET') {
   	if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'APIKEY: 111111111111111111111',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}
?>
