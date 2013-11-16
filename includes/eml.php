<?php
require_once 'connect.eml';
require_once '../lib/SwiftMailer/swift_required.php';
$transport = Swift_SmtpTransport::newInstance()
    ->setUsername($emlusername)
    ->setPassword($emlpassword)
    ->setHost($emlserver)
    ->setPort($port)
    ->setEncryption($encryption)
;
$mailer = Swift_Mailer::newInstance($transport);