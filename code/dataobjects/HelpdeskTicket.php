<?php

class HelpdeskTicket extends DataObject {

	private static $singular_name = 'Helpdesk ticket';
	private static $plural_name = 'Helpdesk tickets';

	private static $db = array(

	);

	private static $summary_fields = array(
		'ID',
		'Created'
	);

}