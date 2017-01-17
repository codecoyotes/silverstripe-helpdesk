<?php

class HelpdeskPage extends Page
{

	private static $singular_name = 'Helpdesk page';
	private static $plural_name = 'Helpdesk pages';
	private static $description = 'Page with helpdesk tickets';

	private static $has_one = array(
		'AdminMember' => 'Member'
	);

	private static $has_many = array(
		'Tickets' => 'HelpdeskTicket'
	);

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

	public function viewticket()
	{
		$ticketID = $this->getRequest()->param('TicketID');
		$ticket = HelpdeskTicket::get()->byID($ticketID);
		if (!$ticket) {
			return $this->httpError(404);
		}
		return $this->customise(array(
			'Ticket' => $ticket
		));
	}

	public function createticket()
	{
		return $this;
	}

	public function CreateTicketForm()
	{
		return new HelpdeskCreateTicketForm($this, 'CreateTicketForm');
	}

	public function CommentTicketForm()
	{
		return new HelpdeskCommentTicketForm($this, 'CommentTicketForm');
	}

}