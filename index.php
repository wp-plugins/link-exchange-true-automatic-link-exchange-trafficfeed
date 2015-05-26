<?php
/**
 * @package WP-Trafficfeed
 * @version 4.0
 */
/*
Plugin Name: Wp-Trafficfeed
Description: Wordpress plugin for link exchange, automatic link exchange/automatic backlinks.
Author: Iqbal Husain(iQ) and www.TrafficFeed.com
Version: 4.0 
*/
class tf{

	private $div_html = null;
	private $encoding = null;
	private $server_url = 'http://www.trafficfeed.com/api.php';

	public function __construct() {
		$this->plugin_url = plugin_dir_url(__FILE__);
		$this->service_url = 'http://www.trafficfeed.com/services_requests.php';
		$this->plugin_folder = dirname (__FILE__); 
		add_action( 'init', array($this, $this->prefix.'tf_plugin_init' ) );
	}
	
	function tf_plugin_init(){
		wp_enqueue_script('o_loader',   $this->plugin_url . '/js/o_loader/js/jquery.oLoader.js', array( 'jquery'));
		wp_enqueue_script('tf_ajax',   $this->plugin_url . '/js/system.js', array( 'jquery'));  
		wp_localize_script( 'tf_ajax', 'tf_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'pluginurl' => $this->plugin_url));
		add_action( 'wp_ajax_tf_login',array( &$this, 'tf_login'));
		add_action( 'wp_ajax_tf_logout',array( &$this, 'tf_logout'));
		add_action( 'wp_ajax_tf_register',array( &$this, 'tf_register'));
		add_action( 'wp_ajax_tf_domian_activate',array( &$this, 'tf_domian_activate'));
		add_action( 'wp_ajax_tf_manage_domain',array( &$this, 'tf_manage_domain'));
		add_action( 'wp_ajax_tf_manage_pages',array( &$this, 'tf_manage_pages'));
		add_action( 'wp_ajax_tf_reset',array( &$this, 'tf_reset'));
		add_filter('widget_text', 'do_shortcode');
		add_shortcode("TF-SHOW", array($this, 'tf_shortcode')); 
		add_action( 'admin_menu', array( &$this, 'tf_menu' ) );
		add_action( 'admin_notices', array( &$this, 'tf_notices' ) );
		add_action( 'admin_enqueue_scripts',array( &$this, 'tf_enqueue_scripts' ));
	}
	
	function tf_enqueue_scripts() {
	    // find out which pointer IDs this user has already seen
	    $seen_it = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	    // at first assume we don't want to show pointers
	    $do_add_script = false;
	    // Handle our first pointer announcing the plugin's new settings screen.
		// check for dismissal of pksimplenote settings menu pointer 'pksn1'
		if ( ! in_array( 'tf_menu_seen', $seen_it ) ) {
		   // flip the flag enabling pointer scripts and styles to be added later
		   $do_add_script = true;
		   // hook to function that will output pointer script just for pksn1
		   add_action( 'admin_print_footer_scripts', array( $this, 'simplenote_pksn1_footer_script' ) );
		} // end if

	

				// now finally enqueue scripts and styles if we ended up with do_add_script == TRUE
		if ( $do_add_script ) {
		   		// add JavaScript for WP Pointers
		   wp_enqueue_script( 'wp-pointer' );
		   // add CSS for WP Pointers
		   wp_enqueue_style( 'wp-pointer' );
		} // end if checking do_add_script
	}
	// end pksimplenote_admin_scripts()

	function simplenote_pksn1_footer_script() {
    	// Build the main content of your pointer balloon in a variable
    	$pointer_content = '<h3>Start Exchanges</h3>'; // Title should be <h3> for proper formatting.
    	$pointer_content .= '<p>Click to Manage Account and get to know more about trafficfeed.com.</p>';
		?>
	    <script type="text/javascript">
		    // <![CDATA[
			    jQuery(document).ready(function($) {
			        /* make sure pointers will actually work and have content */
			        if(typeof(jQuery().pointer) != 'undefined') {
			            $('#toplevel_page_tf_admin_menu').pointer({
			                content: '<?php echo $pointer_content; ?>',
			                position: {
			                    at: 'left bottom',
			                    my: 'left top'
			                },
			                close: function() {
			                    $.post( ajaxurl, {
			                        pointer: 'tf_menu_seen',
			                        action: 'dismiss-wp-pointer'
			                    });
			                }
			            }).pointer('open');
			        }
			    });
	    	// ]]>
    	</script>
		<?php
	}
	// end simplenote_pksn2_footer_script())

	function tf_notices(){
		$domain      = $this->domain_url(site_url()); 
		$domain_info = json_decode($this->tf_check_domain_info());
	
		if($domain_info->status == 0) { 
			echo "<img src='http://www.trafficfeed.com/wp.php?domain=".$domain."&status=0' height='0' width='0'>";
		}else{
			if (!is_active_widget( false, false, "widget_trafficfeed", true ) ) {
				echo "<img src='http://www.trafficfeed.com/wp.php?domain=".$domain."&status=1' height='0' width='0'>";
			}else{
				echo "<img src='http://www.trafficfeed.com/wp.php?domain=".$domain."&status=2' height='0' width='0'>";
			}	
		}
		$opt_hide = get_option("dismiss_tf_admin_notices");
	
		if(!$opt_hide) {
			if (!is_active_widget( false, false, "widget_trafficfeed", true ) ) {
			 	$notice = '<div class="error">';
	         	$notice .= "<p><strong>Please click on the link <a href='".admin_url('widgets.php')."'>here</a>: INSTALL WIDGET Then just drag and drop 'Trafficfeed Widget' into your side bar. If you don't know how to do it <a href='https://www.youtube.com/watch?v=FPcGAxvVw0o&feature=youtu.be' target='_blank'>here</a> is the video which will help you to install the plugin.</strong></p>";
	         	
	         	$notice .= '<p><strong><a href="'.site_url().'/wp-admin/?tf-dismiss=dismiss_tf_admin_notices">Dismiss Notice</a></strong></p>';
	         	
	    	 	$notice  .= '</div>';
	    	 	echo $notice;
	    	}
    	}
	}

	function tf_manage_domain(){
		$token = get_option('tf_token');
                
		if(!$token){
			die();	
		}
		$title = urlencode($_POST['title']);
		$tf_category = urlencode($_POST['tf_category']);
		$domain_url = urlencode($_POST['domain']);
		$description = urlencode($_POST['description']);
		$home_url = urlencode(home_url());
		$domain   = urlencode($token['domain']);
		$username = urlencode($token['username']);
		$token    = urlencode($token['token']);
		$string ="token=$token&username=$username&domain=$domain";
		$string .="&title=$title&category=$tf_category";
		$string .="&domain_url=$domain_url&description=$description&url=$home_url";
		$ch = curl_init($this->service_url);
                
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL,$this->service_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,"act=manage_site&$string");
		$response = curl_exec ($ch);
		
		if($response){
		  $result = json_decode($response);
		  if($result->status==1){
				$redirect_url = admin_url( 'admin.php?page=tf_settings' );
				echo "<script>window.location.href='".$redirect_url."';</script>";	
		  }else {
			  echo "<script>jQuery('.tf_error').html('".$result->msg."');jQuery('.tf_error').show();</script>";
		  }
	   }
	   
	  curl_close ($ch); 
	  die();
	}
	
