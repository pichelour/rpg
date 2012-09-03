<?php
function url_action($action, $params = null, $urlEncode = true)
{
	$params['action'] = $action;
	return '?'.http_build_query($params, '', $urlEncode ? '&amp;' : '&');
}
?>
