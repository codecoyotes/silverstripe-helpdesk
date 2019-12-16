<?php
namespace CodeCoyotes\Helpdesk;

use SilverStripe\ORM\DataObject;

class HelpdeskTag extends DataObject {

	private static $singular_name = 'Tag';
    private static $plural_name = 'Tags';
    private static $table_name = 'Tag';

	private static $db = array(
		'Value' => 'Varchar'
	);

	private static $many_many = array(
		'FaqItems' => FaqItem::class,
		'HelpdeskTickets' => HelpdeskTicket::class
	);

	private static $summary_fields = array(
		'ID',
		'Created',
		'Value'
	);

}
