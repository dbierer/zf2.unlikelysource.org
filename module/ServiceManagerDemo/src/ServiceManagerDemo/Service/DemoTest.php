<?php
namespace ServiceManagerDemo\Service;

class DemoTest
{
    /**
     * 
     * @param string $logFile
     */
    public function __construct($logFile)
    {
        $message = 'ABSTRACT: DEMOTEST: ';
        $message .= __CLASS__ . PHP_EOL;
        error_log($message, 3, $logFile);
    }
}