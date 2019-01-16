<html>
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<link href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>

<?php
	
        function insertKeluhan($keluhan,$doc){
            include 'koneksi.php';
            $sql = "INSERT INTO tb_tr_keluhan VALUES('{$keluhan}','{$doc}')";
            $qry = mysqli_query($conn, $sql);

        }
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

