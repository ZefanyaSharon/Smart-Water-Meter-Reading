<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Determine who you are
* @param [in]
* @return
*/
if (!function_exists('setHighlight')) {
	function setHighlight($result, $field) {
		return isset($result->highlight->{$field}) ? reset($result->highlight->{$field}) : $result->_source->{$field};
	}
}

if ( ! function_exists('generateFacetUrl'))
{
	function generateFacetUrl($get_facet, $path, $is_checklist)
	{
		$CI =& get_instance();

		$url_facet     = '';
		$facet[$path]  = $path;
		$keyword       = $CI->input->get('q');
		$current_facet = $CI->input->get($get_facet);
		$current_facet = explode('|', $current_facet);
		foreach ($current_facet as $idx => $res) {
			$facet[$res] = $res;
		}

		if ($is_checklist === TRUE)
			unset($facet[$path]);

		$facet_uri = '';
		foreach ($facet as $idx => $val) {
			$facet_uri .= '|' . $val;
		}
		$facet_uri = trim($facet_uri, '|');

		$uri_array = $_SERVER['REQUEST_URI'];
		$uri_array = explode('&', $uri_array);
		unset($uri_array[0]);
		$get_uri = [];
		foreach ($uri_array as $idx => $uri) {
			$is_facet = strstr($uri, '=', TRUE);
			$get_uri[$is_facet] = $is_facet;

			if ($is_facet == $get_facet) {
				$uri_array[$idx] = '&' . $get_facet . '=' . $facet_uri;
				if (empty($facet_uri)) // kalau value nya kosong maka unset semua aja biar url nya bersih
					unset($uri_array[$idx]);
			} else
				$uri_array[$idx] = '&' . $uri;
		}
		$url_facet = implode('', $uri_array);

		if ( ! in_array($get_facet, $get_uri))
			$url_facet .= '&' . $get_facet . '=' . $path;

		return site_url('search') . '?q=' . htmlspecialchars($keyword) . ltrim($url_facet, '/');
	}
}
