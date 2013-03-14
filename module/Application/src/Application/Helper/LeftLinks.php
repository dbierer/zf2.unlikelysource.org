<?php
namespace Application\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class LeftLinks extends AbstractHelper
{
	/*
	 * Returns HTML <ul><li><a href="$urlPrefix/$item">$item</li><ul>
	 * @param Array $values = array of values to be processed
	 * @param string $urlPrefix = prefix to be inserted in front of each array element
	 * @return string $html
	 */
	public function render(Array $values, $urlPrefix)
	{
		$html = '<ul  style="list-style-type: none;">' . PHP_EOL;
		foreach ($values as $item) {
			$html .= sprintf("<li><a href=\"%s/%s\">%s</a></li>\n", $urlPrefix, $item, $item);
		}
		$html .= '</ul>' . PHP_EOL;
		return $html;
	}
	public function __invoke(Array $values, $urlPrefix)
	{
		return $this->render($values, $urlPrefix);
	}
}