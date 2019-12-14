<?php
namespace CodeCoyotes\Helpdesk;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;

class HelpdeskPage extends \Page
{

	private static $singular_name = 'Helpdesk page';
	private static $plural_name = 'Helpdesk pages';
    private static $description = 'Page with helpdesk tickets';
    private static $table_name = 'HelpdeskPage';

	private static $db = array(
		'CreatePageContent' => 'HTMLText',
		'NewTicketEmail' => 'Varchar(155)',
		'EmailSender' => 'Varchar(155)'
	);

	private static $has_many = array(
		'Tickets' => HelpdeskTicket::class
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Main', TextField::create('NewTicketEmail', _t('HelpdeskPage.db_NewTicketEmail', 'New ticket receiver email')), 'Content');
		$fields->addFieldToTab('Root.Main', TextField::create('EmailSender', _t('HelpdeskPage.db_EmailSender', 'Ticket email sender')), 'Content');

		$fields->addFieldToTab('Root.CreatePage', HTMLEditorField::create('CreatePageContent'));

		if($this->exists()){
			$ticketsConfig = GridFieldConfig_RecordEditor::create();
			$fields->addFieldToTab('Root.Tickets', GridField::create('Tickets', 'Tickets', $this->Tickets(), $ticketsConfig));
		}

		return $fields;
	}

}

