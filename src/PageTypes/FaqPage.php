<?php
namespace CodeCoyotes\Helpdesk;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class FaqPage extends \Page {

	private static $singular_name = 'FAQ page';
	private static $plural_name = 'FAQ pages';
    private static $description = 'Page with a list of faq categories containing faq items';
    private static $table_name = 'FaqPage';

	private static $has_many = array(
		'Categories' => FaqCategory::class
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$categoriesConfig = GridFieldConfig_RecordEditor::create();
		if(class_exists(GridFieldOrderableRows::class)){
			$categoriesConfig->addComponent(new GridFieldOrderableRows());
		}
		$fields->addFieldToTab('Root.Categories', GridField::create('Categories', _t('FaqCategory.PLURAL_NAME', 'Categories'), $this->Categories(), $categoriesConfig));

		return $fields;
	}

}
