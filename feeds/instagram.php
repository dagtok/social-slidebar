<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<?php  

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'simple_cache.php';

class Instagram{
	public $plugin_name;
	public $access_token;
	public $user_id;
	public $url;
	function __construct(){
		// //echo 'instagram';
		// $this->plugin_name='Kiibal';
		// $this->access_token=$token;//Access token del usuario
		// $this->user_id=$user;
		// $this->url='https://api.instagram.com/v1/';
	}
	function write_json_file($name,$instagram){
		try{
			$fp = fopen(str_replace('instagram.php', $name.'.json', __FILE__), 'w');
			if(!($fp==false)){
				fwrite($fp, $instagram);
				fclose($fp);
			}
		} catch (Exception $e) {
			
		}	
	}

	function parse_feed($feed){
		$result = NULL;
		// $url_info = str_replace('instagram.php', 'instagram_info.json', __FILE__);
		// $url_feed = str_replace('instagram.php', 'instagram_feed.json', __FILE__);
		// $url_follows= str_replace('instagram.php', 'instagram_follows.json', __FILE__);
		// $url_followed= str_replace('instagram.php', 'instagram_followed.json', __FILE__);
		// if(file_exists($url_info) AND file_exists($url_feed) AND file_exists($url_follows) AND file_exists($url_followed)){
		// 	$info = file_get_contents($url_info);
		// 	$info = json_decode($info);
		// 	$feed = file_get_contents($url_feed);
		// 	$feed = json_decode($feed);
		// 	$follows =file_get_contents($url_follows);
		// 	$follows =json_decode($follows);
		// 	$followed =file_get_contents($url_followed);
		// 	$followed =json_decode($followed);

		$tmp_settings['force_crawl'] = false;
		$tmp_settings['access_token'] = '213320447.50dd2f9.b3f3d5ac6e04463c9fa4bde0a11b0d3f';
		$tmp_settings['content_type'] = 'profile_info'; //profile_info (requires numeric user id), recent_media, likes, search_location, location_id, search_tag, 	
		$tmp_settings['results'] = 20; //results per page
		$tmp_settings['feed_value'] = '213320447'; //User id ...applies for [profile_info, ]
		$profile_info = $this->get_feed_json_data($tmp_settings);
		// echo "<pre>";
		// print_r($profile_info);
		// echo "</pre>";
		// exit();
		?>
		<div id="instagram" class="nano">	
			<div class="nano-content" tabindex="0" style="right: -17px;">
				<!-- PROFILE -->
			    <div class="profile-card">
			        <div class="profile-header-inner" style="background-image: url(<?php //echo $profile_info->items[0]->brandingSettings->image->bannerMobileLowImageUrl; ?>);">
			          <!-- <div class="profile-header-inner-overlay"></div> -->
			          	<a href="#" class="profile-picture" target="_blank">
							<img src="<?php echo $profile_info->data->profile_picture; ?>" alt="" width="50px" height="50px">
						</a>
			          	<div class="profile-card-inner" data-screen-name="dagtok" data-user-id="29707259">
			            <h1 class="fullname editable-group">
							<span class="profile-field"><?php echo $profile_info->data->full_name; ?></span>
			           	</h1>
			           	<p class="location-and-url">
			           		<span class="location-container editable-group">
				            	<span class="location profile-field">
				                	$profile_info->items[0]->snippet->description;
				                </span>
				            </span>
						</p>
			          </div>
			        </div>
			    </div>
			    <!-- PROFILE -->
		
			    <div class="feed">
				
					<?php 
					if(isset($feed->meta->code) AND $feed->meta->code == 200){
						echo '<ul style="color:black; background-color:#dfe0e1;" class="photofeed">';
						foreach ($feed->data as $photo_feed) {
							echo '<li>';
							
							// echo "<pre>";
							// print_r($photo_feed);
							// echo "</pre>";

							echo '<div class="profile_info">';
								echo isset($photo_feed->caption->from->profile_picture) ? '<img src="'.$photo_feed->caption->from->profile_picture.'" class="profile_picture" width="50">' : NULL;
								echo isset($photo_feed->caption->from->full_name) ? '<div class="full_name">'.$photo_feed->caption->from->full_name.'</div>' : NULL;
								echo isset($photo_feed->caption->from->username) ? '<div class="username">'.$photo_feed->caption->from->username.'</div>' : NULL;
							echo '</div>';

							echo '<a class="socialslidebar_element" href="'.$photo_feed->images->standard_resolution->url.'">
									<img src="'.$photo_feed->images->low_resolution->url.'" width="280"></a>
									<br>';
									$photo_feed->attribution;
							
							if(isset($photo_feed->comments->data)){
								echo '<ul class="likes">';
								foreach ($photo_feed->comments->data as $comment) {
									echo '<li>';
										echo '<img src="'.$comment->from->profile_picture.'" width="40" >';
										echo '<span><div class="user_name">'.$comment->from->username.'</div><br>';
										echo '<div class="full_name">'.$comment->from->full_name.'</div><br>';
										echo $comment->text.'<br></span>';
									echo '</li>';
								}
								echo '</ul>';
							}

							echo '<ul class="tags">';
							foreach ($photo_feed->tags as $tag) {
								echo '<li>'.$tag.'</li>';
							}
							echo '</ul>';
								if(isset($photo_feed->likes->data)){
									echo '<ul class="comments">';
									foreach ($photo_feed->likes->data as $like) {
										echo '<li>';
										echo '<img src="'.$like->profile_picture.'" width="40" title="'.$like->full_name.'"><br>';
										echo '</li>';
									}
									echo '</ul>';
								}
							echo '</li>';
						}
						echo '</ul>';
					}
					?>
				</div>
			</div>
		</div>
		<?php
		// } else {
		// 	//Aquí empieza el html para los mensajes de error en configuración
		// }
		return $result;
	}

