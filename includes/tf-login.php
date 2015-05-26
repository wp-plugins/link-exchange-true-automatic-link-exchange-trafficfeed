<?php 
	$token = get_option('tf_token'); 
	if(isset($token) && $token!=""){
		$redirect_url = admin_url( 'admin.php?page=tf_settings' );
		echo "<script>window.location.href='".$redirect_url."';</script>";
		exit;
	}
?>
<link href="<?php echo $this->plugin_url?>/css/style.css" rel="stylesheet" />
<link href="<?php echo $this->plugin_url?>/css/bootstrap.css" rel="stylesheet" />
<div class="wrap tf-wrap">
	<h2 class="tf_heading">Trafficfeed Login</h2>
	<?php include('tf-header.php'); ?>
	<div class="row margin-top-10">
		<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
			<div class="panel panel-success">
				<div class="panel-heading">
					<strong> Login to trafficfeed.com</strong>
				</div>
				<div class="panel-body">
			 		<form id="frm_tf_login" name="frm_tf_login" method="post">
                  		<div class="form-group">
                      		<label for="tf_username" class="control-label">Username</label>
                  			<input type="text" class="form-control" id="tf_username" name="tf_username" placeholder="Username">
                  		</div>
                  		
                      	<div class="form-group">
                      		<label for="tf_password" class="control-label">Password</label>
                      		<input type="password" class="form-control" id="tf_password" name="tf_password"placeholder="Password">
                          	<span class="help-block"></span>
                      	</div>

                  		<div class="row">
                  			<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
                  				<button type="submit" class="btn btn-success btn-block">Login</button>
                  			</div>

                  			<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
                  				<a href="<?php echo admin_url( 'admin.php?page=tf_register_form' );?>" class="btn btn-info btn-block">Register Now</a>
                  			</div>
                      	</div>

                      	<div class="row">
							<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
								<div class="tf_error_msg" style="display:none"></div>
							</div>
						</div>
                  	</form>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-xs-12 col-md-8 col-lg-8">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong> What traficfeed.com is?</strong>
				</div>
				<div class="panel-body">
					<ul class="list-group">
			            <li class="list-group-item"><i class="glyphicon glyphicon-hand-right"></i>&nbsp;Manage your all sites from one account.</li>

			            <li class="list-group-item"><i class="glyphicon glyphicon-hand-right"></i>&nbsp;Choose your partner with whom you want to exhange your links.</li>

			            <li class="list-group-item"><i class="glyphicon glyphicon-hand-right"></i>&nbsp;Choose your exchnge type from auto exchange , manual exchange , ABC Exchange.</li>

			            <li class="list-group-item"><i class="glyphicon glyphicon-hand-right"></i>&nbsp;Black list , White list options for exchanges.</li>

			            <li class="list-group-item"><i class="glyphicon glyphicon-hand-right"></i>&nbsp;Sell your links to our verified users they are ready to pay for exchange.</li>
			          </ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
			<div class="result" style="display:none"></div>
		</div>
	</div>

	<!--
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
	-->
	
</div>