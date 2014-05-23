<?php
namespace FormDemo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\Element\Submit;

/**
 * AnnotationController
 *
 * @author
 *
 * @version
 *
 */
class AnnotationController extends AbstractActionController
{

    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        // init vars
        $data     = NULL;
        $table    = $this->getServiceLocator()->get('city-codes-table');
        $catList  = $this->getServiceLocator()->get('form-demo-categories');
        $cityList = $table->getAllCityCodesForForm();
        $countryList = $table->getAllCountryCodesForForm();
               
        // submit button
        $submit  = new Submit('submit');
        $submit->setAttribute('value', 'Submit');
        
        // build form
        $builder = new AnnotationBuilder();
        $entity  = $this->getServiceLocator()->get('form-demo-listings-entity');
        $form    = $builder->createForm($entity);
        $form->get('category')->setValueOptions(array_combine($catList, $catList));
        $form->getInputFilter()
             ->get('category')
             ->getValidatorChain()
             ->attachByName('InArray', array('haystack' => $catList));
        $form->get('country')->setValueOptions($countryList);
        $form->getInputFilter()
             ->get('country')
             ->getValidatorChain()
             ->attachByName('InArray', array('haystack' => $countryList));
        $form->add($submit);
        $form->bind($entity);
        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $data = $form->getData();
            }
        }
        return new ViewModel(array('form' => $form, 'data' => $data, 'cityList' => $cityList));
    }
}