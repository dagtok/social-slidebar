<style type="text/css">
html{
	    background: #000;
}
.facebook{
	    background-color: rgb(242, 242, 242);

}
div._element>div>div._head {
    vertical-align: top;
    display: block;
    margin-left: 10px;
}
div._element>div>div._head>a{
    color: #21759b;
    font-size: 14px;
    line-height: 20px;
    font-weight: bold;
    text-decoration: none; 
}
div._element>div>div._head>a:hover {
    text-decoration: underline;
}

div._element>div>div>a.uiLinkSubtle {
    color: rgb(137, 145, 156);
    line-height: 20px;
    font-weight: normal;
    font-size: 10px;
    display: block;
    text-decoration: none;
}
div._element {
    background-color: rgb(255, 255, 255);
    margin: 5px;
    border: 1px solid rgb(211, 214, 219);
    border-radius:5px;
    color: black;
    width: 620px;
    display: block;
    min-height: 50px;
}
div._element>div>._img{
	float:left;
}
div._element>div>div._42ef a{
    text-decoration: none;
}
div._element>div>div._42ef {
    background-color: rgb(242,242,242);
    overflow: hidden;
    padding: 15px;
    border-color: rgb(233, 234, 237);
    border: 1px solid rgb(230, 230, 230);
    margin: 10px;
}
div._element>div>div._42ef>a>div>div.uiAttachmentTitle {
    color: rgb(59, 89, 152);
}
div._element>div>div._42ef>a>div>div.uiAttachmentDesc{
    padding: 3px 0px;
    font-size: 10px;
    color: rgb(75,75,75);
    text-align: justify;
}
div._element>div>div._42ef>a>div>div.uiAttachmentTitle>span.caption {
color: rgb(201, 201, 201);
}

.uiScaledImageCentered {
    background-color: rgb(242, 242, 242);
    text-align: center;
}
.uiScaledImageContainer {
    position: relative;
    overflow: hidden;
    margin: 10px;
    padding: 10px;
    border-color: rgb(233, 234, 237);
    border: 1px solid rgb(230, 230, 230);
}
div._element > div > div._42ef > a > div > div.uiAttachmentTitle>strong{
    font-size: 10px;
}

div._element > div > div._42ef > a > div.attachmentText> span.caption{
    font-size: 11px;
    color: rgb(150,150,150);
    text-align: justify;
}

div._element>div>div._head {
    vertical-align: top;
    display: block;
    margin-left: 10px;
}
div._element>div>div._head>a{
    color: #21759b;
    font-size: 14px;
    line-height: 20px;
    font-weight: bold;
    text-decoration: none; 
}
div._element>div>div._head>a:hover {
    text-decoration: underline;
}
div._element>div.message{
	    margin: 10px;	
}

</style>
<?php
ini_set('display_errors', 'On');
ini_set('display_errors', 1);
?>
<div class="facebook">
<div class="nano-content">
<div class="feed">	
<div class="_element">
	<div style="display:block; margin:10px; margin-bottom:20px;" >
		<?php 
		echo   '<a id="js_3" class="_img" href="https://www.facebook.com/'.$_GET['id'].'" target="_blank">
					<img class="_50c7 img" alt="" src="'.$_GET['uri'].'"></img>
				</a>
				<div class="_head">
					<a href="https://www.facebook.com/'.$_GET['id'].'" target="_blank">'.$_GET['name'].'</a>
				</div>
				<div>
					<a class="uiLinkSubtle" href="'.(isset($_GET['link']) ? $_GET['link'] : NULL).'" target="_blank">
					'.$_GET['created_time'].'
					</a>
				</div>
				';
		?>
	</div>
	<div class="message">
	<?php
		if(isset($_GET['message']))
			echo $_GET['message'];
		else
			if(isset($_GET['story']))
			 echo $_GET['story'];

		echo '</div>';	
		if($_GET['type'] == 'link' && isset($_GET['link'])) {
			echo '
				<div class="clearfix shareRedesignContainer">
					<div class="_42ef">
						<a class="pam shareText" target="_blank" href="'.$_GET['link_a'].'">
							<div class="attachmentText fsm fwn fcg">
								<div class="uiAttachmentTitle" >
									<strong>'
									.(isset($_GET['name_a']) ? $_GET['name_a'] : NULL).	
									'</strong>
								</div>
								<span class="caption" >'
								.(isset($_GET['caption_a']) ? $_GET['caption_a'] : NULL).	
								'</span>
								<div class="mts uiAttachmentDesc translationEligibleUserAttachmentMessage" >'
								.(isset($_GET['description_a']) ? $_GET['description_a'] : NULL).	
								'</div>		
							</div>
						</a>
					</div>
				</div>';
		}
		if($_GET['type']=='photo'){
			echo '
				<div class="photoUnit clearfix">
					<div class="_53s uiScaledThumb photo photoWidth1">
						<a class="_6i9" rel="theater" href="https://www.facebook.com/photo.php?fbid='.$_GET['object_id'].'" target="_blank">
							<div class="uiScaledImageContainer photoWrap uiScaledImageCentered">
								<img class="photoImg" style="max-width:100%;" alt="Foto: prueba" src="'.$_GET['picture'].'"></img>
							</div>
						</a>
					</div>
				</div>';
		}
	?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=399610060155188";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div style="width:620px;">
<div class="fb-like" data-href="<?php echo $_GET['url']?>" data-send="false" data-width="600" data-show-faces="false" style="margin: 10px;"></div>
<div class="fb-comments" data-href="<?php echo $_GET['url']?>" data-width="620" data-num-posts="10"></div>
</div>
</div>
</div>
</div>
</div>
