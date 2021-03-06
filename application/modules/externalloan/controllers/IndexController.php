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
class Externalloan_IndexController extends Zend_Controller_Action
{
    public function init() 
    {
        $this->view->pageTitle = $this->view->translate('Externalloan');
        $this->view->title = 'Accounting';
        $this->view->adm = new App_Model_Adm ();
        $this->view->dbobj = new Externalloan_Model_Dec();
    }

    public function indexAction() 
    {

        $declarationform = new Externalloan_Form_Account();
        $this->view->form = $declarationform;
        $this->view->membercode = $memcode = $this->_request->getParam('membercode');
        //submit action
        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
                $formData = $this->_request->getPost();
                if ($declarationform->isValid($formData)) 
                {

                    $module=$this->view->dbobj->getmodule('Group'); //print_r($module);
                    $this->view->moduleid = $moduleid=$module[0]['module_id'];
                    $this->view->dbobj->groupDeatils($memcode,$moduleid);
                    $this->view->groupresult=$results =  $this->view->dbobj->groupDeatils($memcode,$moduleid);
                    if ($this->view->groupresult)
                    {
                        $this->view->groupmember=$membername =  $this->view->dbobj->getmember($memcode);
                        $this->view->represent=$repname =  $this->view->dbobj->represent($memcode);
                        $this->view->loans=$loans =  $this->view->dbobj->getgrouploans($memcode);
                    }
                    else
                    {
                        $this->view->error = "Record Not Found ... ";
                    }
                }

        }
    }
    public function reportdisplayAction() 
    {
        $app = $this->view->baseUrl();
        $word=explode('/',$app);
        $projname = $word[1];
        $this->_helper->layout->disableLayout();
        $file1 = $this->_request->getParam('file'); 
        $this->view->filename = "/".$projname."/reports/".$file1;
    }
        function pdfdisplayAction()
    {	

            $declarationform = new Externalloan_Model_Dec();
            $this->view->form = $declarationform;
                $postdata=$this->_request->getpost(); //echo '<pre>'; print_r($postdata);
            $this->view->membercode = $memcode = $postdata['membercode']; //echo $this->view->membercode.'<br>';
            $this->view->moduleid = $moduleid = $postdata['module_id'];;
        $this->view->groupresult=$results =  $this->view->dbobj->groupDeatils($memcode,$moduleid);

        $this->view->groupmember=$membername =  $this->view->dbobj->getmember($memcode);
        $this->view->represent=$repname =  $this->view->dbobj->represent($memcode);
         $this->view->loans=$loans =  $this->view->dbobj->getgrouploans($memcode);
            $app = $this->view->baseUrl();
            $word=explode('/',$app);
            $projname = $word[1];

            $pdf = new Zend_Pdf();
            $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $page;
            // Image
            $image_name = "/var/www/".$projname."/public/images/logo.jpg";
            $image = Zend_Pdf_Image::imageWithPath($image_name);
            //$page->drawImage($image, 25, 770, 570, 820);
                $page->drawImage($image, 30, 770, 130, 820);
            $page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
            $page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
            $page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
            $page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizonta

            // define font resource
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
            // Image
            $image_name = "/var/www/".$projname."/public/images/logo.jpg";
            $image = Zend_Pdf_Image::imageWithPath($image_name);
                $x1=72;         $x2=410;
                $y1=670;        //$y2=;
            $memcode = $this->_request->getParam('membercode');
            $moduleid = $this->_request->getParam('module_id');
//             echo '<pre>'; print_r($this->view->groupresult);
            $dateconvert= new App_Model_dateConvertor();
            foreach($this->view->groupresult as $result) { 
            foreach($this->view->represent as $name) {
            foreach($this->view->groupmember as $memberview){
                // write text to page
                $page->setFont($font, 10)
                ->drawText('( EXTERNAL LOAN REQUEST )', 237, 720);

                $page->setFont($font, 9)
                    ->drawText('Group name :'.$result['name'].'',$x1, $y1);

                $page->setFont($font, 9)
                    ->drawText('Date :'.date('d-m-Y').'',$x2, $y1);
                    $y1=$y1-15;
                $page->setFont($font, 9)
                    ->drawText('Group Address :'.$result['address1'].'',$x1, $y1);

                $page->setFont($font, 9)
                    ->drawText('Group code :'.$result['groupcode'].'',$x2, $y1);

                    $y1=$y1-15;
                $page->setFont($font, 9)
                    ->drawText(''.$result['city'].'',137, $y1);

                $page->setFont($font, 9)
                    ->drawText('Savings A/c :'.$result['account_number'].'',$x2, $y1);

				$y1=$y1-15;
                $page->setFont($font, 9)
                    ->drawText(''.$result['state'].'',137, $y1);

            foreach($this->view->loans as $loan) {
                $page->setFont($font, 9)
                    ->drawText('Loan A/c :'.$loan['loanaccount'].'',$x2, $y1);  
                }
// // 				$y1=$y1-15;
// //                 $page->setFont($font, 9)
// //                     ->drawText('Communication:phone/mobile :'.$loan['mobile'].'',$x1, $y1);
                 $y1=$y1-10;
                     $page->setLineWidth(1)->drawLine(50, $y1, 550, $y1);
                 $y1=$y1-25;
                $page->setFont($font, 9)
                    ->drawText('1...'.$result['purpose'].'...(PURPOSE)sfjhkjh kjhjhjdhfjn dhfjkasdhfjh..'.$result['bankname'].'..(BANK)afd/saa/sdb', $x1, $y1);
                $y1=$y1-15;

                $page->setFont($font, 9)
                    ->drawText('..'.$result['branchname'].'..(Branch name) asdbnhhjh saoinm (LOAN AMOUNT)..'.$result['amount'].'...ajjnsabvcui uwepiyqwne bodaftutguy nhgqwe.',$x1,$y1);
                $y1=$y1-20;

                $page->setFont($font, 9)
                    ->drawText('2. aujhhjuoer uiuhjn jhsfduio  uyhuasmuiohjos iuiowsmhns8u ujmnasusm sjuhm,asdfiu ',$x1,$y1);
                $y1=$y1-15;
                $page->setFont($font, 9)
                    ->drawText('1) '.$name['memnames'].'',150, $y1);

                $y1=$y1-25;
                $page->setFont($font, 9)
                    ->drawText('aujhhjuoer uiuhjn jhsfduio  uyhuasmuiohjos iuiowsmhns8u ujmnasusm sjuhm,asdfiu ',$x1,$y1);

                $y1=$y1-15;
                $page->setLineWidth(1)->drawLine(50, $y1, 550, $y1);
                $y1=$y1-15;

                $page->setFont($font, 9)
                    ->drawText('S.No',80,$y1);

                $page->setFont($font, 9)
                    ->drawText('Member Name',150,$y1);

                $page->setFont($font, 9)
                    ->drawText('Purpose',270,$y1);

                $page->setFont($font, 9)
                    ->drawText('Loan request',360,$y1);

                $page->setFont($font, 9)
                    ->drawText('Signature',450,$y1);

				$y1=$y1-10;
                $page->setLineWidth(1)->drawLine(50, $y1, 550, $y1);

				$y1=$y1-15;
				$page->setFont($font, 9)
                    ->drawText(''.$memberview['memname'].'',150,$y1);


				$page->setFont($font, 9)
                    ->drawText(''.$memberview['purposename'].'',260,$y1);

				$page->setFont($font, 9)
                    ->drawText(''.$memberview['Amount'].'',365,$y1);

                $y1=$y1-10;
                $page->setLineWidth(1)->drawLine(50, $y1, 550, $y1);
				$y1=$y1-50;

                $pdf->pages[] = $page;

            $pdfData = $pdf->render();
            $pdfData = $pdf->render();
            $pdf->save('/var/www/'.$projname.'/reports/externalloan.pdf');
            $path = '/var/www/'.$projname.'/reports/externalloan.pdf';
            chmod($path,0777);
             }         
            }
          } } 
}
