<?php
define('CONF_FILE', dirname(dirname(__FILE__)).'/'.'opauth.conf.php');
define('OPAUTH_LIB_DIR', dirname(__FILE__).'/lib/Opauth/');

/**
* Load config
*/
if (!file_exists(CONF_FILE)) {
  trigger_error('Config file missing at '.CONF_FILE, E_USER_ERROR);
  exit();
}
require CONF_FILE;

/**
 * Instantiate Opauth with the loaded config
 */
require OPAUTH_LIB_DIR.'Opauth.php';

// var_dump($config);
$Opauth = new Opauth( $config );

