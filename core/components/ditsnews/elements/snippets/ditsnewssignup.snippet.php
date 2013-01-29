<?php
require_once MODX_CORE_PATH.'/components/ditsnews/model/ditsnews/ditsnews.class.php';
$ditsnews = new Ditsnews($modx);

if( $ditsnews->signup($hook->getValues(), $scriptProperties['confirmPage']) ) {
  return true;
}
else {
  $hook->addError('signup',$ditsnews->errormsg);
  return false;
}
