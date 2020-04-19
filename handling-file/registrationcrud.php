<?php
$koneksi = mysqli_connect("localhost", "root", "", "billing_address");
parse_str($_POST['datakirim'], $hasil);
$action = $_POST['action'];

//$_FILES record sama untuk sync dan async
if ($action == 'insert') {
	$foto = $_FILES["fotoku"];	//fotoku adalah record yang dikirim dari html (sync) dan js (async)
	$gambar = $_FILES["gambarku"];
	$namagambar = $gambar["name"];

	/* Error File Handling */
	$ccnumber = trim($hasil['CreditCardNumber']);
	if (!empty($foto["name"]) and !empty($ccnumber)){
		$namafile = $foto["name"];		//nama filenya
		preg_match("/([^\.]+$)/", $namafile, $ext);		//Regex: mencari string sesudah titik terakhir, saved in array ext
		$file_ext = strtolower($ext[1]);
		$namafilebaru = $hasil['CreditCardNumber'].".".$ext[1];	//nama file barunya [ccnumber].png
	    $file = $foto["tmp_name"];						//source filenya 
	    //perform the upload operation
		$extensions= array("jpeg","jpg","png");				//extensi file yang diijinkan
		//Kirim pesan error jika extensi file yang diunggah tidak termasuk dalam extensions
		$errors = array();
		if(in_array($file_ext,$extensions) === false)
		 $errors[] = "Extensi yang diperbolehkan jpeg atau png.";
		
		//Kirim pesan error jika ukuran file > 500kB
		$file_size = $foto['size'];
		if($file_size > 2097152)
		 $errors[] = "Ukuran file harus lebih kecil dari 2MB.";
	    
		//Upload file
		if(empty($errors)){
			if(move_uploaded_file($file, "uploads/" . $namafilebaru))
				echo "Uploaded dengan nama $namafilebaru";
		}
	}else echo $errors[] = "Lengkapi nomor kartu kredit dan gambarnya. ";
	echo "<br/>";

	if(!empty($errors)){
		echo "Error : ";
		foreach ($errors as $val)
			echo $val;
	}
	$syntaxsql = "INSERT INTO user(FirstName, LastName, Username, Email, Address, Address1, Country, State, ZIP, Payment, Name_Card, Credit_Number, Expiration, CVV, foto_identitas, gambar_identitas, Time_Insert) VALUES ('$hasil[firstName]','$hasil[lastName]','$hasil[Username]','$hasil[Email]','$hasil[Address]','$hasil[Address1]','$hasil[Country]','$hasil[State]','$hasil[Zip]','$hasil[paymentMethod]','$hasil[NameCard]','$hasil[CreditCardNumber]','$hasil[Expiration]','$hasil[CVV]','$namafilebaru','$namagambar',now())";
}
elseif ($action == 'update') {
	parse_str($_POST['dataTambahan'], $tambahan);
	$foto = $_FILES["fotoku"];	//fotoku adalah record yang dikirim dari html (sync) dan js (async)
	$gambar = $_FILES["gambarku"];
	$namagambar = $gambar["name"];

	/* Error File Handling */
	$ccnumber = trim($hasil['cc-number']);
	if (!empty($foto["name"]) and !empty($ccnumber)){
		$namafile = $foto["name"];		//nama filenya
		preg_match("/([^\.]+$)/", $namafile, $ext);		//Regex: mencari string sesudah titik terakhir, saved in array ext
		$file_ext = strtolower($ext[1]);
		$namafilebaru = $hasil['cc-number'].".".$ext[1];	//nama file barunya [ccnumber].png
	    $file = $foto["tmp_name"];						//source filenya 
	    //perform the upload operation
		$extensions= array("jpeg","jpg","png");				//extensi file yang diijinkan
		//Kirim pesan error jika extensi file yang diunggah tidak termasuk dalam extensions
		$errors = array();
		if(in_array($file_ext,$extensions) === false)
		 $errors[] = "Extensi yang diperbolehkan jpeg atau png.";
		
		//Kirim pesan error jika ukuran file > 500kB
		$file_size = $foto['size'];
		if($file_size > 2097152)
		 $errors[] = "Ukuran file harus lebih kecil dari 2MB.";
	    
		//Upload file
		if(empty($errors)){
			if(move_uploaded_file($file, "uploads/" . $namafilebaru))
				echo "Uploaded dengan nama $namafilebaru";
		}
	}else echo $errors[] = "Lengkapi nomor kartu kredit dan gambarnya. ";
	echo "<br/>";

	if(!empty($errors)){
		echo "Error : ";
		foreach ($errors as $val)
			echo $val;
	}

	$syntaxsql = "UPDATE user SET FirstName='$hasil[firstName]',LastName='$hasil[lastName]',Username='$hasil[Username]',Email='$hasil[Email]',Address='$hasil[Address]',Address1='$hasil[Address1]',Country='$hasil[Country]',State='$hasil[State]',ZIP='$hasil[Zip]',Payment='$hasil[paymentMethod]',Name_Card='$hasil[NameCard]',Credit_Number='$hasil[CreditCardNumber]',Expiration='$hasil[Expiration]',CVV='$hasil[CVV]' WHERE Username='$tambahan[ketTambahan]'";
}
elseif ($action == 'delete') {
	$syntaxsql = "DELETE FROM user WHERE Username='$hasil[Username]'";
}
elseif ($action == 'read') {
	$syntaxsql = "SELECT * FROM user WHERE Username='$hasil[Username]'";
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
			if (empty($row['foto_identitas'])) {
				$dfoto="avatar.png";
			}
			else{
				$dfoto= $row['foto_identitas'];
			}
				
			//echo "<tr><td>".$row['FirstName']."</td><td>". $row['LastName']."</td><td>".$row['Username']."</td><td>". $row['Email']."</td><td>".$row['Address']."</td><td>". $row['Address1']."</td><td>".$row['Country']."</td><td>". $row['State']."</td><td>".$row['ZIP']."</td><td>". $row['Payment']."</td><td>".$row['Name_Card']."</td><td>". $row['Credit_Number']."</td><td>".$row['Expiration']."</td><td>". $row['CVV']."</td></tr>";
			echo "<div class='container'>
			<div class='row'>
			<div class='col-sm-10'>
			<div class='row'>
			<div class='col-sm-4'>Name</div>
			<div class='col-sm-6'>: " .$row['FirstName']." ".$row['LastName']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>Username</div>
			<div class='col-sm-6'>: ".$row['Username']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>Email Address</div>
			<div class='col-sm-6'>: ".$row['Email']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>Address</div>
			<div class='col-sm-6'>: ".$row['Address']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>Address Optional</div>
			<div class='col-sm-6'>: ".$row['Address1']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>Country</div>
			<div class='col-sm-6'>: ".$row['Country']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>State</div>
			<div class='col-sm-6'>: ".$row['State']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>ZIP</div>
			<div class='col-sm-6'>: ".$row['ZIP']."</div>
			</div><div class='row'>
			<div class='col-sm-4'>Payment</div>
			<div class='col-sm-6'>: ".$row['Payment']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>Name on Card</div>
			<div class='col-sm-6'>: ".$row['Name_Card']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>Credit Card Number</div>
			<div class='col-sm-6'>: ".$row['Credit_Number']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>Expiration</div>
			<div class='col-sm-6'>: ".$row['Expiration']."</div>
			</div>
			<div class='row'>
			<div class='col-sm-4'>CVV</div>
			<div class='col-sm-6'>: ".$row['CVV']."</div>
			</div>
			</div>
			<div class='col-sm-2'>
			<img src='uploads/".$dfoto."' alt='Avatar' class='avatar'>
			</div>
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
				    <div class='col-sm-4'>:  $firstname #lastname</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Username</div>
				    <div class='col-sm-4'>:  $username</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Email Address</div>
				    <div class='col-sm-4'>:  $email</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Address</div>
				    <div class='col-sm-4'>:  $address</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Address Optional</div>
				    <div class='col-sm-4'>:  $address1</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Country</div>
				    <div class='col-sm-4'>:  $country</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>State</div>
				    <div class='col-sm-4'>:  $state</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>ZIP</div>
				    <div class='col-sm-4'>:  $zip</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Payment</div>
				    <div class='col-sm-4'>:  $payment</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Name on Card</div>
				    <div class='col-sm-4'>:  $namecard</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Credit Card Number</div>
				    <div class='col-sm-4'>:  $creditnumber</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>Expiration</div>
				    <div class='col-sm-4'>:  $expiration</div>
				  </div>
				  <div class='row'>
				    <div class='col-sm-4'>CVV</div>
				    <div class='col-sm-4'>:  $cvv</div>
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