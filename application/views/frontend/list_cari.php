<?php
$c=0;
foreach($pekerjaan as $p)
{
	$c++;
	echo "<div class=\"listpekerjaan\">";
    echo "<div class='kiri'><h1>$p->nm_pekerjaan</h1></div>";
    echo "<div class='kanan'>";
	echo "<div class='atas'>$p->nm_jns_pekerjaan";

	echo "</div>";
	echo "<div class='bawah'>Rp. ";
	echo number_format($p->gj_pekerjaan,2,',','.')."/$p->wgj_pekerjaan";
	echo "</div></div>";
    echo "<div class='clearfix'></div>";
	echo "</div>";
	
}
if($c!=0)
{
	echo "<a class='jscroll-next' href='".base_url()."kerja/list_cari/$list?";
	$x=0;
	foreach($_GET as $k=>$v)
	{
	if($x!=0)
	{
		echo "&";
	}
	echo $k."=".$v;
	$x++;
	}
	echo "'>Halaman Selanjutnya</a>";
}
?>