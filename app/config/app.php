<?php
/**
 * All app settings
 */
return [
    /**
     * Directory from host, where all files is placed
     */
    'directory' => '/kdrmii',
    /**
     * Web title
     */
    'title' => 'DAMSS',
    /**
     * Old record delete type
     * url - records will be deleted when any user enter register page
     * cron - you will need to configure cronjob to use url: directory/cron/clear
     */
    'old_record_clear' => 'url',
    /**
     * System mail
     */
    'mail' => 'no-reply@mii.lt',
    /**
     * reCaptcha settings
     */
    'recaptcha'=>[
        "site_key" => "6LcMpVYUAAAAAPD0rqA7Bag75oOMoYmrfWKIRdT1",
        "secret_key" => "6LcMpVYUAAAAACSGMnJ7f3lug_XrfXPdHeJwobmZ"
    ],
    'admin_name' => "admin",
    'admin_password' => "admin"
];