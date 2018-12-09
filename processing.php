<?php 
include 'koneksi.php';
function seluruh_data_db(){
	
	$sql = "SELECT * from tb_mst_penyakit";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			print_r ($row);
		}
	} else {
		echo "0 results";
	}

	mysqli_close($conn);

//print_r ($result);
}

function casefolding($str){
	  
	  return strtolower($str);
}
?>