<?php
$koneksi = mysqli_connect("localhost", "root", "", "billing_address");
parse_str($_POST['datakirim'], $hasil);
$action = $_POST['action'];

if ($action == 'insert') {
	$syntaxsql = "INSERT INTO user(FirstName, LastName, Username, Email, Address, Address1, Country, State, ZIP, Payment, Name_Card, Credit_Number, Expiration, CVV, Time_Insert) VALUES ('$hasil[firstName]','$hasil[lastName]','$hasil[Username]','$hasil[Email]','$hasil[Address]','$hasil[Address1]','$hasil[Country]','$hasil[State]','$hasil[Zip]','$hasil[paymentMethod]','$hasil[NameCard]','$hasil[CreditCardNumber]','$hasil[Expiration]','$hasil[CVV]',now())";
}
elseif ($action == 'update') {
	parse_str($_POST['dataTambahan'], $tambahan);
	$syntaxsql = "UPDATE user SET FirstName='$hasil[firstName]',LastName='$hasil[lastName]',Username='$hasil[Username]',Email='$hasil[Email]',Address='$hasil[Address]',Address1='$hasil[Address1]',Country='$hasil[Country]',State='$hasil[State]',ZIP='$hasil[Zip]',Payment='$hasil[paymentMethod]',Name_Card='$hasil[NameCard]',Credit_Number='$hasil[CreditCardNumber]',Expiration='$hasil[Expiration]',CVV='$hasil[CVV]' WHERE Username='$tambahan[ketTambahan]'";
}
elseif ($action == 'delete') {
	$syntaxsql = "DELETE FROM user WHERE Username='$hasil[Username]'";
}
elseif ($action == 'read') {
	$syntaxsql = "SELECT FirstName, LastName, Username, Email, Address, Address1, Country, State, ZIP, Payment, Name_Card, Credit_Number, Expiration, CVV FROM user WHERE Username='$hasil[Username]'";
}
else {
	echo "ERROR ACTION";
	exit();
}

if (mysqli_errno($koneksi)) {
	echo "Gagal Terhubung ke Database".$koneksi -> connect_error; 
	exit();
}else{
	//echo "Database Terhubung";	
}

