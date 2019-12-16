<?php
namespace CodeCoyotes\Helpdesk;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;

class HelpdeskCommentTicketForm extends Form {

	public function __construct(Controller $controller, $name)
	{
		$fields = new FieldList(array(
			HiddenField::create('TicketID'),
			EmailField::create('Email')->setReadonly(true)->setDisabled(true),
			TextField::create('Name')->setReadonly(true)->setDisabled(true),
			TextareaField::create('Comment')
		));
		if(Permission::check('ADMIN')){
			$fields->push(CheckboxField::create('CloseTicket'));
		}

		$actions = FieldList::create(array(
			FormAction::create('handle', _t('HelpdeskTicket.ADD_COMMENT', 'Add comment'))
		));

		$validator = RequiredFields::create(array(
			'Comment'
		));

		parent::__construct($controller, $name, $fields, $actions, $validator);
		if($this->hasExtension('FormSpamProtectionExtension')) {
			$this->enableSpamProtection();
		}
	}

	public function handle($data, Form $form){
		$data['MemberID'] = Member::currentUserID();
		$comment = HelpdeskTicketComment::create($data);
		$comment->write();
		$ticket = HelpdeskTicket::get()->byID($data['TicketID']);
		if(array_key_exists('CloseTicket', $data) && Permission::check('ADMIN')){
			$ticket->Status = 'Closed';
			$ticket->write();
		}
		$ticket->sendNewCommentMail($comment);
		$this->sessionMessage('Comment added', 'success');
		return $this->controller->redirectBack();
	}

}
