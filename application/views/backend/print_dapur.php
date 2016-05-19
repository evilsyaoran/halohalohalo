<!doctype html>
<html>
<head>
<style>
table {width:100%;}
.firstrow{text-align:left;}
img {width:20vh;}
#img{margin:auto;display:table;}
</style>
</head>
<body>
<div id="pesan">
		<table class="form">
		<tr><td style="width:300px">No Pesanan : </td><td><?php echo $pesan->no_pesanan ?></td></tr>
		<tr><td>Atas nama : </td><td><?php echo $pesan->nama_pemesan ?></td></tr>
		<tr><td>Meja : </td><td><?php echo $pesan->meja ?></td></tr>
		</table>
		<br />
	</div>
	<hr />
	<br />
	<table>
		<tr class='firstrow'><th>No</th><th>Pesanan</th><th>Jumlah</th></tr>
		<?php
			$no=1;
			$total=0;
			foreach($isi as $i)
			{
				echo "<tr><td>$no</td><td>$i->nama_produk</td><td>$i->jumlah</td></tr>";
				$total=$total+$i->subtotal;
			}
			
		?>
	</table><br />
</body>
</html>

<script>
   //nama_printer
   jsPrintSetup.setPrinter('HP Deskjet 1050 J410 series');
   
   // set portrait orientation
   jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
   // set top margins in millimeters
   jsPrintSetup.setOption('marginTop', 15);
   jsPrintSetup.setOption('marginBottom', 15);
   jsPrintSetup.setOption('marginLeft', 20);
   jsPrintSetup.setOption('marginRight', 10);
   
   // clears user preferences always silent print value
   // to enable using 'printSilent' option
   jsPrintSetup.clearSilentPrint();
   // Suppress print dialog (for this context only)
   jsPrintSetup.setOption('printSilent', 1);
   // Do Print 
   //hapus progress bar
   //jsPrintSetup. setShowPrintProgress(false);
   // When print is submitted it is executed asynchronous and
   // script flow continues after print independently of completetion of print process! 
   jsPrintSetup.print();
   //jsPrintSetup. setShowPrintProgress(oldShowPrintProgress);
   // next commands
	window.close();window.close();
</script> 