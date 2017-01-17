<?php

class FaqPage extends Page {

	private static $singular_name = 'FAQ page';
	private static $plural_name = 'FAQ pages';
	private static $description = 'Page with a list of faq categories containing faq items';

	private static $has_many = array(
		'Categories' => 'FaqCategory'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$categoriesConfig = GridFieldConfig_RecordEditor::create();
		if(class_exists('GridFieldOrderableRows')){
			$categoriesConfig->addComponent(new GridFieldOrderableRows());
		}
		$fields->addFieldToTab('Root.Categories', new GridField('Categories', _t('FaqCategory.PLURAL_NAME', 'Categories'), $this->Categories(), $categoriesConfig));

		return $fields;
	}

}

class FaqPage_Controller extends Page_Controller {

}