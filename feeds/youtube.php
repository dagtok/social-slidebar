<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />
<?php  
/**
 * Youtube Tools
 * rgb(231, 1, 1)
 */

include 'simple_cache.php';

class Youtube{
  // public $plugin_name;
  // public $access_token;
  // public $url;
  // public $refresh_token;
  
  function __construct($token, $refresh){
    // $this->plugin_name="Kiibal";
    // $this->access_token=$token;//Access token del usuario
    // $this->url='https://www.googleapis.com/youtube/v3/';//Ruta el api de youtube
    // $this->refresh_token=$refresh;//Refresh token del usuario
  }

  function write_json_file($name,$youtube){
    // try{
    //   $fp = fopen(str_replace('youtube.php', $name.'.json', __FILE__), 'w');
    //   if(!($fp==false)){
    //     fwrite($fp, $youtube);
    //     fclose($fp);
    //   }
    // } catch (Exception $e) {
      
    // } 
  }

  function data($feed_data){
    
    $result = NULL;
    $posts = $feed_data;

    // echo '<pre>';
    // print_r($posts->items);
    // echo '</pre>';
    // $url_info = str_replace('youtube.php', 'youtube_info.json', __FILE__);
    // $url_updates = str_replace('youtube.php', 'youtube_updates.json', __FILE__);
    
    // if(file_exists($url_info) AND file_exists($url_updates)){
    //   $info = json_decode(file_get_contents($url_info));
    //   $posts = json_decode(file_get_contents($url_updates));
      ?>
      <div id="youtube" class="nano"> 
        <div class="nano-content">   
          <!-- PROFILE -->
          <?php  if(isset($feed_data->info_data)){ ?>
            <div class="profile-card">
              <div class="profile-header-inner" style="background-image: url(<?php echo $info->items[0]->brandingSettings->image->bannerMobileLowImageUrl; ?>);">
                <div class="profile-header-inner-overlay"></div>
                <a href="#" class="profile-picture" target="_blank">
                  <img src="<?php echo $info->items[0]->snippet->thumbnails->default->url; ?>" alt="" width="73px" height="73px">
                </a>
                <div class="profile-card-inner" data-screen-name="dagtok" data-user-id="29707259">
                  <h1 class="fullname editable-group">
                    <span class="profile-field"><?php echo $info->items[0]->snippet->title; ?></span>
                  </h1>
                  <p class="location-and-url">
                    <span class="location-container editable-group">
                      <span class="location profile-field">
                        <?php echo $info->items[0]->snippet->description; ?>
                      </span>
                    </span>
                  </p>
                </div>
              </div>
            </div>
            <div class="menu">
              <div class="_70k">
                <div id="u_0_h" class="_6_7 clearfix" data-referrer="timeline_light_nav_top">
                  <a id="feed" class="_6-6 _6-7">
                    <span class="_513x" style="display: block;"><?php echo $info->items[0]->statistics->viewCount; ?> <br/>VIEWS</span>
                  </a>
                  <a class="_6-6">
                    <span><?php echo $info->items[0]->statistics->commentCount; ?> <br/>COMMENTS</span>
                  </a>
                  <a class="_6-6">
                    <span class="_gs6"> <?php echo $info->items[0]->statistics->subscriberCount; ?> <br/>STATISTICS</span>
                    <span class="_513x" style="display: none;"></span>
                  </a>
                </div>
              </div>
            </div>
          <?php } ?>
          <!-- PROFILE -->      
          <div class="profile-info">
            <div class="profile_info">
            </div>
          </div>    
          <?php
          echo '<ul>';
          foreach ($posts->items as $updates) {
            // echo '<pre>';
            // print_r($updates);
            // echo '</pre>';
            // exit;

            $thumbnail_url = NULL;
            $video_url = NULL;

            // if (isset($updates->contentDetails->upload->videoId)) { //upload
            //   $thumbnail_url = $updates->snippet->thumbnails->medium->url;
            //   $video_url = $updates->contentDetails->upload->videoId;
            // } elseif (isset($updates->contentDetails->like->resourceId->videoId)) { //like
            //   $thumbnail_url = $updates->snippet->thumbnails->medium->url;
            //   $video_url = $updates->contentDetails->like->resourceId->videoId;
            // } elseif (isset($updates->contentDetails->comment->resourceId->videoId)) { //comment
            //   echo '<h1>ESTE ES COMENTARIO</h1>';
            //   // $video_url = ;
            // } elseif (isset($updates->contentDetails->playlistItem->resourceId->videoId)) { //playlist
            //   echo '<h1>ESTE ES UN playlistItem</h1>';
            //   // $video_url = ;
            // }
            $thumbnail_url = $updates->snippet->thumbnails->medium->url;
            $video_url = $updates->snippet->resourceId->videoId;

            if ($video_url <> NULL) {
              echo '
              <li class="video-thumb">
                  <div class="profile-header-inner" style="background-image: url('.$thumbnail_url.');">
                    <div class="yt_shadow"></div>
                    <a class="socialslidebar_element profile-picture social_sprite play_control" href="wp-content/plugins/social-slidebar/feeds/youtube_comment.php?src='.$video_url.'"> 
                        <img src="#" alt="" width="5px" height="5px">
                    </a>
                    <div class="video-thumb-inner">
                        <h2 class="username">
                              <a target="_blank" rel="me nofollow" href="http://t.co/khywgqKkuq" class="screen-name"></a>
                        </h2>
                    </div>
                  </div>';
                  if (isset($updates->snippet->title)) {
                    echo '<div class="description"><span><strong>'.strtoupper($updates->snippet->resourceId->kind).'</strong>: '.$updates->snippet->title.'<span></div>';
                  }
              echo '</li>';
            }
          }
          echo '<ul>';
          ?>
        </div> <!-- END CONTENT -->
      </div> <!-- END YOUTUBE NANO -->
    <?php
    // } else {
    //   echo 'No existe los jsons';
    //   //Aquí empieza el html para los mensajes de error en configuración
    // }
    return $result;
  }


