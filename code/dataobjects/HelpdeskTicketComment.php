<?php

class HelpdeskTicketComment extends DataObject {

	private static $singular_name = 'Comment';
	private static $plural_name = 'Comments';

	private static $db = array(
		'Comment' => 'Text'
	);

	private static $has_one = array(
		'HelpdeskTicket' => 'HelpdeskTicket',
		'Member' => 'Member'
	);

	private static $summary_fields = array(
		'ID',
		'Created',
		'Member.Name'
	);

}