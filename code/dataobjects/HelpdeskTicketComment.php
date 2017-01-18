<?php

class HelpdeskTicketComment extends DataObject {

	private static $singular_name = 'Comment';
	private static $plural_name = 'Comments';

	private static $db = array(
		'Comment' => 'Text'
	);

	private static $has_one = array(
		'Ticket' => 'HelpdeskTicket',
		'Member' => 'Member'
	);

	private static $summary_fields = array(
		'ID',
		'Created',
		'Member.Name'
	);

	private static $default_sort = 'Created ASC';

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('TicketID');
		return $fields;
	}

	public function IsAdminComment(){
		return Permission::checkMember($this->Member(), 'Admin');
	}

}