<html>
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<link href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>

    <?php
        //include 'Processing.php';
        function insertData($keluhan){
            include 'koneksi.php';
            $sql = "INSERT INTO tb_mst_penyakit(judul,deskripsi_text,slug) VALUES('keluhan','{$keluhan}','keluhan') ";
            $qry = mysqli_query($conn, $sql);
            if($qry){
                $sql = "SELECT LAST_INSERT_ID()";
                $qry = mysqli_query($conn,$sql);
                $id = mysqli_fetch_assoc($qry);
                return $id['LAST_INSERT_ID()'];
            }else{
                echo mysqli_error($conn);
            }
        }
        function deleteKeluhan($id){
            include 'koneksi.php';
            $sql = "DELETE FROM tb_mst_penyakit WHERE id_penyakit = {$id}";
            $hasil = mysqli_query($conn, $sql);
            
        }
        function insertKeluhan($keluhan,$doc){
            include 'koneksi.php';
            $sql = "INSERT INTO tb_tr_keluhan VALUES('{$keluhan}','{$doc}')";
            $qry = mysqli_query($conn, $sql);

        }
        if(isset($_POST['keluhan'])){
            include 'Processing.php';
            $tes = new Processing();
            //Tambahkan terlebih dahulu ke database
            $id = insertData($_POST['keluhan']);
            $tes->seluruh_data_db();
            $tes->tf_idf();
            
            $all_data = Processing::$datas;
            
            $index_doc = count($all_data)-1;
            $data = array();
            
            $maxi = 0;
            $doc = -1;
            for($i=0;$i<$index_doc;$i++){
                $kecocokan = Processing::cosine_similarity($index_doc, $i);
                if($maxi<$kecocokan){
                    $maxi = $kecocokan;
                    $doc = $i;
                }
                $all_data[$i]->cosine_similarity = $kecocokan;
                $data[] = $all_data[$i];
            }
            
            deleteKeluhan($id);
            insertKeluhan($_POST['keluhan'],$doc);
            
        }
        
        
        //insertKeluhan("oke");
    ?>
    <form method="post" action="">
        <table>
            <tr>
                <td><textarea name="keluhan"><?php echo isset($_POST['keluhan'])?$_POST['keluhan']:"" ?></textarea></td>
            </tr>
            <tr>
                <td><button type="submit">Deteksi</button></td>
            </tr>
        </table>
        
        
    </form>
    <table id="tb_hasil" <?php echo isset($_POST['keluhan'])?"" : "style='display:none;'" ?>  class="table table-striped table-bordered" style="width:100%" >
        <thead>
        <tr>
            <th>No</th>
            <th>Penyakit</th>
            <th>Kecocokan</th>
            <th>Detail</th>
        </tr>
        </thead>
        <?php for($i=0;$i<count($data);$i++) {?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo ($data[$i]->penyakit); ?></td>
            <td><?php echo ($data[$i]->cosine_similarity); ?></td>
            <td><a href="<?php echo ($data[$i]->url_page_ori); ?>"><button>Detail</button></a></td>
        </tr>
        <?php } ?>
        
    </table>
</html>
<script>
    $(document).ready(function() {
        $('#tb_hasil').DataTable({
            "order": [[ 2, "desc" ]]
        });
         
    } );
</script>

