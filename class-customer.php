<?php
/** miniOrange enables user to log in through OAuth to apps such as Google, EVE Online etc.
    Copyright (C) 2015  miniOrange

	Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

	* @package 		miniOrange OAuth
	* @license		https://docs.miniorange.com/mit-license MIT/Expat
*/

/**
	This library is miniOrange Authentication Service.
	Contains Request Calls to Customer service.

**/
class Customer {
	
	public $email;
	public $phone;
	
	private $defaultCustomerKey = "16555";
	private $defaultApiKey = "fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq";

	function create_customer(){
		$url = get_option('host_name') . '/moas/rest/customer/add';
		
		$this->email 		= get_option('mo_oauth_admin_email');
		$this->phone 		= get_option('mo_oauth_admin_phone');
		$password 			= get_option('password');
		$firstName    		= get_option('mo_oauth_admin_fname');
		$lastName     		= get_option('mo_oauth_admin_lname');
		$company      		= get_option('mo_oauth_admin_company');
		
		$fields = array(
			'companyName' => $company,
			'areaOfInterest' => 'WP OAuth Client',
			'firstname'	=> $firstName,
			'lastname'	=> $lastName,
			'email'		=> $this->email,
			'phone'		=> $this->phone,
			'password'	=> $password
		);
		$field_string = json_encode($fields);
		$headers = array( 'Content-Type' => 'application/json', 'charset' => 'UTF - 8', 'Authorization' => 'Basic' );
		$args = array(
			'method' =>'POST',
			'body' => $field_string,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers,
 
		);
		
		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo "Something went wrong: ". esc_html($error_message);
			exit();
		}
		
