<?php 
	$token = get_option('tf_token'); 
	if(isset($token) && $token!=""){
		$redirect_url = admin_url( 'admin.php?page=tf_settings' );
		echo "<script>window.location.href='".$redirect_url."';</script>";
		exit;
	}
	$domain_info = json_decode($this->tf_check_domain_info());
	
	$title 		 = get_bloginfo('name'); 
	$description = get_bloginfo('description'); 
	$domain      = $this->domain_url(site_url()); 
?>
<link href="<?php echo $this->plugin_url?>/css/style.css" rel="stylesheet" />
<link href="<?php echo $this->plugin_url?>/css/bootstrap.css" rel="stylesheet" />
<div class="wrap tf-wrap">
	<h2 class="tf_heading">Trafficfeed Signup</h2>
	<?php include('tf-header.php'); ?>
	<?php include("steps.php"); ?>

	<div class="row">
		<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
			<div class="panel panel-success">
				<div class="panel-heading">
					<strong> Sign Up For Free TrafficFeed.com Account</strong>
				</div>
				<div class="panel-body">
					<?php if($domain_info->status == 0) { ?>
				 		<form id="frm_tf_reg" name="frm_tf_login" method="post">
				 			<legend>Personal Information</legend>

				 			<div class="row">
				 				<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
				 					<div class="form-group">
										<label for="tf_first_name" class="control-label">First Name <span>*</span></label>
										<input type="text" class="form-control" id="tf_first_name" name="tf_first_name" placeholder="Firstname">
									</div>
				 				</div>
				 				<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
				 					<div class="form-group">
										<label for="tf_last_name" class="control-label">Last Name <span>*</span></label>
										<input type="text" class="form-control" id="tf_last_name" name="tf_last_name" placeholder="Firstname">
									</div>
				 				</div>
				 			</div>

				 			<div class="row">
				 				<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
				 					<div class="form-group">
										<label for="tf_username" class="control-label">Username <span>*</span></label>
										<input type="text" class="form-control" id="tf_username" name="tf_username" placeholder="Username">
									</div>
				 				</div>
				 				<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
				 					<div class="form-group">
										<label for="tf_email" class="control-label">Email <span>*</span></label>
										<input type="email" class="form-control" id="tf_email" name="tf_email" placeholder="Email">
									</div>
				 				</div>
				 			</div>

				 			<div class="row">
				 				<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
				 					<div class="form-group">
										<label for="tf_password_reg" class="control-label">Password <span>*</span></label>
										<input type="password" class="form-control" id="tf_password_reg" name="tf_password" placeholder="Password">
									</div>
				 				</div>
				 				<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
				 					<div class="form-group">
										<label for="tf_c_password_reg" class="control-label">Confirm Password <span>*</span></label>
										<input type="password" class="form-control" id="tf_c_password_reg" name="tf_c_password" placeholder="Confirm Password">
									</div>
				 				</div>
				 			</div>

				 			<legend>Add Your Site To TrafficFeed.com</legend>

				 			<div class="row">
				 				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
				 					<div class="form-group">
										<label for="title" class="control-label">Site Title <span>*</span></label>
										<input type="text" class="form-control" value="<?php echo $title ?>" id="title" name="title" placeholder="Site Title">
									</div>
				 				</div>
				 			</div>

				 			<div class="row">
				 				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
				 					<div class="form-group">
										<label for="tf_category" class="control-label">Select Category <span>*</span></label>
										<select class='tf_select form-control' name="tf_category" id="tf_category">
											<option value="">Select Category</option>
							            	<?php 
							            		$categories = $this->get_tf_categories();
												$categories = json_decode($categories);
							            		foreach($categories as $category) {
							            	?>
							            			<option value="<?php echo $category->id?>"><?php echo $category->name?></option>
							            	<?php } ?>
										</select>
									</div>
				 				</div>
				 			</div>

				 			<div class="row">
				 				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
				 					<div class="form-group">
										<label for="domain" class="control-label">Domain <span>*</span></label>
										<input type="text" class="form-control" id="domain" name="domain" placeholder="Domain" value="<?php echo $domain; ?>">
									</div>
				 				</div>
				 			</div>

				 			<div class="row">
				 				<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
				 					<div class="form-group">
										<label for="description" class="control-label">Description <span>*</span></label>
										<textarea class="form-control" id="description" rows="5" name="description" placeholder="Description"><?php echo $description; ?></textarea>
									</div>
				 				</div>
				 			</div>
							
                      		<div class="row">
                      			<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
                      				<input type="submit" class="btn btn-success btn-block" name="tf_btn_register" id="tf_btn_register" value="Sign Up" />
                      			</div>

                      			<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
                      				<a href="<?php echo admin_url( 'admin.php?page=tf_login_form' );?>" class="btn btn-info btn-block" title="Login Now">Already have an account?</a>
                      			</div>
                          	</div>
                          	<div class="row">
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
									<div class="tf_error_msg" style="display:none"></div>
								</div>
							</div>
                  		</form>
                  	<?php } else { ?>
                  		<?php echo $domain_info->message; ?>
                  		<div class="row margin-top-10">
                  			<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                  				<a href="<?php echo admin_url( 'admin.php?page=tf_login_form' );?>" class="btn btn-info btn-block" title="Login Now">Click here to login</a>
                  			</div>
                      	</div>
                  	<?php } ?>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong> What traficfeed.com is?</strong>
				</div>
				<div class="panel-body">
					<p><strong>What is TrafficFeed.com?</strong> – sign up for your free account to get instant access to online marketing and seo tools and educational materials, to help you take your business to the next level and start making money now.</p>
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
</div>