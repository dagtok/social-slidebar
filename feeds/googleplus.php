<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<style type="text/css">
	body{
		background-color: white
	}
</style>
<?php  
/**
 * GooglePlus Tools
 */

include 'simple_cache.php';

class GooglePlus{
	// public $plugin_name;
	// public $access_token;
	// public $url;
	// public $refresh_token;

	function __construct(){
		// $this->plugin_name="Kiibal";
		// $this->access_token=$token;//access token del usuario
		// $this->url='https://www.googleapis.com/plus/v1/people/';//url de la api
		// $this->refresh_token=$refresh;//refresh token del usuario
	}

	function write_json_file($name,$tumblr){
		try{
			$fp = fopen(str_replace('googleplus.php', $name.'.json', __FILE__), 'w');
			if(!($fp==false)){
				fwrite($fp, $tumblr);
				fclose($fp);
			}
		} catch (Exception $e) {
			
		}
	}

	function parse_feed($feed_data){
		$result = NULL;
		// $url_info = str_replace('googleplus.php', 'googleplus_info.json', __FILE__);
		// $url_updates = str_replace('googleplus.php', 'googleplus_updates.json', __FILE__);
		
		// if(file_exists($url_info) AND file_exists($url_updates)){
		// 	$profile_info = json_decode(file_get_contents($url_info));//info del perfil, usar id de usuario o "me" para perfil propio 
		// 	$updates=json_decode(file_get_contents($url_updates)); //feed del usuario, usar id de usuario o "me" para perfil propio 
		// 	?>

			<!-- <div id="panel" style="height: 582px; left: 0px;"> -->
		<div id="dribbble" class="nano">
				<div class="nano-content">
					<ul>
					<?php
					foreach ($feed_data->items as $post) { ?>
						<li>
							<?php 
							echo '<a href="'.$post->actor->url.'">';
							echo '<img src="'.$post->actor->image->url.'">';
							echo $post->actor->displayName.'<br>'; 
							echo '</a>';
							echo $post->published;
							echo '<hr>';
							echo $post->title.'<br>';
							//echo $post->object->objectType;
							//echo $post->object->attachments[0]->objectType.'<br>';
							echo $post->object->attachments[0]->displayName.'<br><br>';
							echo $post->object->attachments[0]->content.'<br>';

							echo '<a href="'.$post->object->attachments[0]->url.'">';
							echo '<img src="'.$post->object->attachments[0]->fullImage->url.'" style="width:100%">';
							echo '</a>';
							?>
						</li>
						<?php
					}
					?>
					</ul>
				</div>
		</div>
		<?php
		// } else {
		// 	echo 'Json File doesnot exists';
		// }
		// return $result;
	}



	function get_live_json_data($settings){
		// $uri=$resource.'?access_token='.$this->access_token;
		// $options = array(
		// 	CURLOPT_HEADER => false,
		// 	CURLOPT_URL => $this->url.$uri,
		// 	CURLOPT_RETURNTRANSFER => true,
		// 	CURLOPT_SSL_VERIFYPEER => false
		// );
		
		// $feed = curl_init();
		// curl_setopt_array($feed, $options);
		// $result = curl_exec($feed);
		// $info = curl_getinfo($feed);
		// if(curl_getinfo($feed, CURLINFO_HTTP_CODE) != 200){
		// 	  if(curl_getinfo($feed, CURLINFO_HTTP_CODE) == 401){
		// 		curl_close($feed);
		// 		$postfields='client_id=86359086070.apps.googleusercontent.com&client_secret=jOpyXhLhu6oI2Au_APlks3FC&refresh_token='.$this->refresh_token.'&grant_type=refresh_token';
		// 		$options = array(
				
		// 		CURLOPT_HEADER => false,
		// 		CURLOPT_URL => 'https://accounts.google.com/o/oauth2/token',
		// 		CURLOPT_RETURNTRANSFER => true,
		// 		CURLOPT_SSL_VERIFYPEER => false
		// 		);
		// 		$feed = curl_init();
		// 		curl_setopt_array($feed, $options);
		// 		curl_setopt($feed,CURLOPT_POST, 4);
		// 		curl_setopt($feed,CURLOPT_POSTFIELDS, $postfields);
		// 		$result = curl_exec($feed);
		// 		$info = curl_getinfo($feed);
		// 		$result=json_decode($result);
		// 		$this->access_token=$result->access_token;

		// 		return $this->get_live_json_data($resource);
		// 	  }	else {
		// 	  	curl_close($feed);
		// 	  	return NULL;
		// 	  }
		// } else {
		//		curl_close($feed);
		//		return $result;
		// }
		$cache = new SimpleCache();
		$api_key = $settings['api_key'];
				
		// if ($nextPageToken = @$_SESSION[$sb_label]['loadcrawl'][$social_network.$i.$key2])
  		//	$pageToken = '&pageToken='.$nextPageToken;
        $feed_url = 'https://www.googleapis.com/plus/v1/people/' . $settings['user_id'] . '/activities/public?maxResults=' . $settings['results'] . @$pageToken . '&key=' . $api_key;

        $content = ( $settings['force_crawl'] ) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
		
		$feed = @json_decode($content);
        if (@$feed->error) {
            $feed = null;
        }
        //echo "<pre>";
        //print_r($feed);
        //echo "</pre>";
        return $feed;
	}
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	
	$crawled = 0;
	$settings['results'] = 100;
	$settings['api_key'] = 'AIzaSyBRnt4x56w0tFGh2RLYJHBNYUvGKp1G0nQ';
	$settings['user_id'] = '108993345500421220863';
	$settings['force_crawl'] = true;

	$google_plus = new GooglePlus();
	$data = $google_plus->get_live_json_data($settings);
	$google_plus->parse_feed($data);


	// echo "<pre>";
	// print_r($data);
	// echo "</pre>";	

	// echo $tb->data();
}
?>