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
<h1>Laporan Persediaan</h1>
<h2>Pasific Cafe</h2>
<h3>Per Tanggal <?=date('d-m-Y')?></h3>
<hr />
</div>
<br />
<br />
<h2>Total Persediaan</h2>
<table class="">
<tr class="firstrow"><th>Kode Persediaan</th><th>Nama</th><th>Jumlah</th><th>Harga</th><th>Nilai Total Asset</th></tr>
<?php
	$hombreng = 0;
	foreach ($perse as $persa)
	{
	echo "<tr>";
	echo "<td>".$persa->kode_persediaan."</td>";
	echo "<td>".$persa->nama_persediaan."</td>";
	echo "<td>".number_format($persa->jumlah,2,",",".")."</td>";
	echo "<td> Rp. ".number_format($persa->harga,2,",",".")."</td>";
	echo "<td> Rp. ".number_format($persa->jumlah*$persa->harga,2,",",".")."</td>";
	echo "</tr>";
	$hombreng = $hombreng + $persa->jumlah*$persa->harga;
	}
	echo "<tr class='lastrow'><td colspan='4'>Jumlah</td><td>Rp. ".number_format($hombreng,2,",",".")."</td></tr>";
?>
</table>
<br />
<br />
<h2> Persediaan Cabang </h2>
<?php
	foreach($muach as $homo)
	{
		echo "<table>";
		echo "<tr class='firstrow'><th colspan='3' >".$homo[0]."</th><th>Wilayah ".$homo[3]." kota ".$homo[2]."</th><th>".$homo[1]."</th></tr>";
		echo "<tr class='secondrow'><th>Kode</th><th>Nama</th><th>Jumlah</th><th>Harga Mean</th><th>Nilai Asset Total</th></tr>";
		$hombreng = 0;
		foreach ($homo[4] as $gay)
		{
			echo "<tr>";
			echo "<td>".$gay[0]."</td>";
			echo "<td>".$gay[1]."</td>";
			echo "<td>".number_format($gay[2]*1,2,",",".")."</td>";
			echo "<td> Rp. ".number_format($gay[3]*1,2,",",".")."</td>";
			echo "<td> Rp. ".number_format($gay[3]*$gay[2],2,",",".")."</td>";
			echo "</tr>";
			$hombreng = $hombreng + $gay[2]*$gay[3];
		}
		echo "<tr class='lastrow'><td colspan='4'>Jumlah</td><td>Rp. ".number_format($hombreng,2,",",".")."</td></tr>";
		echo "</table>";
		echo "<br />";
	}
?>
</div>
</body>
</html>