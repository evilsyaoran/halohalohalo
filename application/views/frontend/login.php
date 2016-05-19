   <div class='container'>
   <form class="form-signin" method="post" action="<?php echo base_url()?>user/proses_masuk">
        <h2 class="form-signin-heading">Silahkan isi untuk masuk</h2>
		<?php if($this->session->flashdata('gagal')){
			echo "<div class=\"alert alert-danger\">";
			echo "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
			echo $this->session->flashdata('gagal');
			echo "</div>";
		 } ?>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>
      </form>
	  <div class='container'>