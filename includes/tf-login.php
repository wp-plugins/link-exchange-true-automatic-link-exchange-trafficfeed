<?php 
	$token = get_option('tf_token'); 
	if(isset($token) && $token!=""){
		$redirect_url = admin_url( 'admin.php?page=tf_settings' );
		echo "<script>window.location.href='".$redirect_url."';</script>";
		exit;
	}
?>
<link href="<?php echo $this->plugin_url?>/css/style.css" rel="stylesheet" />
<div style="width:95%; margin:10px 0px;">
<?php include('tf-header.php'); ?>
</div>
<div class="tf_login_form">
	
    <div class="form-wrap">
		
        <h3>Login to trafficfeed.com</h3>
	 	<form method="post" name="frm_tf_login" id="frm_tf_login">
			<div class="">
				<div class="form-field form-required">
		        	 <label for="tf_username">Username <span>*</span></label>
		        	 <input type="text" name="tf_username" id="tf_username" />
		        </div>
		        <div  class="form-field form-required">
		        	<label for="tf_password">Password <span>*</span></label> 
		        	<input type="password" name="tf_password" id="tf_password" style="width:98%" />		
		        </div>
		        
		        <p class="submit">
		          <input type="submit" class="button button-primary"  name="tf_btn_login" id="tf_btn_login" value="Login" />
		          <a href="<?php echo admin_url( 'admin.php?page=tf_register_form' );?>" class="btn_green" title="Register Now">Register Now</a>
		        </p>
		        <div class="tf_error_msg" style="display:none"></div>

			</div>
		</form>	
	</div>
</div>
<div class="tf_info_box_large">
	<h3>What traficfeed.com is?</h3>
    <p>
    <ul>
 		<li>
        	Manage your all sites from one account.
        </li>
        <li>
        	Choose your partner with whom you want to exhange your links.
        </li>
        <li>
        	Choose your exchnge type from auto exchange , manual exchange , ABC Exchange. 
        </li>
        <li>
        	Black list , White list options for exchanges.
        </li>
        <li>
        	Sell your links to our verified users they are ready to pay for exchange.
        </li>   	
    </ul>
    </p>
</div>
<div class="result" style="display:none"></div>