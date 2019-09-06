<?php
/**
 * HTML标签排除
 *
 */
class Html_Trim
	{
		/// <summary>
		/// HTML标签排除
		/// </summary>
		/// <param name="strHtml">源HTML代码.</param>
		/// <param name="serial">排除的数组 1,2,5,4,6</param>
		/// <returns></returns>		
		/**
		 * HTML标签排除
		 *
		 * @param u源HTML代码$strHtml
		 * @param u排除的数组 1,2,5,4,6$serial
		 * @return unknown
		 */
		function HtmlTrim($strHtml,$serial) 
		{

			$ids=explode(",",$serial);//获取要排除html代码的序号
			$aryReg =array(
								  "/<a[^>]*?>([\w\W]*?)</a>/i",
								  "/<br>/i",
								  "/<table[^>]*?>([\w\W]*?)</table>/i",
								  "/<tr[^>]*?>([\w\W]*?)</tr>/i",
								  "/<td[^>]*?>([\w\W]*?)</td>/i",
								  "/<p[^>]*?>([\w\W]*?)</p>/i",
								  "/<font[^>]*?>([\w\W]*?)</font>/i",
								  "/<div[^>]*?>([\w\W]*?)</div>/i",
								  "/<span[^>]*?>([\w\W]*?)</span>/i",
								  "/<([\/]?)b>/i",
								  "/<tbody[^>]*?>([\w\W]*?)</tbody>/i",
								  "/<img[^>]*?>/i",
								  "/[&nbsp;]{2,}/i",
								  "/<script[^>]*?>([\w\W]*?)</script>/i",

							  );

			$aryRep = array(
								   "$1",
								   "",
								   "$1",
								   "$1",
								   "$1",
								   "$1",
								   "$1",
								   "$1",
								   "$1",
								   "",
								   "$1",
								   "",
								   "&nbsp;",
								   "$1",
								);

			$newReg =$aryReg[0];
			$strOutput=$strHtml;
			foreach($ids as $id)
			{
				$strOutput = preg_replace($newReg[$id],$newRep[$id],$strOutput);
			}
			return $strOutput;
		}
	}
?>