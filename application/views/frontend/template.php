<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo base_url() ?>asset/favicon.ico" rel="icon" type="image/x-icon" />
    <link href="<?php echo base_url() ?>asset/icon_o4u_icon.ico" rel="shortcut icon" type="image/x-icon" />

    <title>HaloKerja</title>
	
	<!-- JS -->
	<script src="<?php echo base_url() ?>asset/jquery-1.11.1.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url() ?>asset/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Bootstrap core JS -->
	<script src="<?php echo base_url() ?>asset/js/bootstrap.min.js"></script>
	
	
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo base_url() ?>asset/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url() ?>asset/halokerja.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>asset/logo.png"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
		  <ul class="nav navbar-nav navbar-right">
			<?php if(!$this->session->userdata('user')){ ?>
            <li><a href="<?php echo base_url() ?>" class="halonav">Home</a></li>
			<li><a href="<?php echo base_url() ?>kerja/cari" class="halonav ">Cari Kerja</a></li>
			<li><a href="<?php echo base_url() ?>user/masuk" class="halonav">Masuk</a></li>
			<li><a href="<?php echo base_url() ?>user/daftar" class="halonav">Daftar</a></li>
			<?php }else{ ?>
			<li><a href="<?php echo base_url() ?>" class="halonav">Home</a></li>
			<li><a href="<?php echo base_url() ?>kerja/cari" class="halonav">Cari Pekerjaan</a></li>
			<li><a href="<?php echo base_url() ?>kerja/pasang" class="halonav">Pasang Tawaran Kerja</a></li>
			<li><a href="<?php echo base_url() ?>user/logout" class="halonav">Logout</a></li>
			<?php } ?>
            <li><a href="<?php echo base_url() ?>" class="halonav">Tentang Kami</a></li>
 <li><a href="https://www.facebook.com/halokerja/" class="halonav"><img src="<?php echo base_url() ?>asset/fb.png"></a></li>
 <li><a href="https://www.twitter.com" class="halonav"><img src="<?php echo base_url() ?>asset/twitter.png"></a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
<div class="body">
	<?php
		$this->load->view($page);
	?>

	</div>
		<footer><hr>
	<div class="container">
			<p>&copy; 2015 HaloKerja</p>

	</div>
		</footer></body>
</html>