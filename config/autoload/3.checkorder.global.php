<?php
use CheckOrder\Entity\Storage;
Storage::$order[] = '======== ' . basename(__FILE__) . ' ===========================';
Storage::$order[] = '.... Param: ' . __FILE__;
return array();