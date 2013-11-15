<?php
namespace Forum\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;

class ForumForm extends Form
{
	public function prepareElements($topicList, $categoryList, $captchaOptions)
	{
		// repurpose $topicList and $categoryList
		$topics = array('---' => 'Choose');
		foreach ($topicList as $item) {
			$topics[$item->item] = $item->item;
		}
		$categories = array('---' => 'Choose');
		foreach ($categoryList as $item) {
			$categories[$item->item] = $item->item;
		}

		$author = new Element\Hidden('author');

		$category1 = new Element\Text('category');
		$category1->setLabel('Category')
			 ->setAttribute('title', 'Enter a category: i.e. zf2 or use the dropdown list below')
			 ->setAttribute('size', 16)
			 ->setAttribute('maxlength', 16);

		$category2 = new Element\Select('selectCategory');
		$category2->setValueOptions($categories);

		$topic1 = new Element\Text('topic');
		$topic1->setLabel('Topic')
			 ->setAttribute('title', 'Enter a topic code: i.e. zf2f-2013-02-25 or use the dropdown list below')
			 ->setAttribute('size', 60)
			 ->setAttribute('maxlength', 254);

		$topic2 = new Element\Select('selectTopic');
		$topic2->setValueOptions($topics);

		$title = new Element\Text('title');
		$title->setLabel('Title')
			 ->setAttribute('title', 'Enter a suitable title for this posting')
			 ->setAttribute('size', 60)
			 ->setAttribute('maxlength', 254);

		$body = new Element\Textarea('body');
		$body->setLabel('Body')
			->setAttribute('title', 'Enter the body for this posting')
			->setAttribute('rows', 4)
			->setAttribute('cols', 60);

		$captcha = new Element\Captcha('captcha');
		$captchaAdapter = new Captcha\Image();
		$captchaAdapter->setWordlen(4)
					   ->setOptions($captchaOptions);
		$captcha->setCaptcha($captchaAdapter)
				->setLabel('Help us to prevent SPAM!')
				->setAttribute('class', 'captchaStyle')
			    ->setAttribute('title', 'Help to prevent SPAM');

		$submit = new Element\Submit('submit');
		$submit->setAttribute('value', 'Post')
			   ->setAttribute('title', 'Click here when done');

		$this->add($author)
			 ->add($topic1)
			 ->add($topic2)
			 ->add($category1)
			 ->add($category2)
			 ->add($title)
			 ->add($body)
			 ->add($captcha)
			 ->add($submit);
	}
}
