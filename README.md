## Salesforce Web-to-Lead

Generally when using Salesforce's Web-to-Lead feature to send form submissions to your Salesforce instance you have to send them from the frontend by setting the HTML form target attribute to a salesforce.com URL, by-passing your own controllers and not storing submission info in your own database.

Using this package, you can send your leads to Salesforce from the backend of your application when and where you want to, ideally from the controller that already handles storing your form sumbissions. 


Features
--------

* Send leads using the Salesforce Web-to-Lead feature from the backend of your application using PHP instead of the frontend using HTML
* A debug option that when enabled will send you an email from Salesforce on each submission informing you whether the lead was successfully sent; and if it was not, details on what went wrong. 
* Method-chaining

### Installation

Install the latest version with

```bash
$ composer require cloudassessments/salesforce-web-to-lead
```

### Basic Usage

```php
<?php

use CloudAssessments\Salesforce\WebToLead;

$form = new WebToLead();
$form
    ->setSalesforceAccountIdentifier('YourAccountID')  
    ->submit(                                          
        [                                              
            'first_name'      => 'John',               
            'last_name'       => 'Doe',                
            'email'           => 'johndoe@example.com',
            'phone'           => '555-123-4567',       
            'company'         => 'Acme Inc.',          
            'lead_source'     => 'Web-to-Lead',        
        ]                                              
    );
```

### Custom Fields

The fields provided in the example above are simply the default Salesforce fields that everyone has.

However, you can create custom fields in Salesforce and use this library to submit those as well. Unfortunately, when you create a custom field in Salesforce (let's say you create a text box called `Referral Source`), the name attribute of that input element is a randomly generated string, e.g. `00N46000009SDY5`.

The only way to find out the name of that field is to inspect your form in Salesforce from your browser and find the name attribute on the `<input>` element for that field.

Once you have that randomly generated string, you can use that as a key in the array when submitting to Salesforce.

For example:

```php
use CloudAssessments\Salesforce\WebToLead;

$form = new WebToLead();
$form
    ->setSalesforceAccountIdentifier('YourAccountID')  
    ->submit(                                          
        [                                              
            'first_name'      => 'John',
            'last_name'       => 'Doe',
            'email'           => 'johndoe@example.com',
            'lead_source'     => 'Web-to-Lead',
             // Your new Referral Source field below
            '00N46000009SDY5 => 'https://example.com/referral-page',
        ]                                              
    );
```
