<?php
	include 'koneksi.php';
	$sql = "SELECT * FROM tb_mst_penyakit";

	$result = mysqli_query($conn,$sql);
	$i=1;
	while ($row = mysqli_fetch_assoc($result)) {
		# code...
		// print_r($row) ;

			/*$srting = '<a title="" href="/index.html"><b>Some Text</b></a>
Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
*/



		$id = $row['id_penyakit'];
		// $judul = $row['judul'];
		// htmlentities($row['deskripsi'],ENT_QUOTES, 'utf8_encode')
		$desc = $row['deskripsi'];
		$hasil = strip_tags( $row['deskripsi']);
		// $hasil = utf8_encode($row['deskripsi']);
		// echo trim($hasil);
		$res = trim($hasil);
		// Hapus Tab
		$res = str_replace("&nbsp;", " ", $res);
		//Hapus Enter	
		$res = str_replace("\n", " ", $res);
			// echo $res;

		// echo trim(substr(strip_tags($desc, '<style>'),strpos($desc, "</style>")+8)); // ----- As @Andreas mentioned this is the right one -----
		//echo "$desc";
		// echo $hasil;
		// print_r($hasil);
		// echo strip_tags_content($hasil);
		
		$upd = "UPDATE tb_mst_penyakit SET deskripsi_text = '$res' WHERE id_penyakit = $id";
		 if(mysqli_query($conn,$upd)){
		 	echo $i++;
		 }else{
		 	echo "yey";
		 }
	}
function strip_tags_content($text) {

    return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);

 }	
	
?>