<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/produk" class="nav">List Item</a>
				<a href="<?php echo base_url() ?>cpanel/tambah_produk" class="nav">Tambah Item</a>
</div>
<div id="judul_konten">
	<h2>Detail Item</h2>
</div>
<div id="content">
<br />
<br />
<form action="<?php echo base_url()?>cpanel/php_update_produk" method="post">
	<table class='form'>
		<tr><td>Kode Produk : </td><td><input type="text" readonly='readonly' value='<?=$form->kode_produk ?>' name="kode" /></td></tr>
		<tr><td>Nama : </td><td><input type="text" value='<?=$form->nama_produk ?>' name="nama" /></td></tr>
		<tr><td>Jenis : </td><td><select name='jenis'><option value='bar' <?php if($form->jenis_produk=='bar'){echo "selected";}?>>Bar</option><option  <?php if($form->jenis_produk=='dapur'){echo "selected";}?> value='dapur'>Dapur</option><option  <?php if($form->jenis_produk=='produk'){echo "selected";}?> value='produk'>Produk</option><option  <?php if($form->jenis_produk=='lainnya'){echo "selected";}?> value='produk'>Lainnya</option></select></td></tr>
		<tr><td>Harga : </td><td><input type="number" value='<?=$form->harga ?>' name="harga" /></td></tr>
		<tr><td>Status : </td><td><select name='status'><option value='1' <?php if($form->status_produk=='1'){echo "selected";}?>>Aktif</option><option  <?php if($form->status_produk=='0'){echo "selected";}?> value='0'>Tidak Aktif</option></select></td></tr>
		<tr><td colspan="2"></td></tr>
	</table><br>
	<input class='lsubmit' type="submit" value="Update" />
	</form>
	<div class='clearfix'></div>
		<br /><br />
		<div style="border:1px solid rgb(79,44,38);border-radius:5px;padding:5px;"><br>
		<form action="<?php echo base_url()?>cpanel/php_detail_produk" method="post">
		<input type="hidden" readonly='readonly' value='<?=$form->kode_produk ?>' name="kode" />
			Bahan : 
		<input type="text" name="bihun" list="bihun" id="pilih" />
		<datalist id="bihun"><?php foreach($bihun as $mie){echo "<option value='".$mie->id_inventory." - ".$mie->nama_inventory."'>";} ?></datalist>
		Jumlah : <input type="text" name="jumlah" />
		<br /><br />
		<input class='lsubmit' type="submit" value="Tambah" />
		<div class='clearfix'></div>
		</form>
		</div>
	<br /><br />
		<table>
		<tr class=''><th colspan='4'><h2 style='text-align:center;'>Daftar Bahan Produk <?=$form->nama_produk ?></h2></th></tr>
		<tr class='firstrow'><th>Kode Bahan</th><th>Nama</th><th>Jumlah</th><th>Batal</th></tr>
		<?php
			foreach($isi as $detail)
			{echo "<tr><td>".$detail->id_inventory."</td><td>".$detail->nama_inventory."</td><td>".$detail->jumlah."</td>".
				"<td style='text-align:center;'>".
				"<a href='".
				base_url().
				"cpanel/batal_bahan/".
				$form->kode_produk."/".
				$detail->id_inventory.
				"'><img src='".
				base_url().
				"images/batal.png' style='height:30px;' /></a>".
				"</td></tr>";
			}
			?>
		
	</table>
</div>
</div>