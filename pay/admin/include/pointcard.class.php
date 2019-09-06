<?php
class pointcard
{
	var $logs_table = '';
	var $db = '';
	var $lang ;
    var $c_table = '';
	function pointcard()
	{
		global $db , $LANG;
		$this->lang = $LANG;
		$this->db	= $db;
		$this->table_logs = DB_PRE.'pay_pointcard_type';
        $this->table_c	= DB_PRE.'pay_card';
	}

	function get_list()
	{
		$sql = "SELECT * FROM `$this->table_logs` where 1  ORDER BY `ptypeid` DESC";
		$result		= $this->db->query($sql);
		$pointcard = array();
		while($r = $this->db->fetch_array($result))
		{
			$pointcard['info'][$r['ptypeid']] = $r;
		}
		return $pointcard;
	}

	function update($id, $data = array())
	{
        $id = intval($id);
        return $this->db->update($this->table_logs, $data, '`ptypeid` = '.$id);
	}

    function add($data = array())
    {
        return $this->db->insert($this->table_logs, $data);
    }

    function get_card($id) {
        $id = intval($id);
        $sql = "SELECT * FROM `$this->table_logs` WHERE `ptypeid` = '{$id}'";
        return $this->db->get_one($sql);
    }

    function drop($ids)
	{
        if($this->dropTypeCard($ids))
        {
            $query_in = $this->db_create_in($ids);
            $sql = "DELETE FROM `$this->table_logs` WHERE `ptypeid` {$query_in}";
            return $this->db->query($sql);
        }
	}

    function dropTypeCard($typids)
    {
        $query_in = $this->db_create_in($typids);
        $sql = "DELETE FROM `$this->table_c` WHERE `ptypeid` {$query_in}";
        return $this->db->query($sql);
    }

    function db_create_in( $item_list, $field_name = "" )
	{
		if ( empty( $item_list ) )
		{
			return $field_name." IN ('') ";
		}
		else
		{
			if ( !is_array( $item_list ) )
			{
				$item_list = explode( ",", str_replace( "'", "", $item_list ) );
			}
			$item_list = array_unique( $item_list );
			$item_list_tmp = "";
			foreach ( $item_list as $item )
			{
				if ( $item !== "" )
				{
					$item_list_tmp .= $item_list_tmp ? ",'{$item}'" : "'{$item}'";
				}
			}
			if ( empty( $item_list_tmp ) )
			{
				return $field_name." IN ('') ";
			}
			else
			{
				return $field_name." IN (".$item_list_tmp.") ";
			}
		}
    }
}
?>