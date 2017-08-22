Salesforce Web-to-Lead
=========================

Generally when using Salesforce's Web-to-Lead feature to send form submissions to your Salesforce instance you have to send them from the frontend by setting the HTML form target attribute to a salesforce.com URL, by-passing your own controllers and not storing submission info in your own database.

Using this package, you can send your leads to Salesforce from the backend of your application when and where you want to, ideally from the controller that already handles storing your form sumbissions. 


Features
--------

* Send leads using the Salesforce Web-to-Lead feature from the backend of your application using PHP instead of the frontend using HTML
* A debug option that when enabled will send you an email from Salesforce on each submission informing you whether the lead was successfully sent; and if it was not, details on what went wrong. 
* Method-chaining

Usage
--------
```use CloudAssessments\Salesforce\WebToLead;

$form = new WebToLead();
$form
    ->setSalesforceAccountIdentifier('YourAccountID')  
    ->submit(                                          
        [                                              
            'first_name'      => 'John',               
            'last_name'       => 'Doe',                
            'phone'           => '555-123-4567',       
            'company'         => 'Acme Inc.',          
            'lead_source'     => 'Web-to-Lead',        
        ]                                              
    );
```