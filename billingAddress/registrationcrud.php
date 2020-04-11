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
		while($row = $result->fetch_assoc()) {
			echo "<div class='container'><div class='row'><div class='col-sm-4'>Name</div><div class='col-sm-8'>: " .$row['FirstName']." ".$row['LastName']."</div></div><div class='row'><div class='col-sm-4'>Username</div><div class='col-sm-8'>: ".$row['Username']."</div></div><div class='row'><div class='col-sm-4'>Email Address</div><div class='col-sm-8'>: ".$row['Email']."</div></div><div class='row'><div class='col-sm-4'>Address</div><div class='col-sm-8'>: ".$row['Address']."</div></div><div class='row'><div class='col-sm-4'>Address Optional</div><div class='col-sm-8'>: ".$row['Address1']."</div></div><div class='row'><div class='col-sm-4'>Country</div><div class='col-sm-8'>: ".$row['Country']."</div></div><div class='row'><div class='col-sm-4'>State</div><div class='col-sm-8'>: ".$row['State']."</div></div><div class='row'><div class='col-sm-4'>ZIP</div><div class='col-sm-8'>: ".$row['ZIP']."</div></div><div class='row'><div class='col-sm-4'>Payment</div><div class='col-sm-8'>: ".$row['Payment']."</div></div><div class='row'><div class='col-sm-4'>Name on Card</div><div class='col-sm-8'>: ".$row['Name_Card']."</div></div><div class='row'><div class='col-sm-4'>Credit Card Number</div><div class='col-sm-8'>: ".$row['Credit_Number']."</div></div><div class='row'><div class='col-sm-4'>Expiration</div><div class='col-sm-8'>: ".$row['Expiration']."</div></div><div class='row'><div class='col-sm-4'>CVV</div><div class='col-sm-8'>: ".$row['CVV']."</div>
				</div>";
		}
	}
}

$koneksi->close();
?>
