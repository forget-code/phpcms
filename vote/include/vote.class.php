<?php
defined('IN_PHPCMS') or exit('Access Denied');

class vote
{
	var $voteid;
	var $db;

	function vote($voteid = 0)
	{
		global $db;
		$this->db = $db;
		$this->voteid = intval($voteid);
	}

	function add_subject($info)
	{
		$info['minval'] = max(1,intval($info['minval']));
		if(!$info['maxval'] || $info['maxval']<$info['minval']) $info['maxval']=0;
		$this->db->insert(DB_PRE.'vote_subject',$info);
		return $this->db->insert_id();
	}

	function add_option($data, $subjectid = 0)
	{
		if(!$data['subjectid']) $data['subjectid'] = intval($subjectid);
		if(!is_array($data) || !$data['subjectid']) return FALSE ;

		$this->db->insert(DB_PRE.'vote_option',$data);
		$this->db->query('update '.DB_PRE."vote_subject set maxval=(select count(*) from ".DB_PRE."vote_option where subjectid='$subjectid')  where subjectid='$subjectid'");
		$this->update_number(subjectid);
		return $data['subjectid'];
	}

	function add_options($data, $subjectid)
	{
		unset($data['subjectid']);
		if(!is_array($data['option'])) return FALSE;
		if(!$this->db->get_one("select subjectid from ".DB_PRE."vote_subject where subjectid='$subjectid'")) return FALSE;
		foreach($data['option'] as $key=>$val)
		{
			if(trim($val)=='') continue;
			$newopt=array(
				'subjectid'=>$subjectid,
				'option'=>$val,
				'image'=>$data['image'][$key],
				'listorder'=>0
			);

			$this->add_option($newopt);
		}
		$this->update_number(subjectid);
		return TRUE;
	}

	function del($sid)
	{
		$sid =is_array($sid)?implode(',', $sid):intval($sid);
        $optionids = $this->db->select("select optionid from ".DB_PRE."vote_option where subjectid in($sid)");
        foreach($optionids as $key=>$data)
        {
            $this->del_option($data['optionid']);
        }
		$this->db->query("delete from ".DB_PRE."vote_option where subjectid in($sid)");
		$this->db->query("delete from ".DB_PRE."vote_data where subjectid in($sid)");
		$this->db->query("delete from ".DB_PRE."vote_subject where subjectid in($sid) or parentid in($sid)");
		return true;
	}

	function del_option($optionid)
	{
		$delid=is_array($optionid)?implode(',', $optionid):intval($optionid);
		$this->db->query("delete from ".DB_PRE."vote_option where optionid in($delid)");
        $this->db->query("delete from ".DB_PRE."vote_useroption where optionid in($delid)");
		return $this->db->affected_rows();
	}

	function edit_subject($data,$subjectid)
	{
		$subjectid = intval($subjectid);
		$sql='';
		if(!is_array($data)) return false;
		foreach($data as $key=>$val)
		{
			$sql.="`$key`='$val',";
		}
		$sql=substr($sql,0,strlen($sql)-1);
		$this->db->query("update ".DB_PRE."vote_subject set $sql where subjectid=$subjectid");
        if(!$data['ismultiple'])  $this->db->query("delete from ".DB_PRE."vote_subject where parentid='$subjectid'");
		return $subjectid;
	}

	function edit_option($data)
	{
		if(!is_array($data['option']) || !is_array($data['image'])) return false;
		foreach($data['option'] as $optionid=>$option)
		{
			$image=$data['image'][$optionid];
			if(!preg_match('/(\.png|\.gif|\.jpg|\.jpeg)$/i',$image)) $image='';
			$this->db->query("update `".DB_PRE."vote_option` set `option`='$option',`image`='$image' where `optionid`='$optionid'");
		}
		return $this->db->affected_rows();
	}

	function get_options($subjectid)
	{
		$subjectid=intval($subjectid);
		return $this->db->select("select * from ".DB_PRE."vote_option where subjectid='$subjectid' order by listorder desc,optionid asc",'optionid');
	}