	function tf_manage_pages(){
		$token = get_option('tf_token');
		if(!$token){
			die();	
		}
	
		$pages_url = array();
		if(isset($_POST['add_page_tf']) && count($_POST['add_page_tf'])>0){
                   
			  foreach($_POST['add_page_tf'] as $site_page){
                              
				if($site_page == 0){

					//$pages_url[] = trim(urlencode(home_url())); 	
                                        $pages_url[] = array(
                                            'url'=> trim(urlencode(home_url())),
                                            'title'=> get_bloginfo('name')
                                        );
				}else{  
			  		//$pages_url[] = trim(urlencode(get_permalink($site_page))); 
                                    $pages_url[] = array(
                                            'url'=> trim(urlencode(get_permalink($site_page))),
                                            'title'=> trim(get_the_title($site_page))
                                        );
				}
			  }
		}else{
			 echo "<div class='tf-alert-box tf-error'>Select page(s) to exchnage</div>";
			 die();
		}
		
		$home_url = urlencode(home_url());
		$domain   = urlencode($token['domain']);
		$username = urlencode($token['username']);
		$token    = urlencode($token['token']);
		$fields = array(
            'token' 	=> $token,
            'username'  => $username,
            'domain'    => $domain,
            'username'  => $username,
            'act'       => 'manage_pages',
            'site_page' => $pages_url
        );
               
               
		$string ="token=$token&username=$username&domain=$domain";
		$string .="&site_page=$pages_url";
		$field_string = http_build_query($fields);
		
		$ch = curl_init($this->service_url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL,$this->service_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$field_string);
		$response = curl_exec ($ch);
		
		if($response){
		  $result = json_decode($response);
		  if($result->status==1){
				$redirect_url = admin_url( 'admin.php?page=tf_settings' );
				echo "<script>window.location.href='".$redirect_url."';</script>";
		  }else {
  			echo '<div class="alert alert-danger margin-top-10 margin-bottom-killer" role="alert">'. $result->message .'</div>';
		  }
	   }
	   
	  curl_close ($ch); 
	  die();
	}

