<?php

require_once('custom/include/sampleclasses/ClassA.php');

/*
* Functional test
*/
class ClassATest extends Rt_PHPUnit_Framework_TestCase
{
	/**
    * This method used to create test data
    */
    public function setUp()
	{
		//initialize database
		$GLOBALS['db'] = DBManagerFactory::getInstance();

		$GLOBALS['db']->query(
            "Replace INTO `contacts` (id, title) VALUES('1', 'Sales Manager')"
        );
		parent::setUp();
	}
	public function testFunctionA()
	{		
		$obj = new ClassA();
		$result = $obj->functionA();
		$this->assertEquals("1", $result);
	}
	
    public function tearDown()
    {
        $GLOBALS['db']->query("DELETE FROM contacts WHERE id  = '1'");
        unset($GLOBALS['db']);
        parent::tearDown();
    }
}