<?php
$koneksi = mysqli_connect("localhost", "root", "", "Billing_Address");
parse_str($_POST['dataku'], $hasil);
//echo $output = "First Name : $hasil[firstName] <br/> Last Name : $hasil[lastName] <br/> Username : $hasil[Username] <br/> Email : $hasil[Email] <br/> Address : $hasil[Address] <br/> Address 2 : $hasil[Address1] <br/> Country : $hasil[Country] <br/> State : $hasil[State] Zip : $hasil[Zip] <br/> Payment : $hasil[paymentMethod] <br/> Name on Card : $hasil[NameCard] <br/> Credit Card Number : $hasil[CreditCardNumber] <br/> Expiration : $hasil[Expiration] <br/> CVV : $hasil[CVV]";

$insert = "INSERT INTO `user`(`FirstName`, `LastName`, `Username`, `Email`, `Address`, `Address1`, `Country`, `State`, `ZIP`, `Payment`, `Name_Card`, `Credit_Number`, `Expiration`, `CVV`, `Time_Insert`) VALUES ('$hasil[firstName]','$hasil[lastName]','$hasil[Username]','$hasil[Email]','$hasil[Address]','$hasil[Address1]','$hasil[Country]','$hasil[State]','$hasil[Zip]','$hasil[paymentMethod]','$hasil[NameCard]','$hasil[CreditCardNumber]','$hasil[Expiration]','$hasil[CVV]',now())";

if (mysqli_errno($koneksi)) {
	echo "Gagal Terhubung ke Database";
}else{
	echo "Database Terhubung";
	mysqli_query($koneksi,$insert);
	echo "Submit Berhasil";

}
//$koneksi->close();
/*if ($hasil[saveInfo] == 'save') {
	mysqli_query($insert);
}*/
?>