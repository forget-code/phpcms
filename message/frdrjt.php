<?php
require './include/common.inc.php';
if (isset($action) && isset($user) && isset($type))
{
	$type = intval($type);
	if ($user == $_username)
	{
		echo 0;
	}
	else
	{
		switch ($action)
		{
			case 'insert':
				$res = $db->query("SELECT ".TABLE_MEMBER_GROUP.".messagelimit FROM ".TABLE_MEMBER_GROUP.",".TABLE_MEMBER." WHERE ".TABLE_MEMBER.".groupid=".TABLE_MEMBER_GROUP.".groupid AND ".TABLE_MEMBER.".username='$user'");
				if ($db->num_rows($res) < 1)
				{
					echo 1;
				}
				else
				{
					$row = $db->fetch_row($res);
					if ($row[0] < 1)
					{
						echo 2;
					}
					else
					{
						$res = $db->query("SELECT id FROM ".TABLE_MESSAGE_FRIEND." WHERE userself='$_username' AND userother='$user'");
						if ($db->num_rows($res) > 0)
						{
							echo 3;
						}
						else
						{
							$db->query("INSERT INTO ".TABLE_MESSAGE_FRIEND." (userself,userother,types) VALUES ('$_username','$user',$type)");
							if ($db->affected_rows() < 1)
							{
								echo 4;
							}
							else
							{
								echo 5;
							}
						}
					}
				}
				break;
			case 'delete':
				$db->query("DELETE FROM ".TABLE_MESSAGE_FRIEND." WHERE userself='$_username' AND userother='$user'");
				if ($db->affected_rows() < 1)
				{
					echo 6;
				}
				else
				{
					echo 7;
				}
				break;
			case 'update':
				$db->query("UPDATE ".TABLE_MESSAGE_FRIEND." SET types=$type WHERE userself='$_username' AND userother='$user'");
				if ($db->affected_rows() < 1)
				{
					echo 8;
				}
				else
				{
					echo 9;
				}
		}
	}
}
?>