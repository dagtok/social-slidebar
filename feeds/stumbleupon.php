<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<?php  
/**
 * StumbleUpon Tools
 */
include 'simple_cache.php';

class StumbleUpon{
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
			$json_posts = $data;
			// echo sizeof($json_posts);
			//http://www.stumbleupon.com/stumbler/dagtok
			?>
			<div id="stumbleupon" class="nano">
				<div class="nano-content">
					<ul>
					<?php
					foreach ($json_posts as $post) { ?>
						<li>
							<?php 
							//echo '<img src="'.$post->images->hidpi.'"><br>'; 
							$doc = new DOMDocument();
							$doc->loadHTML($post->description);
							$imageTags = $doc->getElementsByTagName('img');

							foreach($imageTags as $tag) {
								$img_src = $tag->getAttribute('src');
								//echo $img_src;
							}
							echo '<img width="100%" src="'.$img_src.'">';
							?>
							<a href="<?php echo $post->guid; ?>" target="blank_">
								<?php //echo $post->pubDate; ?>
								<?php echo $post->title; ?>
								<?php //echo $post->link; ?>
								<?php //echo $post->comments; ?>
								<?php //echo $post->description; ?>
							</a>
						</li>
						<?php
					}
					?>
					</ul>
				</div>
			</div>
			<?php	
			return 0;
	}

	function get_blog_avatar(){
		$uri=$this->blog_name.'/avatar?api_key=';
		return $this->url.$uri.$this->api_key;
	}
	
	function get_json_data($settings){
		$feed = null;
		// if ( $settings['force_crawl'] ) {
			$cache = new SimpleCache();
			$feedtypes = array('comments', 'likes');

			foreach ($feedtypes as $type) {
				// echo $type.'<br>';
				if ($settings['feeds'][$type]) {
			        $feed_url = "http://www.stumbleupon.com/rss/stumbler/" . $settings['username'] . "/" . $type;
			        
			        $content = ( $settings['force_crawl'] == false ) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);

			        if ( $data = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA) ){
			            $feed[$type] = $data;
			        }

			    }
			}
		// }
		return $feed;
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	
	$stumbleupon = new StumbleUpon(null);
	
	$crawled = 0;
	$settings['username'] = 'dagtok';
	$settings['feeds']['comments'] = true;
	$settings['feeds']['likes'] = true;
	$settings['force_crawl'] = true;
		
	$feed_data = $stumbleupon->get_json_data( $settings );
	$feed_data = $feed_data['likes']->channel->item;

	// echo '<pre>';
	// print_r($feed_data);
	// echo '</pre>';
	// exit();

	$html_feed = $stumbleupon->parse_feed( $feed_data );
	
	//echo '<pre>';
	//print_r(sizeof($feed_data['likes']->channel->item));
	//echo '</pre>';

}