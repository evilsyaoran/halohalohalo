<?php
	class kerja extends CI_Controller {
		
		function index()
		{
			$data['page'] = "frontend/home";
			$data['title'] = "Home";
			$this->load->view("frontend/template",$data);
		}
		
		function cari()
		{
			$data['page'] = "frontend/cari";
			$data['title'] = "Cari Pekerjaan";
			
			$data['list']=1;
			$data['jns']=$this->db->get('tbl_jns_pekerjaan')->result();
			
			if($this->input->get('jenis'))
			{
				$this->db->where('k.id_jns_pekerjaan',$this->input->get('jenis'));
			}
			
			if($this->input->get('min'))
			{
				$this->db->where("gj_pekerjaan >=",$this->input->get('min'));
			}
			
			if($this->input->get('max'))
			{
				$this->db->where("gj_pekerjaan <=",$this->input->get('max'));
			}
			
			if($this->input->get('waktugaji'))
			{
				if($this->input->get('waktugaji')!="all")
				{
					$this->db->where('wgj_pekerjaan',$this->input->get('waktugaji'));
				}
			}
			
			$pekerjaan=$this->db->limit(5)->from('tbl_pekerjaan k')->join('tbl_jns_pekerjaan j','j.id_jns_pekerjaan=k.id_jns_pekerjaan')->get();
			$data["cpekerjaan"]=$pekerjaan->num_rows();
			$data["pekerjaan"]=$pekerjaan->result();
			$this->load->view("frontend/template",$data);
		}
		
		function list_cari($list=0)
		{
			$data['title'] = "Cari Pekerjaan hal $list";
			
			$listx=$list*5;
			$data['list']=$list+1;
			
			if($this->input->get('jenis'))
			{
				$this->db->where('k.id_jns_pekerjaan',$this->input->get('jenis'));
			}
			
			if($this->input->get('min'))
			{
				$this->db->where("gj_pekerjaan >=",$this->input->get('min'));
			}
			
			if($this->input->get('max'))
			{
				$this->db->where("gj_pekerjaan <=",$this->input->get('max'));
			}
			
			if($this->input->get('waktugaji'))
			{
				if($this->input->get('waktugaji')!="all")
				{
					$this->db->where('wgj_pekerjaan',$this->input->get('waktugaji'));
				}
			}
			
			$pekerjaan=$this->db->limit(5,$listx)->from('tbl_pekerjaan k')->join('tbl_jns_pekerjaan j','j.id_jns_pekerjaan=k.id_jns_pekerjaan')->get();
			$data["cpekerjaan"]=$pekerjaan->num_rows();
			$data["pekerjaan"]=$pekerjaan->result();
			$this->load->view("frontend/list_cari",$data);
		}
		
		function pasang()
		{
			$data['page'] = "frontend/pasang";
			$data['title'] = "Pasang Pekerjaan";
			
			$data['list']=1;
			$data['jns']=$this->db->get('tbl_jns_pekerjaan')->result();
			
			$this->db->where('id_user',$this->session->userdata('user'));
			$data['pekerjaan']=$this->db->from('tbl_pekerjaan k')->join('tbl_jns_pekerjaan j','j.id_jns_pekerjaan=k.id_jns_pekerjaan')->get()->result();
			$this->load->view("frontend/template",$data);
		}
		
		public function proses_pasang()
		{
			$nama= $this->input->post('nama');
			$kategori= $this->input->post('kategori');
			$jenis= $this->input->post('jenis');
			$descripsi= $this->input->post('descripsi');
			$gaji= $this->input->post('gaji');
			$wgj= $this->input->post('wgj');
			$id_user=$this->session->userdata('id_user');
			$tgl=date('Y-m-d');
			if(!$this->db->insert("tbl_pekerjaan",array('tgl_post_pekerjaan'=>$tgl,'id_user'=>$id_user,'nm_pekerjaan'=>$nama,'kt_pekerjaan'=>$kategori,'id_jns_pekerjaan'=>$jenis,'des_pekerjaan'=>$descripsi,'gj_pekerjaan'=>$gaji,'wgj_pekerjaan'=>$wgj)))
			{
				echo "<script language=\"javascript\">alert('Gagal')</script>";
				echo "<script language=\"javascript\">document.location='".base_url()."kerja/pasang'</script>";
				
			}
			else
			{
				echo "<script language=\"javascript\">alert('Berhasil')</script>";
				echo "<script language=\"javascript\">document.location='".base_url()."kerja/pasang'</script>";
			}
		}
		
		public function delete($id)
		{
			if(!$this->db->where('id',$id)->delete("tgl_post_pekerjaan"))
			{
				echo "<script language=\"javascript\">alert('Gagal')</script>";
				echo "<script language=\"javascript\">document.location='".base_url()."kerja/pasang'</script>";
				
			}
			else
			{
				echo "<script language=\"javascript\">alert('Berhasil')</script>";
				echo "<script language=\"javascript\">document.location='".base_url()."kerja/pasang'</script>";
			}
		}
		
		public function proses()
		{
			$id=$this->input->post('id_pekerjaan');
			$nama= $this->input->post('nm_pekerjaan');
			$kategori= $this->input->post('kt_pekerjaan');
			$jenis= $this->input->post('id_jns_pekerjaan');
			$descripsi= $this->input->post('des_pekerjaan');
			$gaji= $this->input->post('gj_pekerjaan');
			$wgj= $this->input->post('wgj_pekerjaan');
			$action=$this->input->post('action');

			if ($action === 'edit') {
				$this->db->where('id_pekerjaan',$id)->update('tbl_pekerjaan',array('nm_pekerjaan'=>$nama,'kt_pekerjaan'=>$kategori,'id_jns_pekerjaan'=>$jenis,'des_pekerjaan'=>$descripsi,'gj_pekerjaan'=>$gaji,'wgj_pekerjaan'=>$wgj));
			} else if ($action === 'delete') {
					$this->db->where('id_pekerjaan',$id)->delete('tbl_pekerjaan');
			} 
			echo json_encode($id);
		}
	}
?>