<?php 
include 'Penyakit.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '512M');
error_reporting(E_ALL);
class Processing{
    
    public static $datas;
    public static $tf;
    public static $idf;
    public static $df;
    public static $tf_idf;
    public static $keywords;
    
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
                        $banyak = count($desc_t);
                        $words = Processing::tokenizing($desc_t);
//                        print_r($words);
                        // Menghitung tiap word
                        $l_word_count = Processing::hitung_kata($words);
//                        print_r ($l_word_count);
                        $data = new Penyakit($id, $judul, $desc, $desc_t, $penyakit, $page, $url_ori, $slug,$banyak,$l_word_count,$words);
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
    
    public static function tokenizing($kalimat)
    {
        
        $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $kalimat);
        // Replaces multiple spasi with single spasi.
        $string = preg_replace('!\s+!', ' ', $string);
        // String to array
        $string_array = explode(" ", $string);
        return $string_array;
    }
	//Fungsi untuk menghitung Banyak kata pada suatu dokumen
    public static function hitung_kata($katas){
        return array_count_values($katas);
    }
	//Method untuk mengembalikan banyaknya kata pada suatu dokumen
    public static function banyak_kata($doc,$word){
//        print_r ($doc->list_word_count[$word]);
        return ($doc->list_word_count[$word]);
//        print_r($doc->list_word_count);
//        return $doc->list_word_count[$word];
    }
	// Fungsi untuk mencari unique word
    public static function unique_word_string($teks){
        return array_unique(Processing::tokenizing($teks));
    }
    //Biar lebih efisien waktu
    public static function unique_word_array($arr){
        return array_unique($arr);
    }
    
    public static function gabung($teks1,$teks2){
        return array_merge($teks1,$teks2);
    }
    //Fungsi untuk mencari seluruh keyword pada gabungan dokumen
    public static function cari_seluruh_keyword(){
        //Filter dengan unique word terlebih dahulu
        $dok = Processing::$datas[0];
//        print_r($dok);
//        $katas = Processing::unique_word_array($dok->words);
         $katas = array_unique($dok->words);
//        print_r($katas);
        $hasil = $katas;
//        print_r($hasil);
        //Gabung satu persatu
        for($i=1;$i<count(Processing::$datas);$i++){
            $dok = Processing::$datas[$i];
//            $katas = Processing::unique_word_array($dok->words);
            $katas = array_unique($dok->words);
//        print_r($katas);            
            $hasil = Processing::gabung($hasil, $katas);
//            print_r($hasil);
            //Filter kembali
            $hasil = array_unique($hasil);
//            print_r($hasil);
        }
        return $hasil;
    }
    public static function tf_idf(){
        
        //Penghitungan TF
        
        $keywords = Processing::cari_seluruh_keyword();
        Processing::$keywords = $keywords;
//        print_r($keywords);
        //Per Keyword
//        Processing::$tf= array(array());
//        Processing::$df= array();
//        Processing::$idf= array();
        for($i=0;$i<count($keywords);$i++){
            
            
            if(isset($keywords[$i])||(!empty($keywords[$i]))){
                $word = $keywords[$i];
                Processing::$df[$word] = 0;
                //TF dengan keyword '$...' pada data $i
                for($j=0;$j<count(Processing::$datas);$j++){
                    $doc =Processing::$datas[$j];
    //                  echo $j;  
    //                echo Processing::banyak_kata($doc, $word);
                    //Jika list tidak null maka ada kata tersebut ada di dokumennya
                    Processing::$tf[$word][$j] = isset($doc->list_word_count[$word]) ? $doc->list_word_count[$word] :0;
                    // DF Bertambah jika pada suatu dokumen terdapat kata tersebut
                    Processing::$df[$word] = (Processing::$tf[$word][$j]!=0) ? (Processing::$df[$word])+1 : Processing::$df[$word];
                    Processing::$tf[$word][$j] = Processing::$tf[$word][$j] / $doc->banyak_word;
                }
                
                //jika df == 0 maka jadikan df = 0.1
                Processing::$df[$word] = (Processing::$df[$word]==0) ? 0.1 : Processing::$df[$word];
                // Penghitungan IDF 
                Processing::$idf[$word] = log(count(Processing::$datas)/Processing::$df[$word])/log(2);
                
                // Penghitungan tabel TF-IDF
//                Processing::$tf_idf= array(array());
                for($j=0;$j<count(Processing::$datas);$j++){
                    Processing::$tf_idf[$word][$j]  = Processing::$tf[$word][$j] * Processing::$idf[$word];
                    //self::insertTF_IDF(self::$datas[$j]->id_penyakit, $word, self::$tf_idf[$word][$j]);
                }    
            }
            
            
        }
//        echo "<pre>";
//        print_r($tf);
//        print_r($idf);
//        echo "</pre>";
         
    }
    public static function insertTF_IDF($id,$word,$tfidf){
        include 'koneksi.php';
        $sql = "INSERT INTO tb_tr_tf_idf VALUES ({$id},'{$word}',{$tfidf})";
        $query = mysqli_query($conn, $sql);
        if($query){
        
            
        }else{
            
        }
        
    }
    // Telah tersedia data tabel TF-IDF 
	// Method untuk menghitung Skalar TF-IDF
    public static function skalar($index_dok){
        $skalar = 0;
        
        for($i=0;$i<count(Processing::$keywords);$i++){
           $word =  Processing::$keywords[$i];
           $skalar += pow(Processing::$tf_idf[$word][$index_dok],2);
        }
        return sqrt($skalar);
    }
    // Method untuk menghitung Cosine Similarity
    public static function cosine_similarity($index_dok1,$index_dok2){
        $ska_dok1 = Processing::skalar($index_dok1);
        $ska_dok2 = Processing::skalar($index_dok2);
        
        $jumlah_atas = 0;
        for($i=0;$i<count(Processing::$keywords);$i++){
            $word =  Processing::$keywords[$i];
            $keyword = Processing::$tf_idf[$word];
            $jumlah_atas += $keyword[$index_dok1]*$keyword[$index_dok2];
            
        }
        return ($jumlah_atas)/($ska_dok1*$ska_dok2);
    }

}


?>
