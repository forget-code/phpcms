<?php
require './include/common.inc.php';
if (isset($action) && isset($username))
{
	$username = trim($username);
	if ($_username != $username)
	{
		if ($action == 'add')

		{
			$res = $db->query("SELECT userid FROM ".TABLE_MEMBER." where username='$username'");
			if ($db->num_rows($res) > 0)
			{
				$res = $db->query("SELECT types FROM ".TABLE_MESSAGE_FRIEND." WHERE userself='$_username' AND userother='$username'");
				if ($db->num_rows($res) > 0)
				{
					$row = $db->fetch_row($res);
					if ($row[0] == 0)
					{
						echo 1;
					}
					else
					{
						$db->query("UPDATE ".TABLE_MESSAGE_FRIEND." SET types=0 WHERE userself='$_username' AND userother='$username'");
						if ($db->affected_rows() > 0)
						{
							echo 2;
						}
						else
						{
							echo 0;
						}
					}
				}
				else
				{
					$db->query("INSERT INTO ".TABLE_MESSAGE_FRIEND." (userself,userother) VALUES ('$_username','$username')");
					if ($db->affected_rows() > 0)
					{
						echo 3;
					}
					else
					{
						echo 0;
					}
				}
			}
			else
			{
				echo 4;
			}
		}
		elseif ($action == 'delete')
		{
			$db->query("DELETE FROM ".TABLE_MESSAGE_FRIEND." WHERE userother='$username' AND userself='$_username' AND types=0");
			if ($db->affected_rows() > 0)
			{
				echo 5;
			}
			else
			{
				echo 0;
			}
		}
	}
	else
	{
		echo 6;
	}
}
?>