<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<style type="text/css">
	body{
		background-color: white
	}
</style>
<?php  
/**
 * Dribbble Tools
 */
include 'simple_cache.php';

class Dribbble{
	// public $plugin_name;
	// public $api_key;
	// public $url;
	// public $blog_name;
	
	function __construct(){
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
			?>
			<div id="dribbble" class="nano">
				<div class="nano-content">
					<ul>
					<?php
					foreach ($json_posts as $post) { ?>
						<li>
							<?php echo '<a class="title" href="'.$post->images->hidpi.'">'; ?>
							<?php echo '<img src="'.$post->images->normal.'" width="100%">'; ?>
							<?php echo '</a>'; ?>
							<?php echo '<a class="title" href="'.$post->html_url.'">'.$post->title.'</a><br>'; ?>
							<?php //echo $post->description.'<br>'; ?>
							<?php echo 'views '.$post->views_count; ?>
							<?php echo 'comments '.$post->comments_count; ?>
							<?php echo 'likes '.$post->likes_count.'<br>'; ?>
							<?php
								// echo '<ul class="tags">';
								// foreach ($post->tags as $tag) {
								// 	echo '<li>'.$tag.'</li>';
								// }
								// echo '</ul>';
							?>
							<?php //echo '<img src="'.$post->images->hidpi.'"><br>'; ?>
							<?php //echo '<img src="'.$post->images->teaser.'"><br>'; ?>
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
				
		$token = $settings['access_token'];
		$username = $settings['username'];
		$partOfUrl = ($settings['timeline_type'] == 'liked') ? 'likes' : 'shots';
		$feed_url = "https://api.dribbble.com/v1/users/{$username}/{$partOfUrl}?access_token={$token}&sort=recent&page=".$settings['page'];
		$content = ($settings['force_crawl']) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
		$feed = json_decode($content);

		return $feed;
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	$dribbble = new Dribbble();
	
	//TUMBLR
	$crawled = 0;

	$settings['access_token'] = '047cef63065c6aff3b8928ce3279aa8cf0157a5904889206cd890a084083c464';
	$settings['username'] = 'prakhar';
	$settings['timeline_type'] = 'shots';
	$settings['force_crawl'] = false;
	$settings['page'] = 1;

	$feed_data = $dribbble->get_json_data( $settings );
	// echo "<pre>";
	// print_r($feed_data);
	// echo "</pre>";
	$html_feed = $dribbble->parse_feed( $feed_data );

	// echo $html_feed;

	// echo $tumblr->data();
}