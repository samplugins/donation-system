# Donation System with Advanced Reporting

PHP Payment form with multiple payment gateways support. By default it supports PayPal. One window utility.

* AJAX based
* Dashboard to view graphical monthly reports (new)
* Advanced filters (By time, Today, This month, Last year) (new)
* API for multiple payment gateways
* Paypal supported by default
* No third party library dependency
* PHP/MySQL
* Secure Admin panel
* Web based one click settings
* Donation Manager
* CSV Exporter
* Software Version : PHP 5.x

# General Config

Open: php\include\config\config.php

`$config = array(
    "site_url"=> "http://localhost:50/donation-form/",  // must ends with slash - Trailing slash must be there
    "demo_mode"=> true,
    "currency"=> 'USD',
    "database"  => array(
        'host'=>'localhost',
        'user'=>'root',
        'password'=>'root',
        'db'=>'donation_form'
    )
);`


# Payment Config

Open: php\include\config\config.php

`$payment_config = array(
    'paypal' => array
    (
        'merchant_email' => 'sales@themology.net',
        'pdt_auth_code' => 'ZrzsgLIK23zrz_FEDP2sTGOdjd9xi4YiXSTz9IFloD9uGOE2Q3jlhdyJkvq',
    ) 
);`


# Create Database

You can use MySQL Manager e.g. PHPMyAdmin

Donation Form: http://localhost:50/donation-form/

Admin Details: http://localhost:50/donation-form/admin.php

u: admin
p: Th3mology

More Script and WordPress Plugins visit: http://samplugins.com
