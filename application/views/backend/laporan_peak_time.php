<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/laporan_main" class="nav"> Index</a>
				<a href="<?php echo base_url() ?>cpanel/laporan_fast_slow" class="nav"> Fast/Slow Moving</a>
				<a href="<?php echo base_url() ?>cpanel/laporan_high_low" class="nav"> Hight/low Profit</a>
				<a href="<?php echo base_url() ?>cpanel/laporan_operational" class="nav"> Operational Profit</a>
				<a href="<?php echo base_url() ?>cpanel/laporan_cost" class="nav"> Cost Calculation</a>
			</div>
<div id="judul_konten">
	<h2>Laporan Peak Time</h2>
</div>
<div id="content">
<br />
<br />
<form action="<?=base_url()?>cpanel/php_laporan_peak_time" method="post" target="_blank">
		<table class="form">
		<tr><td style="width:300px">Tahun : </td><td><input name="tahun" type="number" value="<?php echo date('Y'); ?>"></td></tr>
		<tr><td style="width:300px">Bulan : </td><td><select name="bulan"><option value="1">Januari</option><option value="2">Februari</option><option value="3">Maret</option><option value="4">April</option><option value="5">Mei</option><option value="6">Juni</option><option value="7">July</option><option value="8">Agustus</option><option value="9">September</option><option value="10">Oktober</option><option value="11">November</option><option value="12">Desember</option></select></td></tr>
		<tr><td style="width:300px">Hari : </td><td><select name="hari"><option value="2">Senin</option><option value="3">Selasa</option><option value="4">Rabu</option><option value="5">Kamis</option><option value="6">Jummat</option><option value="7">Sabtu</option><option value="1">Minggu</option><select></td></tr>
		<tr><td>Format : </td><td>HTML<input type="radio" name="format" value="html" checked></td></tr>
		</table>
		<br>
		<input type="submit"  value="Submit"/><br />
		</form><br />
</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>asset/jquery.datetimepicker.js"></script>
<script type="text/javascript">
$('.wa').datetimepicker()
	.datetimepicker({timepicker:false,format: 'Y-m-d',mask:'9999-19-39'});
</script>