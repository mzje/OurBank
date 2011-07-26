<?php
/**Loan Disbursement Module
This Class will
-Create an disbursement form having 3 fields namely date description n disbursed amount
*/
class Transaction_Form_close extends Zend_Form
    {
		public function __construct($options = null)
		{
			parent::__construct($options);
            $accountCode= new Zend_Form_Element_Hidden('accountcode');
            $memberId = new Zend_Form_Element_Hidden('membercode');
			$categoryId = new Zend_Form_Element_Hidden('categoryId');


			$description = new Zend_Form_Element_Textarea('description');
			$description->setAttrib('rows', '2');
			$description->setAttrib('cols', '20');
			$description->setRequired(true);

			$totalamount = new Zend_Form_Element_Text('totalamount');
			$totalamount->setAttrib('class', 'textfield');
			$totalamount->setAttrib('id', 'totalamount');
			$totalamount->setAttrib('readonly', 'true');


			$paymenttype = new Zend_Form_Element_Select('paymenttype');
			$paymenttype->addMultiOption('','select');
			$paymenttype->setAttrib('class','NormalBtn');
			$paymenttype->setAttrib('id', 'paymenttype');
			$paymenttype->setAttrib('onchange','toggleField();');
			$paymenttype->setRequired(true);


			$no = new Zend_Form_Element_Textarea('paymenttype_details');
			$no->setAttrib('class', 'textfield');
 			$no->setAttrib('rows','1');
			$no->setAttrib('cols','20');
			$no->setAttrib('id', 'paymenttype_details');
			$no->setAttrib('style','display:none;');
			$no->setRequired(true);

			$paymenttype1 = new Zend_Form_Element_Hidden('paymenttype1');
			$paymenttype_details1 = new Zend_Form_Element_Hidden('paymenttype_details1');
			$totalamount1 = new Zend_Form_Element_Hidden('totalamount1');
			$description1 = new Zend_Form_Element_Hidden('description1');

            $confirm = new Zend_Form_Element_Submit('confirm');
            $confirm->setAttrib('class', 'officesubmit');

            $submit = new Zend_Form_Element_Submit('Submit');
            $submit->setAttrib('class', 'officesubmit');
            $this->addElements( array ($submit,$description,$accountCode,$memberId,$categoryId,$totalamount,$paymenttype,$no,$confirm,$paymenttype1,$paymenttype_details1,$totalamount1,$description1));
        }
    }