	function get_subject($subjectid)
	{
		$subjectid=intval($subjectid);
		return $this->db->get_one("SELECT * FROM ".DB_PRE."vote_subject  WHERE subjectid='$subjectid'");
	}

	function get_vote($voteid, $fields='*')
	{
		$voteid = intval($voteid) ;
		$vote=$this->db->get_one("select $fields from ".DB_PRE."vote_subject where  subjectid='$voteid' and parentid='0'", 'subjectid');
		if($vote['userinfo'])
        {
            $userinfo = $vote['userinfo'];
            eval("\$userinfo=$userinfo ;");
            $vote['userinfo'] = $userinfo;
        }

		return $vote ;
	}

	function set_listorder($tbname,$keyid,$data)
	{
		if(!is_array($data)) return FALSE;
		foreach($data as $key=>$val)
		{
			$val = intval($val);
			$key = intval($key);
			$this->db->query("update $tbname set listorder='$val' where {$keyid}='$key'");
		}
		return $this->db->affected_rows();
	}

	function get_subjects($voteid)
	{
		$voteid = intval($voteid);
		$subjects = $this->db->select("SELECT * FROM ".DB_PRE."vote_subject  WHERE (subjectid='$voteid' and ismultiple<>'1')  or parentid='$voteid' ORDER BY listorder desc",'subjectid');
		if(!$subjects) return array();
		foreach($subjects as $sid=>$data)
		{
			if(!is_numeric($sid)) continue;
			$subjects[$sid] = $data;
			$subjects[$sid]['options']=$this->get_options($sid);
			$min = intval($subjects[$sid]['minval']);
			$max = intval($subjects[$sid]['maxval']);
			$subjects[$sid]['minval']= max($min,1);
			$subjects[$sid]['maxval']= ($max<$min)?count($subjects[$sid]['options']):$max;
		}
		return $subjects;
	}


	function reset_data($subjectid)
	{
		$subjectid = intval($subjectid);
		$subid = $this->db->select('SELECT subjectid from '.DB_PRE."vote_subject where subjectid='$subjectid' or parentid='$subjectid'",'subjectid');
		if(!$subid) return FALSE;
		$subid = implode(',',array_keys($subid));
		$this->db->query('delete from '.DB_PRE."vote_data where subjectid in ($subid)");
        $this->db->query("delete from ".DB_PRE."vote_useroption where subjectid='$subjectid'");
		return $this->db->affected_rows();
	}

    function vote_submit($voteid, $subjectids, $votedata, $userinfo='')
	{
		global $_userid,$_username;
		$voteid = intval($voteid) ;
        $this->submit_useroption($mainid, $votedata);
        $votedata = addslashes(var_export($votedata, TRUE));
		if(!is_array($subjectids))  return FALSE;
		if(!$this->db->get_one("select subjectid from ".DB_PRE."vote_subject where subjectid='$voteid' and parentid=0"))
		{
			exit ;
			return FALSE;
		}
		$subs = $this->db->select("select subjectid,minval,maxval,ismultiple,credit from ".DB_PRE."vote_subject where (subjectid='$voteid' and ismultiple<>'1')  or parentid='$voteid'",'subjectid');
		if($subs[$mainid]['credit'] && $_userid)
		{
			include_once PHPCMS_ROOT.'member/include/member.class.php';
			$user = new member;
			$user->update_credits($subs[$voteid]['credit']);
		}
		$subids=array_keys($subs);
		$subjectids = array_values($subjectids);
		sort($subids);
		sort($subjectids);
        if(is_array($userinfo))
        {
            foreach($userinfo as $key=>$val)
            {
                $userinfo[$key] = htmlspecialchars($val);
            }
        }

         if($userinfo['truename'])  $userinfo['truename']=substr($userinfo['truename'],0,10);
         if($userinfo['email'])     $userinfo['email'] = substr($userinfo['email'],0,30);
         if($userinfo['addr'])      $userinfo['addr'] = substr($userinfo['addr'],0,50);
         if($userinfo['comment'])   $userinfo[comment] = substr($userinfo[comment],0,500);
         if($userinfo['extra'])     $userinfo['extra'] = substr($userinfo['extra'],0,500);

        $userinfo = is_array($userinfo) ? addslashes(var_export($userinfo, TRUE)) : '';

		$this->db->insert(DB_PRE.'vote_data',array(
			'userid'=>$_userid,
			'username'=>$_username,
			'subjectid'=>$voteid,
			'time'=>TIME,
			'ip'=>IP,
			'data'=>$votedata,
            'userinfo'=>$userinfo
		));
	}