  function get_live_json_data($type, $resource){
    // if($type==1)
    //   $uri="channels?part=id%2Csnippet%2CbrandingSettings%2CcontentDetails%2CinvideoPromotion%2Cstatistics%2CtopicDetails&forUsername=".$resource."&access_token=".$this->access_token;
    // else
    //   $uri="activities?part=id%2Csnippet%2CcontentDetails&channelId=".$resource."&maxResults=20&access_token=".$this->access_token;
    // $options = array(
    //   //CURLOPT_HTTPHEADER => "Authorization: Bearer ".$this->access_token,
    //   //URLOPT_POSTFIELDS => $postfields,
    //   CURLOPT_HEADER => false,
    //   CURLOPT_URL => $this->url.$uri,
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_SSL_VERIFYPEER => false
    // );
    // //echo $this->url.$uri;
    // $feed = curl_init();
    // curl_setopt_array($feed, $options);
    // $result = curl_exec($feed);
    // $info = curl_getinfo($feed);
    // $postfields=array(
    // 'client_id'=> '86359086070.apps.googleusercontent.com',
    // 'client_secret'=>'jOpyXhLhu6oI2Au_APlks3FC',
    // 'refresh_token'=>$this->access_token,
    // 'grant_type'=>'refresh_token'
    // );
    // if(curl_getinfo($feed, CURLINFO_HTTP_CODE) != 200){//Cuando hay un error en la peticion
    //     if(curl_getinfo($feed, CURLINFO_HTTP_CODE) == 401){ //Cuando caduca el token
    //     curl_close($feed);
    //     $postfields='client_id=86359086070.apps.googleusercontent.com&client_secret=jOpyXhLhu6oI2Au_APlks3FC&refresh_token='.$this->refresh_token.'&grant_type=refresh_token';
    //     $options = array(
    //     //CURLOPT_HTTPHEADER => "Authorization: Bearer ".$this->access_token,
        
    //     //URLOPT_POSTFIELDS => $postfields,
    //     CURLOPT_HEADER => false,
    //     CURLOPT_URL => 'https://accounts.google.com/o/oauth2/token',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_SSL_VERIFYPEER => false
    //     );
    //     $feed = curl_init();
    //     curl_setopt_array($feed, $options);
    //     curl_setopt($feed,CURLOPT_POST, 4);
    //     curl_setopt($feed,CURLOPT_POSTFIELDS, $postfields);
    //     $result = curl_exec($feed);
    //     $info = curl_getinfo($feed);
    //     $result=json_decode($result);
    //     $this->access_token=$result->access_token; //obtiene el nuevo token

    //     //return NULL;
    //     return $this->get_live_json_data($type,$resource); //vuelve a realizar la petición
    //     } 
    //     else{//Cuando hay otro tipo de error
    //       curl_close($feed);
    //       return NULL;
    //     } 
        
    // }
    // else{//Cuando el resultado es correcto
    //   curl_close($feed);
    //   return $result;
    // }
  }

