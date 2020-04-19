<?php
$gambarku = $_FILES["gambarku"];

if (!empty($gambarku["name"])){
	$namafile = $gambarku["name"];
	preg_match("/([^\.]+$)/", $namafile, $ext);
	$file_ext = strtolower($ext[1]);
    $file = $gambarku["tmp_name"];
	$extensions= array("jpeg","jpg","png");
	$errors = array();
	$file_size = $gambarku['size'];

	if(in_array($file_ext,$extensions) === false){
		$errors[] = "Gambar hanya diperbolehkan berformat JPG, JPEG dan PNG";
	}

	if($file_size > 2097152){
		$errors[] = "Ukuran file harus lebih kecil dari 2MB";
	}
	if(empty($errors)){
		if(move_uploaded_file($file, "uploads/" . $namafile))
			echo "Uploaded dengan nama $namafilebaru";
	}
}

if(!empty($errors)){
	echo "Error : ";
	foreach ($errors as $val)
		echo $val;
}

?>