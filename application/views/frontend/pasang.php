 <div class="container">
 <div class="well ">
<h3>Pengelolaan Posting Lowongan</h3>
<p>Fitur ini digunakan untuk mengelola lowongan yang Anda post.
</div>
</div>

<div class="afix" data-spy="affix" data-offset-top="186">
 <div class="container">
<div class="row">
<div class="col-sm-3 col-xs-3">
<button style="font-size:14px;padding:5px 5px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#postpekerjaan">+ Post Pekerjaan</button>
</div>
</div>
</div>
</div>


<div id="postpekerjaan" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create New Job Post</h4>
      </div>
	  <form method="post" action="<?php echo base_url()?>kerja/proses_pasang">
		<div class="modal-body">
		<table class="form">
		  <tr><td>Nama Pekerjaan : </td><td><input required type="text" name="nama"></td></tr>
		  <tr><td>Kategori Pekerjaan : </td><td><select name="kategori"><option value="none">Tidak ada</option><option value="kuliner">Kuliner</option><option value="keuangan">Keuangan</option><option value="none">Keamanan</option></select></tr>
		  <tr><td>Jenis Pekerjaan : </td><td><select name="jenis"><?php foreach($jns as $j){echo "<option value='$j->id_jns_pekerjaan'>$j->nm_jns_pekerjaan</option>";} ?></select></td></tr>
		  <tr><td>Description : </td><td><textarea name="descripsi"></textarea></td></tr>
		  <tr><td>Gaji : </td><td><input required type="number" name="gaji"></td></tr>
		  <tr><td>Waktu Penggajian : </td><td><select name="wgj"><option value="bulan"></option><option value="bulan">bulanan</option><option value="minggu">mingguan</option><option value="hari">harian</option></select></td></tr>
		 </table>
      </div>
	  <br>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
	  </form>
    </div>

  </div>
</div>

<br>

<div class="container">
<table class='table' id="ajaxtable">
<thead>
<tr><th>ID</th><th>Tgl Post</th><th>Nama</th><th>Kategori</th><th>Jenis</th><th>Deskripsi</th><th>Gaji</th><th>Waktu Byr</th></tr>
</thead>
<tbody>
<?php
	foreach($pekerjaan as $c)
	{
		echo "<tr><td>$c->id_pekerjaan</td>";
		echo "<td>$c->tgl_post_pekerjaan</td>";
		echo "<td>$c->nm_pekerjaan</td>";
		echo "<td>$c->kt_pekerjaan</td>";
		echo "<td>$c->nm_jns_pekerjaan</td>";
		echo "<td>$c->des_pekerjaan</td>";
		echo "<td>$c->gj_pekerjaan</td>";
		echo "<td>$c->wgj_pekerjaan</td></tr>";
	}
?>

<script src="<?php echo base_url() ?>asset/jquery.tabledit.js"></script>
<script>
$('#ajaxtable').Tabledit({
	restoreButton: false,
    url: '<?php echo base_url() ?>kerja/proses',
    columns: {
        identifier: [0, 'id_pekerjaan'],
        editable: [[2, 'nm_pekerjaan'],[3,'kt_pekerjaan'],[4,'id_jns_pekerjaan','{<?php $a=0;foreach($jns as $j){if($a!=0){echo ",";}echo "\"$j->id_jns_pekerjaan\":\"$j->nm_jns_pekerjaan\"";$a++;}?>}'],[5,'des_pekerjaan'],[6,'gj_pekerjaan'],[7,'wgj_pekerjaan','{"bulan":"bulan","minggu":"minggu","hari":"hari"}']]
    }
});
</script>
</tbody>
</table>
</div>