  function get_feed_data($settings){

    $cache = new SimpleCache();
    $google_api_key = $settings['api_key'];
    $results = $settings['results'];
    
    // if ($nextPageToken = $_SESSION[$sb_label]['loadcrawl'][$social_network.$i.$key2]){
    //   $pageToken = '&pageToken='.$nextPageToken;
    // }

    switch($settings['feed_type']) { 
      case 'profile': //Profile
        $feed_url = 'https://www.googleapis.com/youtube/v3/videos?id=7lCDEYXw3mM&key='.$google_api_key.'&part=snippet,contentDetails,statistics,status';
        break;
      case 'playlist': //Playlist
        $feed_url = 'https://www.googleapis.com/youtube/v3/playlistItems?playlistId=' . $settings['username'];
        break;
      case 'search': //Search
        $feed_url = 'https://www.googleapis.com/youtube/v3/search?q=' . rawurlencode($settings['username']);
        break;
      case 'channel': //Channel
        $channel_filter = ($settings['channel_filter'] == 'user') ? 'forUsername' : 'id';
        $user_url = 'https://www.googleapis.com/youtube/v3/channels?part=contentDetails&'.$channel_filter.'=' . $settings['username'] .'&key=' . $google_api_key;
        $user_content = ( $settings['force_crawl']  == false ) ? $cache->get_data($user_url, $user_url) : $cache->do_curl($user_url);

        // echo '<pre>';
        // print_r($user_content);
        // echo '</pre>';
        // exit();

        if ($user_content) {
          $user_feed = json_decode($user_content);
          if ($user_feed->items[0]){
            $feed_url = 'https://www.googleapis.com/youtube/v3/playlistItems?playlistId=' . $user_feed->items[0]->contentDetails->relatedPlaylists->uploads;
          }
        }
        break;
    }
    
    if($results > 50) { //Max value allowed by api
      $results = 50;
    }
    
    if ($feed_url) {
        $feed_url .= '&part=snippet&maxResults=' . $results . @$pageToken . '&key=' . $google_api_key;
        $content = ( $settings['force_crawl']) ? $cache->get_data($feed_url, $feed_url) : $cache->do_curl($feed_url);
        $feed = @json_decode($content);
    }

    return $feed;

  }

}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html') {

  $crawled = 0;
  $results = 100;
  $settings['api_key'] = 'AIzaSyBRnt4x56w0tFGh2RLYJHBNYUvGKp1G0nQ';
  // $settings['username'] = 'PLOGOV_FDu2Hp8OqGU0v5KUeDlCBSWbmK5';
  // $settings['username'] = 'lady 100'; //search term
  $settings['username'] = 'redbull'; //search term
  $settings['channel_filter'] = 'user';
  $settings['feed_type'] = 'channel';
  $settings['results'] = 50;
  $settings['force_crawl'] = true;

  $youtube = new Youtube(null, null);
  $feed_data = $youtube->get_feed_data($settings);
  $youtube->data($feed_data);

  // echo "<pre>";
  // print_r($feed_data);
  // echo "</pre>";

  // echo $tb->data();
}