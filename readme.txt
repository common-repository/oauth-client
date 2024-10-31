=== OAuth 2.0 client for SSO ===
Contributors: cyberlord92
Tags: oauth, oauth 2.0, single sign-on, wordpress sso, azure login
Requires at least: 3.0.1
Tested up to: 6.1
Stable tag: 1.11.5
License: MIT/Expat
License URI: https://docs.miniorange.com/mit-license

Allows WordPress Login with your Eve Online, Slack, Discord or any custom OAuth server (OAuth Provider) with OAuth 2.0 standard

== Description ==

WordPress OAuth Client (WordPress OAuth 2.0 Client / Login) plugin allows login with your Eveonline, Clever, Slack, Discord, Custom OAuth server, Openid Connect provider. OAuth Client plugin works with any OAuth provider that conforms to the OAuth 2.0 standard which provides quick & easy configuration.

= Use Cases =
* Login with Azure (Azure Login)
* Login with Facebook (Facebook Login)
* Login with AWS Cognito (AWS Cognito Login)
* Login with Social Apps


= FREE VERSION FEATURES =

*	WordPress OAuth Login supports single sign-on / SSO with any 3rd party OAuth / OpenIDConnect server or custom OAuth / OpenIDConnect server like Amazon, Azure B2C, Office 365, Google, Facebook, etc.
*   SSO Grant Support - Standard OAuth 2.0 Grant :  Authorization Code
*   Auto Create Users : After SSO, new user automatically gets created in WordPress
*	Account Linking : After user SSO to WordPress, if user already exists in WordPress, then his profile gets updated or it will create a new WordPress User
*	Attribute Mapping : OAuth Login supports username Attribute Mapping feature to map WordPress user profile username attribute.
*	Login Widget : Use Widgets to easily integrate the login link with your WordPress site
*	OpenID Connect / OAuth Provider Support : OAuth Login supports only one OpenID Connect / OAuth Provider.
*	Redirect URL after Login : OAuth Login Automatically Redirects user after successful login.
*	Logging :  If you run into issues OAuth Login can be helpful to enable debug logging


= STANDARD VERSION FEATURES =

*	All the FREE Version Features included.
*   SSO Grant Support - Standard OAuth 2.0 Grant :  Authorization Code
*	Optionally Auto Register Users : OAuth Login does automatic user registration after login if the user is not already registered with your site
*	Basic Role Mapping :  OAuth Login provides basic Attribute Mapping feature to map WordPress user profile attributes like username, firstname, lastname, email and profile picture. Manage username & email with data provided.
                          Also, Assign default role to user registering through OAuth Login based on rules you define.
*	Support for Shortcode : Use shortcode to place OAuth login button anywhere in your Theme or Plugin
*	Customize Login Buttons / Icons / Text : Wide range of OAuth Login Buttons/Icons and it allows you to customize Text shadow
*	Custom Redirect URL after Login : WordPress OAuth SSO provides auto redirection and this is useful if you wanted to globally protect your whole site
*	Custom Redirect URL after logout : WordPress OAuth SSO allows you to auto redirect Users to custom URL after he logs out from your WordPress site


= PREMIUM VERSION FEATURES =

*	All the STANDARD Version Features
*   SSO Grant Support - Standard OAuth2.0 Grants: Authorization Code, Implicit Grant, Password Grant, Refresh Token Grant (Customization Available)
*	Advanced Role Mapping : Assign roles to users registering through OAuth Login based on rules you define.
*	Force Authentication / Protect Complete Site : Allows user to restrict login / authorization for particular site
*	Multiple Userinfo Endpoints Support : OAuth Login supports multiple Userinfo Endpoints.
*	App domain specific Registration Restrictions : OAuth Login restricts registration on your site based on the person's email address domain
*	Multi-site Support : OAuth Login have unique ability to support multiple sites under one account

= ENTERPRISE VERSION FEATURES =

*	All the PREMIUM Version Features
*	Multiple OAuth / OpenID Connect Provider Support
*   SSO Grant Support - Standard OAuth2.0 Grants : Authorization Code, Implicit Grant, Password Grant, Refresh Token Grant, Client Credential Grant (Customization Available)
*	Single Login button for Multiple Apps : It provides single login button for multiple providers
*	Extended OAuth API support : Extend OAuth API support to extend functionality to the existing OAuth client.
*	BuddyPress Attribute Mapping : OAuth Login allows BuddyPress Attribute Mapping.
*	Page Restriction according to roles : Limit Access to pages based on user status or roles. This WordPress OAuth Login plugin allows you to restrict access to the content of a page or post to which only certain group of users can access.
*	WP Hooks for Different Events : Provides support for different hooks for user defined functions
*	Login Reports : OAuth Login creates user login and registration reports based on application used.


= No SSL restriction =
*	Login to WordPress using Google credentials (Google Apps Login) or any other app without having an SSL or HTTPS enabled site.

= List of popular OAuth Providers we support =
*	Eve Online
*	Azure AD
*	AWS Cognito
*   WHMCS
*   Ping Federate (Ping / Ping Identity)
*	Slack
*	Discord
*	HR Answerlink / Support center
*	WSO2
*	Wechat
*	Weibo
*   LinkedIn
*	Gitlab
*	Shibboleth
*	Blizzard (Formerly Battle.net)
*	servicem8
*	Meetup
*	Gluu Server
*   WSO2
*	NetIQ
* 	Centrify
*   Azure AD
*   Azure B2C
*   Egnyte
*   Twitter
*   OpenAM
*   Egnyte

