<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Model_MergeTests_WheelsTest extends VF_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
	function testShouldAllowtOperation()
    {
        $vehicle1 = $this->createMMY('Honda','Civic','2000');
        $vehicle2 = $this->createMMY('Honda','Civic','2001');
        
        $wheelVehicle1 = new Elite_Vafwheel_Model_Vehicle($vehicle1);
        $wheelVehicle1->save();
        $wheelVehicle1->addBoltPattern( $this->boltPattern('4x114.3') );
        
        $wheelVehicle2 = new Elite_Vafwheel_Model_Vehicle($vehicle2);
        $wheelVehicle2->save();
        $wheelVehicle2->addBoltPattern( $this->boltPattern('4x114.3') );
        
        $slaveLevels = array(
            array('year', $vehicle1 ),
            array('year', $vehicle2 ),
        );
        $masterLevel = array('year', $vehicle2 );
        
        $this->merge($slaveLevels, $masterLevel);
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation()
    {
        $vehicle1 = $this->createMMY('Honda','Civic','2000');
        $vehicle2 = $this->createMMY('Honda','Civic','2001');
        
        $wheelVehicle1 = new Elite_Vafwheel_Model_Vehicle($vehicle1);
        $wheelVehicle1->save();
        $wheelVehicle1->addBoltPattern( $this->boltPattern('4x114.3') );
        
        $wheelVehicle2 = new Elite_Vafwheel_Model_Vehicle($vehicle2);
        $wheelVehicle2->save();
        $wheelVehicle2->addBoltPattern( $this->boltPattern('5x114') );
        
        $slaveLevels = array(
            array('year', $vehicle1 ),
            array('year', $vehicle2 ),
        );
        $masterLevel = array('year', $vehicle2 );
        
        $this->merge($slaveLevels, $masterLevel);
    }
}