<?php namespace LinuxAcademy\Salesforce;

/**
 * WebToLead.php
 *
 * Sending form submissions to Salesforce using their Web-to-Lead feature.
 *
 * @author Kurt Maine <kurt@linuxacademy.com>
 */


/**
 * Class WebToLead
 *
 * @package LinuxAcademy\Salesforce\WebToLead
 */
class WebToLead
{

    /**
     * The Salesforce Web-to-Lead form target URL
     */
    const SALESFORCE_FORM_TARGET_URL = 'https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8';

    /**
     * @var string A unique identifier used by Salesforce to target your specific Salesforce instance
     */
    private $salesforceAccountIdentifier = '';

    /**
     * @var string The Salesforce Web-to-Lead form return URL
     */
    private $salesforceReturnUrl;

    /**
     * @var string The email that debugging information will be sent to
     */
    private $salesforceDebugEmail;

    /**
     * @var string If set to true, Salesforce will email debug info to the email set in $salesforceDebugEmail;
     */
    private $salesforceDebug = '';

    /**
     * @var array cURL options that should be set on every request
     */
    private $curlOpts = [
        CURLOPT_URL            => self::SALESFORCE_FORM_TARGET_URL,
        CURLOPT_HEADER         => false,
        CURLOPT_RETURNTRANSFER => false,
    ];

    /**
     * @var array Form fields that should be set on every request
     */
    private $defaultFields = [
        'debug'      => false,
        'debugEmail' => false,
        'oid'        => false,
        'retUrl'     => '',
    ];


    /**
     * Salesforce Form constructor.
     *
     * @param bool $debug If true, debug information will be emailed
     */
    public function __construct($debug = false)
    {

        // If debug is true, append debug values to array of default form fields
        if ($debug) {
            $this->setSalesforceDebug(1);
            $this->setSalesforceDebugEmail($this->salesforceDebugEmail);
        }
    }


    /**
     * @param bool $salesforceDebug
     *
     * @return $this
     */
    public function setSalesforceDebug(bool $salesforceDebug)
    {

        $this->salesforceDebug        = $salesforceDebug;
        $this->defaultFields['debug'] = $this->salesforceDebug;

        return $this;
    }


    /**
     * @param string $salesforceDebugEmail
     *
     * @return $this
     */
    public function setSalesforceDebugEmail(string $salesforceDebugEmail)
    {

        $this->salesforceDebugEmail   = $salesforceDebugEmail;
        $this->defaultFields['debug'] = $this->salesforceDebugEmail;

        return $this;
    }


    /**
     * @param $salesforceReturnUrl
     *
     * @return $this
     */
    public function setSalesforceReturnUrl($salesforceReturnUrl)
    {

        $this->salesforceReturnUrl     = $salesforceReturnUrl;
        $this->defaultFields['retUrl'] = $this->salesforceReturnUrl;

        return $this;
    }


    /**
     * @param $salesforceAccountIdentifier
     *
     * @return $this
     */
    public function setSalesforceAccountIdentifier($salesforceAccountIdentifier)
    {

        $this->salesforceAccountIdentifier = $salesforceAccountIdentifier;
        $this->defaultFields['oid']        = $this->salesforceAccountIdentifier;

        return $this;
    }


    /**
     * A check that is run before form submission to ensure all required fields are set.
     */
    private function configurationChecks()
    {

        // Debug Check: If debug enabled, check that debug email is set
        if ($this->salesforceDebug && is_string($this->salesforceDebugEmail) && $this->salesforceDebugEmail != '') {
            throw new \InvalidArgumentException('With debug mode enabled, you must set the debug email address.');
        }


        // OID Check: Make sure the unique Salesforce account identifier is set and is a string
        if (!$this->defaultFields['oid'] && is_string($this->defaultFields['oid']) && $this->defaultFields['oid'] != '') {
            throw new \InvalidArgumentException('The unique Salesforce account ID (oid) must be set as a string.');
        }
    }


    /**
     * Send a form submission to Salesforce by providing an array of form fields.
     *
     * @param array $formInput An array of form fields and values
     *
     * @return mixed
     */
    public function submit(array $formInput)
    {

        // Check that all necessary options have been set
        $this->configurationChecks();

        // Open a new curl connection
        $ch = curl_init();

        // POST field preparation, fields that need to be prepended to each request
        $formInput = array_merge($this->defaultFields, $formInput);

        $formFields = $this->processFormFields($formInput);

        if ($formFields) {
            // Set curl options
            curl_setopt_array($ch, $this->curlOpts);
            curl_setopt($ch, CURLOPT_POST, count($formInput));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formFields);

            // Execute the curl request
            $response = curl_exec($ch);

            // Close the curl connection
            curl_close($ch);

            return $response;
        }

        return false;
    }


    /**
     * Transforms an array of form fields in to a string separated by ampersands.
     *
     * @param array $postArray An array of form names and values
     *
     * @return bool|string
     */
    private static function processFormFields(array $postArray)
    {

        $formFields = false;

        // If there are POST variables and the array is not empty
        if ($postArray) {
            // Initialize the $kv array for later use
            $postFields = [];

            // For each POST variable as $name_of_input_field => $value_of_input_field
            foreach ($postArray as $key => $value) {
                // Set array element for each POST variable (ie. first_name=Kurt)
                $postFields[] = stripslashes($key) . "=" . stripslashes($value);
            }

            // Create a query string with join function separated by ampersands
            $formFields = join("&", $postFields);
        }

        return $formFields;
    }
}
