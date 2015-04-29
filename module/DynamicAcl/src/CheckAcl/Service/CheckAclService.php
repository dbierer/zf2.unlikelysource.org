<?php
// 2015-03-11 DB
namespace DynamicAcl\Service;

use Zend\Navigation\Navigation;
use Zend\Mvc\MvcEvent;
use Zend\Navigation\Service\ConstructedNavigationFactory;
use Zend\Permissions\Acl\Acl;
class DynamicAclService
{
    
    const DYNAMIC_ACL_MENU_CACHE_PREFIX = 'MAIN_MENU_';
    const DYNAMIC_ACL_ACL_CACHE_KEY     = 'MAIN_ACL_CACHE';
    const DEFAULT_CACHE_KEY              = 'DEFAULT';

    protected $rolesInheritance;
    protected $groupsTable;
    protected $navMenuTable;
    protected $aclAllowTable;
    protected $session;
    protected $serviceManager;
    protected $parentRoles = array();
    protected $groupNames  = array();
    
    /**
     * 
     * @return Zend\Permissions\Acl\Acl 
     */
    public function getAcl()
    {
        $sm = $this->getServiceManager();
        $cache   = $sm->get('dynamic-acl-cache');
        $acl = $cache->getItem(static::DYNAMIC_ACL_ACL_CACHE_KEY, $success);
        if (!$success) {
            $acl = $this->buildAcl();
            $cache->setItem(static::DYNAMIC_ACL_ACL_CACHE_KEY, $acl);
        }
        return $acl;
    }

    /**
     * Builds ACL from base ACL + database table acl_allow
     * @return Zend\Permissions\Acl $acl
     */
    public function buildAcl()
    {
        // 2015-03-19 DB: ACL is now built completely from the ground up
        $acl = new Acl();
        // NOTE: roles are defined in config/autoload/roles.global.php
        foreach ($this->rolesInheritance as $key => $value) {
            if ($value) {
                $acl->addRole($key, $value);
            } else {
                $acl->addRole($key);
            }
        }
        // get list of resources
        $allowList = $this->aclAllowTable->fetchAll();
        // add resources to ACL
        foreach ($allowList as $item) {
            $resource = $item->controller;
            if (!$acl->hasResource($resource)) {
                $acl->addResource($resource);
            }
            $acl->allow($item->role, $resource, explode(',', $item->actions));
        }
        return $acl;
    }
    
    public function getMenu()
    {
        $sm      = $this->getServiceManager();
        $default = $sm->get('dynamic-acl-default-menu');
        $cache   = $sm->get('dynamic-acl-cache');
        // is menu available from cache? if so, retrieve it
        $cache = $sm->get('dynamic-acl-cache');
        $key = $this->getKey($this->getGroupNamesFromSession());
        // 2nd param returns (bool) and is assigned by reference
        $navigation = $cache->getItem($this->getCacheKey($key), $success);
        if (!$success) {
            $navigation = $this->buildNavigation($key, $default);
            $cache->setItem($this->getCacheKey($key), $navigation);
        }
        return $navigation;
    }

    public function getCacheKey($key)
    {
        // YES ... I know that "md5()" is outdated ...
        // but it makes a great way to generate a single alphanumeric value out of multiple ones
        return static::DYNAMIC_ACL_MENU_CACHE_PREFIX . md5($key);
    }
    
    /**
     * Builds a navigation container based on group memberships
     * If user belongs to >1 group, key will look like this:
     * group1-group2-group3 etc.
     * 
     * @param string $key = group membership
     * @param array $default = default menu
     * @return Zend\Navigation\Navigation container
     */
    public function buildNavigation($key)
    {
        // init vars
        $navMenuList = $this->navMenuTable->fetchAll();
        $roles       = $this->getRolesFromGroups();
        $roles       = $this->getInheritedRoles($roles, $this->getAcl());
        $count       = 0;
        $category    = '';
        $menu        = array();
        $submenu     = array();
        // loop through nav_menu table
        foreach ($navMenuList as $navItem) {
            $check = $this->roleCheck($roles, $navItem);
            if ($check) {
                if ($category != $navItem->category) {
                    $menu[] = array(
                        'label' => $category,
                        'uri'   => '#',
                        'pages' => $submenu,
                    );
                    $submenu = array();
                    $category = $navItem->category;
                }
                $submenu[] = array(
                    'label' => $navItem->label,
                    'route' => $navItem->route,
                    'action' => $navItem->action,
                );
            }
        }
        // check for edge case where only 1 menu category is allowed
        $menu[] = array(
            'label' => $category,
            'uri'   => '#',
            'pages' => $submenu,
        );
        unset($menu[0]);
        return new Navigation($menu);
    }

    /**
     * Returns an array which includes these roles + any parent roles they have
     * @param array $roles
     * @param Zend\Permissions\Acl\Acl $acl
     * @return array $roles
     */
    protected function getInheritedRoles($roles, $acl)
    {
        $result = array();
        $parentRoles = $this->getParentRolesArray($acl);
        foreach ($roles as $item) {
            $result[] = $item;
            if ($parentRoles[$item]) {
                foreach ($parentRoles[$item] as $value) {
                    $result[] = $value;
                }
            }
        }
        return array_unique($result);
    }
    