= List of popular OpenID Connect (OIDC) Providers we support =
*	Amazon
*	Salesforce
*	PayPal
*	Google
*	AWS Cognito
*	Okta
*	OneLogin
*	Yahoo
*	ADFS
*	Gigya
*   Swiss-RX-Login (Swiss RX Login)
*   Azure AD
*   Azure B2C
*   OpenAM
*   Centrify
*   Egnyte
*   DID.app

= List of grant types we support =
*   Authorization code grant
*   Implicit grant
*   Resource owner credentials grant
*   Client credentials grant
*   Refresh token grant


= Other OAuth Providers we support =
*	Other OAuth Providers OAuth Login (OAuth client) plugin support includes Foursquare, Harvest, Mailchimp, Bitrix24, Spotify, Vkontakte, Huddle, Reddit, Strava, Ustream, Yammer, RunKeeper, Instagram, SoundCloud, Pocket, PayPal, Pinterest, Vimeo, Nest, Heroku, DropBox, Buffer, Box, Hubic, Deezer, DeviantArt, Delicious, Dailymotion, Bitly, Mondo, Netatmo, Amazon, WHMCS, FitBit, Clever, Sqaure Connect, Windows, Dash 10, Github, Invision Comminuty, Blizzar, authlete, Keycloak etc.


== Installation ==

= From your WordPress dashboard =
1. Visit `Plugins > Add New`
2. Search for `WordPress OAuth Login`. Find and Install `WordPress OAuth Login`
3. Activate the plugin from your Plugins page

= From WordPress.org =
1. Download WordPress OAuth Login.
2. Unzip and upload the `miniorange-oauth-login` directory to your `/wp-content/plugins/` directory.
3. Activate miniOrange OAuth from your Plugins page.

= Once Activated =
1. Go to `Settings-> miniOrange OAuth -> Configure OAuth`, and follow the instructions
2. Go to `Appearance->Widgets` ,in available widgets you will find `miniOrange OAuth` widget, drag it to chosen widget area where you want it to appear.
3. Now visit your site and you will see login with widget.


== Frequently Asked Questions ==
= I need to customize the plugin or I need support and help? =
Please email us at info@xecurify.com or <a href="http://miniorange.com/contact" target="_blank">Contact us</a>. You can also submit your query from plugin's configuration page.

= I don't see any applications to configure. I only see Register to miniOrange? =
Our very simple and easy registration lets you register to miniOrange. OAuth login works if you are connected to miniOrange. Once you have registered with a valid email-address and phone number, you will be able to configure applications for OAuth.

= How to configure the applications? =
When you want to configure a particular application, you will see a Save Settings button, and beside that a Help button. Click on the Help button to see configuration instructions.


<code>
add_action( 'show_user_profile', 'mo_oauth_my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'mo_oauth_my_show_extra_profile_fields' );
</code>


= I need integration of this plugin with my other installed plugins like BuddyPress, etc.? =
We will help you in integrating this plugin with your other installed plugins. Please email us at info@xecurify.com or <a href="http://miniorange.com/contact" target="_blank">Contact us</a>. You can also submit your query from plugin's configuration page.

= I verified the OTP received over my email and entering the same password that I registered with, but I am still getting the error message - "Invalid password." =
Please write to us at info@xecurify.com and we will get back to you very soon.

= For any other query/problem/request =
Please email us at info@xecurify.com or <a href="http://miniorange.com/contact" target="_blank">Contact us</a>. You can also submit your query from plugin's configuration page.

== Screenshots ==

1. Add OAuth Applications
2. List of Apps
2. Configure Custom OAuth Application

== Changelog ==

= 1.11.5 =
* Added compatibility with WP 6.1
* UI updates
* Minor security fixes
* Some bug fixes

= 1.11.4 =
* Security fixes

= 1.11.3 =
* Added compatibility with WordPress 6.0
* Minor fixes

= 1.11.2 =
* Added compatibility with WordPress 5.9
* Added an option to show SSO login button on wp-login form

= 1.11.1 =
* Security Fixes

= 1.11.0 =
* Updated FAQ links
* Minor changes in Licensing plans

= 1.10.8 =
* updated setup guide

= 1.10.7 =
* Pricing Update

= 1.10.6 =
* Dropdown with input box in Attribute mapping
* Update the Add on page

= 1.10.5 =
* Added bug fixes
* Added UI changes
* Added new Licensing plans

= 1.10.4 =
* Added some bug fixes
* Added compatibility fixes with WordPress 5.4

= 1.10.3 =
* UI updates

= 1.10.2 =
* UI Fixes

= 1.10.1 =
* Fixed login issue
* Fixed registration issue

= 1.10.0 =
* Updated plugin licensing
* Added compatibility for WordPress Version 5.3.2
* Added Compatibility for php7.4
* Bugfixes for Custom Appname Issue, registration, Login Widget, Shortcode, Login flow

= 1.9.1 =
* Minor Bugfixes
* Support Special Characters in scope field

= 1.9.0 =
* Updated contact-us api
* Added comptibility for WordPress v5.1 and above

= 1.8.1 =
* Added support for customized Eve APIs

= 1.8.0 =
* Updated Google APIs
* Fixed cURL issues 

= 1.6.0 =
* Updated Licensing Plan

= 1.5.0 =
* Added Auto Create User feature

= 1.4.0 =
* Bug fixes for 'Vulnerable Link' issue

= 1.3.4 =
* Updated OAuth Guide link

= 1.3.3 =
* Added Eve Online Corporation and Alliance Restriction

= 1.2.2 =
* Timestamp issue fixed

= 1.2.1 =
* Added Custom Display Button

= 1.1.1 =
* First version with supported applications as slack, discord, aws, google, facebook