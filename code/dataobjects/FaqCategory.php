<?php

class FaqCategory extends DataObject {

	private static $singular_name = 'FAQ category';
	private static $plural_name = 'FAQ categories';

	private static $db = array(
		'Title' => 'Varchar'
	);

	private static $has_one = array(
		'Page' => 'FaqPage'
	);

	private static $has_many = array(
		'Items' => 'FaqItem'
	);

	private static $summary_fields = array(
		'ID',
		'Created',
		'Title'
	);

}