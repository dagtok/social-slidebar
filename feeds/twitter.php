<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'simple_cache.php';

/**
* Twitter Tools
*/
class Twitter {
	public $plugin_name;
	
	function __construct() {
		$plugin_name = 'Kiibal';		
	}
	
	function get_stored_json_data(){
		//Si el archivo de de twitter con json no existe
		if( ($data = @file_get_contents(str_replace('twitter.php', 'json/twitter.json', __FILE__)) ) == FALSE){
			$this->write_json_file(NULL);
			return NULL;
		}
		return json_decode($data);
	}

	function format_feed(){
		if(($json_data = $this->get_stored_json_data()) <> NULL) {
			$this->data($json_data);	
		} else {
			echo 'Json file is empty';
		}
	}
	
	function write_json_file($data){
		try{
		$fp = fopen(str_replace('.php', '.json', __FILE__), 'w');
		if(!($fp==false)){
			fwrite($fp, $data);
			fclose($fp);
		}
		}catch(Exception $e){}
	}

	function get_live_json_data($settings){
		$cache = new SimpleCache();
		$consumer_key = trim($settings['api_key']);
		$consumer_secret = trim($settings['api_secret']);
		$oauth_access_token = trim($settings['access_token']);
		$oauth_access_token_secret = trim($settings['access_token_secret']);
		
		switch($settings['feed_type']) {
			case 'timeline':
		        $rest = 'statuses/user_timeline';
		        $params = array(
		            'exclude_replies' => ($settings['replies']) ? 'false' : 'true',
		            'screen_name' => $settings['username']
		            );
		        if ( ! $settings['retweets']) {
		            $params['include_rts'] = 'false';
		        }
			break;
			case 'lists':
				$rest = "lists/statuses";

		        if ( is_numeric($settings['username']) ) {
		            $params = array('list_id' => $settings['username']);
		        } else {
		            $feedvalarr = explode('/', $settings['username']);
		            $params = array('owner_screen_name' => $feedvalarr[0], 'slug' => $feedvalarr[1]);
		            if ($settings['retweets']){
		                $params['include_rts'] = 'true';
		            }
		        }
			break;
			case 'search':
		        $rest = "search/tweets";
		        $settings['username'] = urlencode($settings['username']);
		        if ( ! $settings['retweets']){
		            $settings['username'] .= ' AND -filter:retweets';
		        }
		        $params = array('q' => $settings['username']);
			break;
			case 'favorites':
		        $rest = "favorites/list";
		        $params = array(
		            'screen_name' => $settings['username']
		            );
			break;
		}

		$params['count'] = $settings['results'];

		if ($id_from = $settings['id_range'][0])
		    $params['since_id'] = $id_from;
		    
		if ($id_to = $settings['id_range'][1])
		    $params['max_id'] = $id_to;
		    
		// if ($max_id = @$_SESSION[$sb_label]['loadcrawl'][$social_network.$i.$key2])
		//     $params['max_id'] = $max_id;

		$get_feed = TRUE;
		$label = 'https://api.twitter.com/1.1/'.$rest.'/'.serialize($params);

		if ( $settings['force_crawl'] == false) {
			if ( $cache->is_cached($label) ) {
		        $content = $cache->get_cache($label);
		        $get_feed = FALSE;
		    }
		}

		// print_r($params);

		if ($get_feed) {
		    if ( ! class_exists( 'TwitterOAuth' ) ) {
		        require_once('oauth/twitteroauth.php');
		    }

		    $auth = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret);
		    // $auth->timeout = $this->attr['timeout'];
		    // $auth->connecttimeout = $this->attr['timeout'];
		    $auth->decode_json = FALSE;
		    $content = $auth->get( $rest, $params );
		    if ( ! $content ) {
		    	if (@$this->attr['debuglog'])
		            sb_log( 'Twitter error: An error occurs while reading the feed, please check your connection or settings.');
		    } else {
		        $feed = json_decode($content);
		        if ( isset( $feed->errors ) ) {
		            foreach( $feed->errors as $key => $val ) {
		                if ($this->attr['debuglog'])
		                    sb_log( 'Twitter error: '.$val->message.' - ' . $rest);
		            }
		            $feed = null;
		        }
		    }
				if ( ! $settings['force_crawl'] )
		        $cache->set_cache($label, $content);
		} else {
		    $feed = json_decode($content);
		}

