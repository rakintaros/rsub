<?php 
	date_default_timezone_set("Asia/Bangkok");
	define("DB_HOSTNAME","localhost");
	define("DB_DATABASE","3e_app");
	define("DB_USERNAME","dbadm");
	define("DB_PASSWORD","1@mdb@dm1n");
	
	define("BASE_URL","http://apps.3e.world/");

	
	$mysqli=new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
	$mysqli->select_db(DB_DATABASE);
	$mysqli->query("SET NAMES utf8;");
	
	function ConvertToThaiDate  ($date,$short) {
		if($date){
			if($short){
				$MONTH = array("", "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			}else{
				$MONTH = array(1=>"มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			}
			$dt = explode("-", $date);
			$tyear = $dt[0];
			$dt[0] = $dt[2] +0;
			$dt[1] = $MONTH[$dt[1]+0];
			$dt[2] = $tyear+543;
			return join(" ", $dt);
		}else{
			return "<font color=\"#FF0000\">ไม่ระบุ</font>";
		}
	}
	
	function get_time_ago($time_stamp)
	{
		$time_difference = strtotime('now') - $time_stamp;
		
		if ($time_difference >= 60 * 60 * 24 * 365.242199)
		{
			/*
			 * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 365.242199 days/year
			 * This means that the time difference is 1 year or more
			 */
			return get_time_ago_string($time_stamp, 60 * 60 * 24 * 365.242199, 'year');
		}
		elseif ($time_difference >= 60 * 60 * 24 * 30.4368499)
		{
			/*
			 * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 30.4368499 days/month
			 * This means that the time difference is 1 month or more
			 */
			return get_time_ago_string($time_stamp, 60 * 60 * 24 * 30.4368499, 'month');
		}
		elseif ($time_difference >= 60 * 60 * 24 * 7)
		{
			/*
			 * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 7 days/week
			 * This means that the time difference is 1 week or more
			 */
			return get_time_ago_string($time_stamp, 60 * 60 * 24 * 7, 'week');
		}
		elseif ($time_difference >= 60 * 60 * 24)
		{
			/*
			 * 60 seconds/minute * 60 minutes/hour * 24 hours/day
			 * This means that the time difference is 1 day or more
			 */
			return get_time_ago_string($time_stamp, 60 * 60 * 24, 'day');
		}
		elseif ($time_difference >= 60 * 60)
		{
			/*
			 * 60 seconds/minute * 60 minutes/hour
			 * This means that the time difference is 1 hour or more
			 */
			return get_time_ago_string($time_stamp, 60 * 60, 'hour');
		}
		else
		{
			/*
			 * 60 seconds/minute
			 * This means that the time difference is a matter of minutes
			 */
			return get_time_ago_string($time_stamp, 60, 'min');
		}
	}

	function get_time_ago_string($time_stamp, $divisor, $time_unit)
	{
		$time_difference = strtotime("now") - $time_stamp;
		$time_units      = floor($time_difference / $divisor);

		settype($time_units, 'string');

		if ($time_units === '0')
		{
			return 'just now';
		}
		elseif ($time_units === '1')
		{
			return '1 ' . $time_unit . ' ago';
		}
		else
		{
			/*
			 * More than "1" $time_unit. This is the "plural" message.
			 */
			// TODO: This pluralizes the time unit, which is done by adding "s" at the end; this will not work for i18n!
			return $time_units . ' ' . $time_unit . 's ago';
		}
	}

