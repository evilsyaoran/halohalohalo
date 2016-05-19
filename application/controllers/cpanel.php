<?php
	class cpanel extends CI_Controller {
		public function __construct()
			{
			parent::__construct();
			//Control awal
			if(!$this->session->userdata('pegawai'))
				{
				redirect(base_url());
				}
			$this->datetime = date("Y-m-d H:i:s");
		}
		
		public function index() // List produk dibawah EOQ
		{
			$data['page'] = "backend/home";
			$data['title'] = "Home";
			$this->load->view("backend/template",$data);
		}
		
		//1-kasir
		public function pesanan($index=1) // List pesanan
		{
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			//pagination
			$this->load->library('pagination');
			$config['base_url'] = base_url()."cpanel/pesanan";
			$config['total_rows'] = $this->db->where('kode_cabang',$cabang)->get('pesanan')->num_rows();
			$config['per_page'] = 30;
			$config['uri_segment'] = 3;
			$config['first_url'] = 0;
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '<p>';
			$config['anchor_class'] = 'class="page" ';
			$config['use_page_numbers'] = TRUE;
			$this->pagination->initialize($config);
				
			$data['pagination']=$this->pagination->create_links();
			
			//data pesanan
			$this->db->order_by('no_pesanan','desc');
			$this->db->limit($config['per_page'],$index-1);
			$data['pesanan'] = $this->db->where('kode_cabang',$cabang)->get('pesanan')->result();
			
			$data['page'] = "backend/pesanan";
			$data['title'] = "Pesanan";
			$this->load->view("backend/template",$data);
		}
		
		public function tambah_pesanan() // Tambah Order
		{			
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			$produk = $this->db->query("select * from produk where (jenis_produk='bar' or jenis_produk='dapur' or jenis_produk='produk' or jenis_produk='lainnya') and status_produk=1");
			$method = $this->db->query("select * from produk where jenis_produk='method'");
			
			$data['method'] = $method->result();
			$data['produk'] = $produk->result();
			$pesan = $this->db->query("select no_pesanan from pesanan where kode_cabang='$cabang' order by no_pesanan desc limit 1");
			$pesan = $pesan->row();
			if (empty($pesan->no_pesanan))
			{$no = 0;}
			else
			$no = $pesan->no_pesanan;
			$data['pesan'] = intval($no)+1;
			
			$data['page'] = "backend/tambah_pesanan";
			$data['title'] = "Tambah Pesanan";
			$this->load->view("backend/template",$data);
		}
		
		public function detail_pesanan($detail = 0) // Detail pembuatan order
		{			
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			$cabang = $this->session->userdata("cabang");
			$produk = $this->db->query("select * from produk where (jenis_produk='bar' or jenis_produk='dapur' or jenis_produk='produk' or jenis_produk='lainnya') and status_produk=1");
			$method = $this->db->query("select * from produk where jenis_produk='method'");
			
			$data['method'] = $method->result();
			$data['produk'] = $produk->result();
			
			$data['pesan'] = $this->db->where('no_pesanan',$detail)->get('pesanan')->row();
			$pesan = $detail;
			
			$isi = $this->db->query("select * from baris_pesanan join produk on baris_pesanan.kode_produk=produk.kode_produk where kode_cabang='$cabang' and no_pesanan='$pesan'");
			$data['isi'] = $isi->result();
			
			$data['page'] = "backend/detail_pesanan";
			$data['title'] = "Detail Pesanan ".$detail;
			$this->load->view("backend/template",$data);
		}
		
		public function php_tambah_pesanan() // Fungsi penambahan produk pada order + Complete Order
		{			
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			$waktu = date('Y-m-d H:i:s');
			$pesan = $this->input->post("pesan");
			$peg=$this->session->userdata('idpeg');
			
			if ($this->input->post("Selesai")) // Untuk menyeselsaikan order
			{
				
				//mengamankan
				$pengaman=0;
				$bp=$this->db->select("*,sum(b.jumlah*n.jumlah) as jm",'',false)->group_by('id_inventory')->where("no_pesanan",$pesan)->from('baris_pesanan b')->join('bahan n','n.kode_produk=b.kode_produk')->get();
				foreach($bp->result() as $ca)
				{
					echo $ca->jm;
					$jml=$ca->jm;
					$cek=$this->db->where('id_inventory',$ca->id_inventory)->get('inventory')->row();
					$jmi=$cek->jumlah_inventory;
					
					if(($jmi-$jml)<0 and $cek->status_inventory != 0)
					{
						$pengaman=1;
					}
				}
				if($pengaman==1)
				{
					echo "<script language=\"javascript\">alert('Salah satu produk habis')</script>";
					echo "<script language=\"javascript\">window.history.back();</script>";
				}
				else
				{
					//jumlah order
					$jorder=$this->db->select("sum(jumlah) as total","",false)->where('no_pesanan',$pesan)->get('baris_pesanan')->row()->total;
					
					//total
					$total=$this->db->select("sum(subtotal) as total","",false)->where('no_pesanan',$pesan)->get('baris_pesanan')->row()->total;
					
					//input ke realisasi
					$qwerty=$this->db->where('no_pesanan',$pesan)->get('baris_pesanan')->result();
					
					//cogs
					$tcogs=0;
					foreach($qwerty as $q)
					{
						//andaikan minuman
						$jenis=$this->db->where('kode_produk',$q->kode_produk)->get('produk')->row()->jenis_produk;
						
						if($jenis == "bar")
						{
							//cogs method
							$mbahan=$this->db->where('kode_produk',$q->method)->from('bahan b')->join('inventory i','i.id_inventory=b.id_inventory')->get()->result();
							foreach($mbahan as $b)
							{
								$this->db->insert('realisasi_cogs',array('idq'=>$q->idq,'id_inventory'=>$b->id_inventory,'jumlah'=>$b->jumlah*$q->jumlah,'tcpu'=>$b->jumlah*$b->harga_inventory*$q->jumlah));
								
								if($b->status_inventory==1)
								{
									//update inventory
									$nj=$b->jumlah*$q->jumlah;
									$this->db->set('jumlah_inventory',"jumlah_inventory-$nj",false);
									$this->db->where('id_inventory',$b->id_inventory)->update('inventory');
								
									$jakhir=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row()->jumlah_inventory;
									$jawal=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row()->jumlah_inventory+$nj;
									$this->db->insert('moving_inventory',array('jumlah'=>$nj,'waktu'=>$waktu,'id_inventory'=>$b->id_inventory,'pergerakan'=>'keluar','q_awal'=>$jawal,'q_akhir'=>$jakhir,'harga_awal'=>$b->harga_inventory,'harga_akhir'=>$b->harga_inventory,'jenis_pergerakan'=>'penjualan','id_sumber'=>$q->idq));
								}
							}
							
							//cogs susu
							if($q->add_milk >0)
							{
								$sbahan=$this->db->where('kode_produk','K0017')->from('bahan b')->join('inventory i','i.id_inventory=b.id_inventory')->get()->result();
								foreach($sbahan as $b)
								{
									$cek=$this->db->where('idq',$q->idq)->where('id_inventory',$b->id_inventory)->get('realisasi_cogs')->num_rows();
									if($cek <1)
									{
										$this->db->insert('realisasi_cogs',array('idq'=>$q->idq,'id_inventory'=>$b->id_inventory,'jumlah'=>$b->jumlah*$q->add_milk*$q->jumlah,'tcpu'=>$b->jumlah*$b->harga_inventory*$q->add_milk*$q->jumlah));
										
										if($b->status_inventory==1)
										{
											//update inventory
											$nj=$b->jumlah*$q->add_milk*$q->jumlah;
											$this->db->set('jumlah_inventory',"jumlah_inventory-$nj",false);
											$this->db->where('id_inventory',$b->id_inventory)->update('inventory');
											
											$jakhir=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row()->jumlah_inventory;
											$jawal=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row()->jumlah_inventory+$nj;
											$this->db->insert('moving_inventory',array('jumlah'=>$nj,'waktu'=>$waktu,'id_inventory'=>$b->id_inventory,'pergerakan'=>'keluar','q_awal'=>$jawal,'q_akhir'=>$jakhir,'harga_awal'=>$b->harga_inventory,'harga_akhir'=>$b->harga_inventory,'jenis_pergerakan'=>'penjualan','id_sumber'=>$q->idq));
										}
									}
									else
									{
										$nj=$b->jumlah*$q->add_milk*$q->jumlah;
										$ntc=$b->jumlah*$b->harga_inventory*$q->add_milk*$q->jumlah;
										$this->db->set('jumlah',"jumlah+$nj",false);
										$this->db->set('tcpu',"tcpu+$ntc",false);
										$this->db->where('idq',$q->idq)->where('id_inventory',$b->id_inventory)->update('realisasi_cogs');
										
										if($b->status_inventory==1)
										{
											//update inventory
											$this->db->set('jumlah_inventory',"jumlah_inventory-$nj",false);
											$this->db->where('id_inventory',$b->id_inventory)->update('inventory');
											
											$jakhir=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row()->jumlah_inventory;
											$jawal=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row()->jumlah_inventory+$nj;
											$this->db->insert('moving_inventory',array('jumlah'=>$nj,'waktu'=>$waktu,'id_inventory'=>$b->id_inventory,'pergerakan'=>'keluar','q_awal'=>$jawal,'q_akhir'=>$jakhir,'harga_awal'=>$b->harga_inventory,'harga_akhir'=>$b->harga_inventory,'jenis_pergerakan'=>'penjualan','id_sumber'=>$q->idq));
										}
									}
								}
							}
						}
						
						
						//dasar
						$bahan=$this->db->where('kode_produk',$q->kode_produk)->from('bahan b')->join('inventory i','i.id_inventory=b.id_inventory')->get()->result();
						foreach($bahan as $b)
						{
							$cek=$this->db->where('idq',$q->idq)->where('id_inventory',$b->id_inventory)->get('realisasi_cogs')->num_rows();
							if($cek <1)
							{
								$this->db->insert('realisasi_cogs',array('idq'=>$q->idq,'id_inventory'=>$b->id_inventory,'jumlah'=>$b->jumlah*$q->jumlah,'tcpu'=>$b->jumlah*$b->harga_inventory*$q->jumlah));
							
								if($b->status_inventory==1)
								{
								//update inventory
									$nj=$b->jumlah*$q->jumlah;
									$this->db->set('jumlah_inventory',"jumlah_inventory-$nj",false);
									$this->db->where('id_inventory',$b->id_inventory)->update('inventory');
									
									$jakhir=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row()->jumlah_inventory;
									$jawal=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row()->jumlah_inventory+$nj;
									$this->db->insert('moving_inventory',array('jumlah'=>$nj,'waktu'=>$waktu,'id_inventory'=>$b->id_inventory,'pergerakan'=>'keluar','q_awal'=>$jawal,'q_akhir'=>$jakhir,'harga_awal'=>$b->harga_inventory,'harga_akhir'=>$b->harga_inventory,'jenis_pergerakan'=>'penjualan','id_sumber'=>$q->idq));
								}
							}
							else
							{
								$nj=$b->jumlah*$q->jumlah;
								$ntc=$b->jumlah*$b->harga_inventory*$q->jumlah;
								$this->db->set('jumlah',"jumlah+$nj",false);
								$this->db->set('tcpu',"tcpu+$ntc",false);
								$this->where('idq',$q->idq)->where('id_inventory',$b->id_inventory)->update('realisasi_cogs');
								
								if($b->status_inventory==1)
								{
									//update inventory
									$this->db->set('jumlah_inventory',"jumlah_inventory-$nj",false);
									$this->db->where('id_inventory',$b->id_inventory)->update('inventory');
									
									$jakhir=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row()->jumlah_inventory;
									$jawal=$this->db->where('id_inventory',$b->id_inventory)->get('inventory')->row()->jumlah_inventory+$nj;
									$this->db->insert('moving_inventory',array('jumlah'=>$nj,'waktu'=>$waktu,'id_inventory'=>$b->id_inventory,'pergerakan'=>'keluar','q_awal'=>$jawal,'q_akhir'=>$jakhir,'harga_awal'=>$b->harga_inventory,'harga_akhir'=>$b->harga_inventory,'jenis_pergerakan'=>'penjualan','id_sumber'=>$q->idq));
								}
							}
						}
						//tarik total realisasi
						$cogs=$this->db->select("sum(tcpu) as cogs","",false)->where('idq',$q->idq)->get('realisasi_cogs')->row()->cogs;
						$tcogs=$tcogs+$cogs;
						$this->db->where('idq',$q->idq)->update('baris_pesanan',array('subcogs'=>$cogs));
					}
					$pembayaran=$this->input->post('bayar');
					$kembali=$pembayaran-$total;
					$this->db->where('kode_cabang',$cabang)->where('no_pesanan',$pesan)->update('pesanan',array('id_pegawai'=>$peg,'pembayaran'=>$pembayaran,'kembalian'=>$kembali,'waktu_pesanan_fi'=>$waktu,'jumlah_order'=>$jorder,'total_sales'=>$total,'total_cogs'=>$tcogs,"status_pesanan"=>1));
					//log
					$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"Penjualan;NP:$pesan;JO:$jorder;TS:$total;TC:$cogs;"));
					
					$this->session->set_flashdata('sukses','Input sukses. Tagihan Rp.'.number_format($total,0,",",".")."<br>Kembalian <b>Rp".number_format($kembali,0,",",".")."</b><br><br><br>");
					redirect(base_url()."cpanel/message/$pesan");
				}
			}
			else
			{
				$produk = $this->input->post("produk");
				$nama = $this->input->post("nama");
				$meja = $this->input->post("meja");
				$produk = explode (" - ",$produk);
				$waktu=date('Y-m-d H:i:s');
				$cabang=$this->session->userdata('cabang');
				
				$secu=0;
				if(!is_array($produk))
				{
					$secu=1;
				}
				else
				{
					$produk=$produk[0];
					$cek=$this->db->where('kode_produk',$produk)->get('produk')->num_rows();
					if($cek==0)
					{
						$secu=1;
					}
					
					if(!$jumlah)
					{
						$secu=1;
					}
					
					if($jumlah==0)
					{
						$secu=1;
					}
				}
				if($secu==1)
				{
					echo "<script language=\"javascript\">alert('Input produk pesanan salah')</script>";
					echo "<script language=\"javascript\">window.history.back();</script>";
				}
				else
				{
					$jumlah = $this->input->post("jumlah");
					
					$cek = $this->db->query("select * from pesanan where kode_cabang='$cabang' and no_pesanan='$pesan'");
					$cek = $cek->num_rows();
					
					if($cek == 0)
					{
						$this->db->query("insert into pesanan(no_pesanan,nama_pemesan,meja,waktu_pesanan_in,id_pegawai,kode_cabang) values('$pesan','$nama','$meja','$waktu','$peg','$cabang')");
					}
					else
					{
						$this->db->where('no_pesanan',$pesan)->update('pesanan',array('nama_pemesan'=>$nama,'meja'=>$meja));
					}
					
					$dpro=$this->db->where('kode_produk',$produk)->get('produk')->row();
					$subtotal=$jumlah*($dpro->harga);
					if($dpro->jenis_produk != "bar"){
					$this->db->query("insert into baris_pesanan(no_pesanan,kode_cabang,kode_produk,jumlah,subtotal) values ('$pesan','$cabang','$produk','$jumlah','$subtotal')");
					}
					else
					{
						$method=$this->input->post('method');
						$beans=$this->input->post('beans');
						$milk=$this->input->post('milk');
						
						//harga method
						$hme=$this->db->where('kode_produk',$method)->get('produk')->row()->harga;
						
						//harga milk
						$hmi=$this->db->where('jenis_produk','add')->get('produk')->row()->harga*$milk;
						
						$subtotal=$jumlah*($dpro->harga+$hme+$hmi);
						$this->db->query("insert into baris_pesanan(no_pesanan,kode_cabang,kode_produk,method,beans,add_milk,jumlah,subtotal) values ('$pesan','$cabang','$produk','$method','$beans','$milk','$jumlah','$subtotal')");
					}
					
					$this->session->set_flashdata('sukses','Input sukses');
					redirect(base_url()."cpanel/detail_pesanan/".$pesan);
				}
			}
		}
		
		public function batal_menu_pesanan($pesan,$idq) // Membatalkan produk yang sedang dipesan
		{
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			$this->db->query("delete from baris_pesanan where idq='$idq' and kode_cabang='$cabang'");
			redirect(base_url()."cpanel/detail_pesanan/".$pesan);
		}
		
		public function tambah_pesanan_ajax() // Ajax yang menghasilkan harga barang
		{
			$barang = $this->input->get("barang");
			$barang = explode(' - ',$barang);
			$barang = $barang[0];
			$barang = $this->db->query("select harga from produk where kode_produk='$barang'");
			$barang = $barang->row();
			if (empty($barang))
			{$barang = 0;}
			else
			{
				$barang = $barang->harga;
				$barang = intval($barang);
			}
			echo $barang;
		}
		
		public function tambah_pesanan_ajax_1() //Ajax yang menghasilkan tipe produk
		{
			$barang = $this->input->get("barang");
			$barang = explode(' - ',$barang);
			$barang = $barang[0];
			$barang = $this->db->query("select jenis_produk from produk where kode_produk='$barang'");
			$barang = $barang->row();
			if (empty($barang))
			{$barang = 1;}
			else
			{
				$barang = $barang->jenis_produk;
				if($barang != "bar")
				{
					$barang=0;
				}
				else
				{
					$barang=1;
				}
			}
			echo $barang;
		}
		
		public function tambah_pesanan_ajax_2() //Ajax yang mencari harga method
		{
			$method = $this->input->get("method");
			$method = $this->db->where('kode_produk',$method)->get('produk')->row()->harga;
			echo $method;
		}
		
		public function message($pesan) //Pesan yang menampilkan jumlah kembalian dan melaksanakan print
		{			
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			$data['cabang']=$this->session->userdata('cabang');
			$data['pesan']=$pesan;
			
			$data['page'] = "backend/message";
			$data['title'] = "Wait";
			$this->load->view("backend/template",$data);
		}
		
		public function print_bon($detail = 0) // Printer utama
		{			
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			$cabang = $this->session->userdata("cabang");
			$produk = $this->db->query("select * from produk where jenis_produk='bar' or jenis_produk='dapur'");
			$method = $this->db->query("select * from produk where jenis_produk='method'");
			
			$data['method'] = $method->result();
			$data['produk'] = $produk->result();
			
			$data['pesan'] = $this->db->where('no_pesanan',$detail)->get('pesanan')->row();
			$pesan = $detail;
			
			$isi = $this->db->query("select * from baris_pesanan join produk on baris_pesanan.kode_produk=produk.kode_produk where kode_cabang='$cabang' and no_pesanan='$pesan'");
			$data['isi'] = $isi->result();
			
			$this->load->view("backend/print_bon",$data);
		}
		
		public function print_bar($detail = 0) // Apabila ada printer bar
		{	
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			$cabang = $this->session->userdata("cabang");
			$produk = $this->db->query("select * from produk where jenis_produk='bar' or jenis_produk='dapur'");
			$method = $this->db->query("select * from produk where jenis_produk='method'");
			
			$data['method'] = $method->result();
			$data['produk'] = $produk->result();
			
			$data['pesan'] = $this->db->where('no_pesanan',$detail)->get('pesanan')->row();
			$pesan = $detail;
			
			$isi = $this->db->query("select * from baris_pesanan join produk on baris_pesanan.kode_produk=produk.kode_produk where kode_cabang='$cabang' and no_pesanan='$pesan'  and jenis_produk='bar'");
			$data['isi'] = $isi->result();
			
			$this->load->view("backend/print_bon",$data);
		}
		
		public function print_dapur($detail = 0) // Apabila ada printer dapur
		{
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			$cabang = $this->session->userdata("cabang");
			$produk = $this->db->query("select * from produk where jenis_produk='bar' or jenis_produk='dapur'");
			$method = $this->db->query("select * from produk where jenis_produk='method'");
			
			$data['method'] = $method->result();
			$data['produk'] = $produk->result();
			
			$data['pesan'] = $this->db->where('no_pesanan',$detail)->get('pesanan')->row();
			$pesan = $detail;
			
			$isi = $this->db->query("select * from baris_pesanan join produk on baris_pesanan.kode_produk=produk.kode_produk where kode_cabang='$cabang' and no_pesanan='$pesan' and jenis_produk='dapur'");
			$data['isi'] = $isi->result();
			
			$this->load->view("backend/print_bon",$data);
		}
		
		public function laporan() //Laporan jumlah uang yang harus disetor kasir
		{
			if($this->session->userdata('level')!='kasir'){
				redirect(base_url()."cpanel");
			}
			$data['page'] = "backend/laporan";
			$data['title'] = "Laporan";
			$this->load->view("backend/template",$data);
		}
		
		//2-Admin
		public function produk()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$produk = $this->db->query("select * from produk where jenis_produk='bar' or jenis_produk='dapur' or jenis_produk='produk' order by jenis_produk asc");
			$data['produk'] = $produk->result();
			$data['page'] = "backend/resep";
			$data['title'] = "List Produk";
			$this->load->view("backend/template",$data);
		}
		
		public function tambah_produk()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}			
			$last_bahan = $this->db->query("select * from produk order by kode_produk desc limit 1");
			$last_bahan = $last_bahan->row();
			$hitung = (substr($last_bahan->kode_produk,-4));
			$data['last'] = "K".substr(strval($hitung + 10000 + 1),-4);
			
			$data['page'] = "backend/tambah_produk";
			$data['title'] = "Tambah Produk";
			$this->load->view("backend/template",$data);
		}
		
		public function hapus_produk($kode)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			if($this->db->where('kode_produk',$kode)->delete('produk'))
			{
				redirect(base_url()."cpanel/produk");
			}
			else
			{
					echo "<script language=\"javascript\">alert('Data telah digunakan')</script>";
					echo "<script language=\"javascript\">window.history.back();</script>";
			}
		}

		public function php_tambah_produk()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$kode = $this->input->post("kode");
			$nama = $this->input->post("nama");
			$jenis = $this->input->post("jenis");
			$harga = $this->input->post("harga");
			
			$this->db->query("insert into produk values('$kode','$nama','$jenis',1,'$harga')");
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"TBH Produk;KD:$kode;NM:$nama;JS:$jenis;HG:$harga"));
			redirect(base_url()."cpanel/detail_produk/".$kode);
		}
		
		public function detail_produk($kode)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$haha = $this->db->query("select * from bahan join inventory on inventory.id_inventory=bahan.id_inventory where kode_produk='$kode'");
			$data['isi'] = $haha->result();
			
			$hihi = $this->db->query("select * from produk where kode_produk='$kode'");
			$data['form'] = $hihi->row();
			
			$huhu = $this->db->query("select * from inventory");
			$data['bihun'] = $huhu->result();
			
			$data['kode'] = $kode;
			$data['page'] = "backend/detail_produk";
			$data['title'] = "Detail Produk";
			$this->load->view("backend/template",$data);
		}
		
		public function batal_bahan($produk,$bahan)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$this->db->query("delete from bahan where id_inventory='$bahan' and kode_produk='$produk'");
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"HPS BPRDK;KPDRK:$produk;KBHN:$bahan;"));
			redirect(base_url()."cpanel/detail_produk/".$produk);
		}
		
		public function php_detail_produk()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$kode = $this->input->post("kode");
			$bihun = $this->input->post("bihun");
			$jumlah = $this->input->post("jumlah");
			
			if(!empty($bihun))
			{
				$bihun = explode(" - ",$bihun);
				$bihun = $bihun[0];
				
				$cek = $this->db->query("select * from bahan where kode_produk='$kode' and id_inventory='$bihun'");
				$num = $cek->num_rows();
				
				if($num >= 1)
					{
					$this->db->query("update bahan set jumlah='$jumlah' where id_inventory='$bihun' and kode_produk='$kode'");
					}
				else
					{
					$this->db->query("insert into bahan values('$bihun','$kode','$jumlah')");
					}
				$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"TBH BPRDK;KPDRK:$kode;KBHN:$bihun;JMLH:$jumlah"));
			}
			redirect(base_url()."cpanel/detail_produk/".$kode);
		}
		
		public function php_update_produk()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$kode = $this->input->post("kode");
			$nama = $this->input->post("nama");
			$harga = $this->input->post("harga");
			$status = $this->input->post("status");
			$jenis = $this->input->post("jenis");
			
			$data=$this->db->where('kode_produk',$kode)->get('prdouk')->row();
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"UDT PRDK;KPDRK:$kode;NM:$data->nama_produk => $nama;HRG:$data->harga_produk => $harga;STS:$data->status_produk => $status;JNS:$data->jenis_produk => $jenis"));
			$this->db->query("update produk set nama_produk='$nama',status_produk='$status',harga='$harga',jenis_produk='$jenis' where kode_produk='$kode'");
			redirect(base_url()."cpanel/detail_produk/".$kode);
		}
			
		public function inventory_main()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$cabang=$this->session->userdata('cabang');
			$inventory = $this->db->query("select * from inventory where kode_cabang='$cabang' order by id_inventory asc");
			$data['inventory'] = $inventory->result();
			$data['page'] = "backend/inventory";
			$data['title'] = "List Inventory";
			$this->load->view("backend/template",$data);
		}
		
		public function tambah_inventory()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}			
			$last_bahan = $this->db->query("select * from inventory order by id_inventory desc limit 1");
			$last_bahan = $last_bahan->row();
			$hitung = (substr($last_bahan->id_inventory,-4));
			$data['last'] = "P".substr(strval($hitung + 10000 + 1),-4);
			
			$data['page'] = "backend/tambah_inventory";
			$data['title'] = "Tambah Inventory";
			$this->load->view("backend/template",$data);
		}
		
		public function detail_inventory($kode)
		{	
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$hihi = $this->db->query("select * from inventory where id_inventory='$kode'");
			$data['form'] = $hihi->row();
			
			
			$data['kode'] = $kode;
			$data['page'] = "backend/detail_inventory";
			$data['title'] = "Detail inventory";
			$this->load->view("backend/template",$data);
		}
		
		public function php_tambah_inventory()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$kode = $this->input->post("kode");
			$nama = $this->input->post("nama");
			$jenis = $this->input->post("jenis");
			$satuan = $this->input->post("satuan");
			$jumlah = $this->input->post("jumlah");
			$harga = $this->input->post("harga");
			$eoq = $this->input->post("eoq");
			$status = $this->input->post("status");
			$cabang=$this->session->userdata('cabang');
			
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"TBH INV;KDINV:$kode;NM:$nama;JNS:$jenis;JMLH:$jumlah;HRG:$harga;EOQ:$eoq;STS:$status"));
			$this->db->query("insert into inventory values('$kode','$nama','$jenis','$satuan','$jumlah','$harga','$eoq','$status','$cabang')");
			redirect(base_url()."cpanel/detail_inventory/".$kode);
		}
		
		public function php_update_inventory()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$kode = $this->input->post("kode");
			$nama = $this->input->post("nama");
			$jenis = $this->input->post("jenis");
			$satuan = $this->input->post("satuan");
			$jumlah = $this->input->post("jumlah");
			$harga = $this->input->post("harga");
			$eoq = $this->input->post("eoq");
			$status = $this->input->post("status");
			$cabang=$this->session->userdata('cabang');
			
			$data=$this->db->where('id_inventory',$kode)->get('inventory')->row();
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"UDT INV;KDINV:$kode;NM:$data->nama_inventory => $nama;JNS:$data->jenis_inventory => $jenis;STN:$data->satuan_inventory => $satuan;JMLH:$data->jumlah_inventory => $jumlah;HRG:$data->harga_inventory => $harga;EOQ:$data->eoq_inventory => $eoq;STS:$data->status_inventory => $status"));
			$this->db->query("update inventory set nama_inventory='$nama',jenis_inventory='$jenis',satuan_inventory='$satuan',jumlah_inventory='$jumlah',harga_inventory='$harga',eoq_inventory='$eoq',status_inventory='$status',kode_cabang='$cabang' where id_inventory='$kode'");
			redirect(base_url()."cpanel/detail_inventory/".$kode);
		}
		
		public function hapus_inventory($kode)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			if($this->db->where('id_inventory',$kode)->delete('inventory'))
			{
				$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"HPS INV;KDINV:$kode"));
				redirect(base_url()."cpanel/inventory_main");
			}
			else
			{
					echo "<script language=\"javascript\">alert('Data telah digunakan')</script>";
					echo "<script language=\"javascript\">window.history.back();</script>";
			}
		}
				
		public function penyesuaian_inventory()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$inventory = $this->db->query("select * from inventory where status_inventory=1");
			$data['inventory'] = $inventory->result();
			$data['page'] = "backend/penyesuaian_inventory";
			$data['title'] = "Penyesuaian Inventory";
			$this->load->view("backend/template",$data);
		}
		
		public function php_penyesuaian_inventory()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			foreach($this->input->post('id') as $ids)
			{
				$id[]=$ids;
			}
			
			foreach($this->input->post('jumlah') as $jumlahs)
			{
				$jumlah[]=$jumlahs;
			}
			
			$log="";
			foreach(array_combine($id,$jumlah) as $i => $j)
			{
				$data=$this->db->where('id_inventory',$i)->get()->row;
				$ja=$data->jumlah_inventory;
				$se=$ja-$j;
				if($se!=0)
				{
					//input ke pengeluaran
					$cabang=$this->session->useradata('cabang');
					$waktu=date('Y-m-d H:i:s');
					$nama="Selisih penyesuaian";
					$idp=9;
					$nilai=$se;
					$peg=$this->session->userdata('pegawai');
					
					$this->db->insert('pengeluaran',array('waktu_pengeluaran'=>$waktu,'nama_pengeluaran'=>$nama,'id_pengeluaran'=>$idp,'nilai_pengeluaran'=>$nilai,'id_pegawai'=>$peg,'kode_cabang'=>$cabang));
					
					
					//input ke moving inventory
					if($se<0)
					{
						$this->db->insert('moving_inventory',array('waktu'=>$waktu,'id_inventory'=>$i,'pergerakan'=>$masuk,'q_awal'=>$data->jumlah_inventory,'q_akhir'=>$j,'harga_awal'=>$data->harga_inventory,'jenis_pergerakan'=>'penyesuaian'));
					}
					else
					{
						$this->db->insert('moving_inventory',array('waktu'=>$waktu,'id_inventory'=>$i,'pergerakan'=>$keluar,'q_awal'=>$data->jumlah_inventory,'q_akhir'=>$j,'harga_awal'=>$data->harga_inventory,'jenis_pergerakan'=>'penyesuaian'));
					}
					$log=$log." ".$i.":".$data->jumlah_inventory."->".$j;
					$this->db->where('id_inventory',$i)->update('inventory',array('jumlah_inventory'=>$j));	
				}
			}
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"PNYS INV;$log"));
				
			redirect(base_url()."inventory_main");
		}
			
		public function beban($index=1)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			//pagination
			$this->load->library('pagination');
			$config['base_url'] = base_url()."cpanel/beban";
			$config['total_rows'] = $this->db->where('kode_cabang',$cabang)->get('pengeluaran')->num_rows();
			$config['per_page'] = 30;
			$config['uri_segment'] = 3;
			$config['first_url'] = 0;
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '<p>';
			$config['anchor_class'] = 'class="page" ';
			$config['use_page_numbers'] = TRUE;
			$this->pagination->initialize($config);
				
			$data['pagination']=$this->pagination->create_links();
			
			//data pengeluaran
			$this->db->order_by('idp','desc');
			$this->db->limit($config['per_page'],$index-1);
			$data['beban'] = $this->db->where('kode_cabang',$cabang)->from('kategori_pengeluaran k')->join('pengeluaran p','p.id_pengeluaran=k.id_pengeluaran')->get()->result();
			
			$data['page'] = "backend/beban";
			$data['title'] = "List Beban";
			$this->load->view("backend/template",$data);
		}
		
		public function cogs_pos($index=1)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			//pagination
			$this->load->library('pagination');
			$config['base_url'] = base_url()."cpanel/cogs_pos";
			$config['total_rows'] = $this->db->where('kode_cabang',$cabang)->get('pesanan')->num_rows();
			$config['per_page'] = 30;
			$config['uri_segment'] = 3;
			$config['first_url'] = 0;
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '<p>';
			$config['anchor_class'] = 'class="page" ';
			$config['use_page_numbers'] = TRUE;
			$this->pagination->initialize($config);
				
			$data['pagination']=$this->pagination->create_links();
			
			//data pengeluaran
			$this->db->order_by('no_pesanan','desc');
			$this->db->limit($config['per_page'],$index-1);
			$data['beban'] = $this->db->where('kode_cabang',$cabang)->get('pesanan')->result();
			
			$data['page'] = "backend/cogs_pos";
			$data['title'] = "COGS POS";
			$this->load->view("backend/template",$data);
		}
		
		public function tambah_beban()
		{		
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			//data pengeluaran
			$data['kategori']=$this->db->get('kategori_pengeluaran')->result();
			
			$data['page'] = "backend/tambah_beban";
			$data['title'] = "Tambah Beban";
			$this->load->view("backend/template",$data);
			
		}
		
		public function php_tambah_beban()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$uraian=$this->input->post('uraian');
			$waktu=$this->input->post('waktu');
			$jenis=$this->input->post('jenis');
			$nilai=$this->input->post('nilai');
			$ref=$this->input->post('ref');
			$ket=$this->input->post('ket');
			$idpeg=$this->session->userdata('idpeg');
			$cabang=$this->session->userdata('cabang');
			
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"TBH BEBAN;URN:$uraian;NLN:$nilai;REF:$ref"));
			$this->db->insert('pengeluaran',array('nama_pengeluaran'=>$uraian,'waktu_pengeluaran'=>$waktu,'id_pengeluaran'=>$jenis,'nilai_pengeluaran'=>$nilai,'referensi'=>$ref,'keterangan'=>$ket,'id_pegawai'=>$idpeg,'kode_cabang'=>$cabang));
			
			redirect(base_url()."cpanel/beban");
		}
		
		public function delete_beban($index)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$data=$this->db->where('idp',$index)->get('pengeluaran')->row();
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"HPS BEBAN;ID:$index;URN:$data->nama_pengeluaran;NLN:$data->nilai_pengeluaran;REF:$data->referensi"));
			$this->db->where('idp',$index)->delete('pengeluaran');
			
			redirect(base_url()."cpanel/beban");
		}
		
		public function batal()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$data['page'] = "backend/batal";
			$data['title'] = "Pembatalan";
			$this->load->view("backend/template",$data);
		}
		
		public function batal_pesanan($index=1)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			//pagination
			$this->load->library('pagination');
			$config['base_url'] = base_url()."cpanel/batal_pesanan";
			$config['total_rows'] = $this->db->where('kode_cabang',$cabang)->get('pesanan')->num_rows();
			$config['per_page'] = 30;
			$config['uri_segment'] = 3;
			$config['first_url'] = 0;
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '<p>';
			$config['anchor_class'] = 'class="page" ';
			$config['use_page_numbers'] = TRUE;
			$this->pagination->initialize($config);
				
			$data['pagination']=$this->pagination->create_links();
			
			//data pesanan
			$this->db->order_by('no_pesanan','desc');
			$this->db->limit($config['per_page'],$index-1);
			$data['pesanan'] = $this->db->where('kode_cabang',$cabang)->get('pesanan')->result();
			
			$data['page'] = "backend/batal_pesanan";
			$data['title'] = "Batal Pesanan";
			$this->load->view("backend/template",$data);
		}
		
		public function php_batal_pesanan($kode)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$bp=$this->db->where('no_pesanan',$kode)->get('baris_pesanan')->result();
			foreach($bp as $b)
			{
				//inverse
				$inv = $this->db->where('id_sumber',$b->idq)->where('jenis_pergerakan','penjualan')->get('moving_inventory')->result();
				foreach($inv as $v)
				{
					$tambah=$v->q_awal-$v->q_akhir;
					$data=$this->where('id_inventory',$b->id_inventory)->get('inventory')->row();
					$jum=$data->jumlah_inventory;
					$hlam=$data->harga_inventory;
					
					$hita=$v->q_awal*$v->harga_awal;
					$hitb=$v->q_akhir*$v->harga_akhir;
					$hargai=($hita-$hitb)/$tambah;
					
					$jumb=$hum+$tambah;
					$hab=$hlam+$hargai;
					$this->db->insert('moving_inventory',array('jumlah'=>$tambah,'waktu'=>date('Y-m-d'),'id_inventory'=>$v->id_inventory,'pergerakan'=>'masuk','q_awal'=>$jum,'q_akhir'=>$jumb,'harga_awal'=>$data->hlam,'harga_akhir'=>$b->hargai,'jenis_pergerakan'=>'pembatalan','id_sumber'=>$v->idq));
					$this->db->where('id_inventory',$v->id_inventory)->update('inventory',array('jumlah_inventory'=>$jumb,'harga_inventory'=>$hab));
				}
				$data=$this->db->where('no_pesanan',$kode)->get('pesanan')->row();
				$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"DLT PSN;NP:$kode;IP:$data->id_pegawai; JO: $data->jumlah_order ; TS: $data->total_sales ; TC: $data->total_cogs"));
				$this->db->where('idq',$b->idq)->delete('realisasi_cogs');
				$this->db->where('idq',$b->idq)->delete('baris_pesanan');
			}
			
			$this->db->where('no_pesanan',$kode)->delete('pesanan');
			redirect(base_url()."cpanel/batal_pesanan");
		}
		
		public function detail_batal_pesanan($detail = 0)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			$cabang = $this->session->userdata("cabang");
			$produk = $this->db->query("select * from produk where (jenis_produk='bar' or jenis_produk='dapur' or jenis_produk='produk') and status_produk=1");
			$method = $this->db->query("select * from produk where jenis_produk='method'");
			
			$data['method'] = $method->result();
			$data['produk'] = $produk->result();
			
			$data['pesan'] = $this->db->where('no_pesanan',$detail)->get('pesanan')->row();
			$pesan = $detail;
			
			$isi = $this->db->query("select * from baris_pesanan join produk on baris_pesanan.kode_produk=produk.kode_produk where kode_cabang='$cabang' and no_pesanan='$pesan'");
			$data['isi'] = $isi->result();
			
			$data['page'] = "backend/detail_batal_pesanan";
			$data['title'] = "Pembatalan  Pesanan ".$detail;
			$this->load->view("backend/template",$data);
		}
		
		public function php_detail_batal_pesanan($pesan,$idq)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			$inv = $this->db->where('id_sumber',$idq)->where('jenis_pergerakan','penjualan')->get('moving_inventory')->result();
				foreach($inv as $v)
				{
					$tambah=$v->q_awal-$v->q_akhir;
					$data=$this->where('id_inventory',$b->id_inventory)->get('inventory')->row();
					$jum=$data->jumlah_inventory;
					$hlam=$data->harga_inventory;
					
					$hita=$v->q_awal*$v->harga_awal;
					$hitb=$v->q_akhir*$v->harga_akhir;
					$hargai=($hita-$hitb)/$tambah;
					
					$jumb=$hum+$tambah;
					$hab=$hlam+$hargai;
					$this->db->insert('moving_inventory',array('jumlah'=>$tambah,'waktu'=>date('Y-m-d'),'id_inventory'=>$v->id_inventory,'pergerakan'=>'masuk','q_awal'=>$jum,'q_akhir'=>$jumb,'harga_awal'=>$data->hlam,'harga_akhir'=>$b->hargai,'jenis_pergerakan'=>'pembatalan','id_sumber'=>$idq));
					$this->db->where('id_inventory',$v->id_inventory)->update('inventory',array('jumlah_inventory'=>$jumb,'harga_inventory'=>$hab));
				}
				
			$this->db->where('idq',$idq)->delete('realisasi_cogs');
			
			//log
			$data=$this->db->where('idq',$idq)->where('kode_cabang',$cabang)->get('baris_pesanan')->row();
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"HPS DTPSN;IDQ:$idq;STTL:$data->subtotal;SCGS:$data->subcogs;"));
			
			$this->db->query("delete from baris_pesanan where idq='$idq' and kode_cabang='$cabang'");
			redirect(base_url()."cpanel/detail_batal_pesanan/".$pesan);
		}
		
		public function batal_pasokan($index=1)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}			
			$cabang = $this->session->userdata("cabang");
			
			//pagination
			$this->load->library('pagination');
			$config['base_url'] = base_url()."cpanel/batal_pasokan";
			$config['total_rows'] = $this->db->get('pasokan')->num_rows();
			$config['per_page'] = 30;
			$config['uri_segment'] = 3;
			$config['first_url'] = 0;
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '<p>';
			$config['anchor_class'] = 'class="page" ';
			$config['use_page_numbers'] = TRUE;
			$this->pagination->initialize($config);
				
			$data['pagination']=$this->pagination->create_links();
			
			//data pesanan
			$this->db->order_by('no_pasokan','desc');
			$this->db->limit($config['per_page'],$index-1);
			$data['pasok'] = $this->db->get('pasokan')->result();
			
			$data['page'] = "backend/batal_pasokan";
			$data['title'] = "Pasokan";
			$this->load->view("backend/template",$data);
		}
		
		public function php_batal_pasokan($idq)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$cabang = $this->session->userdata("cabang");
			
			$inv = $this->db->where('id_sumber',$idq)->where('jenis_pergerakan','pasokan')->get('moving_inventory')->result();
				foreach($inv as $v)
				{
					$kurang=$v->q_akhir-$v->q_awal;
					$data=$this->where('id_inventory',$b->id_inventory)->get('inventory')->row();
					$jum=$data->jumlah_inventory;
					$hlam=$data->harga_inventory;
					
					$hita=$v->q_awal*$v->harga_awal;
					$hitb=$v->q_akhir*$v->harga_akhir;
					$hargai=($hitb-$hita)/$kurang;
					
					$jumb=$hum-$kurang;
					$hab=$hlam-$hargai;
					$this->db->insert('moving_inventory',array('jumlah'=>$kurang,'waktu'=>date('Y-m-d'),'id_inventory'=>$v->id_inventory,'pergerakan'=>'keluar','q_awal'=>$jum,'q_akhir'=>$jumb,'harga_awal'=>$data->hlam,'harga_akhir'=>$b->hargai,'jenis_pergerakan'=>'pembatalan pasokan','id_sumber'=>$idq));
					$this->db->where('id_inventory',$v->id_inventory)->update('inventory',array('jumlah_inventory'=>$jumb,'harga_inventory'=>$hab));
				}
			$data=$this->db->where('idq',$idq)->get('pasokan')->row();
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"BTL PSKN;IDQ:$idq;IV:$data->id_inventory;HRG:$data->hrg;JMLH:$data->jumlah"));
		
			$this->db->where('no_pasokan',$idq)->delete('pasokan');
			redirect(base_url()."cpanel/batal_pasokan/");
		}
		
		public function user()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$cabang=$this->session->userdata('cabang');
			$user = $this->db->query("select * from pegawai join user on user.id_pegawai=pegawai.id_pegawai where kode_cabang='$cabang' order by pegawai.id_pegawai asc");
			$data['user'] = $user->result();
			$data['page'] = "backend/user";
			$data['title'] = "List User";
			$this->load->view("backend/template",$data);
		}
		
		public function tambah_user()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}			
			$last_bahan = $this->db->query("select * from pegawai order by id_pegawai desc limit 1");
			$last_bahan = $last_bahan->row();
			$hitung = (substr($last_bahan->id_pegawai,-5));
			$data['last'] = "P".substr(strval($hitung + 100000 + 1),-5);
			
			$data['page'] = "backend/tambah_user";
			$data['title'] = "Tambah User";
			$this->load->view("backend/template",$data);
		}
		
		public function hapus_user($kode)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			if($kode=='P00000')
			{
				echo "<script language=\"javascript\">alert('Anda tidak bisa menghapus admin')</script>";
				echo "<script language=\"javascript\">window.history.back();</script>";
			}
			else
			{
				if($this->db->where('id_pegawai',$kode)->delete('pegawai'))
				{
					$data=$this->db->where('id_pegawai',$kode)->from('pegawai')->join('user','user.id_pegawai=pegawai.id_pegawai')->get()->row();
					$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"DLT PGW;ID:$data->id_pegawai;NM:$data->nama_pegawai;TLP:$data->telepon_pegawai;ALM:$data->alamat_pegawai;USN:$data->username"));
					$this->db->where('id_pegawai',$kode)->delete('user');
					redirect(base_url()."cpanel/user");
				}
				else
				{
				
						echo "<script language=\"javascript\">alert('Data telah digunakan')</script>";
						echo "<script language=\"javascript\">window.history.back();</script>";
				}
			}
		}
		
		public function detail_user($kode)
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$hihi = $this->db->query("select * from pegawai join user on user.id_pegawai=pegawai.id_pegawai where pegawai.id_pegawai='$kode'");
			$data['form'] = $hihi->row();
			
			$data['kode'] = $kode;
			$data['page'] = "backend/detail_user";
			$data['title'] = "Detail User";
			$this->load->view("backend/template",$data);
		}
		
		public function php_update_user()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$cabang= $this->session->userdata('cabang');
			$kode = $this->input->post("kode");
			$nama = $this->input->post("nama");
			$telepon = $this->input->post("telepon");
			$alamat = $this->input->post("alamat");
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			
			$cek=$this->db->where('username',$username)->get('user')->num_rows();
			$cek1=$this->db->where('id_pegawai',$kode)->get('pegawai')->num_rows();
			
			if($cek1>0 or $cek>0)
			{
				echo "<script language=\"javascript\">alert('User atau id pegawai telah dipakai')</script>";
				echo "<script language=\"javascript\">window.history.back();</script>";
			}
			else
			{
				//log
				$data=$this->db->where('id_pegawai',$kode)->from('pegawai')->join('user','user.id_pegawai=pegawai.id_pegawai')->get()->row();
				$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"UDT PGW;ID:$data->id_pegawai => $kode;NM:$data->nama_pegawai => $nama;TLP:$data->telepon_pegawai => $telepon;ALM:$data->alamat_pegawai => $alamat;USN:$data->username => $username;PSW"));
		
				$this->db->query("update pegawai set nama_pegawai='$nama',telepon_pegawai='$telepon',alamat_pegawai='$alamat' where id_pegawai='$kode'");
				$this->db->query("update user set username='$user',password='$password' where id_pegawai='$kode'");
				redirect(base_url()."cpanel/detail_user/".$kode);
			}
		}
		
		public function php_tambah_user()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$cabang= $this->session->userdata('cabang');
			$kode = $this->input->post("kode");
			$nama = $this->input->post("nama");
			$telepon = $this->input->post("telepon");
			$alamat = $this->input->post("alamat");
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			
			$cek=$this->db->where('username',$username)->get('user')->num_rows();
			$cek1=$this->db->where('id_pegawai',$kode)->get('pegawai')->num_rows();
			
			if($cek1>0 or $cek>0)
			{
				echo "<script language=\"javascript\">alert('User atau id pegawai telah dipakai')</script>";
				echo "<script language=\"javascript\">window.history.back();</script>";
			}
			else
			{
				$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"TBH PGW;ID:$kode;NM:$nama;TLP:$telepon;ALM:$alamat;USN:$username"));
		
		
				$this->db->query("insert into pegawai values('$kode','$nama','$telepon','$alamat','$cabang')");
				$this->db->query("insert into user values('$username','$password','$kode','1','kasir')");
				redirect(base_url()."cpanel/detail_user/".$kode);
			}
		}
		
		public function laporan_main()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$data['page'] = "backend/laporan_sistem";
			$data['title'] = "Laporan Sistem";
			$this->load->view("backend/template",$data);
		}
		
		public function laporan_fast_slow()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$data['page'] = "backend/laporan_fast_slow";
			$data['title'] = "Laporan Fast Slow moving";
			$this->load->view("backend/template",$data);
		}
		
		public function php_laporan_fast_slow()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$dari=$this->input->post('dari');
			$sampai=$this->input->post('sampai');
			$format=$this->input->post('format');
			$selisih=(strtotime($sampai)-strtotime($dari))/60/60/24;
			
			$data["dari"]=$dari;
			$data["sampai"]=$sampai;
			$data["selisih"]=$selisih;
			
			if($format=="html")
			{$this->load->view("backend/view_laporan_fast_slow",$data);}
			
			if($format=="pdf")
			{
			$this->load->helper(array('dompdf', 'file'));     
			$html = $this->load->view('backend/view_laporan_fast_slow', $data, true);
			pdf_create($html, 'Laporan Fast Slow Moving');
			}
		}
		
		public function laporan_high_low()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$data['page'] = "backend/laporan_high_low";
			$data['title'] = "Laporan Hiw Low Profit";
			$this->load->view("backend/template",$data);
		}
		
		public function php_laporan_high_low()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$dari=$this->input->post('dari');
			$sampai=$this->input->post('sampai');
			$format=$this->input->post('format');
			$selisih=(strtotime($sampai)-strtotime($dari))/60/60/24;
			
			$data["dari"]=$dari;
			$data["sampai"]=$sampai;
			$data["selisih"]=$selisih;
			
			if($format=="html")
			{$this->load->view("backend/view_laporan_high_low",$data);}
			
			if($format=="pdf")
			{
			$this->load->helper(array('dompdf', 'file'));     
			$html = $this->load->view('backend/view_laporan_high_low', $data, true);
			pdf_create($html, 'Laporan High Low Profit');
			}
		}
		
		public function laporan_operational()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$data['page'] = "backend/laporan_operational";
			$data['title'] = "Laporan Operational";
			$this->load->view("backend/template",$data);
		}
		
		public function php_laporan_operational()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$dari=$this->input->post('dari');
			$sampai=$this->input->post('sampai');
			$format=$this->input->post('format');
			$selisih=(strtotime($sampai)-strtotime($dari))/60/60/24;
			
			$data["dari"]=$dari;
			$data["sampai"]=$sampai;
			$data["selisih"]=$selisih;
			
			if($format=="html")
			{$this->load->view("backend/view_laporan_operational",$data);}
			
			if($format=="pdf")
			{
			$this->load->helper(array('dompdf', 'file'));     
			$html = $this->load->view('backend/view_laporan_operational', $data, true);
			pdf_create($html, 'Laporan Harian',true,'a4','landscape');
			}
		}
		
		public function laporan_cost()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$data['page'] = "backend/laporan_cost";
			$data['title'] = "Laporan Cost Caluclation";
			$this->load->view("backend/template",$data);
		}
		
		public function php_laporan_cost()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$dari=$this->input->post('dari');
			$sampai=$this->input->post('sampai');
			$format=$this->input->post('format');
			$selisih=(strtotime($sampai)-strtotime($dari))/60/60/24;
			
			$data["dari"]=$dari;
			$data["sampai"]=$sampai;
			$data["selisih"]=$selisih;
			
			if($format=="html")
			{$this->load->view("backend/view_laporan_cost",$data);}
			
			if($format=="pdf")
			{
			$this->load->helper(array('dompdf', 'file'));     
			$html = $this->load->view('backend/view_laporan_cost', $data, true);
			pdf_create($html, 'Cost Calculation',true,'a4','landscape');
			}
		}
		
		public function laporan_peak_time()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}
			$data['page'] = "backend/laporan_peak_time";
			$data['title'] = "Laporan Peak Time";
			$this->load->view("backend/template",$data);
		}
		
		public function php_laporan_peak_time()
		{
			if($this->session->userdata('level')!='admin'){
				redirect(base_url()."cpanel");
			}			
			$data["tahun"]=$this->input->post('tahun');
			$data["bulan"]=$this->input->post('bulan');
			$data["hari"]=$this->input->post('hari');
			$format=$this->input->post('format');
			
			if($format=="html")
			{$this->load->view("backend/view_laporan_peak_time",$data);}
			
			if($format=="pdf")
			{
			$this->load->helper(array('dompdf', 'file'));     
			$html = $this->load->view('backend/view_laporan_peak_time', $data, true);
			pdf_create($html, 'Laporan Peak Time',true,'a4','landscape');
			}
		}
		
		//3-Fungsi Gabungan Admin-Kasir
		public function pasokan($index="1")
		{
			$cabang = $this->session->userdata("cabang");
			
			//pagination
			$this->load->library('pagination');
			$config['base_url'] = base_url()."cpanel/pasokan";
			$config['total_rows'] = $this->db->get('pasokan')->num_rows();
			$config['per_page'] = 30;
			$config['uri_segment'] = 3;
			$config['first_url'] = 0;
			$config['full_tag_open'] = '<p>';
			$config['full_tag_close'] = '<p>';
			$config['anchor_class'] = 'class="page" ';
			$config['use_page_numbers'] = TRUE;
			$this->pagination->initialize($config);
				
			$data['pagination']=$this->pagination->create_links();
			
			//data pesanan
			$this->db->order_by('no_pasokan','desc');
			$this->db->limit($config['per_page'],$index-1);
			$data['pasok'] = $this->db->get('pasokan')->result();
			
			$data['page'] = "backend/pasokan";
			$data['title'] = "Pasokan";
			$this->load->view("backend/template",$data);
		}
		
		public function tambah_pasokan()
		{
			$cabang = $this->session->userdata("cabang");
			
			$persediaan = $this->db->where('kode_cabang',$cabang)->where('status_inventory',1)->get('inventory');
			$data['persediaan'] = $persediaan->result();
			
			$data['page'] = "backend/tambah_pasokan";
			$data['title'] = "Pasokan";
			$this->load->view("backend/template",$data);
		}
		
		public function php_tambah_pemasok()
		{
			$waktu=$this->input->post('waktu');
			$pemasok=$this->input->post('pemasok');
			$inventory=$this->input->post('inventory');
			$jumlah=$this->input->post('jumlah');
			$harga=$this->input->post('harga');
			
			
			$this->db->insert('audit_log',array('id_pegawai'=>$this->session->userdata('pegawai'),'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"TBH PSN;IV:$inventory;JL:$jumlah;"));
			$this->db->insert('pasokan',array('waktu_kedatangan'=>$waktu,'nama_pemasok'=>$pemasok,'id_inventory'=>$inventory,'harga'=>$harga,'jumlah'=>$jumlah));
			
			$id=$this->db->where('waktu_kedatangan',$waktu)->where('id_inventory',$inventory)->where('jumlah',$jumlah)->get('pasokan')->row()->no_pasokan;
			
			//average
			$inv=$this->db->where('id_inventory',$inventory)->get('inventory')->row();
			$q_lama=$inv->jumlah_inventory;
			$h_lama=$inv->harga_inventory;
			$x_lama=$q_lama*$h_lama;
			
			$j_baru=$j_lama+$jumlah;
			$h_baru=($x_lama+$jumlah*$harga)/$j_baru;
			
			$this->db->where('id_inventory',$inventory)->update('inventory',array('jumlah_inventory'=>$j_baru,'harga_inventory'=>$h_baru));
			$this->db->insert('moving_inventory',array('waktu'=>$waktu,'id_inventory'=>$inventory,'pergerakan'=>'masuk','jumlah'=>$jumlah,'q_awal'=>$q_lama,'q_akhir'=>$j_baru,'harga_awal'=>$h_lama,'harga_akhir'=>$h_baru,'jenis_pergerakan'=>'pasokan','id_sumber'=>$id));
			
			redirect(base_url()."cpanel/pasokan");
		}
	}
?>