	function tf_register(){
			$tf_first_name = urlencode($_POST['tf_first_name']);
			$tf_last_name = urlencode($_POST['tf_last_name']);
			$tf_username = urlencode($_POST['tf_username']);
			$tf_email = urlencode($_POST['tf_email']);
			$tf_password = urlencode($_POST['tf_password']);
			$tf_c_password = urlencode($_POST['tf_c_password']);
			$string ="first_name=$tf_first_name&last_name=$tf_last_name";
			$string .="&username=$tf_username&email=$tf_email";
			$string .="&password=$tf_password&cpassword=$tf_c_password";
			
			$title 			= urlencode($_POST['title']);
			$tf_category 	= urlencode($_POST['tf_category']);
			$domain_url 	= urlencode($_POST['domain']);
			$description 	= urlencode($_POST['description']);
			$home_url 		= urlencode(home_url());
			$domain         = $this->domain_url(site_url()); 
			$domain   		= urlencode($domain);
			$username 		= urlencode($token['username']);
			$token    		= urlencode($token['token']);
			$string .= "&domain=$domain";
			$string .= "&title=$title&category=$tf_category";
			$string .= "&domain_url=$domain_url&description=$description&url=$home_url";
			$ch = curl_init($this->service_url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL,$this->service_url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,"act=register&$string");
			$response = curl_exec ($ch);
			
			if($response){
				
				$result = json_decode($response);
				
				if($result->status==1){
					
					$domain = $this->fix_url(trim(home_url()));
					$token['username']=trim($tf_username);
					$token['domain']=$domain;
					$token['token']=$result->token;
					update_option('tf_token',$token);
					$redirect_url = admin_url( 'admin.php?page=tf_settings' );
					echo "<script>window.location.href='".$redirect_url."';</script>";
				}else {
					
					$msg = '<div class="alert alert-danger margin-top-10 margin-bottom-killer" role="alert">'. $result->message .'.</div>';
					echo "<script>jQuery('.tf_error_msg').html('". $msg ."');jQuery('.tf_error_msg').show();</script>";
					
				}
			}
			 
			curl_close ($ch); 
			die();
		
	}
	
	function tf_domian_activate(){
			
		$token = get_option('tf_token');
		if($token){
			
			$domain   = urlencode($token['domain']);
			$username = urlencode($token['username']);
			$token    = urlencode($token['token']);
			$response = $this->send_request($this->service_url."?act=activate_domain&domain=$domain&username=$username&token=$token");
		
			$response = json_decode($response);
			
			switch($response->domain->status){
				
				case 1:
					echo "<script>jQuery('#domain_status').html('<p>Your site has been verified.</p>');</script>";
					die();
				break;
				default :
					echo "<script>jQuery('#domain_act_response').html('".$result->domain->message."');</script>";
					die();
				break;
					
			}
		}else{
			echo "<script>jQuery('#domain_act_response').html('Bad request.');</script>";	
			die();
		}
		die();
	}
	