    /**
     * Builds array of parents for each role
     * @return array $inheritedRoles
     */
    protected function getParentRolesArray($acl)
    {
        if (!$this->parentRoles) {
            $this->parentRoles = array();
            foreach ($this->rolesInheritance as $outerKey => $value) {
                $this->parentRoles[$outerKey] = array();
                foreach ($this->rolesInheritance as $innerKey => $subvalue) {
                    if ($acl->inheritsRole($outerKey, $innerKey)) {
                        $this->parentRoles[$outerKey][] = $innerKey;
                    }
                }
            }
        }
        return $this->parentRoles;
    }

    /**
     * Checks to see if any $navItem roles are in $roles
     * @param array $roles
     * @param NavMenu\Model\NavMenu $navItem
     */
    public function roleCheck($roles, $navItem)
    {
        $navItem->convertRolesStringToArray();
        $result = FALSE;
        foreach ($roles as $item) {
            if (in_array($item, $navItem->roles)) {
                $result = TRUE;
            }
        }
        return $result;
    }

    public function getDefaultMenu()
    {
        $sm = $this->getServiceManager();
        return new Navigation($sm->get('dynamic-acl-default-menu'));
    }
    
    protected function getKey($groups)
    {
        if (is_string($groups)) {
            $key = $groups;
        } elseif (is_array($groups)) {
            $key = implode(';', $groups);
        } else {
            $key = static::DEFAULT_CACHE_KEY;
        }
        return $key;
    }

    /**
     * Does a lookup by group(s) and returns an array of roles
     * 
     * Assumes $_SESSION['groups'] is set
     * @return array $roles
     */
    public function getRolesFromGroups()
    {
        $roles = array();
        foreach ($this->getGroupNamesFromSession() as $name) {
            $groupModel = $this->groupsTable->getGroupByName($name);
            if ($groupModel) {
                $groupModel->convertRolesStringToArray();
                $roles = array_merge($roles, $groupModel->roles);
            }            
        }   
        return array_unique($roles);
    }

    /**
     * Assumes $_SESSION['groups'] is populated with a series of LDAP DN entries
     * @return array
     */
    public function getGroupNamesFromSession()
    {
        if (!$this->groupNames) {
            if (isset($this->session->groups) && is_array($this->session->groups)) {
                $this->groupNames = array();
                foreach ($this->session->groups as $dn) {
                    $this->groupNames[] = $this->getGroupFromDn($dn);
                }
            }
        }
        return $this->groupNames;
    }
    
    /**
     * Extracts group from DN
     * DN looks like this:
     * "cn=iBeBigBoss,ou=SOMEDISTRICT,o=SOMEREGION"
     * @param string $dn
     * @return string $group
     */
    protected function getGroupFromDn($dn)
    {
        return substr($dn, 3, strpos($dn, ',') - 3);
    }
    
    /**
     * Removes menu cache; if specific key is not provided, does by prefix
     * 
     * @param string $key
     */
    public function clearMenuCache($key = NULL)
    {
        $cache = $this->getServiceManager()->get('dynamic-acl-cache');
        if ($key) {
            return $cache->removeItem($key);
        } else {
            return $cache->clearByPrefix(static::DYNAMIC_ACL_MENU_CACHE_PREFIX);
        }
    }
    
    /**
     * Removes ACL cache
     */
    public function clearAclCache()
    {
        $cache = $this->getServiceManager()->get('dynamic-acl-cache');
        return $cache->removeItem(static::DYNAMIC_ACL_ACL_CACHE_KEY);
    }
    
    /**
     * @return the $groupsTable
     */
    public function getGroupsTable()
    {
        return $this->groupsTable;
    }

    /**
     * @return the $navMenuTable
     */
    public function getNavMenuTable()
    {
        return $this->navMenuTable;
    }

    /**
     * @param field_type $groupsTable
     */
    public function setGroupsTable($groupsTable)
    {
        $this->groupsTable = $groupsTable;
    }

    /**
     * @param field_type $navMenuTable
     */
    public function setNavMenuTable($navMenuTable)
    {
        $this->navMenuTable = $navMenuTable;
    }
    
     /**
     * @return the $aclAllowTable
     */
    public function getAclAllowTable()
    {
        return $this->aclAllowTable;
    }

     /**
     * @param field_type $aclAllowTable
     */
    public function setAclAllowTable($aclAllowTable)
    {
        $this->aclAllowTable = $aclAllowTable;
    }

    /**
     * @return the $serviceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param field_type $serviceManager
     */
    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @return the $rolesInheritance
     */
    public function getRolesInheritance()
    {
        return $this->rolesInheritance;
    }


    /**
     * @param field_type $rolesInheritance
     */
    public function setRolesInheritance($rolesInheritance)
    {
        $this->rolesInheritance = $rolesInheritance;
    }

}
