<?php
class Sbwithdrawal_Form_Search extends Zend_Form 
{
    public function init() 
    {
    	//$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
       	$formfield = new App_Form_Field ();
        $membercode = $formfield->field('Text','membercode','','','mand','',true,'','','','','',0,0);
        $amount = $formfield->field('Text','amount','','','mand','',true,'','','','','',0,0);
        $amount->addValidators(array(array('Digits')));

	$submit = $formfield->field('Submit','Submit','','','','',false,'','','','','',0,0);
        $this->addElements(array($membercode,$amount,$submit));
    }
}