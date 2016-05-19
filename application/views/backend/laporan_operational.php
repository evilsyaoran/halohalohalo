<div id="isi">
<div id="body_nav">
				<a href="<?php echo base_url() ?>cpanel/laporan_main" class="nav"> Index</a>
				<a href="<?php echo base_url() ?>cpanel/laporan_fast_slow" class="nav"> Fast/Slow Moving</a>
				<a href="<?php echo base_url() ?>cpanel/laporan_high_low" class="nav"> Hight/low Profit</a>
				<a href="<?php echo base_url() ?>cpanel/laporan_operational" class="nav"> Operational Profit</a>
				<a href="<?php echo base_url() ?>cpanel/laporan_cost" class="nav"> Cost Calculation</a>
			</div>
<div id="judul_konten">
	<h2>Laporan Operational</h2>
</div>
<div id="content">
<br />
<br />
<form action="<?=base_url()?>cpanel/php_laporan_operational" method="post" target="_blank">
		<table class="form">
		<tr><td style="width:300px">Dari : </td><td><input type="text" class="wa" name="dari" value='<?php echo date('Y-m-d'); ?>' /></td></tr>
		<tr><td style="width:300px">Sampai : </td><td><input type="text" class="wa" name="sampai" value='<?php echo date('Y-m-d '); ?>' /></td></tr>
		<tr><td>Format : </td><td>HTML<input type="radio" name="format" value="html" checked>PDF<input type="radio" name="format" value="pdf" selected></td></tr>
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