<?php
namespace CodeCoyotes\Helpdesk;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\DataObject;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class FaqCategory extends DataObject
{

	private static $singular_name = 'FAQ category';
    private static $plural_name = 'FAQ categories';
    private static $table_name = 'Faq Category';

	private static $db = array(
		'Title' => 'Varchar',
		'Sort' => 'Int'
	);

	private static $has_one = array(
		'Page' => FaqPage::class
	);

	private static $has_many = array(
		'Items' => FaqItem::class
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
		$fields->removeByName('PageID');
		$fields->removeByName('Items');

		if ($this->exists()) {
			$itemsConfig = GridFieldConfig_RecordEditor::create();
			if (class_exists(GridFieldOrderableRows::class)) {
				$itemsConfig->addComponent(new GridFieldOrderableRows());
			}
			$fields->addFieldToTab('Root.Main', GridField::create('Items', _t('FaqItem.PLURAL_NAME', 'Faq items'), $this->Items(), $itemsConfig));
		}

		return $fields;
	}

}
