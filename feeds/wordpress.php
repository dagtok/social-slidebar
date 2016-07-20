<link rel='stylesheet' id='slidebar_style-css'  href='http://localhost:89/wp/wp-content/plugins/social-slidebar/css/style.css?ver=0.1' type='text/css' media='screen' />

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'simple_cache.php';

class Vine{
	public $plugin_name;
	public $user_name;
	/*
	
	function __construct($user){
		$this->plugin_name="Kiibal";
		$this->user_name=$user;
	}
  
  	function write_json_file($name,$vine){
		try{
			$fp = fopen(str_replace('vine.php', $name.'.json', __FILE__), 'w');
			if(!($fp==false)){
				fwrite($fp, $vine);
				fclose($fp);
			}
		} catch (Exception $e) {
			
		}	
	}
	*/
	function parse_feed($data){
	}

	function get_json_data($settings){
    }
}

if(isset($_GET) AND isset($_GET['feed']) AND $_GET['feed'] == 'html'){
	
	$crawled = 0;
	$settings = array();
	
	$vine = new Vine();
	$json = $vine->get_json_data($settings);
	
	// echo '<pre>';
	// print_r($json);
	// echo '</pre>';
	// exit;

	$feed = $json->data->records;
	

	$vine->parse_feed($feed);
}

?>