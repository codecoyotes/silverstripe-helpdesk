<?php

class HelpdeskPage extends Page {

	private static $singular_name = 'Helpdesk page';
	private static $plural_name = 'Helpdesk pages';
	private static $description = 'Page with helpdesk tickets';

}

class HelpdeskPage_Controller extends Page_Controller {

	public function viewticket(){
		//view form
	}

	public function createticket(){
		//create form
	}

}