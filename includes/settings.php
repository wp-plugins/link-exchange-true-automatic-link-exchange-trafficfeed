<link href="<?php echo $this->plugin_url?>/css/style.css" rel="stylesheet" />
<?php 
	$token = get_option('tf_token'); 
?>
<div class="wrap tf-wrap">
  <h2 class="tf_heading">Trafficfeed Settings</h2>
<?php include('tf-header.php'); ?>
  <div id="col-container">
    <?php 
 
 
	if($token) {
		$user = $this->get_user_info();

		?>
    <div>
      <div class="tf_float_left"><a href="javascript://" id="tf_logout" class="tf_logout">LOGOUT FROM TRAFFICFEED</a></div>
      <div class="tf_float_left" style="margin-left:10px;"><a href="javascript://"  class="tf_reset">RESET SETTINGS</a></div>
      <div class="tf_clear"></div>
    </div>
    <?php include('steps.php'); ?>
    <?php if($all_steps){
  		echo "<div class=\"tf-alert-box tf-success\" style=\"width:95%\">Congratulation!!! You have successfully finished all steps...enjoy exchangin...</div>";
  	}?>
    <?php } 
	if(!$token) {

		?>
    <div class="tf_margin">
      <div class="tf_left_info tf_right_extra_padding tf_blue" >
        <div class="col-wrap">
          <h3>Already have TrafficFeed account?</h3>
          <ul>
            <li> You have to login first to manage <?php echo $this->domain_url(site_url());?> domain. </li>
            <li> Make sure that the domain <?php echo $this->domain_url(site_url());?> is associated with same account you going to login with. </li>
          </ul>
          <div class="button_info"> <a href="<?php echo admin_url( 'admin.php?page=tf_login_form' );?>" class="btn_green" title="Login Now">Login Now</a> </div>
        </div>
      </div>
      <div class="tf_left_info tf_red" >
        <div class="col-wrap">
          <h3>Don't have TrafficFeed.com account yet…?</h3>
          <ul>
            <li>Let’s Link The Whole World Together. Take TrafficFeed for a test drive and see what it can do for you…</li>
            <li>Register for a free account and start using Trafficfeed online marketing tools.</li>
          </ul>
          <div class="button_info"> <a href="<?php echo admin_url( 'admin.php?page=tf_register_form' );?>" class="btn_green" title="Register Now">Continue</a> </div>
        </div>
      </div>
      <div style="clear:both"></div>
    </div>
    <?php  } 
if($token) {
		
		
	?>
    <div class="tf_left_info tf_right_extra_padding tf_blue" >
      <div class="col-wrap">
        <div class=" ">
          <div class="">
            <h3>Your details</h3>
            <?php 
						
						if(count($user)>0){
						?>
            <div class="user_info_tf" >
              <label class="tf_user_label">Name</label>
              <div style="tf_float_left"><?php echo $user->name ;?></div>
              <div class="tf_clear"></div>
            </div>
            <div class="user_info_tf">
              <label class="tf_user_label">Username</label>
              <div class="tf_float_left"><?php echo $user->username; ?></div>
              <div class="tf_clear"></div>
            </div>
            <div class="user_info_tf">
              <label class="tf_user_label">Email</label>
              <div class="tf_float_left"><?php echo $user->email; ?></div>
              <div class="tf_clear"></div>
            </div>
            <div class="user_info_tf">
              <label class="tf_user_label">Role</label>
              <div class="tf_float_left"><?php echo $user->role; ?></div>
              <div class="tf_clear"></div>
            </div>
            <div class="user_info_tf">
              <label class="tf_user_label">Balance</label>
              <div class="tf_float_left"><?php echo $user->balance; ?></div>
              <div class="tf_clear"></div>
            </div>
            <div class="user_info_tf">
              <label class="tf_user_label">Earning</label>
              <div class="tf_float_left"><?php echo $user->earning; ?></div>
              <div class="tf_clear"></div>
            </div>
            <div class="user_info_tf">
              <label class="tf_user_label">Added Sites</label>
              <div class="tf_float_left"><?php echo $user->sites; ?></div>
              <div class="tf_clear"></div>
            </div>
            <div class="user_info_tf">
              <label class="tf_user_label">Added Pages</label>
              <div class="tf_float_left"><?php echo $user->pages; ?></div>
              <div class="tf_clear"></div>
            </div>
            <div class="user_info_tf">
              <label class="tf_user_label">Account Status</label>
              <div class="tf_float_left"><?php echo $user->status; ?></div>
              <div class="tf_clear"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tf_left_info tf_red" >
      <div class="col-wrap">
        <div class="form-wrap">
          <?php 
    	    if($user->status =='InActive'){
				echo "<div class='tf_verify'>Please go to your inbox to verify your email address: <strong> ".$user->email." </strong> <br>
				After verifying your trafficfeed account you can start adding and exchanging pages with other verified TrafficFeed users.
				</div>";
			} else { ?>
          <div id="">
            <h3>Domain Information</h3>
            <?php 
							if(isset($token) && $token!=""){
			                    $response =  json_decode($this->tf_check_domain($token));
								
								switch($response->domain->status){
									case 0:

										echo $response->domain->message;
										$site_pages = $this->get_all_pages(); 
										if(count($site_pages)>0){	
											if (!is_active_widget( false, false, "widget_trafficfeed", true ) && $user->pages  > 0) { ?>
            <div class="do_activate_widget" >
              <p><strong>Please click on the link <a href='<?php echo admin_url('widgets.php'); ?>'>here</a>: INSTALL WIDGET Then just drag and drop 'Trafficfeed Widget' into your side bar. If you don't know how to do it <a href='https://www.youtube.com/watch?v=FPcGAxvVw0o&feature=youtu.be' target='_blank'>here</a> is the video which will help you to install the plugin.</strong></p>
            </div>
            <?php 		
											}	
											?>
            <form id="tf_add_site_pages" method="post" >
              <h4>Add Pages to exchange</h4>
              <ul class="tf_site_pages_list">
                <?php 
													echo '<li><input type="checkbox" name="add_page_tf[]" value="0"> ' . home_url() . '</li>';
													foreach ( $site_pages as $page ) {

													   echo '<li><input type="checkbox" name="add_page_tf[]" value="'.$page->ID.'"> ' . $page->post_title . '</li>';

													   
													}
													?>
              </ul>
              <div>
                <input type="submit" id="btn_tf_add_pages" class="button button-primary button-large" value="ADD SELECTED PAGES">
              </div>
            </form>
            <div class="result"></div>
            <?php 
										}

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
										echo "<div class='tf_note' style='color:#fff'>This domain is not linked with your account</div>";
										
									break;
									case 4:
										echo "<div>This domain is not linked with your account</div>";
										
									break;
									case 3:
										?>
            <div class="col-wrap">
              <div> Add your site <?php echo $this->domain_url(site_url()); ?> in in trafficfeed.com. </div>
              <div> Start link exchage automatic. </div>
              <div class="button_info"> <a href="<?php echo admin_url( 'admin.php?page=tf_site_info' );?>" class="btn_green" title="Add your site now">Add your site</a> </div>
            </div>
            <?php
										

									break ;
								}
			                }else{
			                    $response =  json_decode($this->tf_check_domain());
			                  	echo $response->domain->message;
			                }
			
            			?>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div style="clear:both"></div>
    <?php 
		}
		
  	 } else {?>
    <div><?php echo $user->message;?></div>
    <?php } ?>
  </div>
 
</div>
<div class="result" style="display:none"></div>
