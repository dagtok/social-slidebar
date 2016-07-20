<?php

add_action('init','kbl_ssb_of_options');

if (!function_exists('kbl_ssb_of_options')) {
	function kbl_ssb_of_options(){
	
	//Plugin Shortname
	$shortname = "Kiibal";
	$data = get_option('kbl_ssb_of_template');
	
	//Populate the options array
	global $kbl_ssb_options;
	$kbl_ssb_options = get_option('kbl_ssb_of_options');

	//Folder Paths for "type" => "images"
	$sampleurl =  plugins_url() . '/social-slidebar/admin/images/sample-layouts/';

	$options = array();


	/*---------------------- Option Page 1 - Appearance Options--------------------------------------------	*/

	/* Page Name */
	$options[] = array( "name" => __('Appearance','framework_localize'),
				"type" => "heading");

	/* Begin the appearance options */
	$options[] = array( "name" => __('Animation Update Interval','framework_localize'),
				"desc" => __('Specify update interval in seconds','framework_localize'),
				"id" => $shortname."_updateInterval",
				"std" => "1",
				"type" => "select",
				"options" => array(
							'0' => '0',
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
							'8' => '8',
							'9' => '9',
							'10' => '10',
							'11' => '15',
							'12' => '30',
							'13' => '45',
							'14' => '60',
							'15' => '120',
							'16' => '180',
							'17' => '240',
							'18' => '300',
							'19' => '360',
							'20' => '420',
							'21' => '480',
							'22' => '540',
							'23' => '600',
							'23' => '1200',
							'23' => '600',
							)
				);

	$options[] = array( "name" => __('Menu background color','framework_localize'),
				"desc" => __('Select a color.','framework_localize'),
				"id" => $shortname."_bcolor",
				"std" => "",
				"type" => "color");	

	$options[] = array( "name" => __('Menu Position','framework_localize'),
				"desc" => __('Select the position.','framework_localize'),
				"id" => $shortname."_position",
				"std" => "1",
				"type" => "select",
				"options" => array(
							'0%' => 'Top',
							'42%' => 'Middle')
				);

	/* End the appearance options */



	

	/*---------------------- Option Page 2 - Facebook Settings--------------------------------------------	*/

	/* Page Name */
	$options[] = array( "name" => __('Facebook','framework_localize'),
				"type" => "heading");
    

    /* Begin the Facebook Settings */
    $options[] = array( "name" => __('Facebook','framework_localize'),
				"desc" => __('Activate Facebook Tab in Social Slidebar','framework_localize'),
				"id" => $shortname."_isFacebook",
	    		'std' => ( '1' == get_option( 'lang_id' ) ) ? TRUE : FALSE,
				"type" => "checkbox");

	$options[] = array( "name" => __('Facebook name','framework_localize'),
				"desc" => "Your Facebook username.",
				"id" => $shortname."_fb_user_name",
				"std" => "",
				"type" => "text");

	$options[] = array( "name" => __('Profile Type','framework_localize'),
				"desc" => __('Is a facebook page?','framework_localize'),
				"id" => $shortname."_isFacebookPage",
	    		'std' => ( '1' == get_option( 'lang_id' ) ) ? TRUE : FALSE,
				"type" => "checkbox");
				
	$options[] = array( "name" => __('Access Token','framework_localize'),
				"desc" => "Specify the access token gotten when you created your app. If you dont have one make click to <a href=\"http://afternoon-fire-1224.herokuapp.com/facebook/\" target=\"_blank\">get a facebook acess token</a>",
				"id" => $shortname."_fb_access_token",
				"std" => "",
				"type" => "text");

	/* End the Facebook Settings */






	/*---------------------- Option Page 3 - Flickr Settings--------------------------------------------	*/

	/* Page Name */
	$options[] = array( "name" => __('Flickr','framework_localize'),
				"type" => "heading");
	

	/* Begin the flickr settings */
	$options[] = array( "name" => __('Flickr','framework_localize'),
				"desc" => __('Activate Flickr Tab in Social Slidebar','framework_localize'),
				"id" => $shortname."_isFlickr",
	    		'std' => ( '1' == get_option( 'lang_id' ) ) ? TRUE : FALSE,
				"type" => "checkbox");

	$options[] = array( "name" => __('User Access Token','framework_localize'),
				"desc" => "Specify the access token gotten when you created your app. If you dont have one make click to <a href=\"http://afternoon-fire-1224.herokuapp.com/flickr/\" target=\"_blank\">get a flickr acess token</a>",
				"id" => $shortname."_fk_user_access_token",
				"std" => "",
				"type" => "text");

	$options[] = array( "name" => __('User ID','framework_localize'),
				"desc" => "Specify the \"User ID\"",
				"id" => $shortname."_fk_user_id",
				"std" => "",
				"type" => "text");

	/* End the flickr settings */

	





	/*-------------------------- Option Page 4 - Google Accounts Settings -----------------------------------*/

	/* Page Name */ 
	$options[] = array( "name" => __('Google Accounts','framework_localize'),
				"type" => "heading");
	
	/* Begin the Google Settings */
	$options[] = array( "name" => __('Google Plus','framework_localize'),
				"desc" => __('Activate Google Plus Tab in Social Slidebar','framework_localize'),
				"id" => $shortname."_isGooglePlus",
	    		'std' => ( '1' == get_option( 'lang_id' ) ) ? TRUE : FALSE,
				"type" => "checkbox");

	$options[] = array( "name" => __('User Access Token','framework_localize'),
				"desc" => "Specify the access token gotten when you created your app. If you dont have one make click to <a href=\"http://afternoon-fire-1224.herokuapp.com/google/\" target=\"_blank\">get a google acess token</a>",
				"id" => $shortname."_g_user_access_token",
				"std" => "",
				"type" => "text");

	$options[] = array( "name" => __('Refresh Token','framework_localize'),
				"desc" => "Specify the \"Refresh Token\"",
				"id" => $shortname."_g_refresh_token",
				"std" => "",
				"type" => "text");
	$options[] = array( "name" => __('Youtube','framework_localize'),
				"desc" => __('Activate Youtube Tab in Social Slidebar','framework_localize'),
				"id" => $shortname."_isYoutube",
	    		'std' => ( '1' == get_option( 'lang_id' ) ) ? TRUE : FALSE,
				"type" => "checkbox");
	$options[] = array( "name" => __('Youtube Username ','framework_localize'),
				"desc" => "Specify the \"i.e CaELiKe\"",
				"id" => $shortname."_yt_user_name",
				"std" => "",
				"type" => "text");
	/* End the Google Settings */



	/* ------------------------------ Option Page 5 - Instagram Settings ------------------------------------*/

	/* Page Name */
	$options[] = array( "name" => __('Instagram','framework_localize'),
				"type" => "heading");
				
	/* Begin the Instagram Settings */
	$options[] = array( "name" => __('Instagram','framework_localize'),
				"desc" => __('Activate Instagram Tab in Social Slidebar','framework_localize'),
				"id" => $shortname."_isInstagram",
	    		'std' => ( '1' == get_option( 'lang_id' ) ) ? TRUE : FALSE,
				"type" => "checkbox");
	$options[] = array( "name" => __('User Access Token','framework_localize'),
				"desc" => "Specify the access token gotten when you created your app. If you dont have one make click to <a href=\"http://afternoon-fire-1224.herokuapp.com/instagram/\" target=\"_blank\">get a instagram acess token</a>",
				"id" => $shortname."_ig_user_access_token",
				"std" => "",
				"type" => "text");

	$options[] = array( "name" => __('User ID','framework_localize'),
				"desc" => "Specify the \"Refresh Token\"",
				"id" => $shortname."_ig_user_id",
				"std" => "",
				"type" => "text");
	
	/* End the Instagram Settings */







	/* ------------------------------- Option Page 6 - Tumblr Settings -----------------------------------------*/

	/* Page Name*/
	$options[] = array( "name" => __('Tumblr','framework_localize'),
				"type" => "heading");

	$options[] = array( "name" => __('Tumblr','framework_localize'),
				"desc" => __('Activate Tumblr Tab in Social Slidebar','framework_localize'),
				"id" => $shortname."_isTumblr",
	    		'std' => ( '1' == get_option( 'lang_id' ) ) ? TRUE : FALSE,
				"type" => "checkbox");
				
	/* Begin the Tumblr Settings */			
	$options[] = array( "name" => __('Tumblr Blog URL','framework_localize'),
				"id" => $shortname."_tm_blog_url",
				"desc" => "Specify url of tumblr blog i.e whitemenwearinggoogleglass.tumblr.com",
				"std" => "",
				"type" => "text");

	/* End the Tumblr Settings */





	/*------------------------------ Option Page 7 - Twitter Settings---------------------------------------- */

	/* Page Name */
	$options[] = array( "name" => __('Twitter','framework_localize'),
				"type" => "heading");
	
	/* Begin the Twitter Settings */
	$options[] = array( "name" => __('Twitter','framework_localize'),
				"desc" => __('Activate Twitter Tab in Social Slidebar','framework_localize'),
				"id" => $shortname."_isTwitter",
				'std' => ( '1' == get_option( 'lang_id' ) ) ? TRUE : FALSE,
				"type" => "checkbox");

	$options[] = array( "name" => __('User Name','framework_localize'),
				"desc" => "Specify the \"i.e @kiibal\"",
				"id" => $shortname."_tw_user_name",
				"std" => "",
				"type" => "text");

	$options[] = array( "name" => __('Consumer Key','framework_localize'),
				"desc" => "Specify the \"Consumer Key\"",
				"id" => $shortname."_tw_consumer_key",
				"std" => "",
				"type" => "text");

	$options[] = array( "name" => __('Consumer Secret','framework_localize'),
				"desc" => "Specify the \"Consumer Key Secret\"",
				"id" => $shortname."_tw_consumer_key_secret",
				"std" => "",
				"type" => "text");

				
	$options[] = array( "name" => __('Access Token','framework_localize'),
				"desc" => "Specify the \"Oauth Access Token\"",
				"id" => $shortname."_tw_oauth_access_token",
				"std" => "",
				"type" => "text");

	$options[] = array( "name" => __('Access Token Secret','framework_localize'),
				"desc" => "Specify the \"Oauth Access Token\"",
				"id" => $shortname."_tw_oauth_access_token_secret",
				"std" => "",
				"type" => "text");

	
	$options[] = array( "name" => __('Show Profile\'s Background Image  as Banner Background','framework_localize'),
				"desc" => __('Activate Background Image Profile instead of Banner.','framework_localize'),
				"id" => $shortname."_tw_show_background_image",
				"std" => "TRUE",
				"type" => "checkbox");

	$options[] = array( "name" => __('Number of tweets to display','framework_localize'),
				"desc" => NULL,
				"id" => $shortname."_tw_tweets_displayed",
				"std" => "",
				"type" => "text");

	/* End the Twitter Settings */



	/* ------------------------------------ Option Page 8 - Vimeo Settings-------------------------------------------- */

	/*Page Name*/
	$options[] = array( "name" => __('Vimeo','framework_localize'),
				"type" => "heading");

	$options[] = array( "name" => __('Vimeo','framework_localize'),
				"desc" => __('Activate Vimeo Tab in Social Slidebar','framework_localize'),
				"id" => $shortname."_isVimeo",
	    		'std' => ( '1' == get_option( 'lang_id' ) ) ? TRUE : FALSE,
				"type" => "checkbox");
				
	/*Begin the Vimeo Settings*/
	$options[] = array( "name" => __('Vimeo username','framework_localize'),
				"desc" => "Specify only username, for example if your profile url is http://vimeo.com/chriscairns you must Specify chriscairns",
				"id" => $shortname."_vm_username",
				"std" => "",
				"type" => "text");
	/*End the Vimeo Settings*/

	$themename = 'Social Slidebar';

	update_option('kbl_ssb_of_template',$options);
	update_option('kbl_ssb_of_themename',$themename);
	update_option('kbl_ssb_of_shortname',$shortname);

	}
}
?>