<?php 

if (isset($_POST['create'])) {
	include "../db_conn.php";
	function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
	}

	$name = validate($_POST['name']);
	$singer = validate($_POST['singer']);
	$song_val = validate($_POST['song']);
	$cover_val = validate($_POST['cover']);

	$song = $_FILES['song'];
	$cover = $_FILES['cover'];
	$songname = $song['name'];
	$covername = $cover['name'];

 	/*upload song*/
	
	$songpath = "../uploads/" . basename($songname);
	if (move_uploaded_file($song['tmp_name'], $songpath)) {
	    // Move succeed.
	} else {
	    // Move failed. Possible duplicate?
	}

 	/*upload cover*/
	$coverpath = "../uploads/" . basename($covername);
	if (move_uploaded_file($cover['tmp_name'], $coverpath)) {
	    // Move succeed.
	} else {
	    // Move failed. Possible duplicate?
	}




	$user_data = 'name='.$name. '&singer='.$singer;


	if (empty($name)) {
		header("Location: ../index.php?error=Name is required&$user_data");
	}else if (empty($singer)) {
		header("Location: ../index.php?error=Singer is required&$user_data");
	}else {

       $sql = "INSERT INTO users(name, singer, song, cover) 
               VALUES('$name', '$singer','$songpath','$coverpath')";

       $result = mysqli_query($conn, $sql);
       if ($result) {
       	  header("Location: ../read.php?success=successfully created");
       }else {
          header("Location: ../index.php?error=unknown error occurred&$user_data");
       }
	}

}