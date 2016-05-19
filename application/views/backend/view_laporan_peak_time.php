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
	* {text-align:center;}
	#chart{display:table;margin:auto;width:100%;height:220px;}
	.bar{float:left;width:3.7%;margin:0.2%;}
	.gbar{background:white;width:100%;height:220px;position:relative;}
	.clear{clear:both;}
	.warna{background:blue;width:100%;}
	</style>
	
</head>
<body>
<div id="container">
<div id="head">
<h1>Laporan Peak Time</h1>
<hr />
</div>
<br />
<br />
<div id="chart">
<?php 

$this->db->where('year(waktu_pesanan_fi)',$tahun,false);
$this->db->where('month(waktu_pesanan_fi)',$bulan,false);
$this->db->limit(1);
$this->db->order_by('jm','desc');
$this->db->where('dayofweek(waktu_pesanan_fi)',$hari,false);
$this->db->select('COALESCE(sum(jumlah_order),0) as jm',false);
$this->db->group_by('hour(waktu_pesanan_fi)',false);
$max = $this->db->get('pesanan');
if($max->num_rows == 0)
{
	$max=1;
}
else
{
	$max=$max->row()->jm;
}

$h=0;
while($h<=23)
{
	$this->db->where('year(waktu_pesanan_fi)',$tahun,false);
	$this->db->where('month(waktu_pesanan_fi)',$bulan,false);
	$this->db->where('dayofweek(waktu_pesanan_fi)',$hari,false);
	$this->db->where('hour(waktu_pesanan_fi)',$h,false);
	$this->db->select('COALESCE(sum(jumlah_order),0) as jm',false);
	echo "<div class='bar'>";
	echo "<div class='gbar'>";
	$jm = $this->db->get('pesanan')->row()->jm;
	echo $jm;
	echo "<div class='warna' style='height:";
	echo 200*($jm/$max);
	echo "px;position:absolute;bottom:0;'></div>";
	echo "</div>";
	echo gmdate("H:i",$h*60*60)."<br>";
	echo "</div>";
	$h++;
}
?>
<div class="clear"></div>
</div>

</div>
</body>
</html>