<link href="<?php echo $this->plugin_url?>/css/style.css" rel="stylesheet" />
<link href="<?php echo $this->plugin_url?>/css/bootstrap.css" rel="stylesheet" />

<?php $token = get_option('tf_token'); ?>

<div class="wrap tf-wrap">
  <h2 class="tf_heading">Trafficfeed Settings</h2>
  <?php include('tf-header.php'); ?>
  <div id="col-container">

    <?php if($token) {
	    $user = $this->get_user_info();
		  ?>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
          <a href="javascript://" id="tf_logout" class="tf_logout btn btn-info">Logout from TrafficFeed</a>
          <a href="javascript://"  class="tf_reset btn btn-danger">Reset All Setting</a>
        </div>
      </div>
      <?php
      include('steps.php');
      if($all_steps){
  		  echo "<div class='alert alert-success'><strong>Congratulation !</strong> You have successfully finished all steps...Enjoy exchanging!!!</div>";
        }
      }
    ?>

    <?php if(!$token) {  ?>
        <div class="row margin-top-10">
          <div class="col-sm-12 col-md-6">
            <div class="panel panel-success">
              <div class="panel-heading">
                <strong> Already have TrafficFeed account?</strong>
              </div>
              <div class="panel-body">
                  <ul class="list-group">
                    <li class="list-group-item"><i class="glyphicon glyphicon-hand-right"></i>&nbsp;You have to login first to manage <strong><?php echo $this->domain_url(site_url());?></strong> domain.</li>

                    <li class="list-group-item"><i class="glyphicon glyphicon-hand-right"></i>&nbsp;Make sure that the domain <strong><?php echo $this->domain_url(site_url());?></strong> is associated with same account you going to login with.</li>
                  </ul>

                  <a href="<?php echo admin_url( 'admin.php?page=tf_login_form' );?>" class="btn btn-success btn-block" title="Login Now">Login Now</a>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                <strong> Don't have TrafficFeed.com account yet…?</strong>
              </div>
              <div class="panel-body">
                  <ul class="list-group">
                    <li class="list-group-item"><i class="glyphicon glyphicon-hand-right"></i>&nbsp;Let’s Link The Whole World Together. Take TrafficFeed for a test drive and see what it can do for you…</li>

                    <li class="list-group-item"><i class="glyphicon glyphicon-hand-right"></i>&nbsp;Register for a free account and start using Trafficfeed online marketing tools.</li>
                  </ul>

                  <a href="<?php echo admin_url( 'admin.php?page=tf_register_form' );?>" class="btn btn-info btn-block" title="Login Now">Continue</a>
              </div>
            </div>
          </div>
        </div>
    <?php  }  ?>

    <?php if($token) { ?>
      <?php if(count($user)>0){ ?>
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">
                <strong> Your details</strong>
              </div>
              <div class="panel-body">
                <ul class="list-group">
                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-hand-right"></i>&nbsp;
                    <span>Name</span>&nbsp;:&nbsp;<?php echo $user->name ;?>
                  </li>

                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-hand-right"></i>&nbsp;
                    <span>Username</span>&nbsp;:&nbsp;<?php echo $user->username ;?>
                  </li>

                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-hand-right"></i>&nbsp;
                    <span>Email</span>&nbsp;:&nbsp;<?php echo $user->email ;?>
                  </li>

                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-hand-right"></i>&nbsp;
                    <span>Balance</span>&nbsp;:&nbsp;<?php echo $user->balance ;?>
                  </li>

                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-hand-right"></i>&nbsp;
                    <span>Earning</span>&nbsp;:&nbsp;<?php echo $user->earning ;?>
                  </li>

                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-hand-right"></i>&nbsp;
                    <span>Added Sites</span>&nbsp;:&nbsp;<?php echo $user->sites ;?>
                  </li>

                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-hand-right"></i>&nbsp;
                    <span>Added Page</span>&nbsp;:&nbsp;<?php echo $user->pages ;?>
                  </li>

                  <li class="list-group-item">
                    <i class="glyphicon glyphicon-hand-right"></i>&nbsp;
                    <span>Account Status</span>&nbsp;:&nbsp;<?php echo $user->status ;?>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-sm-12 col-md-6">
            <div class="panel panel-<?php echo ($user->status =='InActive') ? 'danger' : 'info'; ?>">
              <div class="panel-heading">
                <strong><?php echo ($user->status =='InActive') ? 'Account is Inactive' : 'Domain Information'; ?></strong>
              </div>
              <div class="panel-body">
                  <?php if($user->status =='InActive') { ?>
                    <p>Please go to your inbox to verify your email address: <strong><?php echo $user->email; ?></strong>. After verifying your trafficfeed account you can start adding and exchanging pages with other verified TrafficFeed users.
                    </p>
                    <div class="well">
                      <p>Please note if you have checked you <strong>INBOX</strong> and <strong>JUNK</strong> folder and don't see email verification from us then don't worry please follow the below steps.</p>
                      <br />
                      <p>Please send us an email from your email that you <strong>REGISTERED</strong> with us, to our email address  <strong>webmaster@trafficfeed.com</strong>.</p>
                      <p>Please put <strong>"PLEASE ACTIVATE MY EMAIL NOW"</strong> in the subject line.</p>
                      <br />
                      <p>Thank You.</p>
                      <a href="http://www.trafficfeed.com" target="_blank">Trafficfeed Team.</a>
                    </div>
                  <?php } else { ?>
                    <?php if(isset($token) && $token!="") {
                      $response = json_decode($this->tf_check_domain($token));
                      ?>
                      <?php switch($response->domain->status) { 
                        case -2:
                          echo "<div class='alert alert-warning margin-top-10 margin-bottom-10' role='alert'>This domain is not linked with your account</div>";
                        break;

                        case 0:
                          echo '<p>' . $response->domain->message . '</p>';
                          $site_pages = $this->get_all_pages();
                          if(count($site_pages)>0){ 
                            if (!is_active_widget(false, false, "widget_trafficfeed", true) && $user->pages > 0) { 
                          ?>
                            <p class="alert alert-danger margin-top-10 margin-bottom-killer" >Please click on the link <a href='<?php echo admin_url('widgets.php'); ?>'>here</a>: INSTALL WIDGET Then just drag and drop 'Trafficfeed Widget' into your side bar. If you don't know how to do it <a href='https://www.youtube.com/watch?v=FPcGAxvVw0o&feature=youtu.be' target='_blank'>here</a> is the video which will help you to install the plugin.</p>
                            <?php } ?>
                            <hr />
                            <form id="tf_add_site_pages" method="post" >
                                <h4 class="text-center">Add Pages to exchange</h4>
                                <ul class="list-group tf_site_pages_list">
                                  <?php
                                    echo '<li class="list-group-item"><div class="checkbox margin-killer"><label for="checkboxes-99999"><input type="checkbox" name="add_page_tf[]" id="checkboxes-99999" value="0">' . home_url() . '</label></div></li>';
                                    foreach ( $site_pages as $key => $page ) {
                                      echo '<li class="list-group-item"><div class="checkbox margin-killer"><label for="checkboxes-'.$key.'"><input type="checkbox" name="add_page_tf[]" id="checkboxes-'.$key.'" value="'.$page->ID.'">' . $page->post_title . '</label></div></li>';
                                    }
                                  ?>
                                </ul>
                                <div>
                                  <input type="submit" id="btn_tf_add_pages" class="btn btn-primary btn-block" value="Add Selected Pages">
                                </div>
                            </form>
                            <div class="result"></div>
                          <?php } ?>
                        <?php break;

                        case 1:
                          echo "<div class='alert alert-warning margin-top-10 margin-bottom-10' role='alert'>Domain is in-active.</div>";
                          echo "<a href='javascript:/' class='active_domain btn btn-success btn-block'>Click here to verify</a></div>";
                          echo "<div id='domain_act_response'></div>";
                        break;

                        case 2:
                          $msg  ="<div class='alert alert-danger margin-top-10 margin-bottom-10' role='alert'>Your domain is either blocked or suspened.</div><br />";
                          $msg  .="<p>To contact us please click <a href='http://www.trafficfeed.com'>here</a>. </p>";
                          echo $msg;
                        break;

                        case 3:
                          $msg = '';
                          $msg .= '<h4> Add your site <strong>' . $this->domain_url(site_url()) .'</strong> in trafficfeed.com. </h4><hr />';
                          $msg .= '<a href="'. admin_url( 'admin.php?page=tf_site_info' ) .'" class="btn btn-success btn-block" title="Add your site now">Add your site</a>';
                          echo $msg;
                        break ;
                        
                        case 4:
                          echo "<div class='alert alert-danger margin-top-10 margin-bottom-10' role='alert'>This domain is not linked with your account</div>";
                        break;
                      }
                    } else { ?>
                      <?php
                        $response =  json_decode($this->tf_check_domain());
                        echo $response->domain->message;
                      ?>
                    <?php } ?>
                  <?php } ?>
              </div>
            </div>
          </div>
        </div>
      <?php } else { ?>
        <div><?php echo $user->message;?></div>
      <?php } ?>
    <?php } ?>
  </div>
 
  <div class="row">
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
      <div class="result" style="display:none"></div>
    </div>
  </div>
</div>