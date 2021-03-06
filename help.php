<link href="<?php echo $this->plugin_url?>/css/style.css" rel="stylesheet" />
<link href="<?php echo $this->plugin_url?>/css/bootstrap.css" rel="stylesheet" />
<div class="wrap">
	<h2 class="tf_heading">Trafficfeed Help</h2>
	<?php include('includes/tf-header.php'); ?>

    <h3>How to use this plugin?</h3>
    <ol>
        <li>
            <h4>Trafficfeed Widget</h4>
            <ul>
                <li>
                    From Appearacne -> Widgets select trafficfeed widget and drop in to your siedbar widget area then select the option from dropdown.
                </li>
            </ul>
        </li>
        <li>
            <h4>Use shortcode for display link exchanges.</h4>
            <ul>
                <li>[TF-SHOW show="receive_div"]. For displaying page link exchanges</li>
                <li>[TF-SHOW show="receive_dir"]. For displaying Link directory.</li>
            </ul>
        </li>
    </ol>  
   
    

    <h3>Link Window</h3>
    <ul>
        <li>This code Will allow you to exchange links on a particular page.</li>
    </ul>
    <h3>Link Directory</h3>
    <ul>
        <li>All exchanges for your site will appear on a page where you will place this short code <b>[TF-SHOW show="receive_dir"]</b>.</li>
    </ul>
    <div style="margin:10px 0px; color:#c10000; font-weight:bold;"> Note : You can use short code in text widget , page and post, just place the short code and you are done. </div>

    <div style="margin:0px autto; padding:10px;">
    <img src="<?php echo $this->plugin_url;?>icon/widget-installation.png" />
    </div>
</div>
