<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<style type="text/css">
	body{
		background-color: white
	}
</style>
<?php  
/**
 * Foursquare Tools
 */
include 'simple_cache.php';

class Foursquare{
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

	function show_tip_feed($data){

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
			<div id="foursquare" class="nano">
				<div class="nano-content">
					<ul>
					<?php
					foreach ($json_posts as $post) { ?>
						<li>
							<?php 
								if(isset($post->photo)){
									echo '<a class="title" href="'.$post->url.'">';
									echo '<img src="'.$post->photo.'" width="100%">';
									echo '</a>';
								}
							?>

							<?php echo '<a class="title" href="'.$post->url.'">'.$post->text.'</a><br>'; ?>
							<?php //echo $post->description.'<br>'; ?>
							<?php echo 'date '.$post->date; ?>
							<?php echo 'agree '.$post->agree; ?>
							<?php echo 'disagree '.$post->disagree.'<br>'; ?>
							
							<?php echo '<img src="'.$post->user->photo.'"> '.$post->user->name; ?>
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

	function show_photo_feed($data){

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
			<div id="foursquare" class="nano">
				<div class="nano-content">
					<ul>
					<?php
					foreach ($json_posts as $post) { ?>
						<li>
							<?php 
								if(isset($post->photo_url)){
									//echo '<a class="title" href="'.$post->url.'">';
									echo '<img src="'.$post->photo_url.'" width="100%">';
									echo $post->date.'<br>';
						            echo '<img src="'.$post->user->photo.'"> '.$post->user->name.'<br>';
									// echo '</a>';
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
	}

	function get_blog_avatar(){
		$uri=$this->blog_name.'/avatar?api_key=';
		return $this->url.$uri.$this->api_key;
	}
	
	function parse_feed($settings){
		
		$cache = new SimpleCache();

		//USER's CONFIGURATION
		$setoption['section_foursquare']['venue_id'] = '551c2bf6498e1cf926bbbe0e';
		// $setoption['section_foursquare']['venue_id'] = '51a2445e5019c80b56934c75';
		$setoption['section_foursquare']['access_token'] = 'BAGG02KESXJ20AVVWR0WMS4DWOL4LQPOHM330OLWUDJVHPMW';
		$setoption['section_foursquare']['content_type'] = 'photos';
		$setoption['section_foursquare']['clientId'] = 'Q5Y302JD0MKY3CBIUGFWOM3Z1LI5GWQZ514DTXYR3OGIPR4M';
		$setoption['section_foursquare']['clientSecret'] = 'L12BWDJY1YOC1YPHDX3LXRCFVZLGRUJHW4AKVLKFZMHOPEHI';

		$venue_id = $setoption['section_foursquare']['venue_id'];
		$token = $setoption['section_foursquare']['access_token'];
		$content_type = $setoption['section_foursquare']['content_type'];
		$client_id = $setoption['section_foursquare']['clientId'];
		$client_secret = $setoption['section_foursquare']['clientSecret'];
		$request_date = '20160128';
		$limit = 40;
		
		//$venue_id = '4d0ad0446c51a1430da7a635'; // Reich by wolters
		// $venue_id = '51a2445e5019c80b56934c75'; //Torre Iffel
		//$venue_id = '51eabef6498e10cf3aea7942'; //Torre Iffel
		
		switch ($content_type) {
			case 'tips':
				$feed_url = "https://api.foursquare.com/v2/venues/{$venue_id}/tips?sort=recent&client_id={$client_id}&client_secret={$client_secret}&v={$request_date}&limit={$limit}";
				break;
			case 'photos':
				$feed_url = "https://api.foursquare.com/v2/venues/{$venue_id}/photos?sort=recent&client_id={$client_id}&client_secret={$client_secret}&v={$request_date}&limit={$limit}";
				break;
			
			default:
				$feed_url = null;
				break;
		}
		
		//Search user
		//$feed_url = "https://api.foursquare.com/v2/users/search?any=dagtok&oauth_token=".$setoption['section_foursquare']['access_token']."&v=20160715";

		//FIND A PLACE
		//FOURSQUARE API WEB SITE  PLAYGROUND 
		//https://developer.foursquare.com/docs/explore#req=venues/search%3Fnear%3Dparis%26query%3Deiffel
		// How i need to call the api
		//https://api.foursquare.com/v2/venues/search?near=lindavista&query=parque&oauth_token=BAGG02KESXJ20AVVWR0WMS4DWOL4LQPOHM330OLWUDJVHPMW&v=20160715

		$feed_content = ($settings['force_crawl']) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
		$feed_stream = array();
		$feed = json_decode($feed_content);

		if($content_type == 'tips'){
			if(isset($feed->response->tips->items)){
				for ($i=0; $i < sizeof($feed->response->tips->items); $i++) { 
					$item = new stdClass();
					$item->url = $feed->response->tips->items[$i]->canonicalUrl;
					$item->agree = $feed->response->tips->items[$i]->agreeCount;
					$item->disagree = $feed->response->tips->items[$i]->disagreeCount;
					$item->date = $feed->response->tips->items[$i]->createdAt;
					$item->text = $feed->response->tips->items[$i]->text;
					
					if(isset($feed->response->tips->items[$i]->photo)){
						$item->photo = $feed->response->tips->items[$i]->photo->prefix.'300x300'.$feed->response->tips->items[$i]->photo->suffix;
					} else {
						$item->photo = null;
					}
					
					$item->user = new stdClass();
					
					if( isset($feed->response->tips->items[$i]->user->firstName) &&
						isset($feed->response->tips->items[$i]->user->lastName)){

						$item->user->name = $feed->response->tips->items[$i]->user->firstName.' '.$feed->response->tips->items[$i]->user->lastName;	

					} else if( isset($feed->response->tips->items[$i]->user->firstName) ){

						$item->user->name = $feed->response->tips->items[$i]->user->firstName;	
					}
					
		            $item->user->photo = $feed->response->tips->items[$i]->user->photo->prefix.'40x40'.$feed->response->tips->items[$i]->user->photo->suffix;
		            array_push($feed_stream, $item);
				}		
			}
		} elseif($content_type == 'photos'){
			if(isset($feed->response->photos->items)){
				for($i=0; $i < sizeof($feed->response->photos->items); $i++) { 
					$item = new stdClass();
					$item->date = $feed->response->photos->items[$i]->createdAt;
					$item->photo_url = $feed->response->photos->items[$i]->prefix.
								'300'.//$feed->response->photos->items[$i]->width.
								'x'.
								'300'.//$feed->response->photos->items[$i]->height.
								$feed->response->photos->items[$i]->suffix;

					$item->user = new stdClass();
					
					if( isset($feed->response->photos->items[$i]->user->firstName) &&
						isset($feed->response->photos->items[$i]->user->lastName)){

						$item->user->name = $feed->response->photos->items[$i]->user->firstName.' '.$feed->response->photos->items[$i]->user->lastName;	

					} else if( isset($feed->response->photos->items[$i]->user->firstName) ){

						$item->user->name = $feed->response->photos->items[$i]->user->firstName;	
					}
					
		            $item->user->photo = $feed->response->photos->items[$i]->user->photo->prefix.'40x40'.$feed->response->photos->items[$i]->user->photo->suffix;
					
					array_push($feed_stream, $item);
					// echo "<pre>";
					// print_r($feed->response->photos->items[$i]);
					// echo "</pre>";
				}
			}
		}

		return $feed_stream;
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	
	$stumbleupon = new Foursquare(null);
	
	$crawled = 0;
	$settings['username'] = 'timeoutnewyork';
	$settings['force_crawl'] = true;
		
	$feed_data = $stumbleupon->parse_feed( $settings );
	//$stumbleupon->show_tip_feed( $feed_data );
	$stumbleupon->show_photo_feed( $feed_data );
	
	// echo '<pre>';
	// print_r($feed_data);
	// echo '</pre>';

}