		return $feed;
	}

	function old($oauth_config, $resource_URL){
		$url = 'statuses/user_timeline.json?screen_name='.$oauth_config['user_name'];
		if($resource_URL <> NULL){
			$url = $resource_URL;
		}
		
		// Figure out the URL parmaters
		$url_parts = parse_url($url);
		parse_str($url_parts['query'], $url_arguments);
		 
		$full_url = 'http://api.twitter.com/1.1/'.$url; // Url with the query on it.
		$base_url = 'http://api.twitter.com/1.1/'.$url_parts['path']; // Url without the query.
		try{
		$oauth = array(
			'oauth_consumer_key' => $oauth_config['consumer_key'],
			'oauth_nonce' => time(),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_token' => $oauth_config['oauth_access_token'],
			'oauth_timestamp' => time(),
			'oauth_version' => '1.0'
		);
			
		$base_info = $this->buildBaseString($base_url, 'GET', array_merge($oauth, $url_arguments));
		$composite_key = rawurlencode($oauth_config['consumer_secret']) . '&' . rawurlencode($oauth_config['oauth_access_token_secret']);
		$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
		$oauth['oauth_signature'] = $oauth_signature;
		 
		// Make Requests
		$header = array(
			$this->buildAuthorizationHeader($oauth), 
			'Expect:'
		);
		$options = array(
			CURLOPT_HTTPHEADER => $header,
			//CURLOPT_POSTFIELDS => $postfields,
			CURLOPT_HEADER => false,
			CURLOPT_URL => $full_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false
		);
		 
		$feed = curl_init();
		curl_setopt_array($feed, $options);
		$result = curl_exec($feed);
		$info = curl_getinfo($feed);
		curl_close($feed);
		 
		return $result;
		}catch(Exception $e){
			$result = new stdClass();
			@$result->errors[0]->message = 'Incomplete Oauth configuration, please verify you filled up all requested fields on Twitter tab from Slidebar Panel ';
			$result->errors[0]->code = '9999';
			return json_encode($result);

		}
	}
 
	function buildBaseString($baseURI, $method, $params) {
		$r = array();
		ksort($params);
		foreach($params as $key=>$value){
		$r[] = "$key=" . rawurlencode($value);
		}
		return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
	}
	 
	function buildAuthorizationHeader($oauth) {
		$r = 'Authorization: OAuth ';
		$values = array();
		foreach($oauth as $key=>$value)
		$values[] = "$key=\"" . rawurlencode($value) . "\"";
		$r .= implode(', ', $values);
		return $r;
	}

	function time_since($original) {
		$chunks = array(
			array(31536000 , 'year'), // 60 * 60 * 24 * 365
			array(2592000 , 'month'), // 60 * 60 * 24 * 30
			array(604800, 'week'), // 60 * 60 * 24 * 7
			array(86400 , 'day'), // 60 * 60 * 24
			array(3600 , 'hour'), // 60 * 60
			array(60 , 'minute'),
		);
		$today = time();
		$since = $today - $original;

		// $j saves performing the count function each time around the loop
		for ($i = 0, $j = count($chunks); $i < $j; $i++)
		{
			$seconds = $chunks[$i][0];
			$name = $chunks[$i][1];
			// finding the biggest chunk (if the chunk fits, break)
			if (($count = floor($since / $seconds)) != 0) break;
		}
		$print = ($count == 1) ? "$count {$name} ago" : "$count {$name}s ago";
		return $print;
	}

	function statusUrlConverter($status, $targetBlank=true, $linkMaxLen=250) {
		$target=$targetBlank ? "target=\"_blank\"" : "";

		// convert link to url
		$status = @preg_replace("/((http:\/\/|https:\/\/)[^ )]+)/e", "'<a href=\"$1\" title=\"$1\" $target>'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);

		// convert @ to follow
		$status = @preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target>$1</a>",$status);

		// convert # to search
		$status = @preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"http://search.twitter.com/search?q=%23$2\" title=\"Search $1\" $target>$1</a>",$status);

		return $status;
	}

	function parse_feed($result){
		if (isset($result->errors)) {
			echo '<div id="twitter" class="nano">	
					<div class="nano-content">';
			echo '<br>Error Code: '.$result->errors[0]->code.'<br><br>';
			echo $result->errors[0]->message.'!  :(<br>';
			if ($result->errors[0]->code == 32) {
				echo '<br>Your keys and tokens are invalid, please go back to your app page and recopy verified user on Slidebar Panel. <br>';
			} elseif ($result->errors[0]->code == 34) {
				echo '<br>Invalid username, please verify this user exists and change it into Slidebar panel. <br>';
			} elseif ($result->errors[0]->code == 89) {
				echo '<br>Invalid or expired token<br>';
			}
			echo '</div></div>';
		}
		/*
		<div class="profile-card">
			<div class="profile-header-inner" style="background-size: 300px 160px; background-repeat: no-repeat; background-image: url(<?php echo (isset($result[0]->profile_banner_url) ? $result[0]->profile_banner_url : $result[0]->user->profile_background_image_url); ?>); height:161px; width:300px;">
				<div class="profile-header-inner-overlay"></div>
				<a class="profile-picture" href="https://twitter.com/<?php echo $result[0]->user->screen_name; ?>" target="_blank"> 
				        <?php echo '<img src="'.str_replace('_normal.', '_bigger.', $result[0]->user->profile_image_url).'" alt="" width="73px" height="73px" />'; ?>
				</a>
				<div class="profile-card-inner">
				      
				      <h1 class="fullname editable-group">
				      	  <a href="https://twitter.com/<?php echo $result[0]->user->screen_name; ?>" target="_blank" class="profile-field"><?php echo $result[0]->user->name; ?></a>
					  </h1>
				
				      <h2 class="username">
				            <a target="_blank" rel="me nofollow" href="<?php echo $result[0]->user->url; ?>" class="screen-name"><s>@</s><?php echo $result[0]->user->screen_name; ?></span>
				      </h2>
				      <p class="location-and-url">
				        <span class="url editable-group">
				          <span class="profile-field">
				            <a target="_blank" rel="me nofollow" href="<?php echo $result[0]->user->url; ?>">
							  <?php echo $result[0]->user->url; ?>
							</a>
				          </span>
				    	</span>
					</p>
				</div>
			</div>
		</div>
		*/
		?>
		<div id="twitter" class="nano">	
				<div class="nano-content">
					
					<div class="profile-banner-footer clearfix">
					    <div class="default-footer">
					        <ul class="stats">
					  			<li><a class="js-nav" href="https://twitter.com/<?php echo $result[0]->user->screen_name; ?>" target="_blank">  
						   			 <strong><?php echo $result[0]->user->statuses_count; ?></strong> Tweets
								</a></li>
								<li><a class="js-nav" href="https://twitter.com/<?php echo $result[0]->user->screen_name; ?>/following" target="_blank">  
									<strong><?php echo $result[0]->user->friends_count; ?></strong> Following
								</a></li>
								<li><a class="js-nav" href="https://twitter.com/<?php echo $result[0]->user->screen_name; ?>/followers" target="_blank">  
									 <strong><?php echo $result[0]->user->followers_count; ?></strong> Followers
								</a></li>
							</ul>			        
					  </div>
					</div>
		<?php
		echo '<ul class="tweets">';
		for ($i=0; $i < sizeof($result); $i++) {
			$profile_image = '<img src="'.$result[0]->user->profile_image_url.'" alt="" class="avatar" /> ';
			$username = htmlentities($result[$i]->user->screen_name);
			if(isset($result[$i]->retweeted_status)){
				$profile_image = '<img src="'.$result[$i]->retweeted_status->user->profile_image_url.'" alt="" class="avatar" />';
				$username = htmlentities($result[$i]->retweeted_status->user->screen_name);
			}
			$parameters='?user_name='.$result[$i]->user->name
						.'&screen_name='.$result[$i]->user->screen_name
						.'&date='.$result[$i]->created_at
						.'&id='.$result[$i]->id_str
						.'&tweet='.$result[$i]->text;
			echo '<li><a class="socialslidebar_element" href="wp-content/plugins/social-slidebar/feeds/twitter_comment.php'.$parameters.'" >'.$profile_image.'<a href="https://twitter.com/'.$username.'" target="_blank">@'.$username.'</a><br><br><p>'.$this->statusUrlConverter($result[$i]->text).'</p></a></li>';	
		}
		echo '</ul>
					<br>			
				</div>
		</div>';
	}

	/*Dashboard*/
	function get_twitter_oauth_credentials(){
		$plugin_name = 'Kiibal';
		$oauth_config['user_name'] = get_option($plugin_name.'_tw_user_name');
		$oauth_config['oauth_access_token'] = get_option($plugin_name.'_tw_oauth_access_token');
		$oauth_config['oauth_access_token_secret'] = get_option($plugin_name.'_tw_oauth_access_token_secret');
		$oauth_config['consumer_key'] = get_option($plugin_name.'_tw_consumer_key');
		$oauth_config['consumer_secret'] = get_option($plugin_name.'_tw_consumer_key_secret');
		
		if ($oauth_config['user_name'] == "" OR $oauth_config['oauth_access_token'] == "" OR $oauth_config['oauth_access_token_secret'] == "" OR $oauth_config['consumer_key'] == "" OR $oauth_config['consumer_secret'] == "") {
			return false;
		}	 
		return $oauth_config;
	}

	function get_next_scheduled_update_date(){
		// return '1368923465';
		return get_option('Kiibal_schedule_update');//siguiente semana
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	$twitter = new Twitter;

	$settings['api_key'] = 'lC0otezJj16DibnHz420p5BSr';
	$settings['api_secret'] = '3SYuKCiwiKML43l3SXQb5fZKXULrbkRqYNOfYswXXBWRC7NBRU';
	$settings['access_token'] = '29707259-NMRRggpuxpsTL4nomEwtm9tqBK9X00vXrkr2d3SvU';
	$settings['access_token_secret'] = 'Gg3U65RjQDPkenV1n8s0UC8R58ODpiPDGgf9ao07tLQWO';
	$settings['replies'] = true;
	$settings['retweets'] = true;
	$settings['results'] = 40;
	$settings['id_range'][0] = false;
	$settings['id_range'][1] = false;

	//TIMELINE
		$crawled = 0;
		$settings['feed_type'] = 'timeline'; //Timeline
		$settings['username'] = 'mashable';
		$settings['force_crawl'] = false;
		$settings['feed_type'] = 'timeline';
		
	// END TIMELINE

	//LISTS
		// $crawled = 0;
		// $settings['feed_type'] = 'lists'; //Twitter list
		// $settings['username'] = 'mashable/social-media';
		// $settings['force_crawl'] = true;

	// END LISTS

	//SEARCH
		// $crawled = 0;
		// $settings['feed_type'] = 'search'; //Search
		// $settings['username'] = 'jupiter';
		// $settings['force_crawl'] = true;

	// END SEARCH

	//FAVORITES
		// $crawled = 0;
		// $settings['feed_type'] =  'search'; //Search
		// $settings['username'] = 'mashable';
		// $settings['force_crawl'] = true;
		
		$data = $twitter->get_live_json_data($settings);

		$twitter->parse_feed($data);
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
	// END FAVORITES
}
?>