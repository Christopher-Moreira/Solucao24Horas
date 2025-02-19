<?php

use Adianti\Database\TTransaction;

class SystemPreferenceService
{
    public static function isStrongPasswordEnabled()
    {
        $alreadyOpen = TTransaction::isOpen('permission');
        
        if(!$alreadyOpen){
            TTransaction::open('permission');
        }

        $preferences = SystemPreference::getAllPreferences();
        
        if(!$alreadyOpen){
            TTransaction::close();
        }

        if(!empty($preferences['strong_password']) && $preferences['strong_password'] == 'T')
        {
            return true;
        }
        
        return false;
    }

    public static function verifyMaintenanceEnabled($user)
    {
        $alreadyOpen = TTransaction::isOpen('permission');
        
        if(!$alreadyOpen){
            TTransaction::open('permission');
        }

        $preferences = SystemPreference::getAllPreferences();
        
        if(!$alreadyOpen){
            TTransaction::close();
        }

        if(!empty($preferences['maintenance_enabled']) && $preferences['maintenance_enabled'] == 'T' && $user->login != 'admin')
        {
            if(empty($preferences['maintenance_users']) || !in_array($user->id, explode(',', $preferences['maintenance_users'])) )
            {
                throw new Exception($preferences['maintenance_message']);
            }   
        }
    }
}