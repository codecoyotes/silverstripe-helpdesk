<?php
namespace CodeCoyotes\Helpdesk;

use SilverStripe\Control\Controller;
use SilverStripe\Control\Session;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\PasswordField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Member;

class HelpdeskCreateTicketForm extends Form {

	public function __construct(Controller $controller, $name)
	{
		$isLoggedIn = Member::currentUserID() ? true : false;
		$fields = FieldList::create(array(
			HiddenField::create('PageID'),
			HeaderField::create('TicketHeader', _t('HelpdeskTicket.YOUR_TICKET', 'Your ticket')),
			TextField::create('Title'),
			TextareaField::create('Message')
		));
		if(!$isLoggedIn){
			$fields->unshift(PasswordField::create('Password'));
			$fields->unshift(TextField::create('Surname'));
			$fields->unshift(TextField::create('FirstName'));
			$fields->unshift(EmailField::create('Email'));
			$loginURL = Controller::curr()->LoginLink(Controller::curr()->CreateTicketLink());
			$fields->unshift(LiteralField::create('CreateAccount', _t('HelpdeskTicket.NEED_AN_ACCOUNT_MESSAGE', 'You need an account with us to get support, you can register for one below or you can login <a href="{LoginURL}">here</a>', 'Message displayed when someone is not logged in', array(
				'LoginURL' => $loginURL
			))));
			$fields->unshift(HeaderField::create('CreateAccountHeader', _t('HelpdeskTicket.CREATE_ACCOUNT', 'Create an account')));
		}else{
			$fields->unshift(TextField::create('Name')->setReadonly(true)->setDisabled(true));
			$fields->unshift(EmailField::create('Email')->setReadonly(true)->setDisabled(true));
			$fields->unshift(HeaderField::create('CreateAccountHeader', _t('HelpdeskTicket.LOGGED_IN_AS', 'Logged in as')));
		}

		$actions = FieldList::create(array(
			FormAction::create('handle', _t('HelpdeskTicket.CREATE_TICKET', 'Create ticket'))
		));

		$validator = RequiredFields::create([
			'Title',
			'Message'
        ]);
		if(!$isLoggedIn){
			$validator->addRequiredField('Email');
			$validator->addRequiredField('FirstName');
			$validator->addRequiredField('Surname');
			$validator->addRequiredField('Password');
		}

		parent::__construct($controller, $name, $fields, $actions, $validator);
		if($this->hasExtension('FormSpamProtectionExtension')) {
			$this->enableSpamProtection();
		}
	}

	public function handle($data, Form $form){
		if(!Member::currentUserID()){
			$memberData = array(
				'Email' => $data['Email'],
				'FirstName' => $data['FirstName'],
				'Surname' => $data['Surname'],
				'Password' => $data['Password']
			);
			$exisitingMember = Member::get()->filter('Email', $memberData['Email'])->first();
			if($exisitingMember){
				$this->sessionMessage(_t('HelpdeskTicket.EMAIL_EXISTS_ERROR', 'This email address is already in use'), 'bad');
				Session::set("FormInfo.{$this->FormName()}.data", $data);
				return $this->controller->redirectBack();
			}
			$member = Member::create($memberData);
			$validationResult = $member->validate();
			if(!$validationResult->valid()){
				$this->sessionMessage($validationResult->message(), 'bad');
				Session::set("FormInfo.{$this->FormName()}.data", $data);
				return $this->controller->redirectBack();
			}
			$member->write();
			$member->logIn(true);
		}
		$data['MemberID'] = Member::currentUserID();
		$ticket = new HelpdeskTicket($data);
		$ticket->write();
		$ticket->sendCreatedMail();
		return $this->controller->redirect($ticket->Link());
	}

}
