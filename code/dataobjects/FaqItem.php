<?php

class FaqItem extends DataObject {

	private static $singular_name = 'FAQ item';
	private static $plural_name = 'FAQ items';

	private static $db = array(
		'Question' => 'Varchar(255)',
		'Answer' => 'HTMLText',
		'Sort' => 'Int'
	);

	private static $has_one = array(
		'Category' => 'FaqCategory'
	);

	private static $belongs_many_many = array(
		'Tags' => 'HelpdeskTag'
	);

	private static $summary_fields = array(
		'ID',
		'Created',
		'Question'
	);

	private static $default_sort = 'Sort';

	public function getTitle()
	{
		if($this->Question){
			return $this->Question;
		}
		return parent::getTitle();
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('Sort');
		$fields->removeByName('CategoryID');
		$fields->removeByName('Tags');

		if($this->exists()){
			$tagField = TagField::create('Tags', 'Tags', HelpdeskTag::get(), $this->Tags());
			$tagField->setTitleField('Value');
			$tagField->setShouldLazyLoad(true);
			$tagField->setCanCreate(true);
			$fields->addFieldToTab('Root.Main', $tagField);
		}

		return $fields;
	}

}