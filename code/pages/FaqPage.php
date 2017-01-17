<?php

class FaqPage extends Page {

	private static $singular_name = 'FAQ page';
	private static $plural_name = 'FAQ pages';
	private static $description = 'Page with a list of faq categories containing faq items';

	private static $has_many = array(
		'Categories' => 'FaqCategory'
	);

}

class FaqPage_Controller extends Page_Controller {

}