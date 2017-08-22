<?php

/**
 * @author Kurt Maine <kurt@cloudassessments.com>
 */

class WebToLeadTest extends PHPUnit_Framework_TestCase
{

    /**
     * Check for syntax errors on initialization
     *
     */
    public function testIsThereAnySyntaxError()
    {

        $var = new CloudAssessments\Salesforce\WebToLead(false);
        $this->assertTrue(is_object($var));
        unset($var);
    }


    /**
     * A check that the setters return no syntax errors
     */
    public function testSetSalesforceReturnUrl()
    {

        $var = new CloudAssessments\Salesforce\WebToLead(false);
        $this->assertTrue($var->setSalesforceReturnUrl("http://example.com/return-url") === $var);
        unset($var);
    }

}