<div class="container pekerjaan">
	<div class="well ">
		<h3>Pencarian Kerja</h3>
		<p>Fitur ini digunakan untuk mencari pekerjaan yang sesuai dengan keinginan Anda.
	</div>

  <div class="row">
    <div class="col-sm-3" >
	    <div class="afix" id="filterpekerjaan" data-spy="affix" data-offset-top="186" style="width:250px;">
	      <div class="form" method="get" style="position:relative">
	      <form>
	      <h4 class="dkategori">Kategori</h4>
		  <hr class="fker">
		  <div class="wkategori" style="display:none;position:absolute;top:0;left:230px;z-index:2000;background:#eee;padding:0 10px 10px 10px;width:400px;">
		 <h4>Daftar Kategori</h4>
			<table class="kategori">
			 <tr><td>All <input name="all" type="checkbox" value="1" checked></td><td> Kuliner <input  name="kuliner" type="checkbox" value="1"> </td><td>Keuangan <input  name="keuangan" type="checkbox" value="keuangan"></td><td>Keamanan <input  name="keamanan" type="checkbox" value="1"></td></tr>
			</table>
		 </div>
	      <h4 class="fker">Tipe</h4>
		  <select name="jenis" style="width:170px">
		  <?php
		  foreach($jns as $j){
			echo "<option value='$j->id_jns_pekerjaan'>$j->nm_jns_pekerjaan</option>";
			};
			?>
		  </select>
		   <br> <br>
		  <hr class="fker">
	       <h4>Gaji</h4>
		   <table>
		   <tr><td style="width:40px">Min </td><td><input name="min" type="number" style="width:170px" value="0" min="0"></td></tr>
		   <tr><td>Max </td><td><input name="max" type="number" style="width:170px" name="max" value="100000000"></td></tr>
		    <tr><td> </td><td><select name="waktugaji" style="margin-top:5px"><option>all</option><option>bulan</option><option>minggu</option><option>hari</option></td></tr>
		   </table>
		   <hr>
	      <input type="submit" value="Search">
	      </form>
	      </div>
	    </div>
		<script>
			$('.dkategori').click(function(){
				$('.wkategori').toggle(300);
				$(this).toggleClass("katklik");
			});
		</script>
    </div>
	<script src="<?php echo base_url() ?>asset/jquery.jscroll.js"></script>
    <div class="col-sm-9">
    <h2>List Pekerjaan</h2>
	<?php 
		if($cpekerjaan==0)
		{
			echo "<p>Maaf, data kosong.</p>";
		}
		else
		{
			echo "<div class=\"jscroll\">";
			$this->load->view("frontend/list_cari"); 
			echo "</div>";
		}
	?>
	<script>
	$('.jscroll').jscroll({
		loadingHtml: '<img src="<?php echo base_url()."asset/"; ?>loading.gif" alt="Loading" /> Loading...',
		nextSelector: 'a.jscroll-next:last'
	});
	</script>
    </div>
  </div>  
 </div>