<?php  
class Facebook {
	public $plugin_name;
	public $access_token;
	public $fb_username;
	public $isFacebookPage;

	function __construct($access_token,$fb_username,$isFacebookPage) {
		$this->access_token=$access_token;
		$this->fb_username=$fb_username;
		$this->isFacebookPage=$isFacebookPage;
		$plugin_name = 'Kiibal';		
	}

	function get_stored_json_data($file){
		$route=str_replace('facebook.php',$file, __FILE__);
		if(file_exists ($route))
			return json_decode(file_get_contents($route));
		else
			return NULL;
	}
	function get_page_json_data(){
		$url_base = 'https://graph.facebook.com/me';
		$fields='?fields=friends.limit(1000).fields(id,name,picture,username,link)&access_token=';
		$url=$url_base.$fields.$this->access_token;
		$options = array(
			CURLOPT_HEADER => false,
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false
		);
		try{
		$feed = curl_init();
		curl_setopt_array($feed, $options);
		$result = curl_exec($feed);
		$info = curl_getinfo($feed);
		if(curl_getinfo($feed, CURLINFO_HTTP_CODE) != 200){
			  curl_close($feed);
			 return NULL;
			  
		}
		else{
			curl_close($feed);
			return $result;
		}
		}catch(Exception $e){
			return NULL;
		}
	}
	function get_live_json_data($resource_URL){
		$url_base = 'https://graph.facebook.com/';
		switch ($resource_URL) {
			case 'feed':
				$fields='?fields=feed.fields(message,picture,name,link,caption,description,actions,type,updated_time,created_time,from.fields(name,id,picture),id,story,privacy,object_id)&access_token=';
				break;
			case 'about_me':
				$fields='?access_token=';
				break;
			case 'friends':
				$fields='?fields=friends.limit(1000).fields(id,name,picture,username,link)&access_token=';
				break;				
			default:
				$fields='?fields=cover,picture,username,name&access_token=';
				break;
		}
		$url=$url_base.$this->fb_username.$fields.$this->access_token;
		// make request
		$options = array(
			CURLOPT_HEADER => false,
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false
		);
		 
		$feed = curl_init();
		curl_setopt_array($feed, $options);
		$result = curl_exec($feed);
		$info = curl_getinfo($feed);
		$code =curl_getinfo($feed, CURLINFO_HTTP_CODE);
		if($code != 200){
			  curl_close($feed);
			  	try{
					$fp = fopen(str_replace('facebook.php', 'facebook_error.json', __FILE__), 'w');
					if(!($fp==false)){
						fwrite($fp, $result);
						fclose($fp);
					}
			  	} catch (Exception $e) {
					
				}	
			 return NULL;
			  
		}
		else{
			curl_close($feed);
			return $result;
		}
	}

	function write_json_file($facebook, $feed, $about, $friends){
		try{
		$fp = fopen(str_replace('facebook.php', 'facebook.json', __FILE__), 'w');
		if(!($fp==false)){
			fwrite($fp, $facebook);
			fclose($fp);
		}else{
			return false;
		}
		$fp1 = fopen(str_replace('facebook.php','feed.json', __FILE__), 'w');
		if(!($fp1==false)){
			fwrite($fp1, $feed);
			fclose($fp1);
		}else{
			return false;	
		}	
		$fp2 = fopen(str_replace('facebook.php','about_me.json', __FILE__), 'w');
		if(!($fp2==false)){
			fwrite($fp2, $about);
			fclose($fp2);
		}else{
			return false;
		}
		$fp3 = fopen(str_replace('facebook.php','friends.json', __FILE__), 'w');
		if(!($fp3==false)){
			fwrite($fp3, $friends);
			fclose($fp3);
			return true;
		}else{
			return false;
		}
		} catch (Exception $e) {
			return false;
		}	
}

