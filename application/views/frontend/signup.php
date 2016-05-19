   <div class='container'>
   <form class="form-signin"  method="post" action="<?php echo base_url()?>user/proses_daftar">
        <h2 class="form-signin-heading">Silahkan isi untuk daftar</h2>
		<?php if($this->session->flashdata('gagal')){
			echo "<div class=\"alert alert-danger\">";
			echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
			echo $this->session->flashdata('gagal');
			echo "</div>";
		 } ?>
        <label for="inputEmail" class="sr-only">Email</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Nama</label>
        <input name="nama"  type="text" id="inputNama" class="form-control" placeholder="Nama" required>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password"  type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Daftar</button>
      </form>
	  <div class='container'>