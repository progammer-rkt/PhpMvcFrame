<?php
/**
 *....................................................................................
 *                                 VirtualDatabase.php                                *
 * ...................................................................................*
 * 
 * This is a resource file. Resource files are used to communicate with database. you
 * can include databse quries here. A resource file should manage both collection and
 * an entity simultaneously.
 * 
 * File     : VirtualDatabase.php
 * contains : class
 * Location : app/class/Demo/Fundraise/Model/Resource/VirtualDatabase.php
 */

/**
 * Demo_Fundraiser_Model_Resource_VirtualDatabase Class
 *
 * This is just a class version of fundraiser_table in ActRight.
 * This class simply holds some properties those are stands for
 * each column of fund_raiser table.
 *
 * 
 */
class Demo_Fundraiser_Model_Resource_VirtualDatabase 
	extends Core_Default_Model_Resource_Abstract
{
	
	/**
	 * holds columns of fund_raiser table as properties.
	 */
	public $id;
	public $event_name;
	public $event_description;
	public $created_by;
	public $created_date;
	public $expected_amount;
	public $amount_raised;
	public $event_status;
	public $created_at;
	public $updated_at;
}