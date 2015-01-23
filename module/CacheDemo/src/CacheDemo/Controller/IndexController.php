<?php
namespace CacheDemo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Tests cache by generating a series of prime numbers (which takes a long time)
 * 1st time through it needs to generate cache
 * 2nd+ time it gets answer from cache
 *
 * @author
 *
 * @version
 *
 */
class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $cache = $this->getServiceLocator()->get('cache-demo-cache');
        // NOTE: this will cause an exception to be thrown
        return new ViewModel(array('cacheInfo' => $cache->getItem('does-not-exist')));
    }

}