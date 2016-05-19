<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/batal_pesanan" class="nav">Batal Pesanan</a>
				<a href="<?php echo base_url() ?>cpanel/batal_pasokan" class="nav">Batal Pasokan</a>
</div>
<div id="judul_konten">
	<h2>Pesanan No. <?php echo $pesan->no_pesanan ?></h2>
</div>
<div id="content">
<br />
<p style="height:20px;;width:100%;text-align:center;border-radius:5px;<?php if($this->session->flashdata('sukses')){echo "background:rgba(0,255,0,.5)";}?>;"><?php if($this->session->flashdata('sukses')){echo $this->session->flashdata('sukses');}?></p>
<br>
	<hr />
	<br />
	<table>
		<tr class=''><th colspan='6'><h2 style='text-align:center;'>Daftar Pesanan</h2></th></tr>
		<tr class='firstrow'><th>No</th><th style="width:250px">Pesanan</th><th style="width:100px;">Harga</th><th>Jumlah</th><th style="width:100px;">Subtotal</th><th>Batal</th></tr>
		<?php
			$no=1;
			$total=0;
			foreach($isi as $i)
			{
				echo "<tr><td>$no</td><td>";
				echo $i->nama_produk."<br>";;
				if($i->jenis_produk=='bar')
				{
					echo "<p style='font-size:10px'>M:".$this->db->where('kode_produk',$i->method)->get('produk')->row()->nama_produk." B:".$i->beans." M:".$i->add_milk."</p>";
				}
				echo "</td><td>".$i->subtotal/$i->jumlah."</td><td>$i->jumlah</td><td>Rp. ".number_format($i->subtotal,0,",",".")."</td><td><a href='".base_url()."cpanel/php_detail_batal_pesanan/$pesan->no_pesanan/$i->idq'><img style='width:30px' src='".base_url()."images/batal.png'></a></td></tr>";
				$total=$total+$i->subtotal;
			}
			echo "<tr><td><b>Total</b></td><td></td><td></td><td></td><td><b>Rp. ".number_format($total,0,",",".")."</b></td><td></td></tr>";
		?>
	</table><br /><br />
</div>
</div>
