<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Log\Log;

class PlgSystemCustomContactMail extends CMSPlugin
{
    
	
	public function onValidateContact(&$contact, &$data) {
		    Log::addLogger(
				['text_file' => 'plg_system_customcontactmail.log.php'],
				Log::ALL,
				['plg_system_customcontactmail']
            );
		
	    	Log::add('on Validate Contact', Log::INFO, 'plg_system_customcontactmail');
			
			foreach ($data as $name => $value) {
					Log::add('Liste des champs du formulaire de contact:'.$name."==".$value, Log::INFO, 'plg_system_customcontactmail');
			}
			
			// Récupérer et sécuriser le champ téléphone
            $telephone = $data['contact_telephone'];

            // Ajouter le téléphone à la fin du message
            $data['contact_message'] .= "\n\nTéléphone :".$telephone;
			
			Log::add('Telpehone ajouté au corps du mail:'.$data['contact_message'], Log::INFO, 'plg_system_customcontactmail');
			
	}
}
