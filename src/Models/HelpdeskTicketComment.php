<?php
namespace CodeCoyotes\Helpdesk;

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;

class HelpdeskTicketComment extends DataObject {

	private static $singular_name = 'Comment';
    private static $plural_name = 'Comments';
    private static $table_name = 'HelpdeskTicketComment';

	private static $db = array(
		'Comment' => 'Text'
	);

	private static $has_one = array(
		'Ticket' => HelpdeskTicket::class,
		'Member' => Member::class
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
