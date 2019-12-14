<?php
namespace CodeCoyotes\Helpdesk;

use SilverStripe\Control\Director;
use SilverStripe\Control\Email\Email;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\TagField\TagField;
use SilverStripe\View\ArrayData;

class HelpdeskTicket extends DataObject
{

	private static $singular_name = 'Helpdesk ticket';
    private static $plural_name = 'Helpdesk tickets';
    private static $table_name = 'HelpdeskTicket';

	private static $db = array(
		'Status' => "Enum('Open,Closed','Open')",
		'Title' => 'Varchar(155)',
		'Message' => 'Text'
	);

	private static $has_one = array(
		'Member' => Member::class,
		'Page' => HelpdeskPage::class
	);

	private static $has_many = array(
		'Comments' => HelpdeskTicketComment::class
	);

	private static $belongs_many_many = array(
		'Tags' => HelpdeskTag::class
	);

	private static $summary_fields = array(
		'ID',
		'Created',
		'Status',
		'Title',
		'Member.Name'
	);

	private static $default_sort = 'Status, Created DESC';

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('PageID');
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

	public function sendCreatedMail()
	{
		$email = Email::create();
		$email->setFrom($this->Page()->EmailSender);
		$email->setTo($this->Page()->NewTicketEmail);
		$email->setSubject(_t('HelpdeskTicket.NEW_TICKET_EMAIL_SUBJECT', 'New ticket'));
		$email->setHTMLTemplate('CodeCoyotes/Helpdesk/Email/NewTicketEmail');
		$email->setData(ArrayData::create(array(
			'Ticket' => $this
		)));
		$email->send();
	}

	public function sendNewCommentMail($comment)
	{
		$sendEmailToList = array();
		$sendEmailToList[$this->Member()->Email] = $this->Member()->Email;
		foreach($this->Comments() as $singleComment){
			$sendEmailToList[$singleComment->Member()->Email] = $singleComment->Member()->Email;
		}
		unset($sendEmailToList[$comment->Member()->Email]);

		foreach($sendEmailToList as $toMail){
			$email = Email::create();
			$email->setFrom($this->Page()->EmailSender);
			$email->setTo($toMail);
			$email->setSubject(_t('HelpdeskTicket.NEW_COMMENT_EMAIL_SUBJECT', 'New ticket'));
			$email->setHTMLTemplate('CodeCoyotes/Helpdesk/Email/NewTicketCommentEmail');
			$email->setData(ArrayData::create(array(
				'Ticket' => $this,
				'Comment' => $comment
			)));
			$email->send();
		}
	}

	public function Link(){
		return $this->Page()->Link($this->ID);
	}

	public function AbsoluteLink(){
		return Director::absoluteURL($this->Link());
	}

	public function IsOpen(){
		return $this->Status == 'Open';
	}

}
