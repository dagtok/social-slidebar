<style type="text/css">
html, iframe {
	width: 580px;
	background: #000;
}
</style>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<?php
ini_set('display_errors', 'On');
ini_set('display_errors', 1);
echo '<blockquote class="twitter-tweet" style="width:600px;" align="center"><p>'.$_GET['tweet'].'</p>&mdash; '.$_GET['user_name'].' (@'.$_GET['screen_name'].') <a href="https://twitter.com/'.$_GET['screen_name'].'/statuses/'.$_GET['id'].'">'.$_GET['date'].'</a></blockquote>';
?>