<?php
namespace CodeCoyotes\Helpdesk;
use CodeCoyotes\Helpdesk\HelpdeskCommentTicketForm;
use CodeCoyotes\Helpdesk\HelpdeskCreateTicketForm;
use CodeCoyotes\Helpdesk\HelpdeskTicket;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\Security\Member;

class HelpdeskPageController extends \PageController
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
		$pagination = PaginatedList::create($list, $this->getRequest());
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
		$form = HelpdeskCreateTicketForm::create($this, 'CreateTicketForm');
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
		$form = HelpdeskCommentTicketForm::create($this, 'CommentTicketForm');
		$form->loadDataFrom(array(
			'TicketID' => $ticketID,
			'Email' => Member::currentUser()->Email,
			'Name' => Member::currentUser()->getName()
		));
		return $form;
	}

	public function LoginLink($returnPage){
		return 'Security/login?BackURL=' . $returnPage;
	}

}
