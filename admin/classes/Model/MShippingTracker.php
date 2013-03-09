<?php
/**
* GNU General Public License.

* This file is part of ZeusCart V2.3.

* ZeusCart V2.3 is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
* 
* ZeusCart V2.3 is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Foobar. If not, see <http://www.gnu.org/licenses/>.
*
*/

/**
 * MShippingTracker
 *
 * This class contains functions to display the list of shipment trackers available 
 * 
 * @package		Model_MShippingTracker
 * @category	Model
 * @author		ZeusCart Team
 * @link		http://www.zeuscart.com
 * @version 	2.3
 */

// ------------------------------------------------------------------------

class Model_MShippingTracker
{
	/**
	 * Stores the output
	 *
	 * @var array $output
	 */	
	var $output = array();	
	
	/**
	 * Function displays the status for the list of shipment trackers available 
	 * 
	 * 
	 * @return array
	 */
	function displayShippingTrackerSetting()
	{
		include('classes/Core/CShippingTracker.php');
		include('classes/Display/DShippingTracker.php');		
		
		$output['shippingtrackersetting'] =   Core_CShippingTracker::displayShippingTrackerSetting();				

		//print_r($output);
		Bin_Template::createTemplate('shipmentstatus.html',$output);
	}	
	
	/**
	 * Function updates the status for the list of shipment trackers available 
	 * 
	 * 
	 * @return array
	 */
	
	function updateShippingTrackerSetting()
	{
		include('classes/Core/CShippingTracker.php');
		include('classes/Display/DShippingTracker.php');		
		
		$output['updatedshippingtrackersetting'] =   Core_CShippingTracker::updateShippingTrackerSetting();				

		header("Location:?do=showshipmenttracker&msg=Updated%20Sucessfully");
	}	
}
?>