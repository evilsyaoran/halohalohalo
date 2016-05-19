<?php
	class user extends CI_Controller {
		public function index()
		{
		}
		
		public function masuk()
		{
			$data['page'] = "frontend/login";
			$data['title'] = "Masuk";
			$this->load->view("frontend/template",$data);
		}
		
		public function proses_masuk()
		{
			$email=$this->input->post('email');
			$password=$this->input->post('password');
			
			$user=$this->db->where('email',$email)->where('password',$password)->get('user');
			if($user->num_rows() < 1)
			{
				$this->session->set_flashdata('gagal','Username atau password salah');
				redirect(base_url()."user/masuk");
			}
			else
			{
				$this->session->set_userdata('user',$user->row()->email);	
				redirect(base_url());
			}
		}
		
		public function daftar()
		{
			$data['page'] = "frontend/signup";
			$data['title'] = "Daftar";
			$this->load->view("frontend/template",$data);
		}
		
		public function proses_daftar()
		{
			$email=$this->input->post('email');
			$nama=$this->input->post('nama');
			$password=$this->input->post('password');
			
			$user=$this->db->where('email',$email)->get('user');
			if($user->num_rows() > 0)
			{
				$this->session->set_flashdata('gagal','Email telah dipakai');
				redirect(base_url()."user/daftar");
			}
			else
			{
				$this->db->insert('user',array('email'=>$email,'nama'=>$nama,'password'=>$password));
				redirect(base_url());
			}
			
		}
		
		public function ganti_password()
		{
			$data['page'] = "frontend/user";
			$data['title'] = "Home";
			$this->load->view("backend/template",$data);
		}
		
		public function php_ganti_password()
		{
			if(!$this->session->userdata('pegawai'))
			{
				redirect(base_url());
			}
			$idpeg=$this->session->userdata('pegawai');
			$passl = $this->input->post("passl");
			
			if($this->db->where('password',$passl)->where('id_pegawai',$idpeg)->get('user')->num_rows()<1)
			{
				echo "<script language=\"javascript\">alert('Maaf password lama Anda salah')</script>";
				echo "<script language=\"javascript\">document.location='".base_url()."user/ganti_password'</script>";
			}
			else
			{
				$pass1 = $this->input->post("pass1");
				$pass2 = $this->input->post("pass2");
				if($pass1 != $pass2)
				{
					echo "<script language=\"javascript\">alert('Maaf confirm password Anda salah')</script>";
					echo "<script language=\"javascript\">document.location='".base_url()."user/ganti_password'</script>";
				}
				else
				{
					$this->db->where('id_pegawai',$idpeg)->update('user',$pass1);
					$this->db->insert('audit_log',array('id_pegawai'=>$idpeg,'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas_log'=>"ID Pegawai $idpeg mengganti passwordnya"));
					
					echo "<script language=\"javascript\">alert('Ganti password berhasil')</script>";
					echo "<script language=\"javascript\">document.location='".base_url()."'</script>";
				}
			}
		}
		
		public function logout()
		{
			$this->db->insert('user_log',array('id_pegawai'=>$idpeg,'waktu_log'=>date('Y-m-d H:i:s'),'aktifitas'=>'out'));
			$this->session->sess_destroy();
			redirect(base_url());
		}
	}
?>