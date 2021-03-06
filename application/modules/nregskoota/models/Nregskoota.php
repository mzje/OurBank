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
class Nregskoota_Model_Nregskoota extends Zend_Db_Table
{
    protected $_name = 'ourbank_master_village';

 	public function fetchDetails($hierarchy,$gilla_id) {
	switch($hierarchy){
		case '3':
		{   $db = $this->getAdapter();
	     	$sql = "SELECT

	(SELECT COUNT(a.village_id) as familymem FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_villagelist d on ourbank_family.rev_village_id = d.village_id
     WHERE ourbank_family.ration_id = 1 and ourbank_family.Koota_id = $gilla_id) AS norationcard,

	(SELECT COUNT(a.village_id)  as familymem FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_villagelist d on ourbank_family.rev_village_id = d.village_id
     WHERE ourbank_family.ration_id = 2 and ourbank_family.Koota_id = $gilla_id) AS APL,

	(SELECT COUNT(a.village_id)  as familymem FROM ourbank_family

    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_villagelist d on ourbank_family.rev_village_id = d.village_id
     WHERE ourbank_family.ration_id = 3 and ourbank_family.Koota_id = $gilla_id) AS BPL ,

	(SELECT COUNT(a.village_id)  as familymem FROM ourbank_family

    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_villagelist d on ourbank_family.rev_village_id = d.village_id
     WHERE ourbank_family.ration_id = 4 and ourbank_family.Koota_id = $gilla_id) AS AAY,d.name as village,COUNT(rev_village_id),COUNT(Koota_id) as totalfamily,COUNT(nregs_jobno!=NULL) as jobcardno

	FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_villagelist d on ourbank_family.rev_village_id = d.village_id
     WHERE ourbank_family.Koota_id = $gilla_id group by d.id";

     $result = $db->fetchAll($sql);
      return $result;	}break;

	case '4':
		{   $db = $this->getAdapter();
	     	$sql = "SELECT

	(SELECT COUNT(a.village_id) as familymem FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_villagelist d on ourbank_family.rev_village_id = d.village_id
     WHERE ourbank_family.ration_id = 1 and ourbank_family.rev_village_id = $gilla_id) AS norationcard,

	(SELECT COUNT(a.village_id) as familymem FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_villagelist d on ourbank_family.rev_village_id = d.village_id
     WHERE ourbank_family.ration_id = 2 and ourbank_family.rev_village_id = $gilla_id) AS APL,

	(SELECT COUNT(a.village_id) as familymem FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_villagelist d on ourbank_family.rev_village_id = d.village_id
     WHERE ourbank_family.ration_id = 3 and ourbank_family.rev_village_id = $gilla_id) AS BPL ,

	(SELECT COUNT(a.village_id) as familymem FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_villagelist d on ourbank_family.rev_village_id = d.village_id
     WHERE ourbank_family.ration_id = 4 and ourbank_family.rev_village_id = $gilla_id) AS AAY,d.name as village,COUNT(rev_village_id) as totalfamily,COUNT(nregs_jobno!=NULL) as jobcardno

	FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_villagelist d on ourbank_family.rev_village_id = d.village_id
 	WHERE ourbank_family.rev_village_id = $gilla_id limit 0,1 ";

        $result = $db->fetchAll($sql);
        return $result;	}break;

	case '5':
		{	$db = $this->getAdapter();
	     	$sql = "SELECT

	(SELECT COUNT(ration_id) FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_village on ourbank_family.rev_village_id = ourbank_master_village.village_id
    join ourbank_master_gillapanchayath on ourbank_master_gillapanchayath.id = ourbank_master_village.panchayath_id
     WHERE ourbank_family.ration_id = 1 and ourbank_master_gillapanchayath.id = $gilla_id) AS norationcard,

	(SELECT COUNT(ration_id) FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_village on ourbank_family.rev_village_id = ourbank_master_village.village_id
    join ourbank_master_gillapanchayath on ourbank_master_gillapanchayath.id = ourbank_master_village.panchayath_id
     WHERE ourbank_family.ration_id = 2 and ourbank_master_gillapanchayath.id = $gilla_id) AS APL,

	(SELECT COUNT(ration_id) FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_village on ourbank_family.rev_village_id = ourbank_master_village.village_id
    join ourbank_master_gillapanchayath on ourbank_master_gillapanchayath.id = ourbank_master_village.panchayath_id
     WHERE ourbank_family.ration_id = 3 and ourbank_master_gillapanchayath.id = $gilla_id) AS BPL ,

	(SELECT COUNT(ration_id) FROM ourbank_family
    join ourbank_familymember a on ourbank_family.id = a.family_id
    join ourbank_master_village on ourbank_family.rev_village_id = ourbank_master_village.village_id
    join ourbank_master_gillapanchayath on ourbank_master_gillapanchayath.id = ourbank_master_village.panchayath_id
     WHERE ourbank_family.ration_id = 4 and ourbank_master_gillapanchayath.id = $gilla_id) AS AAY, ourbank_master_gillapanchayath.name as village,COUNT(nregs_jobno!=NULL) as jobcardno

	FROM ourbank_family
	join ourbank_familymember a on ourbank_family.id = a.family_id
	join ourbank_master_village on ourbank_family.rev_village_id = ourbank_master_village.village_id
	join ourbank_master_gillapanchayath on ourbank_master_gillapanchayath.id = ourbank_master_village.panchayath_id where ourbank_master_gillapanchayath.id= $gilla_id limit 0,1";

        $result = $db->fetchAll($sql);
        return $result;  }
		}
	}
	public function subofficeFromUrl($hierarchy) {
	   switch($hierarchy){
		case '3':{
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT id,name  FROM ourbank_office WHERE officetype_id = $hierarchy";
        $result = $this->db->fetchAll($sql,array($hierarchy));
        return $result;   	}break;

		case '4':{
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT id,name  FROM ourbank_office WHERE officetype_id = $hierarchy";
        $result = $this->db->fetchAll($sql,array($hierarchy));
        return $result; 	}break;

		case '5':{
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = "SELECT id,name  FROM ourbank_master_gillapanchayath";
        $result = $this->db->fetchAll($sql,array($hierarchy));
        return $result;}break;
		}
	}
}

