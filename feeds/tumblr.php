<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<?php  
/**
 * Tumblr Tools
 */
include 'simple_cache.php';

class Tumblr{
	// public $plugin_name;
	// public $api_key;
	// public $url;
	// public $blog_name;
	
	function __construct($blog){
		// $this->plugin_name="Kiibal";
		// $this->api_key='jBaX8ouHmStqMWBYZzoEK5HlJKImRjOXYPHjrstwBWHu4wlKwY';
		// $this->url='http://api.tumblr.com/v2/blog/';
		// $this->blog_name = $blog;
	}

	function write_json_file($name,$tumblr){
		try{
			$fp = fopen(str_replace('tumblr.php', $name.'.json', __FILE__), 'w');
			if(!($fp==false)){
				fwrite($fp, $tumblr);
				fclose($fp);
			}
		} catch (Exception $e) {
			
		}	
	}

	function parse_feed($data){

		$result = NULL;
		$url_info = str_replace('tumblr.php', 'tumblr_info.json', __FILE__);
		$url_posts = str_replace('tumblr.php', 'tumblr_posts.json', __FILE__);
		
		// if(file_exists($url_info) AND file_exists($url_posts)){
		// 	$json_info = file_get_contents($url_info);
		// 	$json_info = json_decode($json_info);
		// 	$json_posts = file_get_contents($url_posts);
		// 	$json_posts = json_decode($json_posts);
			$json_posts = $data;
			?>
			<div id="tumblr" class="nano">
				<div class="nano-content">
					<ul>
					<?php
					foreach ($json_posts->response->posts as $post) { ?>
						<li>
							<span class="username"> <?php echo 'outfit-of-the-day-girls<br>'; ?> </span>
						<?php

						if($post->type == 'text' AND isset($post->source_title)) {
							echo '<a href="'.$post->post_url.'">'.$post->source_title.'</a>'; //titulo
						} elseif ($post->type == 'answer') {
							echo '<a href="'.$post->asking_url.'">'.$post->asking_name.'</a><br>';
							echo $post->question;
						}
						
						if ($post->type == 'text') {
							echo $post->body;
						} elseif ($post->type == 'photo') {
							foreach ($post->photos as $photo) {
								echo '<a href="'.$photo->alt_sizes[1]->url.'"><img src="'.$photo->alt_sizes[3]->url.'"/></a><br>';
							}
						} elseif ($post->type == 'link') {
							echo $post->title;
							echo $post->url;
							echo $post->description;
							echo isset($post->source_title) ? $post->source_title : NULL;
						}

						if($post->type == 'video')	{
							echo $post->player[0]->embed_code;
						}
						?>
						</li>
						<?php
					}
					?>
					</ul>
				</div>
			</div>
			<?php	
			return 0;
		// } else {

		// }
	}

	function get_blog_avatar(){
		$uri=$this->blog_name.'/avatar?api_key=';
		return $this->url.$uri.$this->api_key;
	}
	
	function get_json_data($settings){
		
		$cache = new SimpleCache();

		$api_key = $settings['api_key'];
				
		if($settings['timeline_type'] == 'photo' && $settings['timeline_type'] == 'audio') {
			$feed_url = "https://api.tumblr.com/v2/blog/" . $settings['username'] . ".tumblr.com/posts?api_key={$api_key}&limit=".$settings['results_per_page'];
		} else {
			$post_type = $settings['timeline_type'];
			$feed_url = "https://api.tumblr.com/v2/blog/" . $settings['username'] . ".tumblr.com/posts/{$post_type}?api_key={$api_key}&limit=".$settings['results_per_page'];
		}

		$content = ($settings['force_crawl']) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
		
		return  @json_decode($content);
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	$tumblr = new Tumblr(null);
	
	//TUMBLR
	$crawled = 0;
	$settings['username'] = 'outfit-of-the-day-girls';
	$settings['results_per_page'] = null; //max results per page
	$settings['api_key'] = 'n8aDn4yImQJ6FAktIbUoGcYzj09xe8xxejQPds4mwHn6McVP5u';
	$settings['timeline_type'] = 'photo'; //text, photo, quote, link, chat, audio, video, answer
	$settings['force_crawl'] = false;

	$feed_data = $tumblr->get_json_data( $settings );
	$html_feed = $tumblr->parse_feed( $feed_data );
	// echo "<pre>";
	// print_r($feed_data);
	// echo "</pre>";
	echo $html_feed;
}