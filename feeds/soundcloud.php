<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<style type="text/css">
	body{
		background-color: white
	}
</style>
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'simple_cache.php';

class SoundCloud{
	public $plugin_name;
	public $user_name;
	/*
	
	function __construct($user){
		$this->plugin_name="Kiibal";
		$this->user_name=$user;
	}
  
  	function write_json_file($name,$deviantArt){
		try{
			$fp = fopen(str_replace('deviantArt.php', $name.'.json', __FILE__), 'w');
			if(!($fp==false)){
				fwrite($fp, $deviantArt);
				fclose($fp);
			}
		} catch (Exception $e) {
			
		}	
	}
	*/

	function parse_feed($data){
      
			$json_posts = $data;
			?>
			<div id="dribbble" class="nano">
				<div class="nano-content">
					<ul>
					<?php
					foreach ($json_posts as $post) { ?>
						<li>
							<?php //echo $post->kind.'<br>'; ?>
							<?php //echo $post->id.'<br>'; ?>
							<?php //echo $post->created_at.'<br>'; ?>
							<?php //echo $post->duration.'<br>'; ?>
							<?php //echo $post->state.'<br>'; ?>
							<?php //echo $post->last_modified.'<br>'; ?>
							<?php //echo $post->tag_list.'<br>'; ?>
							<?php //echo $post->permalink.'<br>'; ?>
							<?php //echo $post->streamable.'<br>'; ?>
							<?php //echo $post->embeddable_by.'<br>'; ?>
							<?php echo $post->title.'<br>'; ?>
							<?php echo $post->description.'<br>'; ?>
							<?php echo $post->uri.'<br>'; ?>
							<?php echo $post->permalink_url.'<br>'; ?>
							<?php echo '<img src="'.$post->artwork_url.'" style="width:100%"><br>'; ?>
							<?php echo '<img src="'.$post->waveform_url.'"><br>'; ?>
							<?php echo $post->stream_url.'<br>'; ?>
							<?php echo $post->playback_count.'<br>'; ?>
							<?php echo $post->download_count.'<br>'; ?>
							<?php echo $post->favoritings_count.'<br>'; ?>
							<?php echo $post->comment_count.'<br>'; ?>
							<?php echo '<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.$post->id.'&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe><br>'; ?>
						</li>
						<?php
					}
					?>
					</ul>
				</div>
			</div>
	<?php
	}

	function get_json_data($settings){
		
		$cache = new SimpleCache();

	   //https://auth0.com/docs/connections/social/soundcloud
		// if ( $settings['force_crawl'] ) {
			
			$client_id = $settings['client_id'];
			$results = $settings['results'];
			
			$feed_url = "http://api.soundcloud.com/users/".$settings['username']."/".$settings['data_type'].".json?client_id=" . $client_id . "&limit=$results";
			// echo $feed_url;
			$content = ($settings['force_crawl']) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
			$feed = json_decode($content);
		
		// }

		return $feed;
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	
	$crawled = 0;
	
	$settings['data_type'] = 'tracks'; //'users', 'tracks', 'playlists', 'groups', 'comments'
	// $settings['username'] = 'lana-del-rey';
	$settings['username'] = 'only1dram';
	$settings['client_id'] = '2822fc3526d3500d44c9f6265f51ad7e';
	$settings['force_crawl'] = false;
	$settings['results'] = 100;
	
	$soundCloud = new SoundCloud();
	$feed = $soundCloud->get_json_data($settings);
	$feed = $soundCloud->parse_feed($feed);
	
	echo '<pre>';
	print_r($feed);
	echo '</pre>';
	// $html = $soundCloud->parse_feed($json);
}

?>