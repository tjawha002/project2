<?php
	include "db_connection.php";
		
	$email = $_GET['email'];
	$code = "";

	if(isset($_POST['submit'])){

		$code = mysqli_real_escape_string($db,$_POST['verify']);
		$sql = "Select * from users where email ='$email'";
		$query = mysqli_query($db,$sql);
		if(mysqli_num_rows($query) == 1){
			$row = mysqli_fetch_array($query);
			$user_code = $row['user_code'];
			
			if($user_code == $code){
				$sql2 = mysqli_query($db,"Update users set user_ver='Verified' where email ='$email'");
				echo "<script>alert ('Your Account has been verified');
						window.location.href = 'index.php';
				</script>";
			}
			else{
				echo "<script>alert ('The verification code is wrong') </script>";
			}
		}
	}
	

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Search Engine</title>
	</head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
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
		<div class="col-9 mx-auto py-5">
			<form method="post">
				<div class="row">
					<div class="col-9">
						<input type="text" name="verify" class="form-control">
					</div>
					<div class="col-3">
						<button type="submit" class="btn btn-primary" name="submit">Confirm Registration</button><br>
					</div>
				</div>
			</form>
		</div>
		<div class="col-9 mx-auto"><?php echo $code; ?></div>
	</body>
</html>