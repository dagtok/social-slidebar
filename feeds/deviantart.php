<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'simple_cache.php';

class DeviantArt{
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
		// [title] => No Motion
		// [link] => http://ivanandreevich.deviantart.com/art/No-Motion-604615977
		// [guid] => http://ivanandreevich.deviantart.com/art/No-Motion-604615977
		// [pubDate] => Fri, 22 Apr 2016 15:51:08 PDT
		// [description] => Quiet evening on the river. Remake of ivanandreevich.deviantart.com/…

		// Location: Terra Nova, Richmond, Beautiful British Columbia, Canada. 
		// Equipment: Nikon D5200 + Nikon 10-24mm. 
		// Processing: Photomatix Pro 5 and Photoshop CC from 3 x RAW.

		// Follow me on: Facebook | Instagram | Tumblr
		// thumbnail
		// echo '<pre>';
		// print_r($data->channel->item);
		// echo '</pre>';
	?>
      
		<div id="deviantart" class="nano"> 
			<div class="nano-content">
			  <ul>
			    <?php 
			    foreach ($data->channel->item as $post) {
			    	echo '<li>';
				    	echo '<div class="title"><a href="'.$post->guid.'">'.$post->title.'</a></div>';
				    	// echo $post->description.'<br>';
				    	// echo $post->pubDate.'<br>';
						if(isset($post->description) && strlen($post->description) > 0){
							$doc = new DOMDocument();
							$doc->loadHTML($post->description);
							$imageTags = $doc->getElementsByTagName('img');

							foreach($imageTags as $tag) {
								$img_src = $tag->getAttribute('src');
							}
							echo '<img width="100%" src="'.$img_src.'">';
						}
			    	echo '</li>';
			     //  	echo '
			     //        <li class="video-thumb">
			     //            <div class="profile-header-inner" style="background-image: url('.$video->thumbnail_medium.');">
								// <div class="yt_shadow"></div>
								// 	<a class="socialslidebar_element profile-picture social_sprite play_control" href="wp-content/plugins/social-slidebar/feeds/deviantArt_comment.php?src='.$video->id.'" > 
								// 	  <img src="#" alt="" width="5px" height="5px">
								// 	</a>
								// 	<div class="video-thumb-inner">
								// 	  <h2 class="username">
								// 	        <a target="_blank" rel="me nofollow" href="'.$video->url.'" class="screen-name"></a>
								// 	  </h2>
								// 	</div>
			     //           		</div>
			     //        		<div class="description"><span><a href="'.$video->url.'">'.$video->title.'</a><span>
	       //      			</div>
	       //      		</li>';
			    }
			    ?>
			  </ul>
			</div>
		</div>
		<?php
	}

	function get_json_data($settings){
		
		$cache = new SimpleCache();

	    if ( $settings['force_crawl'] ) {
            $feed_url = "https://backend.deviantart.com/rss.xml?type=deviation&q=by%3A" . $settings['username'] . "+sort%3Atime+meta%3Aall";
            $content = ($settings['force_crawl']) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
            $feed = simplexml_load_string($content);
        }
        // echo '<pre>';
        // print_r($feed);
        // echo '</pre>';

		return $feed;
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	
	$crawled = 0;
	$settings['username'] = 'ivanandreevich';
	$settings['force_crawl'] = true;
	
	$deviantArt = new DeviantArt();
	$json_data = $deviantArt->get_json_data($settings);
	$deviantArt->parse_feed($json_data);
	// echo '<pre>';
	// print_r($json);
	// echo '</pre>';
}

?>