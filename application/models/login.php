<?php
	class login extends CI_Model {
		public function login()
		{
			if ($this->session->userdata("pegawai"))
			{
				redirect(base_url()."cpanel");
			}
				else
			{
				?>
					<form method="POST" action="<?=base_url()?>user/login">
					<input id="luser" type="text" placeholder="Username" name="myusername" class="login"><br />
					<input id="lpass" type="password" placeholder="Password" name="mypassword" class="login"><br /><br />
					<input id="lsubmit" type="submit" class="button" value="Login">
					</form>
				<?php
			}
		}
	}
?>