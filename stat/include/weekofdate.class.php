<?php
class weekOfDate
{
	var $year;
	var $fweek;
	var $weeks;
	function weekOfDate($date)
	{
		$this -> year = date('Y', strtotime($date));
		$this -> fweek = date('w', mktime(0, 0, 0, 1, 1, $this -> year));
		$this -> weeks = date('W', strtotime($date));
	}
	function startDate()
	{
		return date('Y-m-d', mktime(0, 0, 0, 1, $this -> weeks * 7 - $this -> fweek - 6, $this -> year));
	}
	function endDate()
	{
		return date('Y-m-d', mktime(0, 0, 0, 1, $this -> weeks * 7 - $this -> fweek, $this -> year));
	}
}
?>