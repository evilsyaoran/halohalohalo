<html>
<head>
	<style type="text/css">
	body
	{
		background: rgb(180,180,180);
	}
	#container
	{
		background: white;
		border-radius:10px;
		width:700px;
		padding:20px;
		margin:auto;
	}	
	
	table
			{
			border-collapse:collapse;
			width:100%;
			}
			
			table, td
			{
				border-left:1pt solid black;
				border-right:1pt solid black;
			}
			
			.firstrow 
			{
				border:none;
				background:rgb(0,0,222);
			}
			
			.secondrow
			{
				border:1pt solid black;
			}
			.lastrow, th
			{
				border:1px solid black;
			}
		#head
		{
			text-align:center;
			background: url('<?=base_url()?>images/logo1.png');
			background-repeat:none;
		}
	h2,h3
	{
		text-align:center;
	}
	</style>
	<script type="text/javascript">
	window.print();
</script>
</head>
<body>
<div id="container">
<div id="head">
<h1>Laporan Penjualan</h1>
<h2></h2>
<h3>Per Tanggal <?=date('1-m-Y')?> sampai <?=date('d-m-Y')?></h3>
<hr />
</div>
<br />
<br />
<table class="">
<tr class="firstrow"><th>Kode Cabang</th><th>Jumlah Pesanan</th><th>Jumlah Barang</th><th>Subtotal</th></tr>
<?php
	$jumlah = 0;
	foreach ($penjualan as $persa)
	{
	echo "<tr>";
	echo "<td>".$persa[0]."</td>";
	echo "<td>".$persa[1]."</td>";
	echo "<td>".$persa[2]."</td>";
	echo "<td> Rp. ".number_format($persa[3],2,",",".")."</td>";
	echo "</tr>";
	$jumlah = $jumlah + ($persa[3]);
}

	echo "<tr class='lastrow'><td colspan='3'>Jumlah: </td><td> Rp. ".number_format($jumlah,2,",",".")."</td></tr>";
?>
</table>

</div>
</body>
</html>