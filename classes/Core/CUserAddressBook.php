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
 * User address book related  class
 *
 * @package   		Core_CUserAddressBook
 * @category    	Core
 * @author    		AJ Square Inc Dev Team
 * @link   		http://www.zeuscart.com
  * @copyright 	        Copyright (c) 2008 - 2013, AJ Square, Inc.
 * @version   		Version 4.0
 */
class Core_CUserAddressBook
{

	/**
	* This function is used to assign  the errors in this->data 
	* @param array $Err 
	* @return array
 	*/
	function Ulogin($Err)
	{
		if(count($Err->values)==0)
		{
			$this->data = $Err->values;
			$this->data = $Err->messages;
		}
		else 
		{	
			$this->data = $Err->values;
			$this->errormessages = $Err->messages;
		}
	}
	/**
	 * This function is used to get  the  address for user after login
	 *
	 * .
	 * 
	 * @return string
	 */
	function showAddress()
	{
		include('classes/Display/DUserAccount.php');
		$userid=$_SESSION['user_id'];
		if($_GET['id']!='')
		{
			$sql="select a.*,b.cou_name from addressbook_table a,country_table b where a.country=b.cou_code and a.user_id=".$userid." and a.contact_name='".$_GET['id']."'";
			$query = new Bin_Query();
			$query->executeQuery($sql);
			return Display_DUserAccount::showAddress($query->records);
		}
	}
	/**
	 * This function is used to show  the  address for user after login
	 *
	 * .
	 * 
	 * @return string
	 */
	function showAddressBook()
	{
		include('classes/Display/DUserAccount.php');
		
		$userid=$_SESSION['user_id'];
		$pagesize=10;
  	    	if(isset($_GET['page']))
		{
		    
			$start = trim($_GET['page']-1) *  $pagesize;
			$end =  $pagesize;
		}
		else 
		{
			$start = 0;
			$end =  $pagesize;
		}
		$total = 0;
		
		$sqlselect="SELECT a.*,b.cou_name from addressbook_table a,country_table b where a.country=b.cou_code and a.user_id=".$userid." ";
		if(isset($_GET['schltr']))
		{
			$searchletter=trim($_GET['schltr']);
			if(strtolower($searchletter)!='all')
			$sqlselect.=" and a.contact_name like '".$searchletter."%'";
		}
		if(isset($_GET['gname'])&&$_GET['gname']!='')
		{
			$searchletter=trim($_GET['gname']);
			if(strtolower($searchletter)!='')
			$sqlselect.=" and a.contact_name like '".$searchletter."%'";
		}
		if(isset($_GET['fname'])&&$_GET['fname']!='')
		{
			$searchletter=trim($_GET['fname']);
			if(strtolower($searchletter)!='')
			$sqlselect.=" and a.first_name like '".$searchletter."%'";
		}
		if(isset($_GET['lname'])&&$_GET['lname']!='')
		{
			$searchletter=trim($_GET['lname']);
			if(strtolower($searchletter)!='')
			$sqlselect.=" and a.last_name like '".$searchletter."%'";
		}
		if(isset($_GET['comp'])&&$_GET['company']!='')
		{
			$searchletter=trim($_GET['comp']);
			if(strtolower($searchletter)!='')
			$sqlselect.=" and a.company like '".$searchletter."%'";
		}
		if(isset($_GET['city'])&&$_GET['city']!='')
		{
			$searchletter=trim($_GET['city']);
			if(strtolower($searchletter)!='')
			$sqlselect.=" and a.city like '".$searchletter."%'";
		}
		if(isset($_GET['email'])&&$_GET['email']!='')
		{
			$searchletter=trim($_GET['email']);
			if(strtolower($searchletter)!='')
			$sqlselect.=" and a.email like '".$searchletter."%'";
		}
		if(isset($_GET['state'])&&$_GET['state']!='')
		{
			$searchletter=trim($_GET['state']);
			if(strtolower($searchletter)!='')
			$sqlselect.=" and a.state like '".$searchletter."%'";
		}
		$sqlselect.=" order by a.contact_name";
		$query = new Bin_Query();
		$query->executeQuery($sqlselect);
		
		$total = ceil($query->totrows/ $pagesize);
		include('classes/Lib/Paging.php');
		$tmp = new Lib_Paging('classic',array('totalpages'=>$total, 'length'=>10),'pagination');
		$this->data['paging'] = $tmp->output;
		$this->data['prev'] =$tmp->prev;
		$this->data['next'] = $tmp->next;	
		

		return Display_DUserAccount::showAddressBook($query->records,$this->data['paging'],$this->data['prev'],$this->data['next'],$start);
	}
	/**
	 * This function is used to show  the  add address for user after login
	 *
	 * .
	 * 
	 * @return string
	 */
	function showAddAddress()
	{
		include('classes/Display/DUserAccount.php');

		$sqlCountry="SELECT * from country_table";
		
		$objCountry = new Bin_Query();
		$objCountry->executeQuery($sqlCountry);
		
		$userid=$_SESSION['user_id'];
		if($_GET['id']!='')
		{
			$sql="select * from addressbook_table where user_id=".$userid." and contact_name='".$_GET['id']."'";
			$query = new Bin_Query();
			$query->executeQuery($sql);
			return Display_DUserAccount::showAddAddress($objCountry->records,$query->records);
		}
		else
			return Display_DUserAccount::showAddAddress($objCountry->records);
	}
	/**
	 * This function is used to get  the  address from check out process
	 *
	 * .
	 * 
	 * @return string
	 */
	function showAddAddressFromCheckout()
	{
		include('classes/Display/DUserAccount.php');

		$sqlCountry="SELECT * from country_table";
		
		$objCountry = new Bin_Query();
		$objCountry->executeQuery($sqlCountry);
		
		$userid=$_SESSION['user_id'];
		if($_GET['id']!='')
		{
			$sql="select * from addressbook_table where user_id=".$userid." and contact_name='".$_GET['id']."'";
			$query = new Bin_Query();
			$query->executeQuery($sql);
			return Display_DUserAccount::showAddAddressFromCheckout($objCountry->records,$query->records);
		}
		else
			return Display_DUserAccount::showAddAddressFromCheckout($objCountry->records);
	}
	/**
	 * This function is used to insert  the  address 
	 *
	 * .
	 * 
	 * @return string
	 */
	function addAddress()
	{
		$userid=$_SESSION['user_id'];
	
		$sql="select * from addressbook_table where user_id=".$userid." and contact_name='".$_POST['txtGName']."'";
		$query = new Bin_Query();
		$query->executeQuery($sql);
		if(empty($query->records))
		{
			$sql="insert into addressbook_table values('".$userid."','".$_POST['txtGName']."','".$_POST['txtFName']."','".$_POST['txtLName']."','".$_POST['txtCompany']."','".$_POST['txtEMail']."','".$_POST['txtAddress']."','".$_POST['txtCity']."','".$_POST['txtSuburb']."','".$_POST['txtState']."','".$_POST['selCountry']."','".$_POST['txtZip']."','".$_POST['txtPhone']."','".$_POST['txtFax']."')";
			$query = new Bin_Query();
			$query->executeQuery($sql);
			return '<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">×</button>
			Your Contact Successfully  Created!
			</div>';

		}	
		return '<div class="alert alert-error">
			<button data-dismiss="alert" class="close" type="button">×</button>
			Your Contact Could not Created!
			</div>';


	}
	/**
	 * This function is used to insert  the  address  from check out process
	 *
	 * .
	 * 
	 * @return string
	 */
	function addAddressFromCheckout()
	{
		$userid=$_SESSION['user_id'];
	
		$sql="select * from addressbook_table where user_id=".$userid." and contact_name='".$_POST['txtname']."'";
		$query = new Bin_Query();
		$query->executeQuery($sql);
		if(empty($query->records))
		{
			$sql="insert into addressbook_table values('".$userid."','".$_POST['txtname']."','".$_POST['txtname']."','','".$_POST['txtcompany']."','".$_POST['txtEMail']."','".$_POST['txtstreet']."','".$_POST['txtcity']."','".$_POST['txtsuburb']."','".$_POST['txtstate']."','".$_POST['selbillcountry']."','".$_POST['txtzipcode']."','','')";
			$query = new Bin_Query();
			$query->executeQuery($sql);
			return "<div class='success_msgbox'>Created!</div></br>";
		}	
		return "<div class='exc_msgbox'>Could not Created!</div></br>";
	}
	/**
	 * This function is used to edit  the   address for user after login
	 *
	 * .
	 * 
	 * @return string
	 */
	function editAddress()
	{
		$userid=$_SESSION['user_id'];
	
		$sql="update addressbook_table set contact_name='".$_POST['txtGName']."',first_name='".$_POST['txtFName']."',last_name='".$_POST['txtLName']."',company='".$_POST['txtCompany']."',email='".$_POST['txtEMail']."',address='".$_POST['txtAddress']."',city='".$_POST['txtCity']."',suburb='".$_POST['txtSuburb']."',state='".$_POST['txtState']."',country='".$_POST['selCountry']."',zip='".$_POST['txtZip']."',phone_no='".$_POST['txtPhone']."',fax='".$_POST['txtFax']."' where user_id='".$userid."' and contact_name='".$_POST['hidGroup']."'";
			$query = new Bin_Query();
			$query->executeQuery($sql);

			return '<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">×</button>
			Your Contact Successfully  Updated!
			</div>';
	}
	/**
	 * This function is used to delete  the   address for user after login
	 *
	 * .
	 * 
	 * @return string
	 */
	function delAddress()
	{
		$userid=$_SESSION['user_id'];
	
		$sql="delete from addressbook_table where user_id='".$userid."' and contact_name='".$_GET['id']."'";
		$query = new Bin_Query();
		$query->executeQuery($sql);


		return '<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">×</button>
			Your Contact Successfully  Deleted!
			</div>';
	}

}
?>