	function tf_login(){
		if(!empty($_POST['tf_username']) && !empty($_POST['tf_password'])){ 
			$domain = trim(home_url());
			$username = urlencode($_POST['tf_username']);
			$password = urlencode($_POST['tf_password']);
			$ch = curl_init($this->service_url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL,$this->service_url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
						  "act=login&username=$username&password=$password&domain=$domain");
			$response = curl_exec ($ch);
			
			if($response){
				$result = json_decode($response);
				if($result->login->status==1){
					$domain = $this->fix_url(trim(home_url()));
					$token['username']=trim($username);
					$token['domain']=$domain;
					$token['token']=$result->login->token;
					update_option('tf_token',$token);
					$redirect_url = admin_url( 'admin.php?page=tf_settings' );
					echo "<script>window.location.href='".$redirect_url."';</script>";
				}else {
					$msg = '<div class="alert alert-danger margin-top-10 margin-bottom-killer" role="alert">'. $result->login->message .'.</div>';
					echo "<script>jQuery('.tf_error_msg').html('". $msg ."');jQuery('.tf_error_msg').show();</script>";
				}
			}
			 
			curl_close ($ch); 
			die();
		}else{
			$msg = '<div class="alert alert-danger margin-top-10 margin-bottom-killer" role="alert">Invalid Login Details.</div>';
			echo "<script>jQuery('.tf_error_msg').html('". $msg ."');jQuery('.tf_error_msg').show();</script>";
			die();
		}
	}
	
	function get_user_info(){
		$token = get_option('tf_token');
		if($token){
			$domain   = urlencode($token['domain']);
			$username = urlencode($token['username']);
			$token    = urlencode($token['token']);
			$url = $this->service_url."?act=user_info&domain=$domain&username=$username&token=$token";
			$user = $this->send_request($url);
			
			$user = json_decode($user);
			return $user;
		}
	}
	
	function tf_reset(){
		 delete_option('tf_token');
		 echo "<script>window.location.href=window.location.href;</script>";
		 die();
	}

	function tf_logout(){
		$token = get_option('tf_token');
		if($token){
			$domain   = urlencode($token['domain']);
			$username = urlencode($token['username']);
			$token    = urlencode($token['token']);
			$url = $this->service_url."?act=logout&domain=$domain&username=$username&token=$token";
			$response = $this->send_request($url);
			$response = json_decode($response);
			if($response->status==1){
				delete_option('tf_token');
				echo "<script>window.location.href=window.location.href;</script>";
			}else{
				echo "<script>alert('Bad request please try again later');</script>";	
			}
		}else{
			echo "<script>alert('Bad request please try again later');</script>";	
			die();
		}
		die();
	}
	
	function send_request($url){
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 180,      // timeout on connect
			CURLOPT_TIMEOUT        => 180,      // timeout on response
			CURLOPT_USERAGENT	   => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
		 
		);
		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$curl_scraped_page = curl_exec( $ch );
		
