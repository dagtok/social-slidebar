<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'simple_cache.php';

class Vimeo{
	public $plugin_name;
	public $user_name;
	/*
	
	function __construct($user){
		$this->plugin_name="Kiibal";
		$this->user_name=$user;
	}
  
  	function write_json_file($name,$vimeo){
		try{
			$fp = fopen(str_replace('vimeo.php', $name.'.json', __FILE__), 'w');
			if(!($fp==false)){
				fwrite($fp, $vimeo);
				fclose($fp);
			}
		} catch (Exception $e) {
			
		}
	}
	*/
	function parse_feed($data){ ?>
      
		<div id="vimeo" class="nano"> 
			<div class="nano-content">
			  <ul>
			    <?php 
			    foreach ($data['videos'] as $video) {
					echo '
					<li class="video-thumb">
					    <div class="profile-header-inner" style="background-image: url('.$video->thumbnail_medium.');">
							<div class="yt_shadow"></div>
								<a class="socialslidebar_element profile-picture social_sprite play_control" href="wp-content/plugins/social-slidebar/feeds/vimeo_comment.php?src='.$video->id.'" > 
								  <img src="#" alt="" width="5px" height="5px">
								</a>
								<div class="video-thumb-inner">
								  <h2 class="username">
								        <a target="_blank" rel="me nofollow" href="'.$video->url.'" class="screen-name"></a>
								  </h2>
								</div>
					   		</div>
							<div class="description"><span><a href="'.$video->url.'">'.$video->title.'</a><span>
						</div>
					</li>';
			    }
			    ?>
			  </ul>
			</div>
		</div>
	<?php
	}

	function get_json_data($settings){
		// $url='http://vimeo.com/api/v2/'.$this->user_name.'/'.$resource.'.json';
		// $options = array(
		// 	CURLOPT_HEADER => false,
		// 	CURLOPT_URL => $url,
		// 	CURLOPT_RETURNTRANSFER => true,
		// 	CURLOPT_SSL_VERIFYPEER => false
		// );
		// $feed = curl_init();
		// curl_setopt_array($feed, $options);
		// $result = curl_exec($feed);
		// $info = curl_getinfo($feed);
		// if(curl_getinfo($feed, CURLINFO_HTTP_CODE) != 200){//Error request
		// 	  	curl_close($feed);
		// 	  	return NULL; 
		// } else { //Sucess request
		// 	curl_close($feed);
		// 	return $result;
		// }
	    //   return NULL; 
	    $cache = new SimpleCache();
	    $feed = array();

	 	// echo "<pre>";
		// print_r($settings);
		// echo "</pre>";

		if ( $settings['force_crawl'] ) {
		    
		    $requests = "videos,likes,appears_in,all_videos,subscriptions,albums,channels,groups";
		    $feedtypes = explode(',', $requests);

		    foreach ($feedtypes as $type) {
		        if ($settings['feeds'][$type]) {
		            $feed_url = 'https://vimeo.com/api/v2/' . $settings['username'] . '/' . $type . ".json";
		            $content = ( ! $settings['force_crawl']) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
		            if ( $data = @json_decode($content) )
		                $feed[$type] = $data;
		        }
		    }
		}

		// echo "<pre>";
		// print_r($feed);
		// echo "</pre>";

		return $feed;
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	$crawled = 0;
	
	$settings['username'] = 'jakezalutsky';
	$settings['feeds']['videos'] = true;
	$settings['feeds']['likes'] = false;
	$settings['feeds']['appears_in'] = false;
	$settings['feeds']['all_videos'] = false;
	$settings['feeds']['subscriptions'] = false;
	$settings['feeds']['albums'] = false;
	$settings['feeds']['channels'] = false;
	$settings['feeds']['groups'] = false;
	$settings['force_crawl'] = true;
	
	$vimeo = new Vimeo();
	$json = $vimeo->get_json_data($settings);
	$html = $vimeo->parse_feed($json);

}

?>