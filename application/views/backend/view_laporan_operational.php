<html>
<head>
	<style type="text/css">
	body
	{
	}
	#container
	{
		background: white;
		border-radius:10px;
		width:100%;
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
				color:white;
				background:rgb(79,44,38);
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
			background-repeat:none;
		}
	h2,h3
	{
		text-align:center;
	}
	</style>
	
</head>
<body>
<div id="container">
<div id="head">
<h1>Laporan Harian</h1>
<h2></h2>
<h3>Per Tanggal <?=$dari?> sampai <?=$sampai?></h3>
<hr />
</div>
<br />
<br />
<table class="">
<tr class="firstrow"><th rowspan="2">Date</th><th colspan="4">Gross Profit</th><th rowspan="2">Total</th><th rowspan="2">Cost</th><th rowspan="2">Net Profit</th><th rowspan="2">Share Profit</th></tr>
<tr class="firstrow"><th>Bar</th><th>Kitchen</th><th >Product</th><th >Lainnya</th></tr>
<?php
			$q=0;
			while($selisih>=0)
			{
				$tgl=date('Y-m-d',strtotime("$sampai -$q days"));
				echo "<tr><td>".$tgl."</td>";
				//Bar
				$bar=$this->db->select('COALESCE(sum(subtotal),0) as total',false)->where('date(waktu_pesanan_fi)',$tgl)->where('jenis_produk','bar')->from('pesanan p')->join('baris_pesanan b','b.no_pesanan=p.no_pesanan')->join('produk k','k.kode_produk=b.kode_produk')->get()->row()->total;
				echo "<td>".$bar."</td>";
				
				//Kitchen
				$dapur=$this->db->select('COALESCE(sum(subtotal),0) as total',false)->where('date(waktu_pesanan_fi)',$tgl)->where('jenis_produk','dapur')->from('pesanan p')->join('baris_pesanan b','b.no_pesanan=p.no_pesanan')->join('produk k','k.kode_produk=b.kode_produk')->get()->row()->total;
				echo "<td>".$dapur."</td>";
				
				//Product
				$produk=$this->db->select('COALESCE(sum(subtotal),0) as total',false)->where('date(waktu_pesanan_fi)',$tgl)->where('jenis_produk','produk')->from('pesanan p')->join('baris_pesanan b','b.no_pesanan=p.no_pesanan')->join('produk k','k.kode_produk=b.kode_produk')->get()->row()->total;
				echo "<td>".$produk."</td>";
				
				//Lainnya
				$lain=$this->db->select('COALESCE(sum(subtotal),0) as total',false)->where('date(waktu_pesanan_fi)',$tgl)->where('jenis_produk','lainnya')->from('pesanan p')->join('baris_pesanan b','b.no_pesanan=p.no_pesanan')->join('produk k','k.kode_produk=b.kode_produk')->get()->row()->total;
				echo "<td>".$lain."</td>";
				
				//Total
				$total=$bar+$dapur+$produk+$lain;
				echo "<td>".$total."</td>";
				
				//Cost
				//get cogs POS
				$cogs=$this->db->select('COALESCE(sum(total_cogs),0) as tcogs',false)->where('date(waktu_pesanan_fi)',$tgl)->get('pesanan')->row()->tcogs;
				//get cost custom
				$cost=$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as tcogs',false)->where('date(waktu_pengeluaran)',$tgl)->get('pengeluaran')->row()->tcogs;
				$tcost=$cogs+$cost;
				echo "<td>".$tcost."</td>";
				
				//Net Profit
				$np=$total-$tcost;
				echo "<td>".$np."</td>";
				
				//Share
				$share=$np/2;
				echo "<td>".$share."</td>";
				
				
				echo "</tr>";
				$selisih=$selisih-1;
				$q++;
			}
?>
</table>

</div>
</body>
</html>