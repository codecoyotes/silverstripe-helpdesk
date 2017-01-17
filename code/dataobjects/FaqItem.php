<?php

class FaqItem extends DataObject {

	private static $singular_name = 'FAQ item';
	private static $plural_name = 'FAQ items';

	private static $db = array(
		'Question' => 'Varchar(255)',
		'Answer' => 'HTMLText'
	);

	private static $has_one = array(
		'Category' => 'FaqCategory'
	);

	private static $summary_fields = array(
		'ID',
		'Created',
		'Question'
	);

}