	function get_feed_json_data($settings){

		$cache = new SimpleCache();

		$instagram_access_token = $settings['access_token'];
		$max_str = 'max_id';
		$feed_url = '';
		
		// echo $settings['content_type'];
		// exit;
		switch ($settings['content_type']) { 
			
			case 'profile_info': //Get user profile information.
				$feed_url = 'https://api.instagram.com/v1/users/'.$settings['feed_value'].'/?access_token=' . $instagram_access_token;
				break;

			case 'recent_media': //Get the most recent media of the user.

				//get user id
				$user_url = 'https://api.instagram.com/v1/users/search?q='.$settings['feed_value'].'&access_token=' . $instagram_access_token;
				// echo $user_url;
				$user_content = ( $settings['force_crawl'] == true) ? $cache->get_data($user_url, $user_url) : $cache->do_curl($user_url);
				
				//get recent media by user
				if ($user_content) {
					$user_feed = json_decode($user_content);
				    if ( ! empty($user_feed->data) ){
				  //   	echo '<pre>';
						// print_r(json_decode($user_content));
						// echo '</pre>';
						// exit;
				        $feed_url = 'https://api.instagram.com/v1/users/' . $user_feed->data[0]->id . '/media/recent/?access_token='.$instagram_access_token.'&count=' . $settings['results'];
				    }
				}
				break;

			case 'likes': //Get the recent media liked by the user.
				$feed_url = 'https://api.instagram.com/v1/users/self/media/liked??access_token=' . $instagram_access_token;	
				break;
			
			case 'location_id': //Retrive photos related with specified location ID
				$feed_url = 'https://api.instagram.com/v1/locations/' . $settings['feed_value'] . '/media/recent?access_token=' . $instagram_access_token;
				break;

			case 'search_location':
			    $feed_url = 'https://api.instagram.com/v1/media/search?lat=' . $settings['coordinates']['lat'] . '&lng=' . $settings['coordinates']['lng'] . '&distance=' . $settings['coordinates']['distance'];
			    $max_str = 'max_timestamp';
				break;
			case 'search_tag': //Search on tags
		    	$feed_url = 'https://api.instagram.com/v1/tags/'.$settings['feed_value'].'/media/recent?access_token=' . $instagram_access_token;
				break;
			default:
				$feed_url = null;
				break;
		}
		    
		
		$feed_url .= '&access_token=' . $instagram_access_token;
		// echo $feed_url;
		// exit();

		if (isset($feed_url) && strlen($feed_url) > 0) {
		    // if ($next_max_id = $_SESSION[$sb_label]['loadcrawl'][$social_network.$i.$key2])
		    //     $feed_url .= '&'. $max_str .'='.$next_max_id;
		    
		    $content = ($settings['force_crawl'] == true) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
		    
		    $feed = json_decode($content);
		    
		    // echo "<pre>";
		    // print_r($feed);
		    // print_r($settings['content_type']);
		    // print_r($content);
		    // echo "</pre>";
		    // exit;

		    return $feed;
		}
	}
}
/**
 * Flickr Tools
 */

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	

	//Type of content type
	//1 => profile_info //Get user profile information.
	//2 => recent_media  //Get the most recent media of the user.
	//3 => likes //Get the recent media liked by the user.
	//4 => search_location //Get the location id based on specified lat and lng
	//5 => location_id //Search locations to get location id's
	//6 => tag //Search on tags
	
	$crawled = 0;
	$settings['force_crawl'] = false;
	$settings['access_token'] = '213320447.50dd2f9.b3f3d5ac6e04463c9fa4bde0a11b0d3f';
	$settings['content_type'] = 'recent_media'; //profile_info (requires numeric user id), recent_media, likes, search_location, location_id, search_tag, 	
	$settings['results'] = 20; //results per page
	// $settings['feed_value'] = '5147512'; //User id ...applies for [profile_info, ]
	$settings['feed_value'] = 'dagtok'; //Only whent type recent_media
	// $settings['feed_value'] = '214534678'; // Only applies when content type is :: Location ID
	// $settings['feed_value'] = 'superBowl'; //Search on tags
	
	//Only applies when content type is :: search_location
	// $settings['coordinates']['lat'] = '48.858844';
	// $settings['coordinates']['lng'] = '2.294351';
	// $settings['coordinates']['distance'] = '100';

	
	//Get access token with 
	//	https://api.instagram.com/oauth/authorize/?client_id=CLIENT-ID&redirect_uri=REDIRECT-URI&response_type=token
	//	https://api.instagram.com/oauth/authorize/?client_id=50dd2f9ab62d48b08611266d4e11989f&redirect_uri=http://kanban.house&response_type=token
	
	$Instagram = new Instagram();
	$data = $Instagram->get_feed_json_data($settings);
	// echo "<pre>";
	// print_r($data);
	// echo "</pre>";
	// exit();
	$html = $Instagram->parse_feed($data);


	// echo $tb->data();
}