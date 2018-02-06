<?php
/*2014-01-10JH*/
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
* CustomAPI class to register REST api functions
*
* This class has various functions to help perform methods quickly
* through REST API like validating the license key.
*
*/
require_once('custom/include/rt_GSync/RTGSyncHelper.php');
require_once("custom/include/rt_GSync/apiCalls/rt_GSyncApiCalls.php");

class rt_GSyncCustomApi extends SugarApi
{
    use RTGSyncHelper;
    /**
    * @codeCoverageIgnore
    * Register functions with the REST API
    *
    * @param  
    * @return 
    * @access public
    */
    public function registerApiRest()
    {
        return array(
            'rt_GSyncValidateLicense' => array(
                'reqType' => 'GET',
                'path' => array('rt_GSyncLicense', 'validate', '?'),
                'pathVars' => array('', '', 'key'),
                'method' => 'validate',
                'shortHelp' => 'This method validates SugarOutfitter key',
                'longHelp' => '',
            ),
            'rt_GSyncIncreaseLicense' => array(
                'reqType' => 'GET',
                'path' => array('rt_GSyncLicense', 'change', '?'),
                'pathVars' => array('', '', 'key'),
                'method' => 'change',
                'shortHelp' => 'This method boost user count for RT GSync',
                'longHelp' => '',
            ),
            'rt_GSyncGetUserConfig' => array(
                'reqType' => 'GET',
                'path' => array('rt_GSyncConfig', 'prefs'),
                'pathVars' => array('', ''),
                'method' => 'userConfig',
                'shortHelp' => 'This method is used for user configuration options',
                'longHelp' => '',
            ),
            'getSugarVersion' => array(
                'reqType' => 'GET',
                'path' => array('sugar_version',),
                'pathVars' => array('',),
                'method' => 'getSugarVersion',
                'shortHelp' => 'This method returns sugar_version from config',
                'longHelp' => '',
            ),
        );
    }

    /**
    * get sugarcrm version from config
    *
    *
    * @param  object $api  API  
    * @param  array  $args key provided by the user
    * @return string   $sugar_version
    * @access public
    */
    public function getSugarVersion($api, $args)
    {
        $sugar_version = $this->getSugarConfig()->get('sugar_version');
        return $sugar_version;
    }

    /**
    * Validates license key
    *
    *
    * Takes key as argument and calls validate method of OutfittersLicense
    * @param  object $api                           API  
    * @param  array  $args                          key provided by the user
    * @return bool   OutfittersLicense::validate()  Returned value from outfitters' validate method
    * @access public
    */
    public function validate($api, $args)
    {
        if (isset($args) && isset($args['key'])) {
            $_REQUEST['key'] = $args['key'];
        }
        require_once('custom/include/rt_GSync/license/OutfittersLicense.php');
        return OutfittersLicense::validate();
    }
    /**
    * Boost User count
    *
    *
    * @param  object $api                         API  
    * @param  array  $args                        key provided by the user + User count provided
    * @return bool   OutfittersLicense::change()  Returned value from outfitters' change method
    * @access public
    */
    public function change($api, $args)
    {
        if (isset($args) && isset($args['key'])) {
            $_REQUEST['key'] = $args['key'];
        }
        if (isset($args) && isset($args['user_count'])) {
            $_REQUEST['user_count'] = $args['user_count'];
        }
        require_once('custom/include/rt_GSync/license/OutfittersLicense.php');
        return OutfittersLicense::change();
    }
    /**
    * getters, setters for gsync users, gsync schedulars
    *
    *
    * First case gets state of schedulars as either active or inactive
    * Second case sets state of schedulars as either active or inactive
    * Third case gets all the gsync enabled users
    * Forth case registers new users
    * @param  object $api                         API  
    * @param  array  $args              Method to call
    * @return bool   $response          response from the function calls
    * @access public
    */
    public function userConfig($api, $args)
    {
        $response = array();
        $rt_GSyncApiCalls = $this->getRt_GSyncApiCalls();
        if (!empty($args['method']) && method_exists($rt_GSyncApiCalls, $args['method'])) {
            switch ($args['method']) {
                case 'getPreferences':
                    $response = $rt_GSyncApiCalls->getPreferences($args);
                    break;
                case 'setPreferences':
                    $response = $rt_GSyncApiCalls->setPreferences($args);
                    break;
                case 'getUserConfig':
                    $response = $rt_GSyncApiCalls->getUserConfig($args);
                    break;
                case 'setUserConfig':
                    $response = $rt_GSyncApiCalls->setUserConfig($args);
                    break;
                default:
                    break;
            }
        }
        return $response;
    }

    /**
    * @codeCoverageIgnore
    * @return rt_GSyncApiCalls object
    */
    protected function getRt_GSyncApiCalls()
    {
        return new rt_GSyncApiCalls();
    }
}
