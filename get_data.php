<?php 
	

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, 'https://web-halodoc-api.prod.halodoc.com/v4/categories/all/');
	$result = curl_exec($ch);
	curl_close($ch);

	$obj = json_decode($result);
	//$obj = (object) $obj;
	/*	echo "<pre>";
		print_r($obj);
		print_r($result);
		echo "</pre>";
	*/

	include 'koneksi.php';

	/* Testing
	$sql = "INSERT INTO tb_mst_penyakit(judul,deskripsi,penyakit,url_page_ori) VALUES 
	('te','te','te','te'),
	('te1','te','te','te')";
	// print_r($sql)
	$conn->query($sql);

	*/
	// print_r($obj);

	$sql = "INSERT INTO tb_mst_penyakit(judul,deskripsi,penyakit,url_page_ori,slug) VALUES ";
	for ($i=0; $i < count($obj)-1 ; $i++) { 
			# code...
			$url = "https://www.halodoc.com/kesehatan/";
			$temp = strtolower($obj[$i]->name);
			// echo "$temp";
			$ok = str_replace(" ", "-", $temp);
			$ok = str_replace("'", "`", $ok);
			$obj[$i]->content = str_replace("'", "`", $obj[$i]->content);
			$obj[$i]->name = str_replace("'", "`", $obj[$i]->name);
			$url = $url.$ok;
			$sql = $sql."('".$obj[$i]->name."','".$obj[$i]->content."','".$obj[$i]->name."','".$url."','".$ok."'),";
		}	
			//Last Without Commas
			$url = "https://www.halodoc.com/kesehatan/";
			$temp = strtolower($obj[$i]->name);
			$ok = str_replace(" ", "-", $temp);
			$ok = str_replace("'", "`", $ok);
			$url = $url.$ok;
			$obj[$i]->content = str_replace("'", "`", $obj[$i]->content);
			$obj[$i]->name = str_replace("'", "`", $obj[$i]->name);
			$sql = $sql."('".$obj[$i]->name."','".$obj[$i]->content."','".$obj[$i]->name."','".$url."','".$ok."')";
	
	// print_r($sql);
	if($conn->query($sql)){
		echo "Generate Success";
	}else{
		 echo "Error: " . $sql . "<br>" . $conn->error;
	}		
?>