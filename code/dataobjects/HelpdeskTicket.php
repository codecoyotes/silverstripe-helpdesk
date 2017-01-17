<?php

class HelpdeskTicket extends DataObject {

	private static $singular_name = 'Helpdesk ticket';
	private static $plural_name = 'Helpdesk tickets';

	private static $db = array(
		'Status' => "Enum('Open,Closed','Open')",
		'Title' => 'Varchar(155)',
		'Message' => 'Text'
	);

	private static $has_one = array(
		'Member' => 'Member',
		'Page' => 'HelpdeskPage'
	);

	private static $has_many = array(
		'Comments' => 'HelpdeskTicketComment'
	);

	private static $belongs_many_many = array(
		'Tags' => 'HelpdeskTag'
	);

	private static $summary_fields = array(
		'ID',
		'Created',
		'Status',
		'Title',
		'Member.Name'
	);

	private static $default_sort = 'Status Created';

	public function sendCreatedMail(){
//		$this->Page()->AdminMember();
	}

	public function sendNewCommentMail($comment){
//		$comment->Member();
	}
}