    function  submit_useroption($voteid, $votedata)
	{
        global $_userid,$_username;
        if(!is_array($votedata)) return FALSE;
        foreach($votedata as $sid=>$data)
        {
            foreach($data as $optionid=>$val)
            {
               $this->db->query("insert into ".DB_PRE."vote_useroption (userid, username, optionid, subjectid) values('$_userid', '$_username', '$optionid','$voteid')");
            }
        }
    }
	/*
	 0 : not found
	-1 : is a sub voteitem
	-2 : disabled
	-3 : expired
	-4 : has voted
	-5 : later vote
	-6 : group disabled
	-7 : save username vote
	-8 : has voted
	-9 : anonymous disabled
 	*/
	function check($voteid)
	{
		global $_groupid, $_userid;
		$voteid = intval($voteid);
		$info = $this->db->get_one("select subjectid,groupidsvote,groupidsview, parentid,enabled,enablecheckcode,allowguest,fromdate, todate, `interval` from ".DB_PRE."vote_subject where subjectid='$voteid'");
		if(!$info) return 0;

		$info['fromdate']=strtotime($info['fromdate']);
		$info['todate'] = strtotime($info['todate']);

		if($info['parentid']) return 0;
		if(!$info['enabled']) return -2;
		if(TIME>$info['todate'] || TIME<$info['fromdate']) return -3;

		if($info['interval']==0)
		{
			if($this->db->get_one('select subjectid from '.DB_PRE."vote_data where subjectid='$voteid' and ip='".IP."'")) return -4;
		}

		if($info['interval']>0)
		{
			$condition = '('. TIME.'-time)/(24*3600)<'.$info['interval'];
			if($this->db->get_one("select time from ".DB_PRE."vote_data where subjectid='$subjectid' and ip='".IP."' and $condition ")) return -5;
		}
		if($info['groups'] && is_array($info['groups']) && !in_array($_groupid,$info['groups'])) return -6;
		if(!$info['allowguest'] && !$_userid) return -9;
		return $info;
	}

	function update_number($subjectid)
	{
		$subjectid = intval($subjectid);
		$n=$this->db->get_one("select count(optionid) as num from ".DB_PRE."vote_option where subjectid='$subjectid'");
		$n=$n['num'];
		$this->db->query("update ".DB_PRE."vote_subject set optionnumber='$n' where subjectid='$subjectid'");
	}

	function check_optionid($optid)
	{
		$optid=intval($optid);
		if(!$this->db->query("select optionid from ".DB_PRE."vote_option where optionid='$optid'")) return FALSE;
		return TRUE;
	}

	function get_vote_data($subjectid)
	{
		$subjectid = intval($subjectid);
		$data = $this->db->select("SELECT data FROM ".DB_PRE."vote_data WHERE subjectid='$subjectid' ORDER BY subjectid DESC ");
		$vote_data =array();
        $total = 0;
		$vote_data[$subjectid]['total'] = 0;
		$vote_data[$subjectid]['total'] = 0 ;
		$vote_data[$subjectid]['votes'] = count($data);
		foreach($data as $key=>$val)
		{
            eval("\$data[$key][data] = $val[data] ;");
			foreach($data[$key]['data'] as $sid=>$votes)
			{
				$vote_data[$sid]['total'] = intval(array_sum($votes))+intval($vote_data[$sid]['total']);
				foreach($votes as $optionid=>$hit)
				{
					$vote_data[$sid][$optionid]+=1;
                    $total++;
				}
			}
		}
        $vote_data[$subjectid]['total']=$total;
	    return $vote_data;
	}
}
?>