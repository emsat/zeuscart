<?php
/**
* GNU General Public License.

* This file is part of ZeusCart V4.

* ZeusCart V4 is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 4 of the License, or
* (at your option) any later version.
* 
* ZeusCart V4 is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Foobar. If not, see <http://www.gnu.org/licenses/>.
*
*/
/**
 * AJDF
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package   		AJDF
 * @author    		AjSquareInc Dev Team
 * @copyright 		Copyright (c) 2008 - 2013, AjSquare, Inc.
 * @link    		http://www.ajsquare.com/ajhome.php
 * @version  		Version 4.0
 * @created   		January 15 2013
 */

/**
 * This class contains functions related error hander
 *
 * @package  		Bin
 * @author    		AjSquareInc Dev Team
 * @link   		http://www.zeuscart.com
 */
class Bin_Template
{
	function createTemplate($file,$data='')
	{
		$smarty = new Smarty();
		//if($data != '')
		if(count($_SESSION) >0 && count($data) >0)
			$data = array_merge($data,$_SESSION);			
		if(is_array($data))
		{	
			foreach($data as $key=>$item)
				$smarty->assign($key,$item);
		}
		$smarty->display($file);
	}
}
?>