	function get_about_me($json_data){
		$url = str_replace('facebook.php', 'about_me.json', __FILE__);
		if(file_exists($url)){
			$homepage = file_get_contents($url);
			$data = json_decode($homepage);

			$result = '<div class="_element">
			<table class="uiInfoTable" role="presentation">';
			if(isset($data->name)){
				$result .= '
				<tbody>
					<tr>
						<th class="label">
			      			Nombre
			    		</th>
			    		<td class="data">'
			      			.$data->name.
			    		'</td>
			    	</tr>
			    </tbody>
			    ';
			}
			if(isset($data->username)){
				$result .= '
				<tbody>
					<tr>
						<th class="label">
			      			Usuario
			    		</th>
			    		<td class="data">'
			      			.$data->username.
			    		'</td>
			    	</tr>
			    </tbody>
			    ';
			}

			if(isset($data->link)){
				$result .= '
				<tbody>
					<tr>
						<th class="label">
			      			Facebook
			    		</th>
			    		<td class="data">'
			      			.$data->link.
			    		'</td>
			    	</tr>
			    </tbody>
			    ';
			}

			if(isset($data->location->name)){
				$result .= '
				<tbody>
					<tr>
						<th class="label">
			      			Ciudad
			    		</th>
			    		<td class="data">'
			      			.$data->location->name.
			    		'</td>
			    	</tr>
			    </tbody>
			    ';
			}
			
			if(isset($data->quotes)){
				$result .= '
				<tbody>
					<tr>
						<th class="label">
			      			Citas
			    		</th>
			    		<td class="data">'
			      			.$data->quotes.
			    		'</td>
			    	</tr>
			    </tbody>
			    ';
			}
			
			if(isset($data->education[0]->school->name)){
				$result .= '
				<tbody>
					<tr>
						<th class="label">
			      			Educaci&oacute;n
			    		</th>
			    		<td class="data">'
			      			.$data->education[0]->school->name.
			    		'</td>
			    	</tr>
			    </tbody>
			    ';
			}
			
			if(isset($data->gender)){
				$result .= '
				<tbody>
					<tr>
						<th class="label">
			      			Sexo
			    		</th>
			    		<td class="data">'
			      			.$data->gender.
			    		'</td>
			    	</tr>
			    </tbody>
			    ';
			}
			$result .= '</table>';
		}else{
			$url=str_replace('facebook.php', 'facebook_error.json', __FILE__);
			if(file_exists($url)){
				$homepage = file_get_contents($url);
				$data = json_decode($homepage);
				$result = '<div id="facebook" class="nano">
					<div class="nano-content"><div class="feed"><div class="_element">
							<div class="message">'.$data->error->message.'</div></div></div></div>';
			}
			else{
				$result = '<div id="facebook" class="nano">
					<div class="nano-content"><div class="feed"><div class="_element">
							<div class="message">Check your file permissions.</div></div></div></div>';	
			}
		}
		return $result;
	}

