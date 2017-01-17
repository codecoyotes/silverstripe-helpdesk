<?php

class HelpdeskTag extends DataObject {

	private static $singular_name = 'Tag';
	private static $plural_name = 'Tags';

	private static $db = array(
		'Value' => 'Varchar'
	);

	private static $many_many = array(
		'FaqItems' => 'FaqItem',
		'HelpdeskTickets' => 'HelpdeskTicket'
	);

	private static $summary_fields = array(
		'ID',
		'Created',
		'Value'
	);

}