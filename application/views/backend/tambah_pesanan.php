<div id="isi" style="width:750px;float:left;">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/pesanan" class="nav">List Pesanan</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_pesanan" class="nav">Tambah Pesanan</a>
			</div>
<div id="judul_konten">
	<h2>Tambah Pesanan</h2>
</div>
<div id="content">
<br />
<p style="height:20px;;width:100%;text-align:center;border-radius:5px;<?php if($this->session->flashdata('sukses')){echo "background:rgba(0,255,0,.5)";}?>;"><?php if($this->session->flashdata('message')){echo $this->session->flashdata('massage');}?></p>
<br>
	<div id="pesan">
		<form action="<?=base_url()?>cpanel/php_tambah_pesanan" method="post">
		<table class="form">
		<tr><td style="width:300px">No Pesanan : </td><td><input type="text" name="pesan" readonly='readonly' value='<?=$pesan?>' /></td></tr>
		<tr><td>Atas nama : </td><td><input  type="text" name="nama" value='' /></td></tr>
		<tr><td>Meja : </td><td><input type="text" name="meja"  value='' /></td></tr>
		</table>
		<br>
		<br>
		<table class="form">
		<tr><td style="width:300px">Nama Produk : </td><td>
		<input class='jq' type="text" pattern="K.{3,}"   required title="Pilih dengan benar" style="width:400px" autocomplete="off" name="produk" list="produk" id="pilih" />
		<datalist id="produk"><?php foreach($produk as $barang){echo "<option value='".$barang->kode_produk." - ". $barang->nama_produk."'>";} ?></datalist></td></tr><tr>
		<tr ><td style="height:25px;"><span class="hide ">Method : </span></td><td><select class="hide jq" name="method"><option value="-">-</option><?php foreach($method as $m){echo "<option value=\"$m->kode_produk\">$m->nama_produk</option>";}?></select></td></tr>
		<tr  ><td style="height:25px;"><span class="hide">Beans : </span></td><td><input  class="hide" type="text" name="beans" value='' /></td></tr>
		<tr  ><td style="height:25px;"><span class="hide">Add milk : </span></td><td><input  class="hide jq" type="number" min="0" name="milk" value='0' /></td></tr>
		<tr><td>Jumlah : </td><td>
		<input class='jq'  type="number" name="jumlah" value="1" min="1" id="jumlah" autocomplete="off" /></td></tr><tr><td>Harga : </td><td>
		<input type="text"  name="harga" readonly='readonly' id="harga" value="0" /></td></tr><tr><td>Subtotal : </td><td>
		<input type="text"  name="subtotal" readonly='readonly' id="subtotal" value="0" /></td></tr></table><br />
		<input class='lsubmit clear' type="submit" value="tambah"/><br />
		<div class='clearfix'></div>
		</form><br />
	</div>
	<hr />
	<br />
	<table>
		<tr class=''><th colspan='6'><h2 style='text-align:center;'>Daftar Pesanan</h2></th></tr>
		<tr class='firstrow'><th>No</th><th>Pesanan</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Batal</th></tr>
	</table><br /><br />
</div>
</div>
<div id="infos" style="float:left;">
<h2>Makanan Tersedia</h2>
<ul>
<?php
	$tersedia=$this->db->where('jenis_produk','dapur')->group_by('p.kode_produk')->get('produk p')->result();
	foreach($tersedia as $t)
	{
		$cek=0;
		$bahan=$this->db->where('kode_produk',$t->kode_produk)->get('bahan')->result();
		foreach($bahan as $b)
		{
			$inv=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row();
			if($b->jumlah > $inv->jumlah_inventory and $inv->status_inventory == 1)
			{
				$cek=1;
			}
		}
		if($cek==0)
		{
			echo "<li>$t->nama_produk</li>";
		}
	}
