<?php

//include_once dirname( __FILE__ ) . '/eveonline/vendor/autoload.php';
//use Pheal\Pheal;
//use Pheal\Core\Config;

class Mo_Oauth_Widget extends WP_Widget {

	public function __construct() {
		update_option( 'host_name', 'https://login.xecurify.com' );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'init', array( $this, 'mo_oauth_start_session' ) );
		add_action( 'wp_logout', array( $this, 'mo_oauth_end_session' ) );
		add_action( 'login_form', array( $this, 'mo_oauth_wplogin_form_button' ) );
		parent::__construct( 'mo_oauth_widget', 'miniOrange OAuth', array( 'description' => __( 'Login to Apps with OAuth', 'flw' ), ) );

	 }

	 function mo_oauth_wplogin_form_style(){
		wp_enqueue_style( 'mo_oauth_fontawesome', plugins_url( 'css/font-awesome.css', __FILE__ ) );
		wp_enqueue_style( 'mo_oauth_wploginform', plugins_url( 'css/login-page.css', __FILE__ ), array(),MO_OAUTH_CSS_JS_VERSION );
	}

	 function mo_oauth_wplogin_form_button() {
		$appslist = get_option('mo_oauth_apps_list');
		if(is_array($appslist) && sizeof($appslist) > 0){
			$this->mo_oauth_load_login_script();
			foreach($appslist as $key => $app){

				if(isset($app['show_on_login_page']) && $app['show_on_login_page'] === 1){
					$appgroup = get_option("mo_oauth_app_name_".$key);
						if( $key=='EveOnlineApp' || $appgroup == 'EveOnlineApp' ) {
							$imageurl = plugins_url( 'images/icons/eveonline.png', __FILE__ );
							$bcolor = 'btn-github';
							$logo_class = 'fa fa-bars';
						}
						elseif( $key=='facebook' || $appgroup == 'facebook' ) {
							$imageurl = plugins_url( 'images/icons/facebook.png', __FILE__ );
							$bcolor = 'btn-facebook';
							$logo_class='fa fa-facebook';
						}
						elseif( $key=='google' || $appgroup == 'google' ) {
							$imageurl = plugins_url( 'images/icons/google.png', __FILE__ );
							$bcolor = 'btn-google';
							$logo_class='fa fa-google';
						}
						elseif( $key=='windows' || $appgroup == 'windows' ) {
							$imageurl = plugins_url( 'images/icons/windowslive.png', __FILE__ );
							$bcolor = 'btn-microsoft';
							$logo_class='fa fa-windows ';
						}
						elseif( $key=='cognito' || $appgroup == 'cognito' ) {
							$imageurl = plugins_url( 'images/icons/windowslive.png', __FILE__ );
							$bcolor = 'btn-openid';
							$logo_class='fa fa-amazon';
						}
						elseif( $key=='linkedin' || $appgroup == 'linkedin' ) {
							$imageurl = plugins_url( 'images/icons/windowslive.png', __FILE__ );
							$bcolor = 'btn-linkedin';
							$logo_class='fa fa-linkedin ';
						}
						elseif( $key=='github' || $appgroup == 'github' ) {
							$imageurl = plugins_url( 'images/icons/windowslive.png', __FILE__ );
							$bcolor = 'btn-github';
							$logo_class='fa fa-github ';
						}
						elseif( $key=='gitlab' || $appgroup == 'gitlab' ) {
							$imageurl = plugins_url( 'images/icons/windowslive.png', __FILE__ );
							$bcolor = 'btn-danger';
							$logo_class='fa fa-gitlab ';
						}
						else
						{
						    $logo_class = 'fa fa-lock';
							$imageurl = "";
						}
					$this->mo_oauth_wplogin_form_style();

					echo '<br>';
					echo '<h4>Connect with :</h4><br>';
					echo '<div class="row">';
					echo '<a style="text-decoration:none" href="javascript:void(0)" onClick="moOAuthLoginNew(\''.esc_attr($key).'\');"><div class="mo_oauth_login_button mo_oauth_login_button_text"><i class="'.esc_attr($logo_class).' mo_oauth_login_button_icon"></i>Login with '.esc_attr(ucwords($key)).'</div></a>';	
					echo '</div><br><br>';
				}
			}
		}
	}


	function mo_oauth_start_session() {
		if( ! session_id() && ! is_ajax_request() && ! is_rest_api_call() ) {
			session_start();
		}

		if(isset($_REQUEST['option']) and $_REQUEST['option'] == 'testattrmappingconfig'){
			$mo_oauth_app_name = sanitize_text_field($_REQUEST['app']);
			wp_redirect(site_url().'?option=oauthredirect&app_name='. urlencode($mo_oauth_app_name)."&test=true");
			exit();
		}

	}

	function mo_oauth_end_session() {
		if( ! session_id() )
		{ 	session_start();
        }
		session_destroy();
	}

	public function widget( $args, $instance ) {
		extract( $args );

		echo $args['before_widget'];
		if ( ! empty( $wid_title ) ) {
			echo $args['before_title'] . $wid_title . $args['after_title'];
		}
		$this->mo_oauth_login_form();
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		if(isset($new_instance['wid_title']))
			$instance['wid_title'] = strip_tags( $new_instance['wid_title'] );
		return $instance;
	}

	public function mo_oauth_login_form() {

		global $post;
		$this->error_message();
	    $temp = '';
		$appsConfigured = get_option('mo_oauth_google_enable') | get_option('mo_oauth_eveonline_enable') | get_option('mo_oauth_facebook_enable');

		$appslist = get_option('mo_oauth_apps_list');
		if( $appslist && sizeof( $appslist ) > 0 )
			$appsConfigured = true;

		if( ! is_user_logged_in() ) {
			if( isset($appsConfigured) && $appsConfigured ) {
				$this->mo_oauth_load_login_script();
				$style = get_option('mo_oauth_icon_width') ? "width:".get_option('mo_oauth_icon_width').";" : "";
                $style .= get_option('mo_oauth_icon_height') ? "height:".get_option('mo_oauth_icon_height').";" : "";
                $style .= get_option('mo_oauth_icon_margin') ? "margin:".get_option('mo_oauth_icon_margin').";" : "";
				$custom_css = get_option('mo_oauth_icon_configure_css');

				if(empty($custom_css))
                    echo '<style>.oauthloginbutton{background: #7272dc;height:40px;padding:8px;text-align:center;color:#fff;}</style>';
       			else
       			    echo '<style>'. esc_attr($custom_css) .'</style>';


				if( is_array( $appslist ) ) {
					foreach($appslist as $key=>$app) {
						$appgroup = get_option("mo_oauth_app_name_".$key);
						if( $key=='EveOnlineApp' || $appgroup == 'EveOnlineApp' ) {
							$imageurl = plugins_url( 'images/icons/eveonline.png', __FILE__ );
							$bcolor = 'btn-github';
							$logo_class = 'fa fa-bars';
						}
						elseif( $key=='facebook' || $appgroup == 'facebook' ) {
							$imageurl = plugins_url( 'images/icons/facebook.png', __FILE__ );
							$bcolor = 'btn-facebook';
							$logo_class='fa fa-facebook';
						}
						elseif( $key=='google' || $appgroup == 'google' ) {
							$imageurl = plugins_url( 'images/icons/google.png', __FILE__ );
							$bcolor = 'btn-google';
							$logo_class='fa fa-google';
						}
						elseif( $key=='windows' || $appgroup == 'windows' ) {
							$imageurl = plugins_url( 'images/icons/windowslive.png', __FILE__ );
							$bcolor = 'btn-microsoft';
							$logo_class='fa fa-windows ';
						}
						elseif( $key=='cognito' || $appgroup == 'cognito' ) {
							$imageurl = plugins_url( 'images/icons/windowslive.png', __FILE__ );
							$bcolor = 'btn-openid';
							$logo_class='fa fa-amazon';
						}
						elseif( $key=='linkedin' || $appgroup == 'linkedin' ) {
							$imageurl = plugins_url( 'images/icons/windowslive.png', __FILE__ );
							$bcolor = 'btn-linkedin';
							$logo_class='fa fa-linkedin ';
						}
						elseif( $key=='github' || $appgroup == 'github' ) {
							$imageurl = plugins_url( 'images/icons/windowslive.png', __FILE__ );
							$bcolor = 'btn-github';
							$logo_class='fa fa-github ';
						}
						elseif( $key=='gitlab' || $appgroup == 'gitlab' ) {
							$imageurl = plugins_url( 'images/icons/windowslive.png', __FILE__ );
							$bcolor = 'btn-danger';
							$logo_class='fa fa-gitlab ';
						}
						else
						{
						    $logo_class = 'fa fa-lock';
							$imageurl = "";
						}

						//set display name on login button
						$appclass = "oauth_app_".str_replace(" ","-",$key);

						if (array_key_exists('displayappname', $app) && !empty($app['displayappname']) ) {
							$disp_name = $app['displayappname'];
						} else {
							$disp_name = ucwords($key);
						}

						$appgroup= " ";
						echo '<a style="text-decoration:none" href="javascript:void(0)" onClick="moOAuthLoginNew(\''.esc_attr($key).'\');"><div class="mo_oauth_login_button_widget"><i class="'.esc_attr($logo_class).' mo_oauth_login_button_icon_widget"></i><h3 class="mo_oauth_login_button_text_widget">Login with '.esc_attr(ucwords($key)).'</h3></div></a>';

					}
	            }

			} else {
				echo '<div>No apps configured.</div>';
			}
		} else {
			$current_user = wp_get_current_user();
            $link_with_username = __('Howdy, ', 'flw') . $current_user->display_name;
            echo "<div id=\"logged_in_user\" class=\"login_wid\">
            <li>".$link_with_username." | <a href=\"".wp_logout_url( site_url() )."\" >Logout</a></li>
            </div>";
		}
		return $temp;

	}//end of function mo_oauth_login_form


	private function mo_oauth_load_login_script() {
	?>
	<script type="text/javascript">

		function HandlePopupResult(result) {
			window.location.href = result;
		}

		function moOAuthLoginNew(app_name) {
			window.location.href = '<?php echo esc_attr(site_url()); ?>' + '/?option=oauthredirect&app_name=' + app_name;
		}
	</script>
	<?php
	}


	public function error_message() {
		if( isset( $_SESSION['msg'] ) and $_SESSION['msg'] ) {
			echo '<div class="' . esc_attr($_SESSION['msg_class']) . '">' . esc_attr($_SESSION['msg']) . '</div>';
			unset( $_SESSION['msg'] );
			unset( $_SESSION['msg_class'] );
		}
	}

	public function register_plugin_styles() {
		wp_enqueue_style( 'style_login_widget', plugins_url( 'css/style_login_widget.css', __FILE__ ) );
	}


}
	function mo_oauth_login_validate(){

		/* Handle Eve Online old flow */
		if( isset( $_REQUEST['option'] ) and strpos( $_REQUEST['option'], 'oauthredirect' ) !== false ) {
			$appname = sanitize_text_field($_REQUEST['app_name']);
			$appslist = get_option('mo_oauth_apps_list');

			if(isset($_REQUEST['test']))
				setcookie("mo_oauth_test", true, null, null, null, true, true);
			else
				setcookie("mo_oauth_test", false, null, null, null, true, true);

			foreach($appslist as $key => $app){
				if($appname==$key){

					$state = base64_encode($appname);
					$authorizationUrl = $app['authorizeurl'];
					if(strpos($authorizationUrl, "google") !== false) {
						$authorizationUrl = "https://accounts.google.com/o/oauth2/auth";
					}
					if(strpos($authorizationUrl, '?' ) !== false)
					$authorizationUrl = $authorizationUrl."&client_id=".$app['clientid']."&scope=".$app['scope']."&redirect_uri=".$app['redirecturi']."&response_type=code&state=".$state;
				    else 
					$authorizationUrl = $authorizationUrl."?client_id=".$app['clientid']."&scope=".$app['scope']."&redirect_uri=".$app['redirecturi']."&response_type=code&state=".$state;

					if(session_id() == '' || !isset($_SESSION))
						session_start();
					$_SESSION['oauth2state'] = $state;
					$_SESSION['appname'] = $appname;

					header('Location: ' . $authorizationUrl);
					exit;
				}
			}
		}

		else if( isset( $_REQUEST['code']) && isset($_REQUEST['state'] ) ) {  

			if(session_id() == '' || !isset($_SESSION))
				session_start();

			// OAuth state security check
			/*
			if (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {
				if (isset($_SESSION['oauth2state'])) {
					unset($_SESSION['oauth2state']);
				}
				exit('Invalid state');
			} */

			if (!isset($_GET['code'])){
				if(isset($_GET['error_description']))
					exit(esc_html($_GET['error_description']));
				else if(isset($_GET['error']))
					exit(esc_html($_GET['error']));
				exit('Invalid response');
			} else {

				try {

					$currentappname = "";

					if (isset($_SESSION['appname']) && !empty($_SESSION['appname']))
						$currentappname = sanitize_text_field($_SESSION['appname']);
					else if (isset($_GET['state']) && !empty($_GET['state'])){
						$currentappname = sanitize_text_field(base64_decode($_GET['state']));
					}

					if (empty($currentappname)) {
						exit('No request found for this application.');
					}

					$appslist = get_option('mo_oauth_apps_list');
					$email_attr = "";
					$currentapp = false;
					foreach($appslist as $key => $app){
						if($key == $currentappname){
							$currentapp = $app;
							if(isset($app['email_attr'])){
								$email_attr = $app['email_attr'];
							}
						}
					}

					if (!$currentapp)
						exit('Application not configured.');

					$mo_oauth_handler = new Mo_OAuth_Hanlder();
					$accessTokenUrl = $currentapp['accesstokenurl'];
					if(strpos($accessTokenUrl, "google") !== false) {
						$accessTokenUrl = "https://www.googleapis.com/oauth2/v4/token";
					}
					$accessToken = $mo_oauth_handler->getAccessToken($accessTokenUrl, 'authorization_code',
						$currentapp['clientid'], $currentapp['clientsecret'], sanitize_text_field($_GET['code']), $currentapp['redirecturi']);

					if(!$accessToken)
						exit('Invalid token received.');

					$resourceownerdetailsurl = $currentapp['resourceownerdetailsurl'];
					if (substr($resourceownerdetailsurl, -1) == "=") {
						$resourceownerdetailsurl .= $accessToken;
					}
					if(strpos($resourceownerdetailsurl, "google") !== false) {
						$resourceownerdetailsurl = "https://www.googleapis.com/oauth2/v1/userinfo";
					}
					$resourceOwner = $mo_oauth_handler->getResourceOwner($resourceownerdetailsurl, $accessToken);

					$email = "";
						
						
					//TEST Configuration
					if(isset($_COOKIE['mo_oauth_test']) && $_COOKIE['mo_oauth_test']){
						echo '<style>table{border-collapse: collapse;}table, td, th {border: 1px solid black;padding:4px}</style>';
						echo "<h2>Test Configuration</h2><table><tr><th>Attribute Name</th><th>Attribute Value</th></tr>";
						testattrmappingconfig("",$resourceOwner);
						echo "</table>";
						exit();
					}
					
					// Eve Checks
					if(strpos(strtolower($currentappname), 'eveonline' ) !== false){
						$characterID = getnestedattribute($resourceOwner, 'CharacterID');
						if(!empty($characterID)) {
							$eveUserObject = $mo_oauth_handler->getResponse("https://esi.evetech.net/latest/characters/".$characterID."/?datasource=tranquility");
							$eveUser = json_decode($eveUserObject,true);
							$alliance_id = getnestedattribute($eveUser, 'alliance_id');
							$corporation_id = getnestedattribute($eveUser, 'corporation_id');	
							
							$corporations 	= get_option('mo_eve_allowed_corps');
							$alliances 		= get_option('mo_eve_allowed_alliances');
							$characterIds = get_option('mo_eve_allowed_char_name');
							
							if(!empty($corporations)) {
								$corporations = explode(",",$corporations);
								if (!in_array($corporation_id, $corporations))
									wp_die("Your corporation is not allowed to login. Contact administrator.");
							}
							
							if(!empty($alliances)) {
								$alliances = explode(",",$alliances);
								if (!in_array($alliance_id, $alliances))
									wp_die("Your alliance is not allowed to login. Contact administrator.");
							}
							
							if(!empty($characterIds)) {
								$characterIds = explode(",",$characterIds);
								if (!in_array($characterID, $characterIds))
									wp_die("Your character is not allowed to login. Contact administrator.");
							}
						}
					}

					if(!empty($email_attr))
						$email = getnestedattribute($resourceOwner, $email_attr); 
					
					if(empty($email))
						wp_die('Email address not received. Check your <b>Attribute Mapping</b> configuration.');
					
					$user = get_user_by("login",$email);
					if(!$user)
						$user = get_user_by( 'email', $email);

					if($user){
						$user_id = $user->ID;
					}
					else {
						$user_id = 0;
						if(mo_oauth_hbca_xyake()) {
							mo_oauth_jhuyn_jgsukaj($email);			
						} else {
							mo_oauth_hjsguh_kiishuyauh878gs($email);
                            $user = get_user_by( 'login', $email);
                            $user_id = $user->ID;
						}
					}

					if($user_id){
						wp_set_current_user($user_id);
						wp_set_auth_cookie($user_id);
						$user  = get_user_by( 'ID',$user_id );
						do_action( 'wp_login', $user->user_login, $user );
						wp_redirect(home_url());

						//$relaystate = home_url();
						//echo '<script>window.opener.HandlePopupResult("'.$relaystate.'");window.close();</script>';
						exit;

					}


				} catch (Exception $e) {

					// Failed to get the access token or user details.
					//print_r($e);
					exit($e->getMessage());

				}

			}

		}
	}


	function mo_oauth_hjsguh_kiishuyauh878gs($email)
	{
		$random_password = wp_generate_password( 10, false );
		if(is_email($email))
			$user_id = wp_create_user( $email, $random_password, $email );
		else
			$user_id = wp_create_user( $email, $random_password);					
		$user = get_user_by( 'login', $email);						
		wp_update_user( array( 'ID' => $user_id) );
	}

	//here entity is corporation, alliance or character name. The administrator compares these when user logs in
	function mo_oauth_check_validity_of_entity($entityValue, $entitySessionValue, $entityName) {

		$entityString = $entityValue ? $entityValue : false;
		$valid_entity = false;
		if( $entityString ) {			//checks if entityString is defined
			if ( strpos( $entityString, ',' ) !== false ) {			//checks if there are more than 1 entity defined
				$entity_list = array_map( 'trim', explode( ",", $entityString ) );
				foreach( $entity_list as $entity ) {			//checks for each entity to exist
					if( $entity == $entitySessionValue ) {
						$valid_entity = true;
						break;
					}
				}
			} else {		//only one entity is defined
				if( $entityString == $entitySessionValue ) {
					$valid_entity = true;
				}
			}
		} else {			//entity is not defined
			$valid_entity = false;
		}
		return $valid_entity;
	}

	function testattrmappingconfig($nestedprefix, $resourceOwnerDetails){
		foreach($resourceOwnerDetails as $key => $resource){
			if(is_array($resource) || is_object($resource)){
				if(!empty($nestedprefix))
					$nestedprefix .= ".";
				testattrmappingconfig($nestedprefix.$key,$resource);
			} else {
				echo "<tr><td>";
				if(!empty($nestedprefix))
					echo esc_attr($nestedprefix).".";
				echo esc_attr($key)."</td><td>".esc_attr($resource)."</td></tr>";
			}
		}
	}

	function getnestedattribute($resource, $key){
		//echo $key." : ";print_r($resource); echo "<br>";
		if(empty($key))
			return "";

		$keys = explode(".",$key);
		if(sizeof($keys)>1){
			$current_key = $keys[0];
			if(isset($resource[$current_key]))
				return getnestedattribute($resource[$current_key], str_replace($current_key.".","",$key));
		} else {
			$current_key = $keys[0];
			if(isset($resource[$current_key]))
				return $resource[$current_key];
		}
	}

	function register_mo_oauth_widget() {
		register_widget('mo_oauth_widget');
	}

	function is_ajax_request() {
		return defined('DOING_AJAX') && DOING_AJAX;
	}

	function is_rest_api_call() {
		return strpos( $_SERVER['REQUEST_URI'], '/wp-json' ) == false;
	}

	add_action('widgets_init', 'register_mo_oauth_widget');
	add_action( 'init', 'mo_oauth_login_validate' );
?>