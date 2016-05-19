<?php
	class home extends CI_Controller {
		
		function index()
		{
			$data['page'] = "frontend/home";
			$data['title'] = "Home";
			$this->load->view("frontend/template",$data);
		}
	}
?>