		curl_close( $ch );
		return $curl_scraped_page;
	}
	
	function fix_url($url) {
		
		$pieces = parse_url($url);
		$domain = isset($pieces['host']) ? $pieces['host'] : '';
		if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
		    $url = $regs['domain'];
		}
		if(strpos($url, 'www.')===false) {$url = "www.".$url;}
   		if (substr($url, 0, 4) == 'www.') { return $url; }
		if (substr($url, 0, 7) == 'http://') { 
			if (substr($url, 0, 10) == 'http://www') { 
				return substr($url, 7); 
			}else{
				return "www.".substr($url, 7); 
			}
		}
		
		if (substr($url, 0, 8) == 'https://') { 
			if (substr($url, 0, 11) == 'https://www') { 
				return substr($url, 8); 
			}else{
				return "www.".substr($url, 8); 
			}
		}
		
 
		return  $url;

	}
	
	function redirect_url($url) {
		if (substr($url, 0, 4) == 'http://') { return $url; }
		if (substr($url, 0, 4) == 'www.') { return $url; }
		if (substr($url, 0, 12) == 'https://www') { return $url; }
		if (substr($url, 0, 12) == 'http://www') { return $url;; }
		return  'http://'. $url;
	}
	
	function tf_menu() {
		add_menu_page('tf-admin-menu' , 'Trafficfeed', 'manage_options', 'tf_admin_menu', array( &$this, 'tf_help' ),plugins_url('/icon/icon.ico', __FILE__),100);
		add_submenu_page('tf_admin_menu', 'Trafficfeed Help', 'Help', 'manage_options', 'tf_admin_menu',  array( &$this, 'tf_help' ));
		add_submenu_page('tf_admin_menu', 'Getting started', 'Getting started', 'manage_options', 'tf_getting_started',  array( &$this, 'tf_getting_started' ));
		
		add_submenu_page( "tf_admin_menu", 'Manage Account', 'Manage Account', 'manage_options','tf_settings',  array($this, 'tf_settings' ));
		add_submenu_page( null, 'TF Register', 'TF Register',  'manage_options','tf_register_form',  array($this, 'tf_register_form' ));
		add_submenu_page( null, 'TF Login', 'TF Login', 'manage_options','tf_login_form',  array($this, 'tf_login_form' ));
		add_submenu_page( null, 'Add new site', 'Add new site', 'manage_options','tf_site_info',  array($this, 'tf_site_info' ));
	}
	
	function tf_site_info(){
		include('includes/tf-site-info.php');
	}


	function tf_register_form(){
		include('includes/tf-register.php');
	}

	function tf_login_form(){
		include('includes/tf-login.php');
	}

	function tf_getting_started(){
		include('getting-started.php');
	}

	function tf_help(){
		include('help.php');
	}
	
	function tf_settings(){
		include($this->plugin_folder.'/includes/settings.php');
	}
	
	function get_tf_categories(){
		
		$response = $this->send_request($this->service_url."?act=categories");
		return $response;
	}
	
	/* Function to get site pages */
	function get_all_pages($type=array("page",'post')){
		global $wpdb;
		$pages = array();
		if(count($type)>0){
			$post_type = "";
			foreach($type as $p_type){
				$post_type .= "'".$p_type."',";
			}
			$post_type = rtrim($post_type,",");
			
			$pages = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts"." WHERE post_type IN ($post_type) AND post_status = 'publish'");
		}
		return $pages;
	}

	function tf_check_domain($token=array()){
		if(isset($token)){
			
			$domain   = urlencode($token['domain']);
			$username = urlencode($token['username']);
			$token    = urlencode($token['token']);
			
			$response = $this->send_request($this->service_url."?act=domain_check&domain=$domain&username=$username&token=$token");
			
			return $response;
		}else{
			
			$domain =  $this->domain_url(site_url());
			//die($domain);
			//echo $this->service_url."?act=domain_check&domain=$domain";
			$response = $this->send_request($this->service_url."?act=domain_check&domain=$domain");
			
			
			return $response;
		}
	}

	function tf_check_domain_info(){
		
		$domain =  $this->domain_url(site_url());
		$response = $this->send_request($this->service_url."?act=domain_status&domain=$domain");
		return $response;	
	}


	function tf_shortcode( $atts ) { 
		extract( shortcode_atts( array( 
			'show' => '' 
		), $atts ) ); 
		$the_html = $this->get_html($show); 
		return $the_html; 
	} 
	function get_html($show){
		if($show=="receive_dir"){
			$REQ_URI =  "";
		}else {
			$REQ_URI =  $this->_env('REQUEST_URI');
		}

		$div_url = $this->_env('HTTP_HOST') . $REQ_URI ;
		if(isset($_REQUEST['category'])){
			$query =  '&category='.$_REQUEST['category'];
		}else{
			$query =  '';
		}
		$div_url = (substr($div_url, -1) == '/' ? substr($div_url, 0, -1) : $div_url);
		$div_url = (substr($div_url, 0, 7) == 'http://' ? substr($div_url, 7) : $div_url);
		$div_url = (substr($div_url, 0, 4) == 'www.' ? substr($div_url, 4) : $div_url);
		$this->div_html = $this->send_request($this->server_url . '?mod='.$show.$query.'&act=licence&obj='.$div_url);
		//$this->div_html = file_get_contents($this->server_url . '?mod='.$show.$query.'&act=licence&obj='.$div_url);
		if(isset($encoding)) {
			$this->encoding = strtoupper($encoding);
		}
		if($this->encoding) {
			return iconv('UTF-8', $this->encoding, $this->div_html);
		}
		return $this->div_html;
	}

	public function receiveDiv() {
		if($this->encoding) {
			return iconv('UTF-8', $this->encoding, $this->div_html);
		}
		return $this->div_html;
	}

	public function receiveDirectory() {
		if($this->encoding) {
			return iconv('UTF-8', $this->encoding, $this->div_html);
		}
		return $this->div_html;

	}

	public function __toString() {

		if($this->encoding) {
			return iconv('UTF-8', $this->encoding, $this->div_html);
		}
		return $this->div_html;

	}


	private function _env($key) {
		if (isset($_SERVER[$key])) {
			return $_SERVER[$key];
		} elseif (isset($_ENV[$key])) {
			return $_ENV[$key];
		} elseif (getenv($key) !== false) {
			return getenv($key);
		}
		return null;
	}

	function domain_url($url) {
		$pieces = parse_url($url);
		$domain = isset($pieces['host']) ? $pieces['host'] : '';
		if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
		    $url = $regs['domain'];
		}
		if(strpos($url, 'www.')===false) {$url = "www.".$url;}
   		if (substr($url, 0, 4) == 'www.') { return $url; }
		if (substr($url, 0, 7) == 'http://') { 
			if (substr($url, 0, 10) == 'http://www') { 
				return substr($url, 7); 
			}else{
				return "www.".substr($url, 7); 
			}
		}
		
		if (substr($url, 0, 8) == 'https://') { 
			if (substr($url, 0, 11) == 'https://www') { 
				return substr($url, 8); 
			}else{
				return "www.".substr($url, 8); 
			}
		}
		
 
		return  $url;
	}
}
class tf_widget_plugin extends WP_Widget {

