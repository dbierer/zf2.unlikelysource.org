<?php
require '../vendor/ZF2/library/Zend/Version/Version.php';
$version = new Zend\Version\Version();
echo 'ZF Version: ' . $version::VERSION;
echo '<br />';
echo md5('hoohah'); 