if ($koneksi -> query($syntaxsql) === TRUE) {
	echo "$action Successfully";
}
elseif ($koneksi->query($syntaxsql) === FALSE){
	echo "Error:  $syntaxsql" .$koneksi -> error;
}
else {
	$result = $koneksi->query($syntaxsql); //bukan true false tapi data array asossiasi
	if($result->num_rows > 0){
		//echo "<table id='tresult' class='table table-striped table-bordered'>";
		//echo "<thead><th>Firstname</th><th>Lastname</th><th>Username</th><th>Email</th><th>Address</th><th>Address1</th><th>Country</th><th>State</th><th>ZIP</th><th>Payment</th><th>Name on Card</th><th>Credit Card Number</th><th>Expiration</th><th>CVV</th></thead>";
		//echo "<tbody>";
		while($row = $result->fetch_assoc()) {
			//echo "<tr><td>".$row['FirstName']."</td><td>". $row['LastName']."</td><td>".$row['Username']."</td><td>". $row['Email']."</td><td>".$row['Address']."</td><td>". $row['Address1']."</td><td>".$row['Country']."</td><td>". $row['State']."</td><td>".$row['ZIP']."</td><td>". $row['Payment']."</td><td>".$row['Name_Card']."</td><td>". $row['Credit_Number']."</td><td>".$row['Expiration']."</td><td>". $row['CVV']."</td></tr>";
			echo "<div class='container'><div class='row'><div class='col-sm-4'>Name</div><div class='col-sm-8'>: " .$row['FirstName']." ".$row['LastName']."</div></div><div class='row'><div class='col-sm-4'>Username</div><div class='col-sm-8'>: ".$row['Username']."</div></div><div class='row'><div class='col-sm-4'>Email Address</div><div class='col-sm-8'>: ".$row['Email']."</div></div><div class='row'><div class='col-sm-4'>Address</div><div class='col-sm-8'>: ".$row['Address']."</div></div><div class='row'><div class='col-sm-4'>Address Optional</div><div class='col-sm-8'>: ".$row['Address1']."</div></div><div class='row'><div class='col-sm-4'>Country</div><div class='col-sm-8'>: ".$row['Country']."</div></div><div class='row'><div class='col-sm-4'>State</div><div class='col-sm-8'>: ".$row['State']."</div></div><div class='row'><div class='col-sm-4'>ZIP</div><div class='col-sm-8'>: ".$row['ZIP']."</div></div><div class='row'><div class='col-sm-4'>Payment</div><div class='col-sm-8'>: ".$row['Payment']."</div></div><div class='row'><div class='col-sm-4'>Name on Card</div><div class='col-sm-8'>: ".$row['Name_Card']."</div></div><div class='row'><div class='col-sm-4'>Credit Card Number</div><div class='col-sm-8'>: ".$row['Credit_Number']."</div></div><div class='row'><div class='col-sm-4'>Expiration</div><div class='col-sm-8'>: ".$row['Expiration']."</div></div><div class='row'><div class='col-sm-4'>CVV</div><div class='col-sm-8'>: ".$row['CVV']."</div>
				</div>";
		}
		//echo "</tbody>";
		//echo "</table>";
	}
}
/*if ($hasil[saveInfo] == 'save') {
	mysqli_query($insert);
if ($action == 'insert') {
		$insert = "";
		mysqli_query($koneksi,$insert);
		echo "Insert Successfully";
	}
	elseif ($action == 'update') {
		parse_str($_POST['dataTambahan'], $tambahan);
		$update = 
		mysqli_query($koneksi,$update);
		echo "Update Successfully";
	}
	elseif ($action == 'delete') {
		$delete = 
		mysqli_query($koneksi,$delete);
		echo "Delete Successfully";
	}
	elseif ($action == 'read') {
		$read = 
		$query = mysqli_query($koneksi, $read);
		$result = $koneksi->query($read); //bukan true false tapi data array asossiasi
		if(mysqli_num_rows($query) > 0){
		    echo "Data Anda : ";
		    $no = 0;
		    while($row = mysqli_fetch_array($query)) {
		        $firstname = $row['FirstName'];
		        $lastname = $row['LastName'];
				$username = $row['Username'];
				$email = $row['Email'];
				$address = $row['Address'];
				$address1 = $row['Address1'];
				$country = $row['Country'];
				$state = $row['State'];
				$zip = $row['ZIP'];
				$payment = $row['Payment'];
				$namecard = $row['Name_Card'];
				$creditnumber = $row['Credit_Number'];
				$expiration = $row['Expiration'];
				$cvv = $row['CVV'];
				$no++;
				echo "<div class='container bg-light'>
				  <div class='row'>
					<div class='col-sm-4'>Name</div>
				    <div class='col-sm-8'>:  $firstname #lastname</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Username</div>
				    <div class='col-sm-8'>:  $username</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Email Address</div>
				    <div class='col-sm-8'>:  $email</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Address</div>
				    <div class='col-sm-8'>:  $address</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Address Optional</div>
				    <div class='col-sm-8'>:  $address1</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Country</div>
				    <div class='col-sm-8'>:  $country</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>State</div>
				    <div class='col-sm-8'>:  $state</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>ZIP</div>
				    <div class='col-sm-8'>:  $zip</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Payment</div>
				    <div class='col-sm-8'>:  $payment</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Name on Card</div>
				    <div class='col-sm-8'>:  $namecard</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Credit Card Number</div>
				    <div class='col-sm-8'>:  $creditnumber</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Expiration</div>
				    <div class='col-sm-8'>:  $expiration</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>CVV</div>
				    <div class='col-sm-8'>:  $cvv</div>
				</div>";
		    }
		} else {
		    echo "0 results";
		}
		

		
	}
	else{
		echo "Dissconnected";
	}}*/
//echo $action;
//echo $output = "First Name :  $hasil[firstName] <br/> Last Name :  $hasil[lastName] <br/> Username :  $hasil[Username] <br/> Email :  $hasil[Email] <br/> Address :  $hasil[Address] <br/> Address 2 :  $hasil[Address1] <br/> Country :  $hasil[Country] <br/> State :  $hasil[State] Zip :  $hasil[Zip] <br/> Payment :  $hasil[paymentMethod] <br/> Name on Card :  $hasil[NameCard] <br/> Credit Card Number :  $hasil[CreditCardNumber] <br/> Expiration :  $hasil[Expiration] <br/> CVV :  $hasil[CVV]";

/**/

$koneksi->close();
?>