?>
<li>Lumpia</li>
<li>Cireng</li>
</ul>
</div>
<div class="clearfix"></div>
<script>
$(document).ready(function(){
	var txt;
	var txt1 = 0;
	var txt2 = 0;
	var haha=0;
	var bar=1;
	var mil=0;
	var harmil=0;
	var method=0;
	mil=$("input[name='milk']").val()*1;
	harmil=<?php echo $this->db->where('jenis_produk','add')->get('produk')->row()->harga; ?>*1;
	method=<?php echo $this->db->where('jenis_produk','method')->get('produk')->row()->harga; ?>*1;
	
	
    $(".jq").change(function(){
	 txt= $("#pilih").val();
	  
	 $.get("<?php echo base_url()?>cpanel/tambah_pesanan_ajax_1",{barang:txt}, function(data){
  	bar=data;	
	if(bar==0){
		$(".hide").hide();
		method=0;
		mil=$("input[name='milk']").val()*1;
		$("input[name='milk']").val(0);
		method=<?php echo $this->db->where('jenis_produk','method')->get('produk')->row()->harga; ?>*1;
		}
		else
		{
		$(".hide").show();
		}
	});
	
	  mil=$("input[name='milk']").val()*1;
	  
	  
	  brb= $("select[name='method']").val();
   $.get("<?php echo base_url()?>cpanel/tambah_pesanan_ajax_2",{method:brb}, function(data){
  	method=data*1;
	});
	
   $.get("<?php echo base_url()?>cpanel/tambah_pesanan_ajax",{barang:txt}, function(data){
  	$("#harga").val(data*1+method*1+mil*harmil);
	
	  txt1= $("#jumlah").val();
	  txt2= $("#harga").val();
	  
  	haha=txt1*txt2;
  	$("#subtotal").val(haha);
	});
  });
  
     $("input[name='produk']").on('input', function(e){
	  txt= $("#pilih").val();
	  	  $.get("<?php echo base_url()?>cpanel/tambah_pesanan_ajax_1",{barang:txt}, function(data){
  	bar=data;	
	if(bar==0){
		$(".hide").hide();
		method=0;
		mil=$("input[name='milk']").val()*1;
		$("input[name='milk']").val(0);
		method=<?php echo $this->db->where('jenis_produk','method')->get('produk')->row()->harga; ?>*1;
		}
		else
		{
		$(".hide").show();
		}
	});
	$.get("<?php echo base_url()?>cpanel/tambah_pesanan_ajax",{barang:txt}, function(data){
  	$("#harga").val(data*1+method*1+mil*harmil);
	
	  txt1= $("#jumlah").val();
	  txt2= $("#harga").val();
	  
  	haha=txt1*txt2;
  	$("#subtotal").val(haha);
	});
  });

     $(".jq").keyup(function(){
	  txt= $("#pilih").val();
	  	 $.get("<?php echo base_url()?>cpanel/tambah_pesanan_ajax_1",{barang:txt}, function(data){
  	bar=data;	
	if(bar==0){
		$(".hide").hide();
		method=0;
		mil=$("input[name='milk']").val()*1;
		$("input[name='milk']").val(0);
		method=<?php echo $this->db->where('jenis_produk','method')->get('produk')->row()->harga; ?>*1;
		}
		else
		{
		$(".hide").show();
		}
	});
	  $.get("<?php echo base_url()?>cpanel/tambah_pesanan_ajax_1",{barang:txt}, function(data){
  	bar=data;	
	if(bar==0){
		$(".hide").hide();
		method=0;
		mil=$("input[name='milk']").val()*1;
		$("input[name='milk']").val(0);
		method=<?php echo $this->db->where('jenis_produk','method')->get('produk')->row()->harga; ?>*1;
		}
		else
		{
		$(".hide").show();
		}
	});
	
	  mil=$("input[name='milk']").val()*1;
   $.get("<?=base_url()?>cpanel/tambah_pesanan_ajax",{barang:txt}, function(data){
  	$("#harga").val(data*1+method*1+mil*harmil);
	
		
	  txt1= $("#jumlah").val();
	  txt2= $("#harga").val();
	  
  	haha=txt1*txt2;
  	$("#subtotal").val(haha);
	});
	
		
	
  });
});
</script>
</div>