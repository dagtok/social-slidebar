<?php

/*-----------------------------------------------------------------------------------*/
/* Add default options after activation */
/*-----------------------------------------------------------------------------------*/
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php?page=siteoptions" ) {
	//Call action that sets
	add_action('admin_head','kbl_ssb_option_setup');
}

function kbl_ssb_option_setup(){

	//Update EMPTY options
	$kbl_ssb_array = array();
	add_option('kbl_ssb_options',$kbl_ssb_array);

	$template = get_option('kbl_ssb_template');
	$saved_options = get_option('kbl_ssb_options');
	
	foreach($template as $option) {
		if($option['type'] != 'heading'){
			$id = $option['id'];
			$std = $option['std'];
			$db_option = get_option($id);
			if(empty($db_option)){
				if(is_array($option['type'])) {
					foreach($option['type'] as $child){
						$c_id = $child['id'];
						$c_std = $child['std'];
						update_option($c_id,$c_std);
						$kbl_ssb_array[$c_id] = $c_std; 
					}
				} else {
					update_option($id,$std);
					$kbl_ssb_array[$id] = $std;
				}
			}
			else { //So just store the old values over again.
				$kbl_ssb_array[$id] = $db_option;
			}
		}
	}
	update_option('kbl_ssb_options',$kbl_ssb_array);
}





/*-----------------------------------------------------------------------------------*/
/* Admin Backend */
/*-----------------------------------------------------------------------------------*/
function kbl_ssb_kbl_ssb_siteoptions_admin_head() { ?>

<script type="text/javascript">
jQuery(function(){
var message = '<p><strong>Activation Successful!</strong> Social slidebar settings are located under <a href="<?php echo admin_url('admin.php?page=siteoptions'); ?>">Appearance > Site Options</a>.</p>';
jQuery('.themes-php #message2').html(message);
});
</script>
    
    
    <?php }

add_action('admin_head', 'kbl_ssb_kbl_ssb_siteoptions_admin_head');
?>