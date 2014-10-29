<?php 
	$token = get_option('tf_token'); 
	if(	!isset($token) || $token == ""){
		$redirect_url = admin_url( 'admin.php?page=tf_settings' );
		echo "<script>window.location.href='".$redirect_url."';</script>";
		exit;
	}
?>
<link href="<?php echo $this->plugin_url?>/css/style.css" rel="stylesheet" />
<div style="width:95%; margin:10px 0px;">
<?php include('tf-header.php'); ?>
</div>
<div style="padding:10px;">
	<div class="tf_login_form">
		<div class="col-wrap">
		<?php 
			if(isset($token) && $token!=""){
				$domain = $this->domain_url(site_url());
				$title 		 = get_bloginfo('name'); 
				$description = get_bloginfo('description'); 
		
		        $response =  json_decode($this->tf_check_domain($token));
				switch($response->domain->status){
					case 0:
						echo "<div>Domain is active and verified.</div>";
					break;
					case 1:
						echo "<div>";
						echo "<div>Domain is in-active.<div>";
						echo "<div>To verify please click <a href='javascript:/' class='active_domain'>here</a><div>";
						echo "<div id='domain_act_response'><div>";
						echo "</div>";
					break;
					case 2:
						$msg  ="<div>Your domain is either blocked or suspened.</div>";
						$msg  .="<div>To contact us please click <a href='http://www.trafficfeed.com'>here</a>. </div>";
						echo $msg;
					break;
					case -2:
						echo "<div class='tf_note'>This domain is not linked with your account</div>";
						
					break;
					case 4:
						echo "<div>This domain is not linked with your account</div>";
						
					break;
					case 3:

						
						?>
								<div id="" >
					
		    			<div class="form-wrap">
		  					<div class="">
		    					<?php $categories = $this->get_tf_categories();
									$categories = json_decode($categories);
								?>
			
		    					<h3>Add Site in trafficfeed.com</h3>
		    					<?php if($user->is_allow==0) {?>
		    					<form method="post" action="" name="tf_add_site" id="tf_add_site">
		    						
		        
								        <div class="form-field form-required">
								          <label for="title">Site Title <span>*</span></label>
								          <input type="text" name="title" id="title"  class="tf_text" value="<?php echo $title;?>">
								          <p>The title for your site.</p>
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
								          <p>The category for your site.</p>
								          <?php } ?>
								        </div>
								        
								        <div class="form-field form-required">
								          <label for="domain">Domain Name <span>*</span></label>
								          <input type="text" name="domain" value="<?php echo $domain;?>" readonly="readonly" id="domain" class="tf_text">
								       </div>
								      
								        <div  class="form-field form-required">
								          <label for="description">Description <span>*</span></label>
								           <textarea name="description" id="description" rows="5" class="tf_text"><?php echo $Description;?></textarea>
								            <p>Write something about your site</p>
								        </div>
								       
								        <p class="submit">
								          <input type="submit" name="btn_domain" id="btn_domain" value="ADD" class="button button-primary">
								        </p>
								        
								          <div id="tf_error" class="tf_error" style="display:none; width:250px"></div>
								          <div id="tf_success" class="tf_success" style="display:none;width:250px"></div>
								        
		    						
								</form>
								<?php } ?>
		  					</div>
		  				</div>
		  			</div>
						<?php
					break ;
				}
		    }else{
		        $response =  json_decode($this->tf_check_domain());
		      	echo $response->domain->message;
		      	?>
		      	
				
		      	<?php 
		    }
		?>
		</div>
	</div>
	<div class="tf_info_box_large">
		<h3>What traficfeed.com is?</h3>
	</div>
	<div style="clear:both"></div>	
	<div class="result" style="display:none"></div>
</div>