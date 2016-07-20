<?php
/*
Plugin Name: Social Slidebar
Plugin URL: http://dagtok.com
Description: Social Slidebar is a great way to integrate your social profile networks into your wordpress installation with a single plugin. This slidebar were designed to give your visitors the opportunity to get feedback from your social networks directly on your site.
Version: v0
Author: Daniel Gutierrez
Author URL: http://dagtok.com
*/

	//require_once('feeds/simple_cache.php');
	//require_once('feeds/twitter.php');
	// require_once('feeds/_facebook.php');
	// require_once('feeds/vimeo.php');
	// require_once('feeds/flickr.php');
	// require_once('feeds/tumblr.php');
	// require_once('feeds/instagram.php');
	// require_once('feeds/googleplus.php');
	// require_once('feeds/youtube.php');

	require_once('admin/admin-functions.php');
	require_once('admin/admin-interface.php');
	require_once('admin/theme-settings.php');

	function kbl_ssb_enqueue_script() {

		$plugin_name = 'Kiibal';

	    $isFacebookPage = get_option($plugin_name.'_isFacebookPage');
		
		$display_facebook = get_option($plugin_name.'_isFacebook');
	    $display_twitter = get_option($plugin_name.'_isTwitter');
		$display_youtube = get_option($plugin_name.'_isYoutube');
		$display_googlePlus = get_option($plugin_name.'_isGooglePlus');
		$display_vimeo = get_option($plugin_name.'_isVimeo');
		$display_instagram = get_option($plugin_name.'_isInstagram');
		$display_flickr = get_option($plugin_name.'_isFlickr');
		$display_tumblr = get_option($plugin_name.'_isTumblr');
	    
	    // if($display_facebook == 'true' OR $display_twitter == 'true' OR $display_youtube == 'true' OR
	    //    $display_flickr == 'true' OR $display_instagram == 'true' OR $display_vimeo == 'true'){

	    	$bcolor = get_option($plugin_name.'_bcolor');
	    	$position = get_option($plugin_name.'_position');

		   	wp_enqueue_script(
				'jquery.social-slidebar',
				plugins_url( '/js/jquery.social-slidebar.js' , __FILE__ ),
				array( 'jquery' ),
				');.1',
				TRUE
			);

			// if ($display__googleplus == 'true') {
			// 	wp_enqueue_script( 'plusone', 
			// 		'https://apis.google.com/js/plusone.js',null,'3.5.1',TRUE
			// 	);
			// }
			
			wp_localize_script( 
				'jquery.social-slidebar', 'vars', array(
				'display_delicious' => 'true',
				'display_deviantart' => 'true',
				'display_dribbble' => 'true',
				'display_flickr' => 'true',
				'display_foursquare' => 'true',
				'display_facebook' => 'true',
				'display_googleplus' => 'true',
				'display_instagram' => 'true',
				'display_pinterest' => 'true',
				'display_soundcloud' => 'true',
				'display_stumbleupon' => 'true',
				'display_tumblr' => 'true',
				'display_twitter' => 'true',
				'display_vimeo' => 'true',
				'display_vine' => 'true',
				'display_youtube' => 'true',
				'plugin_dir' => plugins_url('social-slidebar/'),
				'bcolor' => $bcolor,
				'isFacebookPage' => $isFacebookPage,
				'updateInterval' => get_option($plugin_name.'_updateInterval'),
				'position' => $position
				) 
			);

			wp_register_style( 'colorbox', 
		 	plugins_url( '/css/colorbox.css' , __FILE__ ),
		 	array(), 
		 	'0.1',
		 	'screen' );

			wp_register_style( 'slidebar_style',
		 	plugins_url( '/css/style.css' , __FILE__ ),
		 	array(), 
		 	'0.2',
		 	'screen' );

			wp_enqueue_style( 'slidebar_style' );
			wp_enqueue_style( 'colorbox' );			
	    // }
	}


	function kbl_ssb_checkForUpdates(){
		$plugin_name = 'Kiibal';

		// $display_facebook = get_option($plugin_name.'_isFacebook');
	 	// $display_twitter = get_option($plugin_name.'_isTwitter');
		// $display_youtube = get_option($plugin_name.'_isYoutube');
		// $display_googlePlus = get_option($plugin_name.'_isGooglePlus');
		// $display_vimeo = get_option($plugin_name.'_isVimeo');
		// $display_instagram = get_option($plugin_name.'_isInstagram');
		// $display_flickr = get_option($plugin_name.'_isFlickr');
		// $display_tumblr = get_option($plugin_name.'_isTumblr');
		
		$display_delicious = get_option($plugin_name.'_isDelicious');
		$display_deviantart = get_option($plugin_name.'_isDeviantart');
		$display_dribbble = get_option($plugin_name.'_isDribbble');
		$display_facebook = get_option($plugin_name.'_isFacebook');
		$display_flickr = get_option($plugin_name.'_isFlickr');
		$display_foursquare = get_option($plugin_name.'_isFoursquare');
		$display_googlePlus = get_option($plugin_name.'_isGooglePlus');
		$display_instagram = get_option($plugin_name.'_isInstagram');
		$display_pinterest = get_option($plugin_name.'_isPinterest');
		$display_soundcloud = get_option($plugin_name.'_isSoundcloud');
		$display_stumbleupon = get_option($plugin_name.'_isStumbleupon');
		$display_tumblr = get_option($plugin_name.'_isTumblr');
		$display_twitter = get_option($plugin_name.'_isTwitter');
		$display_vimeo = get_option($plugin_name.'_isVimeo');
		$display_vine = get_option($plugin_name.'_isVine');
		$display_youtube = get_option($plugin_name.'_isYoutube');

	   	// $display_facebook 	== 'true' ?	kbl_ssb_get_facebook_updates() : '';
	   	// $display_twitter 	== 'true' ?	kbl_ssb_get_twitter_updates() : '';
	   	// $display_youtube 	== 'true' ?	kbl_ssb_get_youtube_updates() : '';
	   	// $display_googlePlus == 'true' ?	kbl_ssb_get_googleplus_updates() : '';
	   	// $display_vimeo 		== 'true' ?	kbl_ssb_get_vimeo_updates() : '';
	   	// $display_instagram 	== 'true' ?	kbl_ssb_get_instagram_updates() : '';
	   	// $display_flickr 	== 'true' ?	kbl_ssb_get_flickr_updates() : '';
	   	// $display_tumblr 	== 'true' ?	kbl_ssb_get_tumblr_updates() : '';

		/*Update content if social network is selected */
	   	$display_delicious == 'true' ? kbl_ssb_get_delicious_updates() : null;
		$display_deviantart == 'true' ? kbl_ssb_get_deviantart_updates() : null;
		$display_dribbble == 'true' ? kbl_ssb_get_dribbble_updates() : null;
		$display_facebook == 'true' ? kbl_ssb_get_facebook_updates() : null;
		$display_flickr == 'true' ? kbl_ssb_get_flickr_updates() : null;
		$display_foursquare == 'true' ? kbl_ssb_get_foursquare_updates() : null;
		$display_googlePlus == 'true' ? kbl_ssb_get_googlePlus_updates() : null;
		$display_instagram == 'true' ? kbl_ssb_get_instagram_updates() : null;
		$display_pinterest == 'true' ? kbl_ssb_get_pinterest_updates() : null;
		$display_soundcloud == 'true' ? kbl_ssb_get_soundcloud_updates() : null;
		$display_stumbleupon == 'true' ? kbl_ssb_get_stumbleupon_updates() : null;
		$display_tumblr == 'true' ? kbl_ssb_get_tumblr_updates() : null;
		$display_twitter == 'true' ? kbl_ssb_get_twitter_updates() : null;
		$display_vimeo == 'true' ? kbl_ssb_get_vimeo_updates() : null;
		$display_vine == 'true' ? kbl_ssb_get_vine_updates() : null;
		$display_youtube == 'true' ? kbl_ssb_get_youtube_updates() : null;
	   	
	}
	
	/*
		function kbl_ssb_get_tumblr_updates(){
			$plugin_name = 'Kiibal';
			$blog= get_option($plugin_name."_tm_blog_url");
			$tumblr=new Tumblr($blog);
			$info = $tumblr->get_live_json_data('info');
			$posts =$tumblr->get_live_json_data('posts');
			if($info <> NULL AND $posts <> NULL){
				$tumblr->write_json_file('tumblr_info',$info);
				$tumblr->write_json_file('tumblr_posts',$posts);
			}
		}	

		function kbl_ssb_get_flickr_updates(){
			$plugin_name = 'Kiibal';	
			$token= get_option($plugin_name."_fk_user_access_token");
			$user= get_option($plugin_name."_fk_user_id");
			$flickr = new Flickr($token,$user);
			$info = $flickr->get_live_json_data(1);
			$photo_feed = $flickr->get_live_json_data(0);
			if($info <> NULL AND $photo_feed <> NULL){
				$flickr->write_json_file('flickr_info',$info);
				$flickr->write_json_file('flickr_photos',$photo_feed);
			}
		}

		function kbl_ssb_get_instagram_updates(){
			$plugin_name = 'Kiibal';	
			$token= get_option($plugin_name."_ig_user_access_token");
			$user= get_option($plugin_name."_ig_user_id");
			$instagram= new Instagram($token,$user);
			$info=$instagram->get_live_json_data('');
			$feed=$instagram->get_feed_json_data();
			$follows=$instagram->get_live_json_data('follows');
			$followed=$instagram->get_live_json_data('followed-by');
			if($info <> NULL AND $feed <> NULL AND $follows <> NULL AND $followed <> NULL){
				$instagram->write_json_file('instagram_info',$info);
				$instagram->write_json_file('instagram_feed',$feed);
				$instagram->write_json_file('instagram_follows',$follows);
				$instagram->write_json_file('instagram_followed',$followed);
			}
		}

		function kbl_ssb_get_vimeo_updates(){
			$plugin_name = 'Kiibal';	
			$user= get_option($plugin_name."_vm_username");
			$vimeo= new Vimeo($user);
			$info=$vimeo->get_live_json_data('info');
			$videos=$vimeo->get_live_json_data('all_videos');
			$likes=$vimeo->get_live_json_data('likes');
			if($info <> NULL AND $videos <> NULL AND $likes <> NULL){
				$vimeo->write_json_file('vimeo_info',$info);
				$vimeo->write_json_file('vimeo_videos',$videos);
				$vimeo->write_json_file('vimeo_likes',$likes);
			}
		}

		function kbl_ssb_get_googleplus_updates(){
			$plugin_name = 'Kiibal';
			$token = get_option($plugin_name.'_g_user_access_token');
			$refresh= get_option($plugin_name.'_g_refresh_token');
			$gplus=new GooglePlus($token, $refresh);
			$user_id = 'me';
			$profile_info = $gplus->get_live_json_data($user_id);//info del perfil, usar id de usuario o "me" para perfil propio 
			$updates=$gplus->get_live_json_data($user_id.'/activities/public'); //feed del usuario, usar id de usuario o "me" para perfil propio 
			if($profile_info <> NULL AND $updates <> NULL) {
				$gplus->write_json_file('googleplus_info',$profile_info);
				$gplus->write_json_file('googleplus_updates',$updates);
			}
		}

		function kbl_ssb_get_youtube_updates(){
			$plugin_name = 'Kiibal';
			$token = get_option($plugin_name.'_g_user_access_token');
			$refresh= get_option($plugin_name.'_g_refresh_token');
			$username = get_option($plugin_name.'_yt_user_name');
			$youtube = new Youtube($token, $refresh);
			$youtube_info = $youtube->get_live_json_data(1,$username);
			$info = json_decode($youtube_info);
			isset($info->items[0]->id) ? $youtube_update = $youtube->get_live_json_data(0,$info->items[0]->id) : $youtube_update = null;
			if($youtube_update<>null and $youtube_info<>null){
				$youtube->write_json_file('youtube_info',$youtube_info);
				$youtube->write_json_file('youtube_updates',$youtube_update);
			}
		}

		function kbl_ssb_get_facebook_updates(){
			$plugin_name = 'Kiibal';
			$isFacebookPage = get_option($plugin_name.'_isFacebookPage');
			$username = get_option($plugin_name.'_fb_user_name');

			$facebook = new Facebook(get_option($plugin_name.'_fb_access_token'),$username,$isFacebookPage);
			$stored_facebook_json = $facebook->get_stored_json_data('facebook.json');
			$stored_feed_json = $facebook->get_stored_json_data('feed.json');
			$stored_about_json = $facebook->get_stored_json_data('about_me.json');
			$stored_friends_json = $facebook->get_stored_json_data('friends.json');
			
			$live_facebook_json = $facebook->get_live_json_data('facebook');
			$live_feed_json = $facebook->get_live_json_data('feed');
			$live_about_me_json = $facebook->get_live_json_data('about_me');
				
			if($isFacebookPage=='true'){
				$live_friends_json = $facebook->get_page_json_data();
			}
			else
			$live_friends_json = $facebook->get_live_json_data('friends');
			if($live_facebook_json<>NULL AND $live_about_me_json<>NULL AND $live_feed_json<>NULL AND $live_friends_json<>NULL)
			$facebook->write_json_file($live_facebook_json,$live_feed_json,$live_about_me_json,$live_friends_json);
			
			return true;
		}

		function kbl_ssb_get_twitter_updates(){
			$plugin_name = 'Kiibal';
			$tweets = new TwitterFeed();
			if (($oauth_config = $tweets->get_twitter_oauth_credentials()) <> FALSE) { //If all required auth-keys are filled in on panel
					$live_json = json_decode($tweets->get_live_json_data($oauth_config, 'statuses/user_timeline.json?count='.get_option($plugin_name.'_tw_tweets_displayed').'&screen_name='.$oauth_config['user_name']));
					if (!isset($live_json->errors)) {
						if (get_option($plugin_name.'_tw_show_background_image') == 'false') {
							$live_json[0]->profile_banner_url = $live_json[0]->user->profile_banner_url.'/mobile';
						}
					}
					$tweets->write_json_file(json_encode($live_json));
			} else {
				$result = new stdClass();
				@$result->errors[0]->message = 'Incomplete Oauth configuration, please verify you filled up all requested fields on Twitter tab from Slidebar Panel ';
				$result->errors[0]->code = '9999';
				$live_json = $result;
				$tweets->write_json_file(json_encode($live_json));
			}
		}
	*/

	function kbl_ssb_get_delicious_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$delicious = new Delicious($blog);
		$info = $delicious->get_live_json_data();
		if($info != null){
			$delicious->write_json_file('delicious_posts', $info);
		}
	}
	function kbl_ssb_get_deviantart_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$deviantart = new Deviantart($blog);
		$info = $deviantart->get_live_json_data();
		if($info != null){
			$deviantart->write_json_file('deviantart_posts', $info);
		}
	}
	function kbl_ssb_get_dribbble_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$dribbble = new Dribbble($blog);
		$info = $dribbble->get_live_json_data();
		if($info != null){
			$dribbble->write_json_file('dribbble_posts', $info);
		}
	}
	function kbl_ssb_get_facebook_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$facebook = new Facebook($blog);
		$info = $facebook->get_live_json_data();
		if($info != null){
			$facebook->write_json_file('facebook_posts', $info);
		}
	}
	function kbl_ssb_get_flickr_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$flickr = new Flickr($blog);
		$info = $flickr->get_live_json_data();
		if($info != null){
			$flickr->write_json_file('flickr_posts', $info);
		}
	}
	function kbl_ssb_get_foursquare_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$foursquare = new Foursquare($blog);
		$info = $foursquare->get_live_json_data();
		if($info != null){
			$foursquare->write_json_file('foursquare_posts', $info);
		}
	}
	function kbl_ssb_get_googlePlus_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$googlePlus = new GooglePlus($blog);
		$info = $googlePlus->get_live_json_data();
		if($info != null){
			$googlePlus->write_json_file('googlePlus_posts', $info);
		}
	}
	function kbl_ssb_get_instagram_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$instagram = new Instagram($blog);
		$info = $instagram->get_live_json_data();
		if($info != null){
			$instagram->write_json_file('instagram_posts', $info);
		}
	}
	function kbl_ssb_get_pinterest_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$pinterest = new Pinterest($blog);
		$info = $pinterest->get_live_json_data();
		if($info != null){
			$pinterest->write_json_file('pinterest_posts', $info);
		}
	}
	function kbl_ssb_get_soundcloud_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$soundcloud = new Soundcloud($blog);
		$info = $soundcloud->get_live_json_data();
		if($info != null){
			$soundcloud->write_json_file('soundcloud_posts', $info);
		}
	}
	function kbl_ssb_get_stumbleupon_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$stumbleupon = new Stumbleupon($blog);
		$info = $stumbleupon->get_live_json_data();
		if($info != null){
			$stumbleupon->write_json_file('stumbleupon_posts', $info);
		}
	}
	function kbl_ssb_get_tumblr_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$tumblr = new Tumblr($blog);
		$info = $tumblr->get_live_json_data();
		if($info != null){
			$tumblr->write_json_file('tumblr_posts', $info);
		}
	}
	function kbl_ssb_get_twitter_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$twitter = new Twitter($blog);
		$info = $twitter->get_live_json_data();
		if($info != null){
			$twitter->write_json_file('twitter_posts', $info);
		}
	}
	function kbl_ssb_get_vimeo_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$vimeo = new Vimeo($blog);
		$info = $vimeo->get_live_json_data();
		if($info != null){
			$vimeo->write_json_file('vimeo_posts', $info);
		}
	}
	function kbl_ssb_get_vine_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$vine = new Vine($blog);
		$info = $vine->get_live_json_data();
		if($info != null){
			$vine->write_json_file('vine_posts', $info);
		}
	}
	function kbl_ssb_get_youtube_updates(){
		$plugin_name = 'Kiibal';
		$blog = get_option($plugin_name."_tm_blog_url");
		$youtube = new Youtube($blog);
		$info = $youtube->get_live_json_data();
		if($info != null){
			$youtube->write_json_file('youtube_posts', $info);
		}
	}

	function kbl_ssb_activation(){	
		if ( !wp_next_scheduled( 'kbl-ssb-cron-event' ) ) {
			wp_schedule_event( current_time( 'timestamp' ), 'kblss', 'kbl-ssb-cron-event');
		}
	}

	function kbl_ssb_deactivation(){
		$all_options = wp_load_alloptions();
		foreach( $all_options as $name => $value ) {
		  if(stristr($name, 'Kiibal')){
		  	delete_option($name);
		  }
		}
		remove_action('kbl-ssb-cron-event', 'kbl_ssb_checkForUpdates');
		remove_action( 'wp_enqueue_scripts', 'kbl_ssb_enqueue_script' );
		wp_unschedule_event(wp_next_scheduled( 'kbl-ssb-cron-event' ), 'kbl-ssb-cron-event');
	}

	function kbl_ssb_custom_cron( $schedules ) {
		$schedules['kblss'] = array(
			'interval' => 900, //update interval (in seconds)
			'display' => 'Every Day'
		);
		return $schedules;
	}

	register_activation_hook( __FILE__, 'kbl_ssb_activation');
	register_deactivation_hook( __FILE__, 'kbl_ssb_deactivation');

	add_filter( 'cron_schedules', 'kbl_ssb_custom_cron' );
	add_action('kbl-ssb-cron-event', 'kbl_ssb_checkForUpdates');
	add_action( 'wp_enqueue_scripts', 'kbl_ssb_enqueue_script' );


