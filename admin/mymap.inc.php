<?php
$sql = "SELECT `modelid`, `name` FROM ".DB_PRE."model ";  category parentid = 0
$result = $db->query($sql);
while($r = $db->fetch_array($result))
{
}

$sql = "SELECT * FROM ".DB_PRE."model AS m INNER JION ".DB_PRE."category AS c ON m.modelid = c.modelid";
?>