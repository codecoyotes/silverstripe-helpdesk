<?php

class HelpdeskCommentTicketForm extends Form {

	public function __construct(Controller $controller)
	{
		$fields = new FieldList(array(

		));

		$actions = new FieldList(array(

		));

		$validator = new RequiredFields(array(

		));

		parent::__construct($controller, 'HelpdeskCommentTicketForm', $fields, $actions, $validator);
	}

	public function handle($data, Form $form){

	}

}