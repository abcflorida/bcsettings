<?php

/**
 * Part of the BC Town settings extension.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Florida Web Design PSL License.
 *
 * This source file is subject to the Florida Web Design PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    type here
 * @version    1.0.1
 * @author     Florida Web Design LLC
 * @license    Florida Web Deisgn LLC PSL
 * @copyright  (c) 2011-2016, Florida Web Deisgn LLC PSL
 * @link       http://flwebdesignservice.com
 */
return [

    // Section title
    'title' => 'BCGeneral Settings',

    // Group
    'admin' => [

        // Group title
        'title' => 'Site Admin',

        // Fields
        'field' => [
            'help' => 'App Help',
        ],

    ],

    // Group
    'application' => [

        // Group title
        'title' => 'Application Basics',

        // Fields
        'field' => [
            'title'     => 'Title',
            'tagline'   => 'Tagline',
            'copyright' => 'Copyright',
        ],

    ],

    // Group
    'email' => [

        // Group title
        'title' => 'Email Settings',

        // Fields
        'field' => [
            'driver'        => 'Mail Driver',
            'host'          => 'Host Address',
            'port'          => 'Host Port',
            'encryption'    => 'Encryption Protocol',
            'from_address'  => 'From Address',
            'from_name'     => 'From Name',
            'username'      => 'Server Username',
            'password'      => 'Server Password',
            'sendmail_path' => 'Sendmail System Path',
            'pretend'       => 'Main "Pretend"',
        ],

    ],

];
