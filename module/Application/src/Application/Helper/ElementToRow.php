<?php
namespace Application\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\Form;
use Zend\Form\View\Helper;
use Zend\Form\ElementInterface;

class ElementToRow extends AbstractHelper
{
	/*
	 * Returns an HTML table row using a form element
	 * <tr><td></td>
	 * @param string $elementName = name of the element to render
	 * @return string $html
	 */
	public function render(ElementInterface $element)
	{
		$formLabel 	 = new Helper\FormLabel();
		$formElement = new Helper\FormElement();
		$formErrors  = new Helper\FormElementErrors();
		$view 		 = $this->getView();
		$formElement->setView($view);
		$formErrors->setView($view);
		$html = '<tr>'
			  . '<th align="right">' . $formLabel($element) . '</th>'
			  . '<td width="10px">&nbsp;</td>'
			  . '<td>' . $formElement($element)
			  . '<span class="form-errors">' . $formErrors($element) . '</span>'
			  . '</td></tr>' . PHP_EOL;
		return $html;
	}
	public function __invoke(ElementInterface $element)
	{
		return $this->render($element);
	}
}