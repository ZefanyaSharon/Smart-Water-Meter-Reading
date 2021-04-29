<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Profiler extends CI_Profiler {

	/**
	 * List of profiler sections available to show
	 *
	 * @var array
	 */
	protected $_available_sections = [
		'benchmarks',
		'get',
		'memory_usage',
		'post',
		'uri_string',
		'controller_info',
		'queries',
		'http_headers',
		'session_data',
		'config',
		'es_query'
	];

	// --------------------------------------------------------------------

	/**
	 * Compile elasticsearch query
	 *
	 * @return 	string
	 */
	protected function _compile_es_query()
	{
		$this->CI->load->library('Lib_elasticsearch');
		$output = "\n\n";
		$count = 0;

		$query_profilers = $this->CI->lib_elasticsearch->query_profiler;

		if ($query_profilers != null && count($query_profilers) > 0) {
			$alias = config_item('es_index');
			$total_time = number_format(array_sum(array_column($query_profilers, 'time')), 4).' '.$this->CI->lang->line('profiler_seconds');

			$hide_queries = (count($query_profilers) > $this->_query_toggle_count) ? ' display:none' : '';

			$show_hide_js = '(<span style="cursor: pointer;" onclick="var s=document.getElementById(\'ci_profiler_es_query_db_'.$count.'\').style;s.display=s.display==\'none\'?\'\':\'none\';this.innerHTML=this.innerHTML==\''.$this->CI->lang->line('profiler_section_hide').'\'?\''.$this->CI->lang->line('profiler_section_show').'\':\''.$this->CI->lang->line('profiler_section_hide').'\';">'.$this->CI->lang->line('profiler_section_hide').'</span>)';

			if ($hide_queries !== '') {
				$show_hide_js = '(<span style="cursor: pointer;" onclick="var s=document.getElementById(\'ci_profiler_es_query_db_'.$count.'\').style;s.display=s.display==\'none\'?\'\':\'none\';this.innerHTML=this.innerHTML==\''.$this->CI->lang->line('profiler_section_show').'\'?\''.$this->CI->lang->line('profiler_section_hide').'\':\''.$this->CI->lang->line('profiler_section_show').'\';">'.$this->CI->lang->line('profiler_section_show').'</span>)';
			}

			$output .= '<fieldset style="border:1px solid #126C6F;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee;">'
				."\n"
				.'<legend style="color:#126C6F;">&nbsp;&nbsp;'.$this->CI->lang->line('profiler_elasticsearch')
				.':&nbsp; '.$alias.' &nbsp;&nbsp;&nbsp;'.$this->CI->lang->line('profiler_queries')
				.': '.count($query_profilers).' ('.$total_time.')&nbsp;&nbsp;'.$show_hide_js."</legend>\n\n\n"
				.'<table style="width:100%;'.$hide_queries.'" id="ci_profiler_es_query_db_'.$count."\">\n";

			foreach ($query_profilers as $query_profiler) {
				$output .= '<tr><td style="padding:5px;vertical-align:top;width:1%;color:#900;font-weight:normal;background-color:#ddd;">'
							.$query_profiler['time'].'&nbsp;&nbsp;</td><td style="padding:5px;color:#000;font-weight:normal;background-color:#ddd;">'
							.$query_profiler['query']."</td></tr>\n";
			}

			$output .= "</table>\n</fieldset>";
		}

		return $output;
	}

	// --------------------------------------------------------------------

}
