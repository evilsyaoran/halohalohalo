<?php
	class page extends CI_Controller {
		
		function index($page)
		{
			$data['page'] = "frontend/".$page;
			$data['title'] = $page;
			$this->load->view("frontend/template",$data);
		}
	}
?>