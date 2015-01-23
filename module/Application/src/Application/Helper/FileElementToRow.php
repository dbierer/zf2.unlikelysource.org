<?php
namespace Application\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\Form;
use Zend\Form\View\Helper;
use Zend\Form\ElementInterface;
use Zend\View\Helper\Escaper;

class FileElementToRow extends AbstractHelper
{
	/*
	 * Returns an HTML table row using a form element
	 * <tr><td></td>
	 * @param string $elementName = name of the element to render
	 * @return string $html
	 */
	public function render(ElementInterface $element)
	{
		$view = $this->getView();
		$formLabel = new Helper\FormLabel();
		$formElement = new Helper\FormFile();
		$formElement->setView($view);
		$formErrors = new Helper\FormElementErrors();
		$formErrors->setView($view);
		$html = '<tr>'
			  . '<th align="right">' . $formLabel($element) . '</th>'
			  . '<td width="10px">&nbsp;</td>'
			  . '<td>' . $formElement($element, Escaper\AbstractHelper::RECURSE_ARRAY)
			  . '<span class="form-errors">' . $formErrors($element) . '</span>'
			  . '</td></tr>' . PHP_EOL;
		return $html;
	}
	public function __invoke(ElementInterface $element)
	{
		return $this->render($element);
	}
}