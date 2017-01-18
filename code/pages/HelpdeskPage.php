<?php

class HelpdeskPage extends Page
{

	private static $singular_name = 'Helpdesk page';
	private static $plural_name = 'Helpdesk pages';
	private static $description = 'Page with helpdesk tickets';

	private static $db = array(
		'CreatePageContent' => 'HTMLText',
		'NewTicketEmail' => 'Varchar(155)',
		'EmailSender' => 'Varchar(155)'
	);

	private static $has_many = array(
		'Tickets' => 'HelpdeskTicket'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Main', new TextField('NewTicketEmail', _t('HelpdeskPage.db_NewTicketEmail', 'New ticket receiver email')), 'Content');
		$fields->addFieldToTab('Root.Main', new TextField('EmailSender', _t('HelpdeskPage.db_EmailSender', 'Ticket email sender')), 'Content');

		$fields->addFieldToTab('Root.CreatePage', new HtmlEditorField('CreatePageContent'));

		if($this->exists()){
			$ticketsConfig = GridFieldConfig_RecordEditor::create();
			$fields->addFieldToTab('Root.Tickets', new GridField('Tickets', 'Tickets', $this->Tickets(), $ticketsConfig));
		}

		return $fields;
	}

}

class HelpdeskPage_Controller extends Page_Controller
{

	private static $allowed_actions = array(
		'viewticket',
		'createticket',
		'CreateTicketForm',
		'CommentTicketForm'
	);

	private static $url_handlers = array(
		'CreateTicketForm' => 'CreateTicketForm',
		'CommentTicketForm' => 'CommentTicketForm',
		'new' => 'createticket',
		'$TicketID!' => 'viewticket'
	);

	public function CreateTicketLink(){
		return $this->Link('new');
	}

	public function PaginatedTickets(){
		$list = $this->Tickets();
		$pagination = new PaginatedList($list, $this->getRequest());
		$pagination->setPageLength(1);
		return $pagination;
	}

	public function viewticket()
	{
		$ticketID = $this->getRequest()->param('TicketID');
		$ticket = HelpdeskTicket::get()->byID($ticketID);
		if (!$ticket) {
			return $this->httpError(404);
		}
		$this->Title = $ticket->Title;
		return $this->customise(array(
			'Ticket' => $ticket
		));
	}

	public function createticket()
	{
		$this->Title = _t('HelpdeskTicket.SUBMIT_A_NEW_TICKET', 'Submit a new ticket');
		return $this;
	}

	public function CreateTicketForm()
	{
		$form = new HelpdeskCreateTicketForm($this, 'CreateTicketForm');
		$form->loadDataFrom(array(
			'PageID' => $this->ID
		));
		if(Member::currentUserID()){
			$form->loadDataFrom(array(
				'Name' => Member::currentUser()->getName(),
				'Email' => Member::currentUser()->Email
			));
		}
		return $form;
	}

	public function CommentTicketForm()
	{
		if($this->getRequest()->isPOST()){
			$ticketID = $this->getRequest()->postVar('TicketID');
		}else{
			$ticketID = $this->getRequest()->param('TicketID');
		}
		$form = new HelpdeskCommentTicketForm($this, 'CommentTicketForm');
		$form->loadDataFrom(array(
			'TicketID' => $ticketID,
			'Email' => Member::currentUser()->Email,
			'Name' => Member::currentUser()->getName()
		));
		return $form;
	}

	public function LoginLink($returnPage){
		return 'Security/Login?BackURL=' . $returnPage;
	}

}