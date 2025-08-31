<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;

public function onContentAfterSave($context, $table, $isNew)
    {
        // On cible bien la soumission d'un nouveau contact
        if ($context === 'com_contact.contact' && $isNew)
        {
            $input = Factory::getApplication()->input;
            $phone = $input->getString('phone', '');

            // Personnalisation du mail à envoyer
            $mailer = Factory::getMailer();

            // Destinataire (par ex. admin ou contact)
            $recipient = $table->email;
            $mailer->addRecipient($recipient);

            // Sujet
            $mailer->setSubject('Nouveau message de contact avec téléphone');

            // Corps du mail avec le champ téléphone ajouté
            $body = "Nom : " . $table->name . "\n";
            $body .= "Email : " . $table->email . "\n";
            $body .= "Téléphone : " . $phone . "\n";
            $body .= "Message : " . $table->message . "\n";

            $mailer->setBody($body);

            // Envoi du mail
            $mailer->send();
        }
    }
?>
