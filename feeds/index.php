<!DOCTYPE html>
<html>
<head>
	<!-- <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script> -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js " type="text/javascript"></script>
</head>
<body>
	<style type="text/css">
		body{
			background-color: black;
		}
	</style>
	<script type="text/javascript">
		//alert(Math.max(document.documentElement.clientHeight, window.innerHeight || 0));
		//Math.max(document.documentElement.clientWidth, window.innerWidth || 0) //Saber el ancho de la ventana
		var feed_url_part_1 = "http://localhost:89/wp/wp-content/plugins/social-slidebar/feeds/";
		var feed_url_part_2 = ".php?feed=html&Orale";

		function changeDataSource(social_network){
			//sidebar-emulator
			// alert(social_network);
			var feed_url = feed_url_part_1 + social_network + feed_url_part_2;
			//alert(feed_url);
			$('#sidebar-emulator').attr('src', feed_url);
		}
	</script>
	<table>
		<tr>
			<td>
				<ul>
					<li>
						<button onclick="changeDataSource('delicious')">delicious</button>
					</li>
					<li>
						<button onclick="changeDataSource('deviantart')">deviantart</button>
					</li>
					<li>
						<button onclick="changeDataSource('dribbble')">dribbble</button>
					</li>
					<li>
						<button onclick="changeDataSource('flickr')">flickr</button>
					</li>
					<li>
						<button onclick="changeDataSource('foursquare')">foursquare</button>
					</li>
					<li>
						<button onclick="changeDataSource('facebook')">facebook</button>
					</li>
					<li>
						<button onclick="changeDataSource('googleplus')">googleplus</button>
					</li>
					<li>
						<button onclick="changeDataSource('instagram')">instagram</button>
					</li>
					<li>
						<button onclick="changeDataSource('pinterest')">pinterest</button>
					</li>
					<li>
						<button onclick="changeDataSource('soundcloud')">soundcloud</button>
					</li>
					<li>
						<button onclick="changeDataSource('stumbleupon')">stumbleupon</button>
					</li>
					<li>
						<button onclick="changeDataSource('tumblr')">tumblr</button>
					</li>
					<li>
						<button onclick="changeDataSource('twitter')">twitter</button>
					</li>
					<li>
						<button onclick="changeDataSource('vimeo')">vimeo</button>
					</li>
					<li>
						<button onclick="changeDataSource('vine')">vine</button>
					</li>
					<li>
						<button onclick="changeDataSource('youtube')">youtube</button>
					</li>
				</ul>				
			</td>
			<td>
				<iframe id="sidebar-emulator" width="300px" height="698px" border="0" src="http://localhost:89/wp/wp-content/plugins/social-slidebar/feeds/vimeo.php?feed=html&Orale"></iframe> 	
			</td>
		</tr>
	</table>
</body>
</html>