	// constructor
	function tf_widget_plugin(){
		$widget_ops = array( 'classname' => 'tf_widget_plugin', 'description' => 'Let’s Link The Whole World Together.Trafficfeed Widget to show your partner’s link exchanges.' );
		$control_ops = array( 'id_base' => 'widget_trafficfeed' );
		$this->WP_Widget( 'widget_trafficfeed', 'Trafficfeed Widget', $widget_ops, $control_ops );
	}
	

	// widget form creation
	function form($instance) {	
		$defaults = array(
			'include_pages_label' => '',
			'title' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>">
          <?php _e( 'Title:', LANGUAGE ); ?>
          </label>
          <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id( 'tf_link_type' ); ?>">
          <?php _e( 'Display Type:' ) ?>
          </label>
          <select id="<?php echo $this->get_field_id( 'tf_link_type' ); ?>" name="<?php echo $this->get_field_name( 'tf_link_type' ); ?>">
          		<option value="1" <?php if($instance['tf_link_type']==1) { ?> selected="selected" <?php } ?>>Link Window (recommended)</option>
          		<option value="2" <?php if($instance['tf_link_type']==2) { ?> selected="selected" <?php } ?>>Link Directory</option>
          </select>
         
        </p>
		<?php 
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['tf_link_type'] = strip_tags( $new_instance['tf_link_type'] );
		return $instance;
	}

	// widget display
	function widget($args, $instance) {
		global $tf;
		
		extract( $args );
		$html = "";
		$html .= $before_widget;
		$title = apply_filters( 'widget_title', $instance['title'] );
		$link_type = $instance['tf_link_type'];
		switch ($link_type){
			case 1;
				$type = "receive_div";
			break;
			case 2:
				$type = "receive_dir";
			
			break;
			default:
				$type = "receive_div";
			break;

		}
		if ( $title == ''){
			$html .= $before_title."Trafficfeed Link Exchanges".$after_title;
		}else{
			$html .= $before_title.$title.$after_title;
		}
		
		$html .= $tf->get_html($type);
		$html .= $after_widget;
		echo $html;

	}

	
}

add_action( 'widgets_init', 'load_tf_widgets' );	
// Registering Custom Widget
function load_tf_widgets() {
	register_widget('tf_widget_plugin');
}

$tf = new tf();
if(isset($_REQUEST['tf-dismiss']) && $_REQUEST['tf-dismiss'] = 'dismiss_tf_admin_notices'){
	update_option( 'dismiss_tf_admin_notices', "hide" );
	echo "<script>window.location = '".admin_url()."'</script>";
}
?>