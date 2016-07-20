<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<?php  
/**
 * Pinterest Tools
 */
include 'simple_cache.php';

class Pinterest{
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
		// $url_info = str_replace('dribbble.php', 'dribbble.json', __FILE__);
		// $url_posts = str_replace('dribbble.php', 'dribbble_posts.json', __FILE__);
		
		// if(file_exists($url_info) AND file_exists($url_posts)){
		// 	$json_info = file_get_contents($url_info);
		// 	$json_info = json_decode($json_info);
		// 	$json_posts = file_get_contents($url_posts);
		// 	$json_posts = json_decode($json_posts);
			$json_posts = $data->channel->item;
			// echo sizeof($json_posts);
			?>
			<div id="pinterest" class="nano">
				<div class="nano-content">
					<ul>
					<?php
					foreach ($json_posts as $post) { ?>
						<li>
							<?php 
								//echo $post->description.'<br>'; 
								//preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $post->description, $matches);
								// echo "<pre>";
								// print_r($matches[1]);
								// echo "</pre>";
							?>
							<?php echo $post->description; ?>
							<p class="content">
								<span class="author">De dagtok </span><br>
								<span class="title"><?php echo $post->title; ?></span><br>
								<?php //echo $matches[1]; ?>
								<?php //echo $post->link.'<br>'; ?>
								<span class="pub-date"><?php echo $post->pubDate; ?></span><br>
								<?php //echo $post->guid.'<br>'; ?>
							</p>
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

		if ( $settings['force_crawl'] ) {
			$feed_url = "https://www.pinterest.com/" . $settings['username'] . "/feed.rss";
			$content = ($settings['force_crawl']) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
			$feed = simplexml_load_string($content);
        }

		return $feed;
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	
	$pinterest = new Pinterest(null);
	
	$crawled = 0;
	$settings['username'] = 'cotemaison';
	$settings['force_crawl'] = true;
		
	$feed_data = $pinterest->get_json_data( $settings );
	$pinterest->parse_feed($feed_data);
	
	// echo '<pre>';
	// print_r($feed_data);
	// echo '</pre>';

}