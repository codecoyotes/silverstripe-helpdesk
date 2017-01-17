<?php

class HelpdeskCommentTicketForm extends Form {

	public function __construct(Controller $controller, $name)
	{
		$fields = new FieldList(array(

		));

		$actions = new FieldList(array(

		));

		$validator = new RequiredFields(array(

		));

		parent::__construct($controller, $name, $fields, $actions, $validator);
		if($this->hasExtension('FormSpamProtectionExtension')) {
			$this->enableSpamProtection();
		}
	}

	public function handle($data, Form $form){

	}

}