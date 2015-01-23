<?php
namespace QandA\Form;
use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\Submit;
class SearchForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setAttribute('method', 'POST');
        $search = new Text('search');
        $search->setLabel('Enter Search Term(s)')
               ->setAttribute('maxlength', 128)
               ->setAttribute('id', 'q-and-a-search');

        $submit = new Submit('submit');
        $submit->setValue('Search')
                ->setAttribute('id', 'q-and-a-submit');

        $this->add($search)
             ->add($submit);
    }
}