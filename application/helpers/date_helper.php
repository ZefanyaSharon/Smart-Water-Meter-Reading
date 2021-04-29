<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !  function_exists('add_date'))
{
	function add_date($current_date_string, $day = 0, $month = 0, $year = 0)
	{
		$current_date = strtotime($current_date_string);
		$new_date = date('Y-m-d h:i:s',
			mktime(
				date('h', $current_date),
				date('i', $current_date),
				date('s', $current_date),
				date('m', $current_date) + $month,
				date('d', $current_date) + $day,
				date('Y', $current_date) + $year
			)
		);

		return $new_date;
	}
}

if ( !  function_exists('is_server_datetime'))
{
	function is_server_datetime($value)
	{
		if (strtotime($value) !== FALSE)
		{


			if (date_create_from_format(config_item('server_datetime_format'), $value) !== FALSE)
				return TRUE;
			elseif (date_create_from_format(config_item('server_datetime_nosecond_format'), $value) !== FALSE)
				return TRUE;
			elseif (date_create_from_format(config_item('server_date_format'), $value) !== FALSE)
				return TRUE;
			elseif (date_create_from_format(config_item('server_time_format'), $value) !== FALSE)
				return TRUE;
			elseif (date_create_from_format(config_item('server_time_nosecond_format'), $value) !== FALSE)
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}
}

if ( !  function_exists('convert_date_string_from_client'))
{
	function convert_date_string_from_client($value)
	{
		if (date_create_from_format(config_item('server_display_datetime_format'), $value) !== FALSE)
		{
			$date_value = date_create_from_format(config_item('server_display_datetime_format'), $value);
			return date_format($date_value, config_item('server_datetime_format'));
		}
		elseif (date_create_from_format(config_item('server_display_datetime_nosecond_format'), $value) !== FALSE)
		{
			$date_value = date_create_from_format(config_item('server_display_datetime_nosecond_format'), $value);
			return date_format($date_value, config_item('server_datetime_nosecond_format'));
		}
		elseif (date_create_from_format(config_item('server_display_date_format'), $value) !== FALSE)
		{
			$date_value = date_create_from_format(config_item('server_display_date_format'), $value);
			return date_format($date_value, config_item('server_date_format'));
		}
		elseif (date_create_from_format(config_item('server_display_time_format'), $value) !== FALSE)
		{
			$date_value = date_create_from_format(config_item('server_display_time_format'), $value);
			return date_format($date_value, config_item('server_time_format'));
		}
		elseif (date_create_from_format(config_item('server_display_time_nosecond_format'), $value) !== FALSE)
		{
			$date_value = date_create_from_format(config_item('server_display_time_nosecond_format'), $value);
			return date_format($date_value, config_item('server_time_nosecond_format'));
		}
		else
			return FALSE;
	}
}

if ( !  function_exists('convert_date_string_from_server'))
{
	function convert_date_string_from_server($value)
	{
		$result = NULL;
		if ( ! empty($value) && $value != '0000-00-00')
		{
			$date = DateTime::createFromFormat(config_item('server_date_format'), $value);
			if ($date !== FALSE)
			{
				$result = $date->format(config_item('server_display_date_format'));
			}
			else
				$result = FALSE;
		}

		return $result;
	}
}

if ( !  function_exists('convert_datetime_string_from_server'))
{
	function convert_datetime_string_from_server($value)
	{


		$result = NULL;
		if ( ! empty($value) && $value != '0000-00-00 00:00:00')
		{
			$date = DateTime::createFromFormat(config_item('server_datetime_format'), $value);
			if ($date !== FALSE)
			{
				$result = $date->format(config_item('server_display_datetime_format'));
			}
			else
				$result = FALSE;
		}

		return $result;
	}
}

if ( !  function_exists('convert_date_to_human'))
{
	function convert_date_to_human($value)
	{

		$server_date_format = config_item('server_date_format');

		$result = NULL;
		if ( ! empty($value))
		{
			$date = DateTime::createFromFormat($server_date_format, $value);
			if ($date !== FALSE)
			{
				$day = $date->format('j');
				$month = $date->format('n');
				$year = $date->format('Y');

				$months = config_item('months');

				$result = $day.' '.$months[$month].' '.$year;
			}
			else
				$result = FALSE;
		}

		return $result;
	}
}

if ( ! function_exists('convert_datetime_to_human')) {
	function convert_datetime_to_human($value) {
		$server_datetime_format = config_item('server_datetime_format');

		$result = null;
		if (!empty($value)) {
			$date = DateTime::createFromFormat($server_datetime_format, $value);
			if ($date !== false) {
				$day    = $date->format('j');
				$month  = $date->format('n');
				$year   = $date->format('Y');
				$hour   = $date->format('H');
				$minute = $date->format('i');
				$second = $date->format('s');

				$months = config_item('months');

				$result = $day . ' ' . $months[$month] . ' ' . $year . ' ' . $hour . ':' . $minute . ':' . $second;
			} else {
				$result = false;
			}
		}

		return $result;
	}
}

if ( !  function_exists('get_range_year'))
{
	function get_range_year($limit)
	{
		$year = [];
        for ($i=0; $i < $limit; $i++) {
            $year[] = empty($i) ? date('Y') : date('Y', strtotime('-' . $i . 'year'));
		}
		return $year;
	}
}

if ( !  function_exists('second_to_time'))
{
	function second_to_time($second)
	{
		if ($second < 60)
			return $second . ' seconds';

		$return = [];
		$second = str_replace(',', '', number_format($second, 0));
		$dtF = new Datetime('@0');
		$dtT = new Datetime("@$second");

		$days    = $dtF->diff($dtT)->format('%a');
		$hours   = $dtF->diff($dtT)->format('%h');
		$minutes = $dtF->diff($dtT)->format('%i');
		$seconds = $dtF->diff($dtT)->format('%s');

		if ( ! empty($days)) $return[] = $days . ' days';
		if ( ! empty($hours)) $return[] = $hours . ' hours';
		if ( ! empty($minutes)) $return[] = $minutes . ' minutes';
		if ( ! empty($seconds)) $return[] = $seconds . ' seconds';

		return implode(' ', $return);
	}
}
