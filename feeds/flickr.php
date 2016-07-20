<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<?php  

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'simple_cache.php';

class Flickr{
	// public $access_token;
	// public $key;
	// public $secret;
	// public $nsid;
	
	function __construct(){
		// $this->access_token=$token;//Access token del usuario
		// $this->key='102c97f4078e9e7914b9734be201c25b';//Api Key
		// $this->secret='8a1c2c992dbfdd2c';//Api Secret
		// $this->nsid=$id;//User Id
	}
	
	function write_json_file($name,$flickr){
		try{
			$fp = fopen(str_replace('flickr.php', $name.'.json', __FILE__), 'w');
			if(!($fp==false)){
				fwrite($fp, $flickr);
				fclose($fp);
			}
		} catch (Exception $e) {
			
		}	
	}

	function parse_feed($data){
		$result = NULL;
		// $url_info = str_replace('flickr.php', 'flickr_info.json', __FILE__);
		// $url_photos = str_replace('flickr.php', 'flickr_photos.json', __FILE__);
		
		// if(file_exists($url_info) AND file_exists($url_photos)){
		// 	$info = file_get_contents($url_info);
		// 	$info = json_decode($info);
		// 	$photo_feed = file_get_contents($url_photos);
		// 	$photo_feed = json_decode($photo_feed);
			echo '
			<div id="flickr" class="nano">	
				<div class="nano-content">';
		// 	echo '<div class="profile_info">';
		// 	if ($info != NULL) {
		// 		echo '<a class="full_name" href="'.$info->person->profileurl->_content.'" target="_blank">'.$info->person->realname->_content.'</a><br>';
		// 		echo '<a class="username" href="'.$info->person->profileurl->_content.'" target="_blank">'.$info->person->username->_content.'</a><br>';
		// 	} else {
		// 		echo 'Problems trying to get json info feed from social network, please verify your internet connection<br>';
		// 	}
		// 	echo '</div>';
			
		// 	if ($photo_feed != NULL AND isset($photo_feed->photos->total) AND $photo_feed->photos->total > 0) {
				echo '<ul class="feed">';
				foreach ($data->photos->photo as $photoa) {
					echo '<li>';
						echo '<a class="socialslidebar_element" href="https://farm'.$photoa->farm.'.staticflickr.com/'.$photoa->server.'/'.$photoa->id.'_'.$photoa->secret.'.jpg"><img src="https://farm'.$photoa->farm.'.staticflickr.com/'.$photoa->server.'/'.$photoa->id.'_'.$photoa->secret.'_n.jpg" width="280"/></a><br>';
						
						$tags = explode(' ',$photoa->tags);
						echo '<ul class="tags">';
						foreach ($tags as $tag) {
							echo '<li>'.$tag.'</li>';
						}
						echo '</ul>';

						$date = explode(' ', $photoa->datetaken);
						
					echo '</li>';
				}
				echo '</ul>';
			// } else {
			// 	echo 'Problems trying to get json photo feed from social network, please verify your internet connection<br>Or please ensure to have at least one photo uploaded into your account.';
			// }
			echo '</div>
			</div>';
		// } else {
		// 	echo 'Problems retryving feed options';
		// }
		return $result;
	}



	function get_live_json_data($settings){
		// if($type==1){
		// 	$uri='http://api.flickr.com/services/rest/?method=flickr.people.getInfo&api_key='.$this->key
		// 	.'&user_id='.$this->nsid.'&format=json&nojsoncallback=1';
		// } else {
		// 	$api_sig=md5($this->secret.'api_key'.$this->key.'auth_token'.$this->access_token
	 	//	.'extrasdate_taken,date_upload,description,geo,icon_server,last_update,license,machine_tags,media,o_dims,original_format,'
	 	//	.'owner_name,path_alias,tags,url_c,url_l,url_m,url_n,url_o,url_s,url_sq,url_q,url_t,url_z,views'
	 	//	.'formatjsonmethodflickr.photos.searchnojsoncallback1per_page20user_id'.$this->nsid);
			
		// 	$uri='http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key='.$this->key
		// 	.'&user_id='.$this->nsid.'&format=json&nojsoncallback=1&per_page=20&auth_token='.$this->access_token
		// 	.'&extras=date_taken,date_upload,description,geo,icon_server,last_update,license,machine_tags,media,o_dims,original_format,'
		// 	.'owner_name,path_alias,tags,url_c,url_l,url_m,url_n,url_o,url_s,url_sq,url_q,url_t,url_z,views&api_sig='.$api_sig;
		// }

		// $options = array(
		// 	CURLOPT_HEADER => false,
		// 	CURLOPT_URL => $uri,
		// 	CURLOPT_RETURNTRANSFER => true,
		// 	CURLOPT_SSL_VERIFYPEER => false
		// );

		// // echo $uri;
		// $feed = curl_init();
		// curl_setopt_array($feed, $options);
		// $result = curl_exec($feed);
		// $info = curl_getinfo($feed);
		// if(curl_getinfo($feed, CURLINFO_HTTP_CODE) != 200){//Cuando hay un error en la peticion
		// 	  	curl_close($feed);
		// 	  	return NULL;
		// } else {//Cuando el resultado es correcto
		// 	curl_close($feed);
		// 	return $result;
		// }

		//GET USER ID FROM NICKNAME http://idgettr.com/
		$cache = new SimpleCache();
		$flickr_api_key = $settings['api_key'];
		//if ($nextPage = @$_SESSION[$sb_label]['loadcrawl'][$social_network.$i.$key2])
		//    $pageToken = '&page='.$nextPage;
		if ($settings['feed_type'] = 'public_photos') {

		    $feed_type = 'flickr.people.getPublicPhotos';
		    $feed_id = '&user_id='.$settings['username'];

		} elseif ($settings['feed_type'] = 'photos') {

		    $feed_type = 'flickr.groups.pools.getPhotos';
		    $feed_id = '&group_id='.$settings['username'];

		}

		$feed_url = 'https://api.flickr.com/services/rest/?method='.$feed_type.'&api_key='.$flickr_api_key . $feed_id . '&per_page=' . $settings['results'] . @$pageToken . '&extras=date_upload,date_taken,owner_name,icon_server,tags,views&format=json&nojsoncallback=1';
		$content = ( $settings['force_crawl'] ) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
		$feed = @json_decode($content);
		return $feed;
	}
}
/**
 * Flickr Tools
 */
if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	
	$crawled = 0;
	$settings['social_network'] = 'flickr';
	$settings['feed_type'] = 'public_photos'; //photos, public_photos
	$settings['username'] = '64534310@N07';
	$settings['results'] = 100;
	$settings['api_key'] = 'e6aee07573f85f664af50e51c59ade14';
	$settings['force_crawl'] = false;
	
	$flickr = new Flickr();
	$data = $flickr->get_live_json_data($settings);
	echo $flickr->parse_feed($data);

	// echo "<pre>";
	// print_r($data);
	// echo "</pre>";
}
