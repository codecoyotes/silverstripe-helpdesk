<?php

class FaqCategory extends DataObject {

	private static $singular_name = 'FAQ category';
	private static $plural_name = 'FAQ categories';

	private static $db = array(
		'Title' => 'Varchar',
		'Sort' => 'Int'
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

	private static $default_sort = 'Sort';

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('Sort');

		$itemsConfig = GridFieldConfig_RecordEditor::create();
		if(class_exists('GridFieldOrderableRows')){
			$itemsConfig->addComponent(new GridFieldOrderableRows());
		}
		$fields->addFieldToTab('Root.Main', new GridField('Items', _t('FaqItem.PLURAL_NAME', 'Faq items'), $this->Items(), $itemsConfig));

		return $fields;
	}

}