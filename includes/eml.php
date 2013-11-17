<?php
require_once 'connect.eml';
require_once '../vendor/swiftmailer/swiftmailer/lib/swift_required.php';
$transport = Swift_SmtpTransport::newInstance()
    ->setUsername($emlusername)
    ->setPassword($emlpassword)
    ->setHost($emlserver)
    ->setPort($port)
    ->setEncryption($encryption)
;
$mailer = Swift_Mailer::newInstance($transport);