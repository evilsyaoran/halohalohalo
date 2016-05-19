<!doctype html>
<html>
<head>
<style>
table {width:100%;}
.firstrow{text-align:left;}
img {width:250px;height:100px}
#img{margin:auto;display:table;}
	*{font-size:10px;font-family:arial;letter-spacing:6px;}
</style>
</head>
<body>
<div id="pesan">
<div id="img">
<img src="<?=base_url()?>images/logo.jpg" />
</div>
		<table class="form">
		<tr><td >No Pesanan : </td><td><?php echo $pesan->no_pesanan ?></td></tr>
		<tr><td>Atas nama : </td><td><?php echo $pesan->nama_pemesan ?></td></tr>
		<tr><td>Meja : </td><td><?php echo $pesan->meja ?></td></tr>
		</table>
		<br />
	</div>
	<hr />
	<br />
	<table>
		<tr class='firstrow'><th>No</th><th>Pesanan</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>
		<?php
			$no=1;
			$total=0;
			foreach($isi as $i)
			{
				echo "<tr><td>$no</td><td>$i->nama_produk</td><td>".$i->subtotal/$i->jumlah."</td><td>$i->jumlah</td><td>Rp. ".number_format($i->subtotal,0,",",".")."</td></tr>";
				if($i->jenis_produk=='bar')
				{
					echo "<tr><td colspan='5'>M:".$this->db->where('kode_produk',$i->method)->get('produk')->row()->nama_produk." B:".$i->beans." M:".$i->add_milk."</td></tr>";
				}
				$total=$total+$i->subtotal;
				$no++;
			}
			echo "<tr><td><b>Total</b></td><td></td><td></td><td></td><td><b>Rp. ".number_format($total,0,",",".")."</b></td><td></td></tr>";
			echo "<tr><td><b>Bayar</b></td><td></td><td></td><td></td><td><b>Rp. ".number_format($pesan->pembayaran,0,",",".")."</b></td><td></td></tr>";
			echo "<tr><td><b>Kembali</b></td><td></td><td></td><td></td><td><b>Rp. ".number_format($pesan->kembalian,0,",",".")."</b></td><td></td></tr>";
		?>
	</table><br />
</body>
</html>

<script>
   //set print name
   jsPrintSetup.setPrinter('GP-7635 Series');
   
   // set portrait orientation
   jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
   // set top margins in millimeters
   jsPrintSetup.setOption('edgeTop', 0);
   jsPrintSetup.setOption('unwriteableMarginTop', 2);
   jsPrintSetup.setOption('marginTop', 0);
   jsPrintSetup.setOption('marginBottom', 0);
   jsPrintSetup.setOption('marginLeft', 0);
   jsPrintSetup.setOption('marginRight', 0);
   
   // clears user preferences always silent print value
   // to enable using 'printSilent' option
   jsPrintSetup.clearSilentPrint();
   // Suppress print dialog (for this context only)
   jsPrintSetup.setOption('printSilent', 1);
   //ngek
 //  jsPrintSetup. setShowPrintProgress(false);
   // Do Print 
   // When print is submitted it is executed asynchronous and
   // script flow continues after print independently of completetion of print process! 
   jsPrintSetup.print();
	//jsPrintSetup. setShowPrintProgress(oldShowPrintProgress);

   // next commands
	window.close();window.close();
</script> 
