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
		width:920px;
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
<h1>Cost Calculation</h1>
<h2></h2>
<h3>Per Tanggal <?=$dari?> sampai <?=$sampai?></h3>
<hr />
</div>
<br />
<br />
<table class="">
<tr class="firstrow"><th >Date</th><th >Bar</th><th >Kitchen</th><th >Produk</th><th>P lainnya</th><th >Biaya Pembantu</th><th >Kasual Lembur</th><th >Listrik</th><th >Uang Mkn</th><th >Gas</th><th >B Lain-lain</th><th >Total</th></tr>
<?php
			$q=0;
			while($selisih>=0)
			{
				$tgl=date('Y-m-d',strtotime("$sampai -$q days"));
				echo "<tr><td>".$tgl."</td>";
				//Bar
				$bar=$this->db->select('COALESCE(sum(subcogs),0) as total',false)->where('date(waktu_pesanan_fi)',$tgl)->where('jenis_produk','bar')->from('pesanan p')->join('baris_pesanan b','b.no_pesanan=p.no_pesanan')->join('produk k','k.kode_produk=b.kode_produk')->get()->row()->total;
				$bar=$bar+$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as total',false)->where('date(waktu_pengeluaran)',$tgl)->where('id_pengeluaran','1')->get('pengeluaran p')->row()->total;
				echo "<td>".$bar."</td>";
				
				//Dapur
				$dpr=$this->db->select('COALESCE(sum(subcogs),0) as total',false)->where('date(waktu_pesanan_fi)',$tgl)->where('jenis_produk','dapur')->from('pesanan p')->join('baris_pesanan b','b.no_pesanan=p.no_pesanan')->join('produk k','k.kode_produk=b.kode_produk')->get()->row()->total;
				$dpr=$dpr+$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as total',false)->where('date(waktu_pengeluaran)',$tgl)->where('id_pengeluaran','2')->get('pengeluaran p')->row()->total;
				echo "<td>".$dpr."</td>";
				
				//Produk
				$prd=$this->db->select('COALESCE(sum(subcogs),0) as total',false)->where('date(waktu_pesanan_fi)',$tgl)->where('jenis_produk','produk')->from('pesanan p')->join('baris_pesanan b','b.no_pesanan=p.no_pesanan')->join('produk k','k.kode_produk=b.kode_produk')->get()->row()->total;
				$prd=$prd+$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as total',false)->where('date(waktu_pengeluaran)',$tgl)->where('id_pengeluaran','3')->get('pengeluaran p')->row()->total;
				echo "<td>".$prd."</td>";
				
				//Lainnya
				$lny=$this->db->select('COALESCE(sum(subcogs),0) as total',false)->where('date(waktu_pesanan_fi)',$tgl)->where('jenis_produk','lainnya')->from('pesanan p')->join('baris_pesanan b','b.no_pesanan=p.no_pesanan')->join('produk k','k.kode_produk=b.kode_produk')->get()->row()->total;
				$lny=$lny+$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as total',false)->where('date(waktu_pengeluaran)',$tgl)->where('id_pengeluaran','3')->get('pengeluaran p')->row()->total;
				echo "<td>".$prd."</td>";
				
				$pbt=$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as total',false)->where('date(waktu_pengeluaran)',$tgl)->where('id_pengeluaran','4')->get('pengeluaran p')->row()->total;
				echo "<td>".$pbt."</td>";
			
				$ksl=$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as total',false)->where('date(waktu_pengeluaran)',$tgl)->where('id_pengeluaran','5')->get('pengeluaran p')->row()->total;
				echo "<td>".$ksl."</td>";
				
				$lst=$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as total',false)->where('date(waktu_pengeluaran)',$tgl)->where('id_pengeluaran','6')->get('pengeluaran p')->row()->total;
				echo "<td>".$lst."</td>";
				
				$mkn=$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as total',false)->where('date(waktu_pengeluaran)',$tgl)->where('id_pengeluaran','7')->get('pengeluaran p')->row()->total;
				echo "<td>".$mkn."</td>";
				
				$gas=$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as total',false)->where('date(waktu_pengeluaran)',$tgl)->where('id_pengeluaran','8')->get('pengeluaran p')->row()->total;
				echo "<td>".$gas."</td>";
				
				$ln=$this->db->select('COALESCE(sum(nilai_pengeluaran),0) as total',false)->where('date(waktu_pengeluaran)',$tgl)->where('id_pengeluaran','9')->get('pengeluaran p')->row()->total;
				echo "<td>".$ln."</td>";
				
				$ttl=$bar+$dpr+$prd+$lny+$pbt+$ksl+$lst+$mkn+$gas+$ln;
				echo "<td>$ttl</td>";
				
				echo "</tr>";
				$selisih=$selisih-1;
				$q++;
			}
?>
</table>

</div>
</body>
</html>