    function posid($field, $value)
    {
		return ($value === '' || $value == 0) ? '' : array(DB_PRE.'video_position','vid',"p.posid=$value");
	}
