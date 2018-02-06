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
        global $db;
        $db->query(
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
        global $db;
        $db->query("DELETE FROM contacts WHERE id  = '1'");
        parent::tearDown();
    }
}
