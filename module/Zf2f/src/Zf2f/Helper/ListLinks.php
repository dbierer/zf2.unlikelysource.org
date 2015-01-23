<?php
namespace Zf2f\Helper;

use Zend\View\Helper\AbstractHelper;

class ListLinks extends AbstractHelper
{
	public function __invoke(Array $links, $prefix)
	{
		$output = '<ul>' . PHP_EOL;
		foreach ($links as $key => $item) {
			$output .= '<li><a href="' . $prefix . '/' . $key . '">' . $item . '</a></li>' . PHP_EOL;
		}
		$output .= '</ul>' . PHP_EOL;
		return $output;
	}
}