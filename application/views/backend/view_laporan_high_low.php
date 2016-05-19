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
<h1>Laporan High-Low Profit Product</h1>
<h2></h2>
<h3>Per Tanggal <?=$dari?> sampai <?=$sampai?></h3>
<hr />
</div>
<br />
<br />
<h2>Minuman</h2>
<table class="">
<tr class="firstrow"><th>No</th><th >Kode Produk</th><th >Nama Produk</th><th >Profit</th></tr>
<?php
		$no=1;		$this->db->where("date(waktu_pesanan_fi)<='$sampai'",'',false);
		$this->db->where("date(waktu_pesanan_fi)>='$$dari'",'',false);
		$minuman=$this->db->order_by('qty','desc')->group_by('produk.kode_produk')->select('*,COALESCE(sum(subtotal-subcogs),0) as qty,produk.kode_produk as kp',false)->where('jenis_produk','bar')->from('produk')->join('baris_pesanan b','b.kode_produk=produk.kode_produk','left')->join('pesanan s','s.no_pesanan=b.no_pesanan')->get()->result();
		foreach($minuman as $m)
		{
			echo "<tr><td>$no</td><td>$m->kp</td><td>$m->nama_produk</td><td>$m->qty</td></tr>";
			$no++;
		}
?>
</table>

<h2>Makanan</h2>
<table class="">
<tr class="firstrow"><th>No</th><th >Kode Produk</th><th >Nama Produk</th><th >Profit</th></tr>
<?php
		$no=1;		$this->db->where("date(waktu_pesanan_fi)<='$sampai'",'',false);
		$this->db->where("date(waktu_pesanan_fi)>='$$dari'",'',false);
		$minuman=$this->db->order_by('qty','desc')->group_by('produk.kode_produk')->select('*,COALESCE(sum(subtotal-subcogs),0) as qty,produk.kode_produk as kp',false)->where('jenis_produk','dapur')->from('produk')->join('baris_pesanan b','b.kode_produk=produk.kode_produk','left')->join('pesanan s','s.no_pesanan=b.no_pesanan')->get()->result();
		foreach($minuman as $m)
		{
			echo "<tr><td>$no</td><td>$m->kp</td><td>$m->nama_produk</td><td>$m->qty</td></tr>";
			$no++;
		}
?>

</table>

<h2>Produk</h2>
<table class="">
<tr class="firstrow"><th>No</th><th >Kode Produk</th><th >Nama Produk</th><th >Profit</th></tr>
<?php
		$no=1;		$this->db->where("date(waktu_pesanan_fi)<='$sampai'",'',false);
		$this->db->where("date(waktu_pesanan_fi)>='$$dari'",'',false);
		$minuman=$this->db->order_by('qty','desc')->group_by('produk.kode_produk')->select('*,COALESCE(sum(subtotal-subcogs),0) as qty,produk.kode_produk as kp',false)->where('jenis_produk','produk')->from('produk')->join('baris_pesanan b','b.kode_produk=produk.kode_produk','left')->join('pesanan s','s.no_pesanan=b.no_pesanan')->get()->result();
		foreach($minuman as $m)
		{
			echo "<tr><td>$no</td><td>$m->kp</td><td>$m->nama_produk</td><td>$m->qty</td></tr>";
			$no++;
		}
?>
</table>

<h2>Lainnya</h2>
<table class="">
<tr class="firstrow"><th>No</th><th >Kode Produk</th><th >Nama Produk</th><th >Profit</th></tr>
<?php
		$no=1;		$this->db->where("date(waktu_pesanan_fi)<='$sampai'",'',false);
		$this->db->where("date(waktu_pesanan_fi)>='$$dari'",'',false);
		$minuman=$this->db->order_by('qty','desc')->group_by('produk.kode_produk')->select('*,COALESCE(sum(subtotal-subcogs),0) as qty,produk.kode_produk as kp',false)->where('jenis_produk','lainnya')->from('produk')->join('baris_pesanan b','b.kode_produk=produk.kode_produk','left')->join('pesanan s','s.no_pesanan=b.no_pesanan')->get()->result();
		foreach($minuman as $m)
		{
			echo "<tr><td>$no</td><td>$m->kp</td><td>$m->nama_produk</td><td>$m->qty</td></tr>";
			$no++;
		}
?>
</table>
</div>
</body>
</html>