<?php
	class nav_admin extends CI_Model {
		public function nav_admin()
		{
			$kode = $this->session->userdata("user");
			if ($kode == "admin")
			{
				?>
				<li><a href="<?=base_url()?>cpanel/produk">Produk</a></li>
				<li><a href="<?=base_url()?>cpanel/inventory_main">Inventory</a></li>
				<li><a href="<?=base_url()?>cpanel/beban">Beban</a></li>
				<li><a href="<?=base_url()?>cpanel/pasokan">Pasokan</a></li>
				<li><a href="<?=base_url()?>cpanel/batal">Pembatalan</a></li>
				<li><a href="<?=base_url()?>cpanel/user">User</a></li>
				<li><a href="<?=base_url()?>cpanel/laporan_main">Laporan</a></li>
				<?php
			}
			else
			{
				?>
				<li><a href="<?=base_url()?>cpanel/pesanan">Pesanan</a></li>
				<li><a href="<?=base_url()?>cpanel/pasokan">Pasokan</a></li>
				<li><a href="<?=base_url()?>cpanel/laporan">Laporan</a></li>
				<?php
			}
		}
	}
?>