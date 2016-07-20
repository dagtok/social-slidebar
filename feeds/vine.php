<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />

<?php
//<iframe src="https://vine.co/v/5ZeKMDT0hui/embed/simple" width="600" height="600" frameborder="0"></iframe><script src="https://platform.vine.co/static/scripts/embed.js"></script>

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'simple_cache.php';

class Vine{
	public $plugin_name;
	public $user_name;
	/*
	
	function __construct($user){
		$this->plugin_name="Kiibal";
		$this->user_name=$user;
	}
  
  	function write_json_file($name,$vine){
		try{
			$fp = fopen(str_replace('vine.php', $name.'.json', __FILE__), 'w');
			if(!($fp==false)){
				fwrite($fp, $vine);
				fclose($fp);
			}
		} catch (Exception $e) {
			
		}	
	}
	*/
	function parse_feed($data){ ?>
      
		<div id="vine" class="nano"> 
			<div class="nano-content">
			  <ul>
			    <?php 
			    foreach ($data as $video) {
			      	//<iframe src="'.$video->permalinkUrl.'/embed/simple" width="600" height="600" frameborder="0"></iframe><script src="https://platform.vine.co/static/scripts/embed.js"></script>
					echo '
		            <li>
						<iframe src="'.$video->permalinkUrl.'/embed/postcard" width="600" height="600" frameborder="0"></iframe><script src="https://platform.vine.co/static/scripts/embed.js"></script>
						<img class="avatar-url" src="'.$video->avatarUrl.'" width="100%">
            			'.$video->username.'
						'.$video->created.'<br>
						
						<a href="'.$video->videoDashUrl.'" > 
	            			<img src="'.$video->thumbnailUrl.'" width="100%">
						</a>

						<a class="loop-description" href="'.$video->permalinkUrl.'">
							'.$video->description.'
						</a><br>
						likes '.$video->likes->count.'<br>
						reposts '.$video->reposts->count.'<br>
						<a class="share" href="'.$video->shareUrl.'" target="_blank">
							Share
						</a><br>
						'.$video->loops->count.' Loops<br>
						comments '.$video->comments->count.'<br>
            		</li>';
			    }
			    // '.$video->loops->count.'
				// '.$video->loops->velocity.'
				// '.$video->loops->onFire.'
			    ?>
			  </ul>
			</div>
		</div>
	<?php
	}

	function get_json_data($settings){
		
		$cache = new SimpleCache();
	    $user_id = $settings['user_id'];
		$tag = $settings['tag'];
		$page = ($settings['page'] > 0) ? '?page='.$settings['page'] : null;

		if ( isset($settings['timeline-type']) ) {
			switch ( $settings['timeline-type'] ) {
				case 'user_timeline':
					$feed_url = "https://api.vineapp.com/timelines/users/{$user_id}{$page}";
					break;
				case 'populars':
				 	$feed_url = "https://api.vineapp.com/timelines/popular";
					break;
				case 'liked':
					$feed_url = "https://api.vineapp.com/timelines/users/{$user_id}/likes{$page}";
					break;
				case 'tag':
					$feed_url = "https://api.vineapp.com/timelines/tags/{$tag}{$page}";
					break;
			}
		}
		
		$content = ($settings['force_crawl']) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
		$feed = json_decode($content);
		$content = json_decode($content);
		
		// $feed = @json_decode($content);

		return $feed;
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	
	$crawled = 0;
	$settings['timeline-type'] = 'user_timeline'; // user_timeline, liked, tag
	$settings['user_id'] = '931427884873170944';
	$settings['tag'] = null;
	$settings['page'] = 0;
	$settings['force_crawl'] = false;
	
	$vine = new Vine();
	$json = $vine->get_json_data($settings);
	
	// echo '<pre>';
	// print_r($json);
	// echo '</pre>';
	// exit;

	$feed = $json->data->records;
	

	$vine->parse_feed($feed);
}

?>