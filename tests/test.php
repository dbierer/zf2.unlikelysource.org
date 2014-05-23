<?php
$string = '<label><span>Event Date (YYYY-mm-dd)</span><input type="text" name="eventDate" required="required" value="2014-02-09"></label><label><span>Event Start Time (24H:min:sec)</span><input type="text" name="eventStartTime" required="required" value=""></label><label><span>Event End Time (24H:min:sec)</span><input type="text" name="eventEndTime" required="required" value=""></label></fieldset>';
$pattern = '/name="(.+?)"/';
preg_match($pattern, $string, $matches);
var_dump($matches);