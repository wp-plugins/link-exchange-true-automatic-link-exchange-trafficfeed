<?php 
	 $all_steps = false;

	 if($_REQUEST['page']=='tf_register_form' || $_REQUEST['page']=='tf_site_info') { 
	 	$step_1 = "active_step_yellow";
	 	$step_2 = "active_step_next";
	 	$step_3 = "active_step_next";
	 	$step_4 = "active_step_next";
	 } else if($token && $user->status =='InActive'){
	 	$step_1 = "active_step_green";
	 	$step_2 = "active_step_yellow";
	 	$step_3 = "active_step_next";
	 	$step_4 = "active_step_next";

	 }else if($token && $user->status =='Active' && $user->pages == 0){
	 	$step_1 = "active_step_green";
	 	$step_2 = "active_step_green";
	 	$step_3 = "active_step_yellow";
	 	$step_4 = "active_step_next";

	 }else if($token && $user->status =='Active' && $user->pages > 0 && !is_active_widget( false, false, "widget_trafficfeed", true ) ){
	 	$step_1 = "active_step_green";
	 	$step_2 = "active_step_green";
	 	$step_3 = "active_step_green";
	 	$step_4 = "active_step_yellow";

	 } else if($token && $user->status =='Active' && $user->pages > 0 && is_active_widget( false, false, "widget_trafficfeed", true )){
	 	$step_1 = "active_step_green";
	 	$step_2 = "active_step_green";
	 	$step_3 = "active_step_green";
	 	$step_4 = "active_step_green";
	 	$all_steps = true;

	 }
?>
<ul class="tf_steps_info">
	<li class="<?php  echo  $step_1;  ?>" >STEP 1 <span class="step_text">(Create an account)</span><a href="http://www.trafficfeed.com/cms/contact-us/" class="tf_help_link"> Need help?</a></li>
    <li class="devide_step">&nbsp;</li>
    <li  class="<?php  echo  $step_2;  ?>" >STEP 2 <span class="step_text">(Verify your account)<a  href="http://www.trafficfeed.com/cms/contact-us/" class="tf_help_link"> Need help?</a></span></li>
    <li class="devide_step">&nbsp;</li>
    <li  class="<?php  echo  $step_3;  ?>" >STEP 3 <span class="step_text">(Add Pages)</span> <a href="http://www.trafficfeed.com/cms/contact-us/" class="tf_help_link">Need help?</a></li>
    <li class="devide_step">&nbsp;</li>
    <li  class="<?php  echo  $step_4;  ?>" >STEP 4 <span class="step_text">(Activate Widget)</span> <a href="http://www.trafficfeed.com/cms/contact-us/" class="tf_help_link">Need help?</a></li>
    <div style="clear:both"></div>
</ul>