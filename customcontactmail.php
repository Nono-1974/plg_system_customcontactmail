<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Log\Log;

class PlgSystemCustomContactMail extends CMSPlugin
{
    public function onAfterRoute()
    {
        Log::addLogger(
            ['text_file' => 'plg_system_customcontactmail.log.php'],
            Log::ALL,
            ['plg_system_customcontactmail']
        );
        
        $app = Factory::getApplication();

        if ($app->isClient('site'))
        {
            $input = $app->input;
            $option = $input->getCmd('option');
            $task = $input->getCmd('task');

            // Lors de la soumission du formulaire contact
            if ($option === 'com_contact' && ($task === 'contact.submit' || $task === 'contact_form.submit'))
            {
                $phone = $input->getString('contact_telephone', '');
                if ($phone)
                {
                    $app->setUserState('com_contact.phone', $phone);
                }
                else
                    Log::add('Telpehone non trouvé:'.$input->getString('contact_name', '');, Log::INFO, 'plg_system_customcontactmail');
            }
        }
    }

    public function onContentSendMail($context, $data)
    {
        if ($context === 'com_contact.contact')
        {
            $app = Factory::getApplication();
            $phone = $app->getUserState('com_contact.phone', '');

             Log::add('Ajout du telephone au mail:'.$phone, Log::INFO, 'plg_system_customcontactmail');

            if ($phone)
            {
                // Ajouter le téléphone au corps du mail
                if (isset($data->body))
                {
                    $data->body .= "\nTéléphone : " . $phone;
                }
                else
                {
                    $data->body = "Téléphone : " . $phone;
                }

                Log::add('Envoie du mail:'.json_encode($data), Log::INFO, 'plg_system_customcontactmail');
            }
        }
    }
}
