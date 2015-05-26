<?php 
	 $all_steps = false;

	 if($_REQUEST['page']=='tf_register_form' || $_REQUEST['page']=='tf_site_info') { 
	 	$step_1 = "sf-active";
	 	$step_2 = "";
	 	$step_3 = "";
	 	$step_4 = "";
	 } else if($token && $user->status =='InActive'){
	 	$step_1 = "sf-passed";
	 	$step_2 = "sf-active";
	 	$step_3 = "";
	 	$step_4 = "";

	 }else if($token && $user->status =='Active' && $user->pages == 0){
	 	$step_1 = "sf-passed";
	 	$step_2 = "sf-passed";
	 	$step_3 = "sf-active";
	 	$step_4 = "";

	 }else if($token && $user->status =='Active' && $user->pages > 0 && !is_active_widget( false, false, "widget_trafficfeed", true ) ){
	 	$step_1 = "sf-passed";
	 	$step_2 = "sf-passed";
	 	$step_3 = "sf-passed";
	 	$step_4 = "sf-active";

	 } else if($token && $user->status =='Active' && $user->pages > 0 && is_active_widget( false, false, "widget_trafficfeed", true )){
	 	$step_1 = "sf-passed";
	 	$step_2 = "sf-passed";
	 	$step_3 = "sf-passed";
	 	$step_4 = "sf-passed";
	 	$all_steps = true;

	 }
?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		&nbsp;
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="stepsForm">
			<div class="sf-steps">
				<div class="sf-steps-content">
					<div class="<?php echo $step_1; ?>">
						<span>1</span> Create an account
					</div>
					<div class="<?php echo $step_2; ?>">
						<span>2</span> Verify your account
					</div>
					<div class="<?php echo $step_3; ?>">
						<span>3</span> Add Pages
					</div>
					<div class="<?php echo $step_4; ?>">
						<span>4</span> Activate Widget
					</div>
				</div>
			</div>
		</div>
	</div>
</div>