		return wp_remote_retrieve_body($response);
	}
	
	function get_customer_key() {
		$url 	= get_option('host_name') . "/moas/rest/customer/key";
		$ch 	= curl_init( $url );
		$email 	= get_option("mo_oauth_admin_email");
		
		$password 			= get_option("password");
		
		$fields = array(
			'email' 	=> $email,
			'password' 	=> $password
		);
		$field_string = json_encode( $fields );
		$headers = array( 'Content-Type' => 'application/json', 'charset' => 'UTF - 8', 'Authorization' => 'Basic' );
		$args = array(
			'method' =>'POST',
			'body' => $field_string,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers,
 
		);
		
		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo "Something went wrong: ". esc_html($error_message);
			exit();
		}
		
		return wp_remote_retrieve_body($response);
	}
	
	function add_oauth_application( $name, $app_name ) {
		$url = get_option('host_name') . '/moas/rest/application/addoauth';
		
		
		$customerKey = get_option('mo_oauth_admin_customer_key');
		$scope = get_option('mo_oauth_' . $name . '_scope');
		$client_id = get_option('mo_oauth_' . $name . '_client_id');
		$client_secret = get_option('mo_oauth_' . $name . '_client_secret');
		if($scope != false) {
			$fields = array(
				'applicationName'	=> $app_name,
				'scope'				=> $scope,
				'customerId' 		=> $customerKey,
				'clientId' 			=> $client_id,
				'clientSecret' 		=> $client_secret
			);
		} else {
			$fields = array(
				'applicationName'	=> $app_name,
				'customerId' 		=> $customerKey,
				'clientId' 			=> $client_id,
				'clientSecret' 		=> $client_secret
			);
		}
		$field_string = json_encode( $fields );
		$headers = array( 'Content-Type' => 'application/json', 'charset' => 'UTF - 8', 'Authorization' => 'Basic' );
		$args = array(
			'method' =>'POST',
			'body' => $field_string,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers,
 
		);
		
		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo "Something went wrong: ". esc_html($error_message);
			exit();
		}
		
		return wp_remote_retrieve_body($response);
	}
	
	function submit_contact_us( $email, $phone, $query ) {
		global $current_user;
		wp_get_current_user();
		$query = '[WP OAuth Client] ' . $query;
		$fields = array(
			'firstName'			=> $current_user->user_firstname,
			'lastName'	 		=> $current_user->user_lastname,
			'company' 			=> sanitize_text_field($_SERVER['SERVER_NAME']),
			'email' 			=> $email,
			'ccEmail'			=> 'oauthsupport@xecurify.com',
			'phone'				=> $phone,
			'query'				=> $query
		);
		$field_string = json_encode( $fields );
		
		$url = get_option('host_name') . '/moas/rest/customer/contact-us';
		
		$headers = array( 'Content-Type' => 'application/json', 'charset' => 'UTF - 8', 'Authorization' => 'Basic' );
		$args = array(
			'method' =>'POST',
			'body' => $field_string,
			'timeout' => '15',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers,
 
		);
		
		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo "Something went wrong: ". esc_html($error_message);
			exit();
		}
		
		return wp_remote_retrieve_body($response);
	}
	
	function send_otp_token($email, $phone, $sendToEmail = TRUE, $sendToPhone = FALSE){
			$url = get_option('host_name') . '/moas/api/auth/challenge';
			
			$customerKey =  $this->defaultCustomerKey;
			$apiKey =  $this->defaultApiKey;

			$username = get_option('mo_oauth_admin_email');
			$phone=get_option('mo_oauth_admin_phone');
			/* Current time in milliseconds since midnight, January 1, 1970 UTC. */
			$currentTimeInMillis = self::get_timestamp();

			/* Creating the Hash using SHA-512 algorithm */
			$stringToHash = $customerKey . $currentTimeInMillis . $apiKey;
			$hashValue = hash("sha512", $stringToHash);

			$customerKeyHeader = "Customer-Key: " . $customerKey;
			$timestampHeader = "Timestamp: " . $currentTimeInMillis;
			$authorizationHeader = "Authorization: " . $hashValue;

			if($sendToEmail){
				$fields = array(
					'customerKey' => $customerKey,
					'email' => $username,
					'authType' => 'EMAIL',
					);}
			else{
					$fields=array(
					'customerKey'=>$customerKey,
					'phone' => $phone,
					'authType' => 'SMS');
			}
			$field_string = json_encode($fields);
			$headers = array( 'Content-Type' => 'application/json');
			$headers['Customer-Key'] = $customerKey;
			$headers['Timestamp'] = $currentTimeInMillis;
			$headers['Authorization'] = $hashValue;
			$args = array(
				'method' =>'POST',
				'body' => $field_string,
				'timeout' => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => $headers,
	
			);
			
			$response = wp_remote_post( $url, $args );
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				echo "Something went wrong: ". esc_html($error_message);
				exit();
			}
			
			return wp_remote_retrieve_body($response);
		}

		public function get_timestamp() {
		    $url = get_option ( 'host_name' ) . '/moas/rest/mobile/get-timestamp';
			$headers = array( 'Content-Type' => 'application/json', 'charset' => 'UTF - 8', 'Authorization' => 'Basic' );
			$args = array(
				'method' =>'POST',
				'body' => array(),
				'timeout' => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => $headers,

			);
			
			$response = wp_remote_post( $url, $args );
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				echo "Something went wrong: ". esc_html($error_message);
				exit();
			}
			
			return wp_remote_retrieve_body($response);
		}

		function validate_otp_token($transactionId,$otpToken){
			$url = get_option('host_name') . '/moas/api/auth/validate';
			

			$customerKey =  $this->defaultCustomerKey;
			$apiKey =  $this->defaultApiKey;

			$username = get_option('mo_oauth_admin_email');

			/* Current time in milliseconds since midnight, January 1, 1970 UTC. */
			$currentTimeInMillis = self::get_timestamp();

			/* Creating the Hash using SHA-512 algorithm */
			$stringToHash = $customerKey . $currentTimeInMillis . $apiKey;
			$hashValue = hash("sha512", $stringToHash);

			$customerKeyHeader = "Customer-Key: " . $customerKey;
			$timestampHeader = "Timestamp: " . $currentTimeInMillis;
			$authorizationHeader = "Authorization: " . $hashValue;

			$fields = '';

				//*check for otp over sms/email
				$fields = array(
					'txId' => $transactionId,
					'token' => $otpToken,
				);

			$field_string = json_encode($fields);
			$headers = array( 'Content-Type' => 'application/json');
			$headers['Customer-Key'] = $customerKey;
			$headers['Timestamp'] = $currentTimeInMillis;
			$headers['Authorization'] = $hashValue;
			$args = array(
				'method' =>'POST',
				'body' => $field_string,
				'timeout' => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => $headers,
	
			);
			
			$response = wp_remote_post( $url, $args );
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				echo "Something went wrong: ". esc_html($error_message);
				exit();
			}
			
			return wp_remote_retrieve_body($response);
	}
	
	function check_customer() {
			$url 	= get_option('host_name') . "/moas/rest/customer/check-if-exists";
			$ch 	= curl_init( $url );
			$email 	= get_option("mo_oauth_admin_email");

			$fields = array(
				'email' 	=> $email,
			);
			$field_string = json_encode( $fields );
			$headers = array( 'Content-Type' => 'application/json', 'charset' => 'UTF - 8', 'Authorization' => 'Basic' );
			$args = array(
				'method' =>'POST',
				'body' => $field_string,
				'timeout' => '5',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => $headers,
	 
			);
			
			$response = wp_remote_post( $url, $args );
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				echo "Something went wrong: ". esc_html($error_message);
				exit();
			}
			
			return wp_remote_retrieve_body($response);
	}
	
	function mo_oauth_send_email_alert($email,$phone,$message){

		if(!$this->check_internet_connection())
			return;
		$url = get_option( 'host_name' ) . '/moas/api/notify/send';
		

		$customerKey = $this->defaultCustomerKey;
		$apiKey =  $this->defaultApiKey;

		$currentTimeInMillis = self::get_timestamp();
		$stringToHash 		= $customerKey .  $currentTimeInMillis . $apiKey;
		$hashValue 			= hash("sha512", $stringToHash);
		$customerKeyHeader 	= "Customer-Key: " . $customerKey;
		$timestampHeader 	= "Timestamp: " .  $currentTimeInMillis;
		$authorizationHeader= "Authorization: " . $hashValue;
		$fromEmail 			= $email;
		$subject            = "Feedback: WordPress OAuth Client Plugin";
		$site_url=site_url();

		global $user;
		$user         = wp_get_current_user();
		$query        = '[WP OAuth 2.0 Client] : ' . $message;

		$content='<div >Hello, <br><br>First Name :'.$user->user_firstname.'<br><br>Last  Name :'.$user->user_lastname.'   <br><br>Company :<a href="'.esc_url($_SERVER['SERVER_NAME']).'" target="_blank" >'.esc_url($_SERVER['SERVER_NAME']).'</a><br><br>Phone Number :'.esc_attr($phone).'<br><br>Email :<a href="mailto:'.esc_attr($fromEmail).'" target="_blank">'.esc_attr($fromEmail).'</a><br><br>Query :'.esc_attr($query).'</div>';

		$fields = array(
			'customerKey'	=> $customerKey,
			'sendEmail' 	=> true,
			'email' 		=> array(
				'customerKey' 	=> $customerKey,
				'fromEmail' 	=> $fromEmail,
				'bccEmail' 		=> 'oauthsupport@xecurify.com',
				'fromName' 		=> 'miniOrange',
				'toEmail' 		=> 'oauthsupport@xecurify.com',
				'toName' 		=> 'oauthsupport@xecurify.com',
				'subject' 		=> $subject,
				'content' 		=> $content
			),
		);
		$field_string = json_encode($fields);
		$headers = array( 'Content-Type' => 'application/json');
		$headers['Customer-Key'] = $customerKey;
		$headers['Timestamp'] = $currentTimeInMillis;
		$headers['Authorization'] = $hashValue;
		$args = array(
			'method' =>'POST',
			'body' => $field_string,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers,

		);
		
		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo "Something went wrong: ". esc_html($error_message);
			exit();
		}
	}
	
	function mo_oauth_forgot_password($email) {
		$url = get_option ( 'host_name' ) . '/moas/rest/customer/password-reset';
		
		
		/* The customer Key provided to you */
		$customerKey = get_option ( 'mo_oauth_admin_customer_key' );
		
		/* The customer API Key provided to you */
		$apiKey = get_option ( 'mo_oauth_admin_api_key' );
		
		/* Current time in milliseconds since midnight, January 1, 1970 UTC. */
		$currentTimeInMillis = self::get_timestamp();
		
		/* Creating the Hash using SHA-512 algorithm */
		$stringToHash = $customerKey . $currentTimeInMillis . $apiKey;
		$hashValue = hash ( "sha512", $stringToHash );
		
		$customerKeyHeader = "Customer-Key: " . $customerKey;
		$timestampHeader = "Timestamp: " . number_format ( $currentTimeInMillis, 0, '', '' );
		$authorizationHeader = "Authorization: " . $hashValue;
		
		$fields = '';
		
		// *check for otp over sms/email
		$fields = array (
				'email' => $email 
		);
		
		$field_string = json_encode ( $fields );
		$headers = array( 'Content-Type' => 'application/json');
		$headers['Customer-Key'] = $customerKey;
		$headers['Timestamp'] = $currentTimeInMillis;
		$headers['Authorization'] = $hashValue;
		$args = array(
			'method' =>'POST',
			'body' => $field_string,
			'timeout' => '5',
			'redirection' => '5',
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => $headers,

		);
		
		$response = wp_remote_post( $url, $args );
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo "Something went wrong: ". esc_html($error_message);
			exit();
		}
		
		return wp_remote_retrieve_body($response);
	}
	
	function check_internet_connection() {
		return (bool) @fsockopen('login.xecurify.com', 443, $iErrno, $sErrStr, 5);
	}
	

}?>