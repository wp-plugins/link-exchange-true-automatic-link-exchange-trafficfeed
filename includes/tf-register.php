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
<div style="width:96%; margin:10px 0px;">
<?php include('tf-header.php'); ?>
</div>
<link href="<?php echo $this->plugin_url?>/css/style.css" rel="stylesheet" />
<?php include("steps.php"); ?>
<div class="tf_submit_form">
	<div class="form-wrap">
		<h3>Sign Up For Free TrafficFeed.com Account</h3>
		<?php 
			if($domain_info->status == 0) {
		?>
				<form method="post" name="frm_tf_reg" id="frm_tf_reg">
			<div class="">
				  <div class="tf_form_gruop">
	 				<div class="form-field form-required tf_field_left">
			          	<label for="tf_first_name">First Name <span>*</span></label>
			        	<input type="text" name="tf_first_name" id="tf_first_name" />
			        </div>
			        <div class="form-field form-required tf_field_left">
			          	<label for="tf_last_name">Last Name <span>*</span></label>
			          	<input type="text" name="tf_last_name" id="tf_last_name" />
			        </div>
			        <div class="tf_clear"></div>
		        </div>
		        <div class="tf_form_gruop">
			        <div class="form-field form-required tf_field_left">
			          	<label for="tf_username">username <span>*</span></label>
			           	<input type="text" name="tf_username" id="tf_username_reg" />
			           	
			        </div>
			        <div class="form-field form-required tf_field_left">
			          	<label for="tf_email">Email <span>*</span></label>
			          	<input type="text" name="tf_email" id="tf_email" />
			        </div>
			        <div class="tf_clear"></div>
		        </div>
		      	<div class="tf_form_gruop">
			        <div class="form-field form-required tf_field_left">
			          	<label for="tf_password">Password <span>*</span></label>
			          	<input type="password" name="tf_password" id="tf_password_reg" />
			        </div>
			       
			        <div class="form-field form-required tf_field_left">
			          	<label for="tf_c_password">Confirm Password <span>*</span></label>
			           	<input type="password" name="tf_c_password" id="tf_c_password_reg" />
			        </div>
			        <div class="tf_clear"></div>
		        </div>
		       
		       
			</div>
			<div class="form-wrap">
				<div class="">
					<?php $categories = $this->get_tf_categories();
						$categories = json_decode($categories);
					?>

					<h3>Add Your Site To TrafficFeed.com</h3>
					
					<div class="form-field form-required">
			          	<label for="title">Site Title <span>*</span></label>
			          	<input type="text" name="title" id="title" value="<?php echo $title?>" class="tf_text">
			          	<p>Title of your site.</p>
			        </div>
			      
			        <div class="form-field form-required">
			          	<label for="tf_category">Select Category <span>*</span></label>
			           	<?php if(count($categories)>0){?>
				          	<select class='tf_select' name="tf_category" id="tf_category">
				            	<option value="">Select Category</option>
				            	<?php foreach($categories as $category) {?>
				            		<option value="<?php echo $category->id?>"><?php echo $category->name?></option>
				            	<?php }?>
				          	</select>
				          	<p>The category of your site.</p>
			          	<?php } ?>
			        </div>
			        
			        <div class="form-field form-required">
			        	<label for="domain">Domain Name <span>*</span></label>
			          	<input type="text" name="domain" readonly="readonly"  value="<?php echo $domain?>"  id="domain" class="tf_text">
			        </div>
				      
			        <div  class="form-field form-required">
			          	<label for="description">Description <span>*</span></label>
			           	<textarea name="description" id="description" rows="5" class="tf_text"><?php echo $description?></textarea>
			            <p>Describe your site</p>
			        </div>
				</div>
  			</div>
  			 <p class="submit" >
		          <input type="submit" class="button button-primary"  name="tf_btn_register" id="tf_btn_register" value="Sign Up" />
		          <a href="<?php echo admin_url( 'admin.php?page=tf_login_form' );?>" class="btn_green" title="Login Now">Already have an account?</a>
		        </p>
		       
		        <div class="tf_success" style="display:none"></div>
		        <div class="tf_error" style="display:none"></div>
				</form>
		<?php } else {
			echo $domain_info->message;
		}?>
	</div>
</div>
<div class="tf_registraion_info_box ">

    <p>
    
    </p><strong>What is TrafficFeed.com?</strong> – sign up for your free account to get instant access to online marketing and seo tools and educational materials, to help you take your business to the next level and start making money now.
</div>
<div class="result" style="display:none"></div>