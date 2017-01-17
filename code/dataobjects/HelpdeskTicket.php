<?php

class HelpdeskTicket extends DataObject
{

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

	public function sendCreatedMail()
	{
		$email = new Email();
		$email->setFrom($this->Page()->AdminMember->Email);
		$email->setTo($this->Page()->AdminMember->Email);
		$email->setSubject(_t('HelpdeskTicket.NEW_TICKET_EMAIL_SUBJECT', 'New ticket'));
		$email->setTemplate('NewTicketEmail');
		$email->populateTemplate(new ArrayData(array(
			'Ticket' => $this
		)));
		$email->send();
	}

	public function sendNewCommentMail($comment)
	{
		if($comment->MemberID == $this->Page()->AdminMemberID){
			$toMail = $this->Member()->Email;
		}else{
			$toMail = $this->Page()->AdminMember()->Email;
		}
		$email = new Email();
		$email->setFrom($this->Page()->AdminMember()->Email);
		$email->setTo($toMail);
		$email->setSubject(_t('HelpdeskTicket.NEW_COMMENT_EMAIL_SUBJECT', 'New ticket'));
		$email->setTemplate('NewTicketCommentEmail');
		$email->populateTemplate(new ArrayData(array(
			'Ticket' => $this,
			'Comment' => $comment
		)));
		$email->send();
	}
}