<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class functions {

	public function search($array, $key, $value){
		$results = array();

		if (is_array($array)) {
			if (isset($array[$key]) && $array[$key] == $value) {
				$results[] = $array;
			}

			foreach ($array as $subarray) {
				$results = array_merge($results, $this->search($subarray, $key, $value));
			}
		}

		return $results;
	}

	public function exists_in_array($array, $key, $value){
		$results = array();

		if (is_array($array)) {
			if (isset($array[$key]) && $array[$key] == $value) {
				$results[] = $array;
			}

			foreach ($array as $subarray) {
				$results = array_merge($results, $this->search($subarray, $key, $value));
			}
		}

		if (!empty($results) && count($results)>0)
			return true;
		else 
			return false;
	}

	public function get_weeks($date, $rollover)
    {
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $i = 1;
        $weeks = 1;

        for($i; $i<=$elapsed; $i++)
        {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));

            if($day == strtolower($rollover))  $weeks ++;
        }

        return $weeks;
    }

	public function get_month_name($month) {
		return date("F", strtotime(date("d-$month-y")));
	}

	public function datediff($interval, $datefrom, $dateto) {
		$quantity = 0;
		while (strtotime($datefrom) <= strtotime($dateto)) {
			$quantity += 1;
			$datefrom = date('m/d/Y', strtotime($interval, strtotime($datefrom)));
		}

		return $quantity;
	}

}