	function get_feed($json_data){
		$url = str_replace('facebook.php', 'json/feed.json', __FILE__);
		$parameters=NULL;
		
		if(file_exists($url)){
			$homepage = file_get_contents($url);
			$data = json_decode($homepage);
			$result = NULL;

			foreach ($data->feed->data as $key) {
				$result .= '
				<div class="_element">
					<div style="display:block; margin:10px; margin-bottom:20px;" >
							<a id="js_3" class="_img" href="https://www.facebook.com/'.$key->from->id.'" target="_blank">
								<img class="_50c7 img" alt="" src="'.$key->from->picture->data->url.'"></img>
							</a>
							<div class="_head">
								<a href="https://www.facebook.com/'.$key->from->id.'" target="_blank">'.$key->from->name.'</a>
							</div>
								<div>
								<a class="uiLinkSubtle" href="'.(isset($key->actions[0]->link) ? $key->actions[0]->link : NULL).'" target="_blank">
				      				'.$key->created_time.'
				    			</a>
							</div>
							</div>
							<div class="message">';
							if(isset($key->message) AND $key->message)
								$result .= $key->message;
							else
								$result .= (isset($key->story) ? $key->story : NULL);
					$result .= '</div>';
					$parameters=(isset($key->from->id) ? '&id='.$key->from->id : '')
								.(isset($key->from->picture->data->url) ? '&uri='.$key->from->picture->data->url : '')
								.(isset($key->from->name) ? '&name='.$key->from->name : '')
								.(isset($key->actions[0]->link) ? '&link='.$key->actions[0]->link : '')
								.(isset($key->created_time) ? '&created_time='.$key->created_time : '')
								.(isset($key->message) ? '&message='.$key->message : '')
								.(isset($key->type) ? '&type='.$key->type : '')
								.(isset($key->story) ? '&story='.$key->story : '');
				if($key->type == 'link' && isset($key->link)){
					$result .= '
					<div class="clearfix shareRedesignContainer">
						<div class="_42ef">
							<a class="pam shareText" target="_blank" href="'.$key->link.'">
								<div class="attachmentText fsm fwn fcg">
									<div class="uiAttachmentTitle" >
										<strong>'
										.(isset($key->name) ? $key->name : NULL).	
										'</strong>
									</div>
									<span class="caption" >'
									.(isset($key->caption) ? $key->caption : NULL).	
									'</span>
									<div class="mts uiAttachmentDesc translationEligibleUserAttachmentMessage" >'
									.(isset($key->description) ? $key->description : NULL).	
									'</div>
								</div>
							</a>
						</div>
					</div>';
					$parameters .= (isset($key->link) ? '&link_a='.$key->link : '')
								.(isset($key->name) ? '&name_a='.$key->name : '')
								.(isset($key->caption) ? '&caption_a='.$key->caption : '')
								.(isset($key->description) ? '&description_a='.$key->description : '');
				}
				if($key->type=='photo'){
					$result .= '
								<div class="photoUnit clearfix">
									<div class="_53s uiScaledThumb photo photoWidth1">
										<a class="_6i9" rel="theater" href="https://www.facebook.com/photo.php?fbid='.$key->object_id.'" target="_blank">
											<div class="uiScaledImageContainer photoWrap uiScaledImageCentered">
												<img class="photoImg" alt="Foto: prueba" src="'.$key->picture.'">
												</img>
											</div>
										</a>
									</div>
								</div>
     

					';
					$parameters .= (isset($key->object_id) ? '&object_id='.$key->object_id : '')
								.(isset($key->picture) ? '&picture='.str_replace('s.jpg', 'b.jpg', $key->picture) : '');
				}
				if(isset($key->actions[0]->link)){
					$result .= '<div class="_ids"><a class=\'view_details socialslidebar_element\' href="wp-content/plugins/social-slidebar/feeds/facebook_comment.php?url='.$key->actions[0]->link.$parameters.'" style"text-align=right">
					View Details</a></div>' ;
				}
				$result.='
				</div>';
			}
		}else{
			$url=str_replace('facebook.php', 'facebook_error.json', __FILE__);
			if(file_exists($url)){
				$homepage = file_get_contents($url);
				$data = json_decode($homepage);
				$result = '<div id="facebook" class="nano">
					<div class="nano-content"><div class="feed"><div class="_element">
							<div class="message">'.$data->error->message.'</div></div></div></div>';
			}
			else{
				$result = '<div id="facebook" class="nano">
					<div class="nano-content"><div class="feed"><div class="_element">
							<div class="message">Check your file permissions.</div></div></div></div>';	
			}
		}

		return $result;
	}

	function get_friends($json_data){

		$url = str_replace('facebook.php', 'friends.json', __FILE__);
		if(file_exists($url)){
			$homepage = file_get_contents($url);
			$data = json_decode($homepage);
			$result = NULL;

			if($this->isFacebookPage=='true'){
				$result .= '

				<div class="_element">	
					Function available only for facebook user profile.
				</div>';
			}else{
				foreach ($data->friends->data as $key) {
					$result .= '
					<div class="_element">
						<div style="display:block; margin:10px; margin-bottom:20px;" >
							<a id="js_3" class="_img" href="'.$key->link.'" target="_blank">
								<img class="_50c7 img" alt="" src="'.$key->picture->data->url.'">
							</a>
							<div class="_head">
								<a href="'.$key->link.'" target="_blank">'.$key->name.'</a>
							</div>
								<div>
									<a class="uiLinkSubtle" href="'.$key->link.'" target="_blank">';
										if(isset($key->username))
											$result .= $key->username;
				      					else
				      						$result .= 'facebook.com';
				    				$result .= '</a>
				    			</div>
							</div>
						</div>
					</div>';
				}
			}
		}else{
			$url=str_replace('facebook.php', 'facebook_error.json', __FILE__);
			if(file_exists($url)){
				$homepage = file_get_contents($url);
				$data = json_decode($homepage);
				$result = '<div id="facebook" class="nano">
					<div class="nano-content"><div class="feed"><div class="_element">
							<div class="message">'.$data->error->message.'</div></div></div></div>';
			}
			else{
				$result = '<div id="facebook" class="nano">
					<div class="nano-content"><div class="feed"><div class="_element"><div class="message">Check your file permissions.</div></div></div></div>';	
			}
		}
		return  $result;
	}

