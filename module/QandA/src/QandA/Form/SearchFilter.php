<?php
namespace QandA\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
class SearchFilter extends InputFilter
{
    public function __construct()
    {
        $search = new Input('search');
        $search->getFilterChain()
               ->attachByName('StripTags')
               ->attachByName('StringTrim');
        $search->getValidatorChain()
               ->attachByName('StringLength', array('min' => 1, 'max' => 128));
        $this->add($search);
    }
}