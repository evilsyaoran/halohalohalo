					<div id="isi" style="width:500px;float:left;">
					<script >
							window.setTimeout(function() {location.href = "<?php echo base_url()."cpanel/pesanan"?>";}, 10000);
							<?php
							echo "window.setTimeout(function() {window.open('".base_url()."cpanel/print_bon/$pesan','print', 'scrollbars=1,height=400,width=400');}, 1000);";
								//cek ada tidak print bar 
								/*
								$cekbar = $this->db->query("select * from baris_pesanan join produk on baris_pesanan.kode_produk=produk.kode_produk where kode_cabang='$cabang' and no_pesanan='$pesan' and jenis_produk='bar'")->num_rows;
								if($cekbar>0)
								{
									echo "window.setTimeout(function() {window.open('".base_url()."cpanel/print_bar/$pesan','_blank');}, 2000);";
								}
								//cek ada tidak print dapur
								$cekdap = $this->db->query("select * from baris_pesanan join produk on baris_pesanan.kode_produk=produk.kode_produk where kode_cabang='$cabang' and no_pesanan='$pesan' and jenis_produk='dapur'")->num_rows;
								if($cekdap>0)
								{
									echo "window.setTimeout(function() {window.open('".base_url()."cpanel/print_dapur/$pesan','_blank');}, 3000);";
								}
								*/
							?>
							  function waktu() {
							  var s;
							  s=document.getElementById('waktu').innerHTML-1;
							  document.getElementById('waktu').innerHTML=s;
							  setTimeout("waktu()",1000); 
							  }
							  setTimeout("waktu()",1000); 
						</script>
						<p style="height:50px;;width:100%;text-align:center;border-radius:5px;"><?php if($this->session->flashdata('sukses')){echo $this->session->flashdata('sukses');}?></p>
						
						<div class="col-xs-12 inner-pad" style='text-align: center'>
							<p>Harap menunggu dalam <span id="waktu">10</span> detik.</p>
					</div>