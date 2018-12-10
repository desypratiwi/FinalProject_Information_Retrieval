<?php 
include 'Penyakit.php';
class Processing{
    public static $datas;
    public static function seluruh_data_db(){
            include 'koneksi.php';
        
            $sql = "SELECT * from tb_mst_penyakit";
            $result = mysqli_query($conn, $sql);
            $datas = array();
            if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
//                            print_r ($row);
                        $id = $row['id_penyakit'];
                        $judul = $row['judul'];
                        $desc = $row['deskripsi'];
                        $desc_t = Processing::casefolding($row['deskripsi_text']);
                        $penyakit = $row['penyakit'];
                        $page = $row['url_page'];
                        $url_ori = $row['url_page_ori'];
                        $slug = $row['slug'];
                        
                        $data = new Penyakit($id, $judul, $desc, $desc_t, $penyakit, $page, $url_ori, $slug);
                        $datas[] = $data;
                        
                    }
            } else {
                    echo "0 results";
            }
            mysqli_close($conn);
            
            Processing::$datas = $datas;
            return $datas;
    //print_r ($result);
    }

    public static function casefolding($str){

              return strtolower($str);
    }    
    
    public function tokenizing($kalimat)
    {
        
        $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $kalimat);
        // Replaces multiple spasi with single spasi.
        $string = preg_replace('!\s+!', ' ', $string);
        // String to array
        $string_array = explode(" ", $string);
        return $string_array;
    }
}
$tes = new Processing();
//print_r($tes->seluruh_data_db());
$tes->seluruh_data_db();
$res = Processing::tokenizing(Processing::$datas[0]->deskripsi_text);
print_r($res);

?>
