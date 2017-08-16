<?php

/**
 * @author Kurt Maine <kurt@linuxacademy.com>
 */
class WebToLeadTest extends PHPUnit_Framework_TestCase
{

    /**
     * Just check if the YourClass has no syntax error
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */
    public function testIsThereAnySyntaxError()
    {

        $var = new LinuxAcademy\Salesforce\WebToLead(false);
        $this->assertTrue(is_object($var));
        unset($var);
    }


    /**
     * Just check if the YourClass has no syntax error
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */
    public function testMethod1()
    {

        $var = new LinuxAcademy\Salesforce\WebToLead(false);
        $this->assertTrue($var->method1("hey") == 'Hello World');
        unset($var);
    }

}