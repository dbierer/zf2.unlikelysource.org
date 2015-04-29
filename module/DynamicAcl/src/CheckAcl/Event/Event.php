<?php
// 2015-03-11 DB
namespace DynamicAcl\Event;

use Zend\EventManager\Event as ZendEvent;

class Event extends ZendEvent
{
    const DYNAMIC_ACL_MENU_EVENT = 'dynamic.acl.menu.event';
    const DYNAMIC_ACL_CHANNEL    = 'dynamic.acl.channel';
}