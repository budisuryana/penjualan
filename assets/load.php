<?php
if(isset($_POST['btn-upload']))
{
	$img = rand(1000,100000)."-".$_FILES['img']['name'];
	$img_loc = $_FILES['img']['tmp_name'];
	$folder="jquery/";
	if(move_uploaded_file($img_loc,$folder.$img))
	{
		echo "<script>alert('Upload Sukses!!!');</script>";
	}
	else
	{
		echo "<script>alert('Upload Gagal');</script>";
	} 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Upload file dengan PHP</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="img" />
	<button type="submit" name="btn-upload">upload</button>
</form>
</body>
</html>