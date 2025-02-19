<?php

use Adianti\Widget\Form\TCheckButton;
use Adianti\Widget\Wrapper\TDBSelect;

/**
 * SystemPreferenceForm
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class SystemPreferenceForm extends TStandardForm
{
    protected $form; // formulário
    
    /**
     * método construtor
     * Cria a página e o formulário de cadastro
     */
    function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('permission');
        $this->setActiveRecord('SystemPreference');
        
        // cria o formulário
        $this->form = new BootstrapFormBuilder('form_preferences');
        $this->form->setFormTitle(_t('Preferences'));
        
        // cria os campos do formulário
        $smtp_auth   = new TCombo('smtp_auth');
        $smtp_host   = new TEntry('smtp_host');
        $smtp_port   = new TEntry('smtp_port');
        $smtp_user   = new TEntry('smtp_user');
        $smtp_pass   = new TPassword('smtp_pass');
        $mail_from   = new TEntry('mail_from');
        $mail_support= new TEntry('mail_support');
        $term_policy = new THtmlEditor('term_policy');
        $strong_passowrd = new TCheckButton('strong_password');
        $maintenance_enabled = new TCheckButton('maintenance_enabled');
        $maintenance_message = new TText('maintenance_message');
        $maintenance_users = new TDBSelect('maintenance_users', 'permission', 'SystemUsers', 'id', 'name', 'name');
        
        $smtp_host->placeholder = 'ssl://smtp.gmail.com, tls://server.company.com';
        
        $yesno = array();
        $yesno['1'] = _t('Yes');
        $yesno['0'] = _t('No');
        $smtp_auth->addItems($yesno);

        $strong_passowrd->setIndexValue('T');
        $strong_passowrd->setInactiveIndexValue('F');
        $strong_passowrd->setUseSwitch();

        $maintenance_enabled->setIndexValue('T');
        $maintenance_enabled->setInactiveIndexValue('F');
        $maintenance_enabled->setUseSwitch();

        $maintenance_users->enableSearch();
        
        $this->form->appendPage(_t('E-mail settings'));

        $row = $this->form->addFields( [new TLabel(_t('Mail from'), null, null, null, '100%'), $mail_from], [new TLabel(_t('SMTP Auth'), null, null, null, '100%'), $smtp_auth] );
        $row->layout = ['col-sm-6', 'col-sm-6'];

        $row = $this->form->addFields( [new TLabel(_t('SMTP Host'), null, null, null, '100%'), $smtp_host], [new TLabel(_t('SMTP Port'), null, null, null, '100%'), $smtp_port]  );
        $row->layout = ['col-sm-6', 'col-sm-6'];

        $row = $this->form->addFields( [new TLabel(_t('SMTP User'), null, null, null, '100%'), $smtp_user], [new TLabel(_t('SMTP Pass'), null, null, null, '100%'), $smtp_pass] );
        $row->layout = ['col-sm-6', 'col-sm-6'];

        $row = $this->form->addFields( [new TLabel(_t('Support mail'), null, null, null, '100%'), $mail_support] );
        $row->layout = ['col-sm-6'];
        
        $this->form->appendPage(_t('Security settings'));

        $row = $this->form->addFields( [new TLabel(_t('Enable strong password'), null, null, null, '100%'), $strong_passowrd] );
        $row->layout = ['col-sm-6'];

        $row = $this->form->addFields( [new TLabel(_t('Terms of use and privacy policy'), null, null, null, '100%'), $term_policy] );
        $row->layout = ['col-sm-12'];

        $this->form->appendPage(_t('Maintenance'));
        
        $row = $this->form->addFields( [new TLabel(_t('Enable maintenance mode'), null, null, null, '100%'), $maintenance_enabled] );
        $row->layout = ['col-sm-6'];

        $row = $this->form->addFields( [new TLabel(_t('Users who can log into the system'), null, null, null, '100%'), $maintenance_users] );
        $row->layout = ['col-sm-12'];

        $row = $this->form->addFields( [new TLabel(_t('Message when attempting to log in'), null, null, null, '100%'), $maintenance_message] );
        $row->layout = ['col-sm-12'];

        $mail_from->setSize('100%');
        $smtp_auth->setSize('100%');
        $smtp_host->setSize('100%');
        $smtp_port->setSize('100%');
        $smtp_user->setSize('100%');
        $smtp_pass->setSize('100%');
        $mail_support->setSize('100%');
        $term_policy->setSize('100%', 250);
        $maintenance_message->setSize('100%');
        $maintenance_users->setSize('100%');
        
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave'], ['static'=>1]), 'far:save');
        $btn->class = 'btn btn-sm btn-primary';
        
        $container = new TVBox;
        $container->{'style'} = 'width: 100%;';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        parent::add($container);
    }
    
    /**
     * Carrega o formulário de preferências
     */
    function onEdit($param)
    {
        try
        {
            // open a transaction with database
            TTransaction::open($this->database);
            
            $preferences = SystemPreference::getAllPreferences();
            unset($preferences['smtp_pass']);

            if ($preferences)
            {
                $this->form->setData((object) $preferences);
            } 
            
            // close the transaction
            TTransaction::close();
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }
    
    /**
     * method onSave()
     * Executed whenever the user clicks at the save button
     */
    function onSave()
    {
        try
        {
            // open a transaction with database
            TTransaction::open($this->database);
            
            // get the form data
            $data = $this->form->getData();
            $data_array = (array) $data;
            
            $old_term_policy = SystemPreference::find('term_policy');
            
            if (is_null($old_term_policy) || $data_array['term_policy'] !== $old_term_policy->preference)
            {
                SystemUsers::where('accepted_term_policy', '=', 'Y')
                            ->set('accepted_term_policy', 'N')
                            ->set('accepted_term_policy_at', '')
                            ->update();
            }

            if (empty(trim($data_array['smtp_pass'])))
            {
                unset($data_array['smtp_pass']);
            }

            foreach ($data_array as $property => $preference)
            {
                if($preference)
                {
                    if(is_array($preference))
                    {
                        $preference = implode(',', $preference);
                    }

                    $object = new SystemPreference;
                    $object->{'id'}    = $property;
                    $object->{'preference'} = $preference;
                    $object->store();
                }
                else
                {
                    SystemPreference::where('id', '=', $property)->delete();
                }
            }
            
            // fill the form with the active record data
            $this->form->setData($data);
            
            // close the transaction
            TTransaction::close();
            
            // shows the success message
            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
            // reload the listing
        }
        catch (Exception $e) // in case of exception
        {
            // get the form data
            $object = $this->form->getData($this->activeRecord);
            
            // fill the form with the active record data
            $this->form->setData($object);
            
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            
            // undo all pending operations
            TTransaction::rollback();
        }
    }
}