	function get_profile_info($plugin_dir = NULL){
		$url = str_replace('facebook.php', 'facebook.json', __FILE__);
		if(file_exists($url) AND isset($plugin_dir)){
			$homepage = file_get_contents($url);
			$data = json_decode($homepage);
			
			$result = '
				<div id="facebook" class="nano">
					<div class="nano-content">
						<div class="profile-card">
							<div class="profile-header-inner" style="background-image: url('.htmlentities($data->cover->source).');">
								<div class="profile-header-inner-overlay">
								</div>
								<a href="http://facebook.com/'.$data->username.'" class="profile-picture" target="_blank">
									<img src="'.htmlentities($data->picture->data->url).'" alt="" width="73px" height="73px" />
								</a>
								<div class="profile-card-inner">
									<h1 class="fullname editable-group">
									<span class="profile-field">'.htmlentities(ucwords($data->name)).'</span>
									</h1>
									<p class="location-and-url">
										<span class="location-container editable-group">
											<span class="location profile-field">'.htmlentities($data->username).'</span>
										</span>
									</p>
								</div>
							</div>
						</div>
						<div class="menu">
							<div class="_70k">
								<div id="u_0_h" class="_6_7 clearfix" data-referrer="timeline_light_nav_top">
									<a id="feed" class="_6-6" href="#" data-feed-url="'.$plugin_dir.'feeds/facebook.php?feed=get_feed&isFacebookPage='.$this->isFacebookPage.'">
									Timeline <span class="_513x"></span>
									</a>
									<a class="_6-6" href="#" data-feed-url="'.$plugin_dir.'feeds/facebook.php?feed=get_about_me&isFacebookPage='.$this->isFacebookPage.'">
									About <span class="_513x"></span>
									</a>';

									if($this->isFacebookPage=='false'){
										$result .='
										<a class="_6-6" href="#" data-feed-url="'.$plugin_dir.'feeds/facebook.php?feed=get_friends&isFacebookPage='.$this->isFacebookPage.'"">
										Friends
										<span class="_513x"></span>
										</a>';
									}	

									$result .='
								</div>
							</div>
						</div>
						<br>';
						$result .= '
						<div class="feed">
						</div>
					</div>
				</div>';
		} else {

			$url=str_replace('facebook.php', 'facebook_error.json', __FILE__);
			
			if(file_exists($url)){
				$homepage = file_get_contents($url);
				$data = json_decode($homepage);
				$result = '<div id="facebook" class="nano">
					<div class="nano-content"><div class="feed"><div class="_element">
							<div class="message">'.$data->error->message.'</div></div></div></div>';
			} else {
				$result = '<div id="facebook" class="nano">
					<div class="nano-content"><div class="feed"><div class="_element">
							<div class="message">Check your file permissions.</div></div></div></div>';	
			}
		}
		return $result;
	}
}

if (isset($_GET) AND isset($_GET['feed']) ) {

	$facebook = new Facebook(NULL,NULL,$_GET['isFacebookPage']);

	if ($_GET['feed'] == 'get_about_me') {
		echo $facebook->get_about_me('json data');
	} elseif ($_GET['feed'] == 'get_feed') {
		echo $facebook->get_feed('hoho');
	} elseif ($_GET['feed'] == 'get_friends') {
		echo $facebook->get_friends('hoho');
	} elseif ($_GET['feed'] == 'get_profile_info' AND isset($_GET['plugin_dir'])) {
		echo $facebook->get_profile_info($_GET['plugin_dir']);
	} 
}

?>