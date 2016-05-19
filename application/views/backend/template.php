<!doctype html>
<html>
	<head>
		<title>
			<?php echo $title ?> | Armor Cafe
		</title>
		<link href="<?php echo base_url() ?>asset/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/jquery.datetimepicker.css"/>
		<style type="text/css">
			html,body 
			{
				margin:0;
				padding:0;
			}
			
			th
			{
				text-align:left;
			}
			
			.ahias
			{
				display:block;
				padding:5px;
				width:100px;
				border-radius:5px;
				box-shadow:0px 0px 2px rgb(79,44,38);
				color:rgb(79,44,38);
				text-align:center;
				font-weight:bold;
				position:absolute;
				bottom:15px;
				text-decoration:none;
			}
			
			.lsubmit
			{
				float:left;
				margin-right:20px;
				width:100px;
				padding:5px;
				color:white;
				border-radius:5px;
				background:rgb(79,44,38)
			}
			
			a {text-decoration:none;font-weight:bold;color:rgb(79,44,38)}
		
			
			*
			{
				font-family:arial;
				margin:0;
				transition:all 0.3s;
			}
			
			body
			{
				background: url('<?=base_url()?>images/bg.jpg');
			}
			
			#container
			{
			}
			
			#head
			{
				position:fixed;
				width:100%;
				min-width:1080px;
				height:50px;
				top:0;
				background: white;
				color:rgb(79,44,38);
				height:50px;
				box-shadow:1px 1px 3px black;
				z-index:9000;
			}
			
			#logo
			{
				float:left;
				padding:5px;
				background:white;
			}
			
			#logo img
			{
				height:35px;
				margin:0px;
			}
			
			#nav
			{
				width:700px;
				float:left;
				list-style:none;
			}
			
			#notice
			{
				float:right
			}
			
			#nav li
			{
				margin:0;
			}
			
			#nav li a
			{
				display:block;
				float:left;
				height:30px;
				padding: 15px 10px 5px 5px;
				font-size:16px;
				font-weight:bold;
				color:rgb(79,44,38);
				text-decoration:none;
				text-align:center;
			}
			
			#notice
			{
				color:rgb(79,44,38);
				margin-right:20px;
				margin-top:15px;
			}
			
			#nav li a:hover
			{
				background:rgba(0,0,0,.1);
			}
			
			#isi
			{
				position:relative;
				width:80%;
				padding:20px;
				margin:auto;
				min-height:100px;
				height:auto;
				background:rgba(244,244,244,1);
				border:3px solid rgb(79,44,38);
				border-radius:10px;
				padding-bottom:30px;
			}
			
			#footer
			{
				margin-top:30px;
				position:relative;
				background: rgba(0,0,0,.6);
				width:100%;
				height:70px;
				box-shadow: 0px -2px 3px rgba(0,0,0,.6);
				padding:0;
			}
			
			#container
			{
				position:relative;
				min-width:1080px;
				height:100%;
			}
			
			body,html
			{
				height:100%;
			}
			
			#body
			{
				min-height: 100%;
				height: auto !important;
				height: 100%;
				margin: 0 auto -100px; 
			}
			
			#push
			{
				height:100px;
			}
			
			#copyright 
			{
				position:absolute;
				bottom:10px;
				left:10px;
				width:200px;
				text-align:center;
			}
			
			#copyright a
			{
				margin:0;
				padding:0;
				color:white;
				text-decoration:none;
				font-size:12px;
				font-weight:bold;
			}
			
			#banner
			{
				padding-top:60px;
				min-width:1080px;
				width:auto;
				width:80%;
				margin:auto;
			}
			
			#banner img
			{
				display:block;
				margin:auto;
				width:300px;
				border-radius:15px;
				overflow:hidden;
			}
			
			#rata{margin:auto;display:table;}
			
			#infos
			{
				min-width:220px;
				margin-top:15vh;
				min-height:400px;
				background:white;
				color:rgb(79,44,38);
				border-radius:5px;
				margin-left:50px;
				border:3px solid rgb(79,44,38);
			}
			
			#infos h2
			{
				color:white;
				background: rgb(79,44,38);
				padding:5px 20px;
			}
			
			#infos ul
			{
				margin-top:10px;
				margin-left:30px;
				padding:0;
			}
			
			#isi
			{
				margin-top:15vh;
				width:900px;
				min-width:400px;
				min-height:300px;
				position:relative;
				background:white;
				margin-bottom:30px;
			}
			
			#body_nav
			{
				position:absolute;
				right:15px;
				top:19px;
				height:51px;
			}
			
			#body_nav .nav
			{
				display: inline-block;
				margin-top:24px;
				padding: 5px;
				font-size:14px;
				border-top:1px solid rgb(200,200,200);
				border-right:1px solid rgb(200,200,200);
				border-left:1px solid rgb(200,200,200);
				font-weight: bold;
				text-decoration:none;
				transition: all 0.2s;
				border-radius:5px 5px 0px 0px;
				color:black;
				background: rgb(250,250,250);
			}
			
			#body_nav .nav:hover
			{
				padding-top:10px;
				margin-top:19px;
				transition: all 0.2s;
				background: rgba(79,44,38,.9);
				color:white;
			}
			
			#judul_konten
			{
				padding:10px;
				height:30px;
			}
			
			#content
			{
				padding:10px;
				border-top:1px solid rgb(200,200,200);
			}
			
			
			#table
			{
				width:100%;
				border-radius: 15px;
				overflow: hidden;
			}
			
			#table th
			{
				border-left:1px solid white;
				border-bottom:1px solid rgb(16, 57, 73);
				background-color: rgb(16, 97, 143);
				color:white;
				text-align:left;
				padding:5px 10px 5px 10px;
			}
			
			#table td
			{
				border-left:1px solid white;
				background-color: rgb(126, 207, 255);
				color:black;
				text-align:left;
				padding:5px 10px 5px 10px;
			}
			
			#table tr
			{
				border-bottom:1px solid rgb(16, 87, 173);
			}
			.clearfix
			{
				clear:both;
			}
			.form, .form td, .form th
			{
				border: none;
			}
			
			table
			{
			border-collapse:collapse;
			width:100%;
			}
			
			
			.dpesanan tr,.dpesanan td .dpesanan th{border:0;}
			.firstrow
			{
				background:rgb(79,44,38);
				color:white;
			}
			
			
			table img
			{
				width:40px;
			}
			
			.page
			{
				color:white;
				weight:bold;
				height:20px;
				width:25px;
				text-align:center;
				text-decoration:none;
				background:rgb(79,44,38);
				display:inline-block;
			}
			
			.icon{width:35px;}
			</style>
			
			<script src="<?=base_url()?>asset/jquery.js"></script>
			<script type="text/javascript">
		  var tick;
		  function stop() {
		  clearTimeout(tick);
		  }
		  function jam() {
		  var ut=new Date();
		  var h,m,s;
		  var time="        ";
		  h=ut.getHours();
		  m=ut.getMinutes();
		  s=ut.getSeconds();
		  if(s<=9) s="0"+s;
		  if(m<=9) m="0"+m;
		  if(h<=9) h="0"+h;
		  time+=h+":"+m+":"+s;
		  document.getElementById('jam').innerHTML=time;
		  tick=setTimeout("jam()",1000); 
		  }
		</script>
	</head>
	<body onload="jam();" onunload="stop();">
		<div id="container">
			<div id="head">
				<div id="logo">
					<a href="<?=base_url()?>cpanel">
						<img src="<?=base_url()?>images/logo.jpg" />
					</a>
				</div>
				<ul id="nav">
					<li><a href="<?=base_url()?>cpanel">Home</a></li>
					<?php $this->load->model("nav_admin","nav");?>
					<li><a href="<?=base_url()?>user/logout">Logout</a></li>
				</ul>
				<div id="notice">
				Anda terhubung sebagai <a href="<?php echo base_url()."user/ganti_password"; ?>"><?=$this->session->userdata("pegawai")?></a> |
				<span id="jam">
				</span>
				</div>
			</div>
			<div id="body">>
			<div id="rata">
					<?php $this->load->view($page); ?>
				</div>
				<div id="push">
				</div>
			</div>
		</div>
	</body>
</html>