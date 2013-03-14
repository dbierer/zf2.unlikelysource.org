<?php
namespace Application\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\Form;
use Zend\Form\View\Helper;
use Zend\Form\Element;

class RadioElementToRow extends AbstractHelper
{
	/*
	 * Returns an HTML table row using a form element
	 * <tr><td></td>
	 * @param string $elementName = name of the element to render (must be type Radio
	 * @param mixed $uncheckedValue = value to be set if element is not checked
	 * @return string $html
	 */
	public function render(Element\Radio $element, $uncheckedValue)
	{
		$html = '';
		$view = $this->getView();
		$formLabel = new Helper\FormLabel();
		$formRadio = new Helper\FormRadio();
		$formRadio->setView($view)
				  // hidden element stores default value
				  ->setUseHiddenElement(TRUE)
				  // default value of hidden element if unchecked
				  ->setUncheckedValue($uncheckedValue)
				  ->setSeparator("</td>\n<td>");
		$formErrors = new Helper\FormElementErrors();
		$formErrors->setView($view);
		$html .= '<tr>'
			  . '<th align="right">' . $formLabel($element) . '</th>'
			  . '<td width="10px">&nbsp;</td>'
			  . '<td>'
				  . '<table width="100%">'
					  . '<tr>'
						  . '<td>' . $formRadio($element) . '</td>'
					  . '</tr>'
				  . '</table>'
				  . PHP_EOL
				  . '<span class="form-errors">' . $formErrors($element) . '</span>'
			  . '</td>'
			  . '</tr>' 
			  . PHP_EOL;
		return $html;
	}
	public function __invoke(Element\Radio $element, $uncheckedValue)
	{
		return $this->render($element, $uncheckedValue);
	}
}