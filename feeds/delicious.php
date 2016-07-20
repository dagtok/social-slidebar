<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<?php  
/**
 * Delicious Tools
 */
include 'simple_cache.php';

class Delicious{
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
			// echo sizeof($json_posts);
		$json_posts = $data;
		// [0] => stdClass Object
		// (
		//     [a] => mikerobertboston
		//     [d] => The Marketer’s Creative Guide to Instagram Advertising
		//     [n] => 
		//     [u] => http://cdn2.hubspot.net/hubfs/234606/Nanigans_-_The_Marketers_Creative_Guide_to_Instagram_Advertising.pdf?utm_campaign=GA-eBook-Instagram+Creative+Guide&utm_medium=email&_hsenc=p2ANqtz-9y-fP5OnpkPlAeZHbwikf_xhK7Z6o-jKRGyvdCOCX6yVrKibWejfYzNur07JtjSWXp-cyscZdTz0nCupsDRXSRJbsB_BlvODV9W-8FFfDxUmkW_ZU&_hsmi=27902123&utm_content=27902123&utm_source=hs_email&hsCtaTracking=e4a525e7-a587-47b0-a10f-4f362f69a523%7C53ee33ba-b082-46de-b14c-09b08d6f2eb4
		//     [t] => Array
		//         (
		//             [0] => Advertising
		//             [1] => MobileMarketing
		//             [2] => mobile
		//             [3] => Instagram
		//             [4] => brands
		//             [5] => SocialMedia
		//             [6] => Photography
		//             [7] => 101
		//             [8] => howto
		//             [9] => Design
		//         )
		//     [dt] => 2016-05-09T16:09:33Z
		// )
		?>
		<div id="delicious" class="nano">
			<div class="nano-content">
				<ul>
					<?php 
					foreach ($json_posts as $post) {
						// echo '<pre>';
						// print_r($post);
						// echo '</pre>';
						echo '<li>';
							echo '<img src="http://del.icio.us/static/img/logo.png">';
							echo '<a class="bookmark-title" href="'.$post->u.'">'.$post->d.'</a><br>';  // Title 
							echo '<p class="description">'.$post->n.'</p><br>'; //Description
							echo '<p class="publish-date-legend">';
							echo 'This link recently saved by carbontradewatch on '.$post->dt.'</p><br>'; //Publish date 
							echo '<ul class="tags">';
							foreach ($post->t as $tag) {
								echo '<li><a href="http://del.icio.us/carbontradewatch/'.$tag.'">'.$tag.'</a></li>';
							}
							echo '</ul>';
						echo '</li>';
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
		$feed = null;
		// http://del.icio.us/rss
		
		// if ( $settings['force_crawl']  == true) {
			$cache = new SimpleCache();
            $feed_url = "http://feeds.del.icio.us/v2/json/" . $settings['username'] . '?count=' . $settings['results'];
            $content = ($settings['force_crawl'] == false) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
            $feed = json_decode($content);
        // }

		return $feed;
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	
	$delicious = new Delicious(null);
	
	//TUMBLR
	$crawled = 0;
	$settings['username'] = 'carbontradewatch';
	$settings['results'] = 20;
	$settings['force_crawl'] = true;

	$feed_data = $delicious->get_json_data( $settings );
	$delicious->parse_feed( $feed_data );
	
	// echo "<pre>";
	// print_r($feed_data);
	// echo "</pre>";

}