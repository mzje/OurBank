<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/
?>

<?php


class Reports_Model_Generalledger extends Zend_Db_Table
{
protected $_name = 'ourbank_transaction';



	
public function fetchAllProductNames() {
			$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('p' => 'ourbank_productdetails'),array('product_id'))
			->where('p.recordstatus_id = 3 or p.recordstatus_id = 1');
			$result = $this->fetchAll($select);
			return $result->toArray();
}
public function fetchledgerDetails($fromDate,$toDate) {

			$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_product'),array('product_id'))
			->join(array('b'=>'ourbank_productdetails'),'a.product_id = b.product_id')
			->where('b.recordstatus_id=3 OR b.recordstatus_id=1')
			->join(array('c'=>'ourbank_productsofferdetails'),'c.product_id = b.product_id')
			->where('c.recordstatus_id=3')
			->join(array('d'=>'ourbank_accounts'),'c.offerproduct_id = d.product_id')
			->where('c.recordstatus_id=3')
->join(array('e'=>'ourbank_transaction'),'d.account_id = e.account_id',array('SUM(e.amount_to_bank) as amount_to_bank','SUM(e.amount_from_bank) as amount_from_bank'))
->where('e.recordstatus_id=3')
->where('e.transaction_date >= "'.$fromDate.'"  AND e.transaction_date <= "'.$toDate.'"')
->group('b.productname')
->join(array('f'=>'ourbank_bankcapitalaccount'),'f.From_account_number = e.account_id',array('SUM(f.amount_to_bank) as capitaltobank','SUM(f.amount_from_bank) as capitalfrombank'));

//die($select->__toString());
return $this->fetchAll($select);
}
public function fetchproductDetails($product) {

$select = $this->select()
->setIntegrityCheck(false)  
->join(array('a' => 'ourbank_product'),array('product_id'))
->join(array('b'=>'ourbank_productdetails'),'a.product_id = b.product_id')
->where('b.recordstatus_id=3 OR b.recordstatus_id=1')
->join(array('c'=>'ourbank_productsofferdetails'),'c.product_id = b.product_id')
->where('c.product_id like "%" ? "%"',$product)
->where('c.recordstatus_id=3')
->join(array('d'=>'ourbank_accounts'),'c.offerproduct_id = d.product_id')
->where('c.recordstatus_id=3')
->join(array('e'=>'ourbank_transaction'),'d.account_id = e.account_id',array('SUM(e.amount_to_bank) as amount_to_bank','SUM(e.amount_from_bank) as amount_from_bank'))
->where('e.recordstatus_id=3')
->group('b.productname')
->join(array('f'=>'ourbank_bankcapitalaccount'),'f.From_account_number = e.account_id',array('SUM(f.amount_to_bank) as capitaltobank','SUM(f.amount_from_bank) as capitalfrombank'));

//die($select->__toString());
return $this->fetchAll($select);
}
public function fetchallDetails($product,$fromDate,$toDate) {

$select = $this->select()
->setIntegrityCheck(false)  
->join(array('a' => 'ourbank_product'),array('product_id'))
->join(array('b'=>'ourbank_productdetails'),'a.product_id = b.product_id')
->where('b.recordstatus_id=3 OR b.recordstatus_id=1')
->join(array('c'=>'ourbank_productsofferdetails'),'c.product_id = b.product_id')
->where('c.product_id like "%" ? "%"',$product)
->where('c.recordstatus_id=3')
->join(array('d'=>'ourbank_accounts'),'c.offerproduct_id = d.product_id')
->where('c.recordstatus_id=3')
->join(array('e'=>'ourbank_transaction'),'d.account_id = e.account_id',array('SUM(e.amount_to_bank) as amount_to_bank','SUM(e.amount_from_bank) as amount_from_bank'))
->where('e.recordstatus_id=3')
->where('e.transaction_date >= "'.$fromDate.'"  AND e.transaction_date <= "'.$toDate.'"')

->group('b.productname')
->join(array('f'=>'ourbank_bankcapitalaccount'),'f.From_account_number = e.account_id',array('SUM(f.amount_to_bank) as capitaltobank','SUM(f.amount_from_bank) as capitalfrombank'));

//die($select->__toString());
return $this->fetchAll($select);
}
public function fetchemptyDetails() {

$select = $this->select()
->setIntegrityCheck(false)  
->join(array('a' => 'ourbank_product'),array('product_id'))
->join(array('b'=>'ourbank_productdetails'),'a.product_id = b.product_id')
->where('b.recordstatus_id=3 OR b.recordstatus_id=1')
->join(array('c'=>'ourbank_productsofferdetails'),'c.product_id = b.product_id')
->where('c.recordstatus_id=3')
->join(array('d'=>'ourbank_accounts'),'c.offerproduct_id = d.product_id')
->where('c.recordstatus_id=3')
->join(array('e'=>'ourbank_transaction'),'d.account_id = e.account_id',array('SUM(e.amount_to_bank) as amount_to_bank','SUM(e.amount_from_bank) as amount_from_bank'))
->where('e.recordstatus_id=3')

->group('b.productname')
->join(array('f'=>'ourbank_bankcapitalaccount'),'f.From_account_number = e.account_id',array('SUM(f.amount_to_bank) as capitaltobank','SUM(f.amount_from_bank) as capitalfrombank'));



//die($select->__toString());
return $this->fetchAll($select);
}
}