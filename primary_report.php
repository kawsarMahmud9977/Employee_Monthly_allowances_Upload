<?







session_start();







ob_start();







require "../support/inc.all.php";







require "../classes/report.class.php";







require_once('../common/class.numbertoword.php');







date_default_timezone_set('Asia/Dhaka');







?>



<!-- MAIN sTYLE PAGE START FROM HERE  -->



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



  <meta http-equiv="content-type" content="text/html; charset=utf-8" />



  <title>



    <?= $report ?>



  </title>



  <link href="../../hrm_mod/css/report.css" type="text/css" rel="stylesheet" />



  <script language="javascript">
    function hide()







    {







      document.getElementById('pr').style.display = 'none';







    }







    function Pager(tableName, itemsPerPage) {







      this.tableName = tableName;







      this.itemsPerPage = itemsPerPage;







      this.currentPage = 1;







      this.pages = 0;







      this.inited = false;







      this.showRecords = function(from, to) {







        var rows = document.getElementById(tableName).rows;















        // i starts from 1 to skip table header row















        for (var i = 1; i < rows.length; i++) {















          if (i < from || i > to) rows[i].style.display = 'none';







          else rows[i].style.display = '';























        }

      }















      this.showPage = function(pageNumber) {















        if (!this.inited) {























          alert("not inited");







          return;















        }















        var oldPageAnchor = document.getElementById('pg' + this.currentPage);















        oldPageAnchor.className = 'pg-normal';























        this.currentPage = pageNumber;







        var newPageAnchor = document.getElementById('pg' + this.currentPage);







        newPageAnchor.className = 'pg-selected';







        var from = (pageNumber - 1) * itemsPerPage + 1;







        var to = from + itemsPerPage - 1;







        this.showRecords(from, to);

      }







      this.prev = function() {







        if (this.currentPage > 1)







          this.showPage(this.currentPage - 1);

      }















      this.next = function() {















        if (this.currentPage < this.pages) {















          this.showPage(this.currentPage + 1);















        }

      }















      this.init = function() {















        var rows = document.getElementById(tableName).rows;







        var records = (rows.length - 1);







        this.pages = Math.ceil(records / itemsPerPage);







        this.inited = true;







      }

      this.showPageNav = function(pagerName, positionId) {























        if (!this.inited) {







          alert("not inited");







          return;







        }

        var element = document.getElementById(positionId);







        var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal">Prev</span>';























        for (var page = 1; page <= this.pages; page++)







          pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span>';







        pagerHtml += '<span onclick="' + pagerName + '.next();" class="pg-normal">Next</span>';







        element.innerHTML = pagerHtml;















      }















    }







    var XMLHttpRequestObject = false;







    if (window.XMLHttpRequest)







      XMLHttpRequestObject = new XMLHttpRequest();







    else if (window.ActiveXObject)







    {















      XMLHttpRequestObject = new







      ActiveXObject("Microsoft.XMLHTTP");















    }







    function getData(dataSource, divID, data)







    {















      if (XMLHttpRequestObject)















      {







        var obj = document.getElementById(divID);







        XMLHttpRequestObject.open("POST", dataSource);







        XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');







        XMLHttpRequestObject.onreadystatechange = function()















        {















          if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)















            obj.innerHTML = XMLHttpRequestObject.responseText;















        }















        XMLHttpRequestObject.send("ledger=" + data);























      }































    }















    function getData2(dataSource, divID, data1, data2)















    {















      if (XMLHttpRequestObject)







      {

        var obj = document.getElementById(divID);















        XMLHttpRequestObject.open("POST", dataSource);







        XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');







        XMLHttpRequestObject.onreadystatechange = function()















        {















          if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)















            obj.innerHTML = XMLHttpRequestObject.responseText;















        }







        XMLHttpRequestObject.send("data=" + data1 + "##" + data2);







      }

    }















    function getflatData3()







    {







      var b = document.getElementById('category_to').value;







      var a = document.getElementById('proj_code_to').value;







      $.ajax({















        url: '../../common/flat_option_new3.php',







        data: "a=" + a + "&b=" + b,















        success: function(data) {







          $('#fid3').html(data);















        }

      });























    }















    function getflatData2()















    {







      var b = document.getElementById('category_from').value;















      var a = document.getElementById('proj_code_from').value;















      $.ajax({







        url: '../../common/flat_option_new2.php',







        data: "a=" + a + "&b=" + b,







        success: function(data) {







          $('#fid2').html(data);















        }















      });















    }
  </script>



</head>



<body>



  <form action="primary_report.php" method="post">



    <div align="center" id="pr">



      <input type="button" value="Print" onclick="hide();window.print();" />



    </div>



    <div class="main">



      <?























      //echo $sql    ***************** Header Surname /// Company Name ****************  ;















      $str  .= '<div class="header">';















      if (isset($_SESSION['company_name']))















        $str  .= '<h2 style="font-size:24px; font-family:bankgothic; transform: uppercase;">AKSID CORPORATION LIMITED</h2>';















      if (isset($report))















        $str  .= '<h2>' . $report . '</h2>';















      if ($_POST['JOB_LOCATION'] != '')















        $str  .= '<h2>' . find_a_field('project', 'PROJECT_DESC', 'PROJECT_ID=' . $_POST['JOB_LOCATION']) . '</h2>';







      if (isset($to_date))







        $str  .= '<h2>' . $fr_date . ' To ' . $to_date . '</h2>';







      $str  .= '</div>';







      if (isset($_SESSION['company_logo']))







        //$str  .= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';







        $str  .= '<div class="center">';







      if (($_POST['area_code'] > 0))







        $str  .= '<p>Area Name: ' . find_a_field('area', 'AREA_NAME', 'AREA_CODE="' . $_POST['area_code'] . '"') . '</p>';







      if (($_POST['zone_code'] > 0))







        $str  .= '<p>Zone Name: ' . find_a_field('zon', 'ZONE_NAME', 'ZONE_CODE="' . $_POST['zone_code'] . '"') . '</p>';







      if (($_POST['region_code'] > 0))







        $str  .= '<p>Region Name: ' . find_a_field('branch', 'BRANCH_NAME', 'BRANCH_ID="' . $_POST['region_code'] . '"') . '</p>';







      if (isset($project_name))







        $str  .= '<p>Project Name: ' . $project_name . '</p>';







      if (isset($allotment_no))















        $str  .= '<p>Allotment No.: ' . $allotment_no . '</p>';















      $str  .= '</div><div class="right">';















      if (isset($client_name))















        $str  .= '<p>Client Name: ' . $client_name . '</p>';















      $strTime  .= '</div><div class="date" style="">Reporting Time: ' . date("h:i A d-m-Y") . '</div>';























      if ($_POST['department'] != '')















        $depts = find_a_field('department', 'DEPT_DESC', 'DEPT_ID=' . $_POST['department']);



































      if (isset($_POST['submit']) && isset($_POST['report']) && $_POST['report'] > 0) {































        if ($_POST['name'] != '')















          $con .= ' and a.PBI_NAME like "%' . $_POST['name'] . '%"';























        if ($_POST['PBI_ORG'] != '')















          $con .= ' and a.PBI_ORG = "' . $_POST['PBI_ORG'] . '"';















        if ($_POST['department'] != '')















          $con .= ' and a.PBI_DEPARTMENT = "' . $_POST['department'] . '"';















        if ($_POST['project'] != '')































          $con .= ' and a.PBI_PROJECT = "' . $_POST['project'] . '"';















        if ($_POST['designation'] != '')















          $con .= ' and a.PBI_DESIGNATION = "' . $_POST['designation'] . '"';































        if ($_POST['zone'] != '')















          $con .= ' and a.PBI_ZONE = "' . $_POST['zone'] . '"';































        if ($_POST['JOB_LOCATION'] != '')















          $con .= ' and a.JOB_LOCATION = "' . $_POST['JOB_LOCATION'] . '"';















        if ($_POST['PBI_GROUP'] != '')































          $con .= ' and a.PBI_GROUP = "' . $_POST['PBI_GROUP'] . '"';































































        if ($_POST['area'] != '')































          $con .= ' and a.PBI_AREA = "' . $_POST['area'] . '"';































        if ($_POST['branch'] != '')































          $con .= ' and a.PBI_BRANCH = "' . $_POST['branch'] . '"';















































        if ($_POST['job_status'] != '')































          $con .= ' and a.PBI_JOB_STATUS = "' . $_POST['job_status'] . '"';































        if ($_POST['gender'] != '')































          $con .= ' and a.PBI_SEX = "' . $_POST['gender'] . '"';































































        if ($_POST['ijdb'] != '')































          $con .= ' and a.PBI_DOJ < "' . $_POST['ijdb'] . '"';































        if ($_POST['ppjdb'] != '')































          $con .= ' and a.PBI_DOJ_PP < "' . $_POST['ppjdb'] . '"';































































        if ($_POST['ijda'] != '')































          $con .= ' and a.PBI_DOJ > "' . $_POST['ijda'] . '"';































        if ($_POST['ppjda'] != '')































          $con .= ' and a.PBI_DOJ_PP > "' . $_POST['ppjda'] . '"';































        if ($_POST['department'] != '')































          $depts = find_a_field('department', 'DEPT_DESC', 'DEPT_ID=' . $_POST['department']);































        if ($_POST['bonus_type'] != '') {







          if ($_POST['bonus_type'] == 2)







            $bonusName = 'Eid-Ul Adha';







          else



            $bonusName = 'Eid-Ul Fitre';
        }
      }











      ?>















      <!-- ****************************************************    Report Start From Here    ******************************************** -->



      <?























      if ($_POST['report'] == 4512) {























        if ($_POST['JOB_LOCATION'] != '')























          $advice_con .= ' and t.job_location ="' . $_POST['JOB_LOCATION'] . '"';















        if ($_POST['department'] != '')























          $advice_con .= ' and t.department ="' . $_POST['department'] . '"';















      ?>



        <table width="100%" cellspacing="0" cellpadding="2" border="0">



          <thead>



            <tr>



              <td style="border:0px;" colspan="11" align="center"><?= $str ?></td>



            </tr>







            <tr>

              <td colspan="11" style="text-align: center;border:0px solid white; font-size:15px;"><strong>Bank Advice </strong></td>

            </tr>



            <tr>



              <td style="border:0px;" colspan="28">

                <div align="center" style="font-size:20px;">Allowances Sheet for the Period of



                  <? $d = strtotime("-1 Months");



                  echo date("M-Y", $d) . ""; ?>



                  To



                  <? $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');

                  echo date_format($test, 'M-Y') . '<br>' . $depts;  ?>



                </div>

              </td>



            </tr>







            <tr>



              <td style="border:0px;" colspan="11" align="center"><?= $strTime ?></td>



            </tr>



            <tr>



              <th>Debit Account</th>



              <th>Voucher/E-mail</th>



              <th>BATCH </th>



              <th>Benificiary. Name</th>



              <th align="center">

                <div align="center">Credit Account/Card</div>

              </th>



              <th>Txn Type</th>



              <th>Bank Name </th>



              <th>Routing No</th>



              <th>

                <div align="center">Pay Amount</div>

              </th>



              <th>Remarks/Narration</th>



            </tr>



          </thead>



          <tbody>



            <?















            $sqld2 = 'select a.PBI_NAME,i.card_no,i.cash,i.cash_bank,t.remarks,







SUM(t.food_bill+t.conveyance+t.site_visit+t.health+t.fule+t.others+t.overtime+t.ifter+t.hotel) as amount















from







monthly_allowances t,







personnel_basic_info a,







salary_info i,







department dept















where







t.bank_or_cash NOT IN ("1","6","7") and



i.PBI_ID = t.PBI_ID and







t.job_status="In Service" and







t.department=dept.DEPT_ID and



t.mon=' . $_POST['mon'] . ' and







t.year=' . $_POST['year'] . ' and







t.PBI_ID=a.PBI_ID ' . $advice_con . '







group by t.PBI_ID order by a.PBI_NAME asc';































            $queryd2 = mysql_query($sqld2);







            ini_set('memory_limit', '-1');







            while ($data2 = mysql_fetch_object($queryd2)) {







              $entry_by = $data2->entry_by;































              if ($data2->amount > 0) {















            ?>



                <tr>



                  <td>

                    <table border="0" cellpadding="0" cellspacing="0" align="center" style="width: 100%; border: 0px solid white;">



                      <tr>



                        <td style="border:0px solid white">&nbsp;&nbsp;&nbsp;1141290217238&nbsp;&nbsp;&nbsp;</td>



                      </tr>



                    </table>

                  </td>



                  <td></td>



                  <td></td>



                  <td nowrap="nowrap"><?= $data2->PBI_NAME ?></td>



                  <?







                  if ($data2->cash || $data2->bank) {



                  ?>



                    <td align="right">&nbsp;&nbsp;&nbsp;



                      <?= ($data2->cash > 0) ? $data2->cash : ''; ?>



                      &nbsp;&nbsp;&nbsp;</td>



                  <? } else { ?>



                    <td align="right">&nbsp;&nbsp;&nbsp;



                      <?= ($data2->card_no > 0) ? $data2->card_no : ''; ?>



                      &nbsp;&nbsp;&nbsp;</td>



                  <? } ?>



                  <? if ($data2->cash > 0) { ?>



                    <td>

                      <div align="center">EBLACT</div>

                    </td>



                  <? } elseif ($data2->card_no > 0) { ?>



                    <td>

                      <div align="center">EBLCDP</div>

                    </td>



                  <? } ?>



                  <td>

                    <div align="center">EBL</div>

                  </td>



                  <td></td>



                  <td>

                    <div align="center">



                      <?= $data2->amount ?>



                    </div>

                  </td>



                  <td>

                    <div align="center">



                      <?= $data2->remarks ?>



                    </div>

                  </td>



                </tr>



















                <? $total += $data2->amount;







                $total_cash2 = $total;  ?>



            <? }
            } ?>



















            <tr>



              <td colspan="8" align="right">Total:</td>



              <td colspan="2"><?= ($total_cash2 > 0) ? number_format($total_cash2, 0) : ''; ?></td>



            </tr>



          </tbody>



        </table>



        In Words:<? echo convertNumberMhafuz($total_cash2); ?> <br>



        <br>



        <br>



        <div style="width:100%; margin:0 auto">



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Prepared By</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Audit</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Accounts</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Managing Director</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Chairman</div>



        </div>



      <?















      }







      ?>











      <!--  BKASH ADVICE REPORT START -->







      <?























      if ($_POST['report'] == 4518) {







        if ($_POST['JOB_LOCATION'] != '')



          $advice_con .= ' and t.job_location ="' . $_POST['JOB_LOCATION'] . '"';



        if ($_POST['department'] != '')



          $advice_con .= ' and t.department ="' . $_POST['department'] . '"';



      ?>







        <table width="100%" cellspacing="0" cellpadding="2" border="0">



          <thead>



            <tr>



              <td style="border:0px;" colspan="11" align="center"><?= $str ?></td>



            </tr>







            <tr>

              <td colspan="11" style="text-align: center;border:0px solid white; font-size:15px;"><strong> </strong></td>

            </tr>



            <tr>



              <td style="border:0px;" colspan="28">

                <div align="center" style="font-size:20px;">Allowances Sheet for the Period of



                  <? $d = strtotime("-1 Months");



                  echo date("M-Y", $d) . ""; ?>



                  To



                  <? $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');

                  echo date_format($test, 'M-Y') . '<br>' . $depts;  ?>



                </div>

              </td>



            </tr>







            <tr>



              <td style="border:0px;" colspan="13" align="center"><?= $strTime ?></td>



            </tr>



            <tr align="center">







              <th>

                <div align="center">ID</div>

              </th>



              <th>

                <div align="center">Name</div>

              </th>



              <th>

                <div align="center">Wallet No</div>

              </th>







              <th>

                <div align="center">Pay Amount</div>

              </th>



              <th>

                <div align="center">Remarks/Narration</div>

              </th>



            </tr>



          </thead>



          <tbody>



            <?















            $sqld2 = 'select a.PBI_CODE,a.PBI_NAME,i.card_no,i.cash,i.cash_bank,t.remarks,SUM(t.food_bill+t.conveyance+t.site_visit+t.health+t.fule+t.others+t.overtime+t.ifter+t.hotel) as amount,t.bkash_no















from







monthly_allowances t,







personnel_basic_info a,







salary_info i,







department dept















where







t.bank_or_cash IN ("6") and



i.PBI_ID = t.PBI_ID and







t.job_status="In Service" and







t.department=dept.DEPT_ID and



t.mon=' . $_POST['mon'] . ' and







t.year=' . $_POST['year'] . ' and







t.PBI_ID=a.PBI_ID ' . $advice_con . ' group by t.PBI_ID







order by a.PBI_NAME asc';















            $queryd2 = mysql_query($sqld2);







            ini_set('memory_limit', '-1');







            while ($data2 = mysql_fetch_object($queryd2)) {







              $entry_by = $data2->entry_by;











              if ($data2->amount > 0) {















            ?>



                <tr>







                  <td>

                    <div align="center"><?= $data2->PBI_CODE ?></div>

                  </td>



                  <td>

                    <div align="center"><?= $data2->PBI_NAME ?></div>

                  </td>















                  <td>

                    <table border="0" cellpadding="0" cellspacing="0" align="center" style="width: 100%; border: 0px solid white;">



















                      <tr>



                        <td style="border:0px solid white; text-align:center">&nbsp;&nbsp;&nbsp;<?= $data2->bkash_no ?>&nbsp;&nbsp;&nbsp;</td>



                      </tr>



                    </table>



                  </td>















                  <td>

                    <div align="right"><?= $data2->amount ?></div>

                  </td>



                  <td>

                    <div align="center"><?= $data2->remarks ?></div>

                  </td>



                </tr>







                <? $total += $data2->amount;







                $total_cash2 = $total;  ?>



            <? }
            } ?>



















            <tr>



              <td colspan="3" align="right">Total:</td>



              <td align="right"><?= ($total_cash2 > 0) ? number_format($total_cash2, 0) : ''; ?></td>



              <td></td>



            </tr>



          </tbody>



        </table>



        In Words:<? echo convertNumberMhafuz($total_cash2); ?> <br>



        <br>



        <br>



        <div style="width:100%; margin:0 auto">



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Prepared By</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Audit</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Accounts</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Managing Director</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Chairman</div>



        </div>



      <?















      }







      ?>



















      <!-- ****************************************************    Report Start From Here    ******************************************** -->



      <?























 if ($_POST['report'] == 4765) {
 if ($_POST['JOB_LOCATION'] != '')
 $advice_con .= ' and t.job_location ="' . $_POST['JOB_LOCATION'] . '"';
 if ($_POST['department'] != '')
 $advice_con .= ' and t.department ="' . $_POST['department'] . '"';



      ?>



        <table width="100%" cellspacing="0" cellpadding="2" border="0">



          <thead>



            <tr>



              <td style="border:0px;" colspan="11" align="center"><?= $str ?></td>



            </tr>







            <tr>

              <td colspan="11" style="text-align: center;border:0px solid white; font-size:15px;"><strong>Bank Advice </strong></td>

            </tr>



            <tr>



              <td style="border:0px;" colspan="28">

                <div align="center" style="font-size:20px;">Staff Incentive Advice Sheet for the Period of







                  <? $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');

                  echo date_format($test, 'M-Y') . '<br>' . $depts;  ?>



                </div>

              </td>



            </tr>







            <tr>



              <td style="border:0px;" colspan="11" align="center"><?= $strTime ?></td>



            </tr>



            <tr>



              <th>Debit Account</th>



              <th>Voucher/E-mail</th>



              <th>BATCH </th>



              <th>Benificiary. Name</th>



              <th align="center">

                <div align="center">Credit Account/Card</div>

              </th>



              <th>Txn Type</th>



              <th>Bank Name </th>



              <th>Routing No</th>



              <th>

                <div align="center">Pay Amount</div>

              </th>



              <th>Remarks/Narration</th>



            </tr>



          </thead>



          <tbody>



            <?















            $sqld2 = 'select a.PBI_NAME,i.card_no,i.cash,i.cash_bank,t.PBI_ID,







SUM(t.jan_com+t.feb_com+t.mar_com+t.apr_com+t.may_com+t.jun_com+t.jul_com+t.aug_com+t.sep_com+t.oct_com+t.nov_com+t.dec_com) as net_convaince,



sum(t.tax_deduction) as tax_deduction,sum(t.advance_deduction) as advance_deduction,sum(t.special_consideration) as special_consideration



from



monthly_sales_commission t,



personnel_basic_info a,



salary_info i,



department dept







where



t.bank_or_cash NOT IN ("1","6","7") and



t.PBI_ID = a.PBI_ID and



t.PBI_ID=i.PBI_ID and



t.job_status="In Service" and







t.department=dept.DEPT_ID and



t.mon=' . $_POST['mon'] . ' and







t.year=' . $_POST['year'] . '















' . $advice_con . '







group by t.PBI_ID order by a.PBI_NAME asc';































            $queryd2 = mysql_query($sqld2);







            ini_set('memory_limit', '-1');







            while ($data2 = mysql_fetch_object($queryd2)) {







              $entry_by = $data2->entry_by;















              $net_deduction = $data2->tax_deduction + $data2->advance_deduction;







              $net_payment = (($data2->net_convaince + $data2->special_consideration) - $net_deduction);







              $total_payment = $total_payment + $net_payment;















              if ($net_payment > 0) {















            ?>



                <tr>



                  <td>

                    <table border="0" cellpadding="0" cellspacing="0" align="center" style="width: 100%; border: 0px solid white;">



                      <tr>



                        <td style="border:0px solid white">&nbsp;&nbsp;&nbsp;1141290217238&nbsp;&nbsp;&nbsp;</td>



                      </tr>



                    </table>

                  </td>



                  <td></td>



                  <td></td>



                  <td nowrap="nowrap"><?= $data2->PBI_NAME ?></td>



                  <?







                  if ($data2->cash || $data2->bank) {



                  ?>



                    <td align="right">&nbsp;&nbsp;&nbsp;



                      <?= ($data2->cash > 0) ? $data2->cash : ''; ?>



                      &nbsp;&nbsp;&nbsp;</td>



                  <? } else { ?>



                    <td align="right">&nbsp;&nbsp;&nbsp;



                      <?= ($data2->card_no > 0) ? $data2->card_no : ''; ?>



                      &nbsp;&nbsp;&nbsp;</td>



                  <? } ?>



                  <? if ($data2->cash > 0) { ?>



                    <td>

                      <div align="center">EBLACT</div>

                    </td>



                  <? } elseif ($data2->card_no > 0) { ?>



                    <td>

                      <div align="center">EBLCDP</div>

                    </td>



                  <? } ?>



                  <td>

                    <div align="center">EBL</div>

                  </td>



                  <td></td>



                  <td>

                    <div align="center">



                      <?= number_format($net_payment); ?>



                    </div>

                  </td>



                  <td>

                    <div align="center">



                      <?= $data2->remarks ?>



                    </div>

                  </td>



                </tr>



















                <?







                $total += $net_payment;



                $total_cash2 = $total;  ?>



            <? }
            } ?>



















            <tr>



              <td colspan="8" align="right">Total:</td>



              <td colspan="2"><? echo $total_cash2; ?></td>



            </tr>



          </tbody>



        </table>



        In Words:<? echo convertNumberMhafuz(number_format($total_cash2)); ?> <br>



        <br>



        <br>



        <div style="width:100%; margin:0 auto">



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Prepared By</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Audit</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Accounts</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Managing Director</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Chairman</div>



        </div>



      <?















      }







      ?>



















      <!-- end commissiion advice -->















      <?



      if ($_POST['report'] == 1) {































        $report = "Employee Basic Information";











        if ($_POST['department'] != '')



          $cons .= ' and t.pbi_department ="' . $_POST['department'] . '"';































      ?>































        <table style="width: auto; margin: 0 auto; font-size: 20px;text-align:center;" border="1" bordercolor="#FFFFFF">































          <tr>































            <td style="border:0px solid white;"><strong>AKSID CORPORATION LTD.</strong></td>































          </tr>































          <tr>































            <td style="border:0px solid white;"><strong>Employee Basic Information</strong></td>































          </tr>































        </table>































        <table style="width:auto;margin:0 auto;" cellpadding="0" cellspacing="0" border="1">































          <thead>































            <tr>































              <td><strong>Sl</strong></td>



















              <td><strong>OLD EMP ID</strong></td>











              <td><strong>EMP ID</strong></td>































              <td><strong>NAME</strong></td>































              <td><strong>DESIGNATION</strong></td>































              <td><strong>DEPARTMENT</strong></td>































              <td><strong>PROJECT</strong></td>































              <td><strong>JOINING DATE</strong></td>































              <td><strong>TOTAL SERVICE LENGTH</strong></td>































              <td><strong>MOBILE</strong></td>































              <td><strong>Email</strong></td>































            </tr>































          </thead>































          <?































          $basic_sql = "select a.PBI_ID,a.PBI_CODE as Emp_ID,a.PBI_NAME as Name,(select DESG_SHORT_NAME from designation where DESG_ID=a.PBI_DESIGNATION) as designation,(select if(DEPT_DESC='NO DEPARTMENT','',DEPT_DESC) from department where DEPT_ID=a.PBI_DEPARTMENT) as department,(select PROJECT_DESC from project where PROJECT_ID=a.JOB_LOCATION) as project_name,a.PBI_GROUP as `Group`, DATE_FORMAT(a.PBI_DOJ,'%d-%b-%Y') as joining_date,a.PBI_DOJ as total_service_length,a.PBI_MOBILE as mobile,a.PBI_EMAIL  from personnel_basic_info a where 1 " . $con . " order by a.PBI_DOJ asc";































          $basic_query = mysql_query($basic_sql);































          $sl = 1;































































          while ($r = mysql_fetch_object($basic_query)) {































          ?>































            <tr>































              <td><?= $sl++; ?></td>























              <td><?= $r->PBI_ID ?></td>







              <td><?= $r->Emp_ID ?></td>































              <td><?= $r->Name ?></td>































              <td><?= $r->designation ?></td>































              <td><?= $r->department ?></td>































              <td><?= $r->project_name ?></td>































              <td><?= $r->joining_date ?></td>































              <td><? $interval = date_diff(date_create(date('Y-m-d')), date_create($r->joining_date));































                  echo $interval->format("%Y Year, %M Months, %d Days");































                  ?></td>































              <td><?= $r->mobile ?></td>















              <td><?= $r->PBI_EMAIL ?></td>































            </tr>































          <?











          }











          ?>































        </table>















        <!-- Salary Summary Sheet -->





      <?

      } elseif ($_POST['report'] == 9999) {



      ?>

        <table style="width:auto;margin: 0 auto; padding:0px;">

          <tr>

            <td style="text-align: center;border:0px solid white; font-family:bankgothic; font-weight:bold; font-size:18px;"><strong>AKSID CORPORATION LIMITED</strong></td>

          </tr>

          <tr>

            <td style="text-align: center;border:0px solid white; font-size:15px;"><strong>Salary Summary Sheet</strong></td>

          </tr>

          <tr>

            <td style="text-align: center;border:0px solid white;"><?







                                                                    $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');

                                                                    $_SESSION['year'] = $_POST['year'];

                                                                    echo date_format($test, 'M-Y');

                                                                    if ($_POST['mon'] == 1) {

                                                                      $last_m = 12;

                                                                      $last_y = $_POST['year'] - 1;
                                                                    } else {

                                                                      $last_m = $_POST['mon'] - 1;

                                                                      $last_y = $_POST['year'];
                                                                    }



                                                                    ?></td>

          </tr>

        </table>





        <table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;" id="ExportTable">

          <input name="mon" value="<?= $_POST['mon'] ?>" type="hidden" />

          <input name="year" value="<?= $_POST['year'] ?>" type="hidden" />

          <tr bordercolor="#FFFFFF">

            <th width="100%" colspan="5" style="text-align:center">Total Salary</th>

          </tr>

          <table width="70%" border="1" id="ExportTable" cellspacing="0" cellpadding="0" style="margin:0 auto;">

            <tr>

              <th width="40%" style="text-align:center">Job Location</th>



              <th width="40%" style="text-align:center">Gross Salary</th>

              <th width="40%" style="text-align:center">Salary Adjustment</th>



              <th width="40%" style="text-align:center">Deduction (Not being part of Cost)</th>



              <th width="15%" style="text-align:center">Cost to the company</th>



              <th width="15%" style="text-align:center">Deduction (Being part of Cost)</th>







              <th width="15%" style="text-align:center">Net Payable Salary</th>



              <!--        <th width="15%" style="text-align:center">Last Month Net Salary</th>

              <th width="15%" style="text-align:center">Difference %</th>-->

            </tr>

            <?



            $found = find_a_field('salary_attendence', 'lock_status', 'mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');

            if ($_POST['mon'] > 8 && $_POST['year'] >= 2018) {

              if ($found == 0) {





                $jl_sql1 = 'select proj.PROJECT_ID,proj.PROJECT_DESC , 

				

	sum(a.total_payable) as total_amt, sum(a.total_earning) as total_earning,

	sum((a.gross_salary+a.adjustment_amount)-(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as total_cost,

	sum(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions) as deduction_not_part_of_cost,

	sum(a.mobile_deduction+a.income_tax+a.food_deduction+a.advance_install) as deduction_being_part_of_cost,

	

	sum(a.gross_salary) as gross_salary, sum(a.adjustment_amount) as adjustment_amount

	

	



    from salary_attendence a,

	personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . ' and b.PBI_JOB_STATUS="In Service" and

	a.remarks_details!="hold" and a.job_location = proj.PROJECT_ID and a.pay>0 GROUP BY proj.PROJECT_ID order by proj.PROJECT_DESC';
              } else {





                $jl_sql1 = 'select proj.PROJECT_ID,proj.PROJECT_DESC , 

		sum(a.total_payable) as total_amt, sum(a.total_earning) as total_earning,

		sum((a.gross_salary+a.adjustment_amount)-(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as total_cost,

		sum((a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as deduction_not_part_of_cost,

		sum(a.mobile_deduction+a.income_tax+a.food_deduction+a.advance_install) as deduction_being_part_of_cost,

		sum(a.gross_salary) as gross_salary, sum(a.adjustment_amount) as adjustment_amount





		from salary_attendence_lock a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and a.mon=' . $_POST['mon'] . ' and

		a.year=' . $_POST['year'] . ' and  a.job_location = proj.PROJECT_ID and a.remarks_details!="hold" and a.pay>0 GROUP BY proj.PROJECT_ID order by proj.PROJECT_DESC';
              }
            } else {





              if ($found == 0) {





                $jl_sql1 = 'select proj.PROJECT_ID,proj.PROJECT_DESC , 

				

	 sum(a.total_payable) as total_amt, sum(a.total_earning) as total_earning,

	 sum((a.gross_salary+a.adjustment_amount)-(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as total_cost,

	 sum((a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as deduction_not_part_of_cost,

	 sum(a.mobile_deduction+a.income_tax+a.food_deduction+a.advance_install) as deduction_being_part_of_cost,

	 sum(a.gross_salary) as gross_salary, sum(a.adjustment_amount) as adjustment_amount

	 





	 from salary_attendence a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . '

	  and a.job_location = proj.PROJECT_ID and a.pay>0 and a.remarks_details!="hold" GROUP BY proj.PROJECT_ID order by proj.PROJECT_DESC';
              } else {





                $jl_sql1 = 'select proj.PROJECT_ID,proj.PROJECT_DESC , sum(a.total_payable) as total_amt,  sum(a.total_earning) as total_earning,

	  sum((a.gross_salary+a.adjustment_amount)-(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as total_cost,

	  sum((a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as deduction_not_part_of_cost,

	  sum(a.mobile_deduction+a.income_tax+a.food_deduction+a.advance_install) as deduction_being_part_of_cost,

	  sum(a.gross_salary) as gross_salary, sum(a.adjustment_amount) as adjustment_amount





		from salary_attendence_lock a, personnel_basic_info b, project proj where a.PBI_ID = b.PBI_ID and mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . ' and

		a.job_location = proj.PROJECT_ID and a.pay>0 and a.remarks_details!="hold" GROUP BY proj.PROJECT_ID order by proj.PROJECT_DESC';
              }
            }





            $jl_query1 = mysql_query($jl_sql1);

            while ($jl1_result1 = mysql_fetch_object($jl_query1)) {

              $last_month_earning_proj = find_a_field('salary_attendence_lock', 'sum(total_earning)', 'mon="' . $last_m . '" and year="' . $last_y . '" and job_location="' . $jl1_result1->PROJECT_ID . '" and pay>0 and remarks_details!="hold"');





              // $sqlll = 'select sum(total_earning) from salary_attendence_lock where mon="'.$last_m.'" and year="'.$last_y.'" and job_location="'.$jl1_result1->PROJECT_ID.'" and pay>0 and remarks_details!="hold"';

              $last_month_earning_proj_total = $last_month_earning_proj_total + $last_month_earning_proj;

              $last_proj_dff = $jl1_result1->total_earning - $last_month_earning_proj;

              $dft = ($last_proj_dff * 100) / $last_month_earning_proj;

            ?>

              <tr style="margin:0px;">





                <td style="margin:0px; width:40%"><?= $jl1_result1->PROJECT_DESC ?>

                  <input type="hidden" name="job_location[]" value="<?= $jl1_result1->PROJECT_DESC ?>" />

                  <input type="hidden" name="tr_type[]" value="all_salary1" />

                </td>





                <td align="right" style="width:15%">

                  <?= (number_format($jl1_result1->gross_salary) > 0) ? number_format($jl1_result1->gross_salary) : '';
                  $all_proj_gross = $all_proj_gross + $jl1_result1->gross_salary; ?>



                </td>





                <td align="right" style="width:15%">

                  <?= (number_format($jl1_result1->adjustment_amount) > 0) ? number_format($jl1_result1->adjustment_amount) : '';

                  $all_proj_adjustment_amount = $all_proj_adjustment_amount + $jl1_result1->adjustment_amount; ?>



                </td>





                <td align="right" style="width:15%">

                  <?= (number_format($jl1_result1->deduction_not_part_of_cost) > 0) ? number_format($jl1_result1->deduction_not_part_of_cost) : '';

                  $all_proj_deduction_not_part_of_cost_amount = $all_proj_deduction_not_part_of_cost_amount + $jl1_result1->deduction_not_part_of_cost; ?>



                </td>





                <td align="right" style="width:15%;"><?= (number_format($jl1_result1->total_cost) > 0) ? number_format($jl1_result1->total_cost) : '';

                                                      $all_proj_salary_cost = $all_proj_salary_cost + $jl1_result1->total_cost; ?>

                  <input type="hidden" name="salary_amount[]" value="<?= $jl1_result1_earning->total_earning ?>">

                </td>





                <td align="right" style="width:15%;">

                  <?= (number_format($jl1_result1->deduction_being_part_of_cost) > 0) ? number_format($jl1_result1->deduction_being_part_of_cost) : '';

                  $all_proj_deduction_being_part_of_cost = $all_proj_deduction_being_part_of_cost + $jl1_result1->deduction_being_part_of_cost; ?>



                </td>













                <td style="text-align:right; width:15%;"><?= (number_format($jl1_result1->total_amt) > 0) ? number_format($jl1_result1->total_amt) : '';

                                                          $all_proj_salary = $all_proj_salary + $jl1_result1->total_amt; ?>



                </td>

                <?php /*?>    <td style="text-align:right;width:15%;"><?= number_format($last_month_earning_proj, 0) ?></td>

                <td style="text-align:right;width:15%;"><?= number_format($dft, 2) ?></td><?php */ ?>

              </tr>

            <?

            } ?>

            <?

            $found = find_a_field('salary_attendence', 'lock_status', 'mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');





            if ($_POST['mon'] > 9 && $_POST['year'] >= 2018) {





              if ($found == 0) {



                $jl_sql = 'select dept.DEPT_ID,dept.DEPT_DESC, 

				

	sum(a.total_payable) as total_amt, sum(a.total_earning) as total_earning,

	sum((a.gross_salary+a.adjustment_amount)-(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as total_cost,

	sum((a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as deduction_not_part_of_cost,

	sum(a.mobile_deduction+a.income_tax+a.food_deduction+a.advance_install) as deduction_being_part_of_cost,

	sum(a.gross_salary) as gross_salary, sum(a.adjustment_amount) as adjustment_amount



	from salary_attendence a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . '  and

	b.PBI_JOB_STATUS="In Service" and a.job_location=0 and a.department = dept.DEPT_ID and  a.pay>0 and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID order by dept.DEPT_DESC';
              } else {







                $jl_sql = 'select dept.DEPT_ID,dept.DEPT_DESC, sum(a.total_payable) as total_amt, sum(a.total_earning) as total_earning,

	 sum((a.gross_salary+a.adjustment_amount)-(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as total_cost,

	 sum((a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as deduction_not_part_of_cost,

	 sum(a.mobile_deduction+a.income_tax+a.food_deduction+a.advance_install) as deduction_being_part_of_cost,

	 sum(a.gross_salary) as gross_salary, sum(a.adjustment_amount) as adjustment_amount



	 from salary_attendence_lock a, personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and a.mon=' . $_POST['mon'] . ' and a.year=' . $_POST['year'] . '  and

	 a.department = dept.DEPT_ID and a.job_location=0 and  a.pay>0 and dept.DEPT_ID not in (13)  GROUP BY dept.DEPT_ID order by dept.DEPT_DESC ';
              }
            } else {





              if ($found == 0) {







                $jl_sql = 'select dept.DEPT_ID,dept.DEPT_DESC, sum(a.total_payable) as total_amt, sum(a.total_earning) as total_earning,

	 sum((a.gross_salary+a.adjustment_amount)-(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as total_cost,

	 sum(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions) as deduction_not_part_of_cost,

	 sum(a.mobile_deduction+a.income_tax+a.food_deduction+a.advance_install) as deduction_being_part_of_cost,

	 sum(a.gross_salary) as gross_salary, sum(a.adjustment_amount) as adjustment_amount

	 

     from salary_attendence a, personnel_basic_info b,

	 department dept where a.PBI_ID = b.PBI_ID and mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . ' and a.remarks_details!="hold"

	 and a.department = dept.DEPT_ID and  a.pay>0 and dept.DEPT_ID not in (3,13,16)  GROUP BY dept.DEPT_ID order by dept.DEPT_DESC ';
              } else {





                $jl_sql = 'select dept.DEPT_ID,dept.DEPT_DESC, sum(a.total_payable) as total_amt, sum(a.total_earning) as total_earning,

		sum((a.gross_salary+a.adjustment_amount)-(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions)) as total_cost,

		sum(a.absent_deduction+a.joining_deduction+a.late_deduction+a.lwp_deduction+a.other_deductions+a.other_deductions) as deduction_not_part_of_cost,

		sum(a.mobile_deduction+a.income_tax+a.food_deduction+a.advance_install) as deduction_being_part_of_cost,

		sum(a.gross_salary) as gross_salary, sum(a.adjustment_amount) as adjustment_amount

        

		from salary_attendence_lock a,

		personnel_basic_info b, department dept where a.PBI_ID = b.PBI_ID and mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . ' and a.remarks_details!="hold"  and

		a.department = dept.DEPT_ID and  a.pay>0 and dept.DEPT_ID not in (3,13,16)  GROUP BY dept.DEPT_ID order by dept.DEPT_DESC';
              }
            }





            $jl_query = mysql_query($jl_sql);







            while ($jl_result = mysql_fetch_object($jl_query)) {

              $last_month_earning_dept = find_a_field('salary_attendence_lock', 'sum(total_earning)', 'mon="' . $last_m . '" and year="' . $last_y . '" and department="' . $jl_result->DEPT_ID . '" and

pay>0 and remarks_details!="hold" and department not in (3,13,16)');



              $last_month_earning_dept_total = $last_month_earning_dept_total + $last_month_earning_dept;

              $last_dept_dff = $jl_result->total_earning - $last_month_earning_dept;

              $dft_dept = ($last_dept_dff * 100) / $last_month_earning_dept;



            ?>

              <tr>

                <td style="text-align:left; width:40%;"><?= $jl_result->DEPT_DESC; ?>

                  <input name="job_location[]" value="<?= $jl_result->DEPT_DESC; ?>" type="hidden" />

                  <input type="hidden" name="tr_type[]" value="all_salary2" />

                </td>





                <td align="right" style="width:15%">

                  <?= (number_format($jl_result->gross_salary) > 0) ? number_format($jl_result->gross_salary) : '';
                  $all_dept_gross = $all_dept_gross + $jl_result->gross_salary; ?>



                </td>





                <td align="right" style="width:15%">

                  <?= (number_format($jl_result->adjustment_amount) > 0) ? number_format($jl_result->adjustment_amount) : '';

                  $all_dept_adjustment_amount = $all_dept_adjustment_amount + $jl_result->adjustment_amount; ?>



                </td>







                <td align="right" style="width:15%">

                  <?= (number_format($jl_result->deduction_not_part_of_cost) > 0) ? number_format($jl_result->deduction_not_part_of_cost) : '';

                  $all_dept_deduction_not_part_of_cost_amount = $all_dept_deduction_not_part_of_cost_amount + $jl_result->deduction_not_part_of_cost; ?>



                </td>



                <td align="right" style="width:15%;"><?= (number_format($jl_result->total_cost) > 0) ? number_format($jl_result->total_cost) : '';

                                                      $all_dept_salary_cost = $all_dept_salary_cost + $jl_result->total_cost; ?>

                  <input type="hidden" name="salary_amount[]" value="<?= $jl_result->total_earning ?>">

                </td>





                <td align="right" style="width:15%;">

                  <?= (number_format($jl_result->deduction_being_part_of_cost) > 0) ? number_format($jl_result->deduction_being_part_of_cost) : '';

                  $all_dept_deduction_being_part_of_cost = $all_dept_deduction_being_part_of_cost + $jl_result->deduction_being_part_of_cost; ?>



                </td>















                <td style="text-align: right;width:15%;"><?= (number_format($jl_result->total_amt) > 0) ? number_format($jl_result->total_amt) : '';

                                                          $all_dept_salary = $all_dept_salary + $jl_result->total_amt; ?>



                </td>









                <?php /*?>       <td style="text-align:right;width:15%"><?= number_format($last_month_earning_dept, 0) ?></td>

                <td style="text-align:right;width:15%"><?= number_format($dft_dept, 2) ?></td><?php */ ?>

              </tr>

            <?

            }



            ?>

            <tr>

              <td align="left"><strong>Total</strong></td>





              <td style="text-align:right"><strong>

                  <?= (number_format($total_gross_cash_bank = $all_dept_gross + $all_proj_gross) > 0) ? number_format($total_gross_cash_bank = $all_dept_gross + $all_proj_gross) : ''; ?>

                </strong></td>





              <td style="text-align:right"><strong>

                  <?= (number_format($total_adjustment_amount = $all_dept_adjustment_amount + $all_proj_adjustment_amount) > 0) ? number_format($total_adjustment_amount = $all_dept_adjustment_amount + $all_proj_adjustment_amount) : ''; ?>

                </strong></td>







              <td style="text-align:right"><strong>

                  <?= (number_format($total_deduction_not_part_of_cost_amount = $all_dept_deduction_not_part_of_cost_amount + $all_proj_deduction_not_part_of_cost_amount) > 0) ? number_format($total_deduction_not_part_of_cost_amount = $all_dept_deduction_not_part_of_cost_amount + $all_proj_deduction_not_part_of_cost_amount) : ''; ?>

                </strong></td>





              <td style="text-align:right"><strong>

                  <?= (number_format($total_all_salary_cost = $all_dept_salary_cost + $all_proj_salary_cost) > 0) ? number_format($total_all_salary_cost = $all_dept_salary_cost + $all_proj_salary_cost) : ''; ?>

                </strong></td>













              <td style="text-align:right"><strong>

                  <?= (number_format($all_dept_deduction_being_part_of_cost + $all_proj_deduction_being_part_of_cost) > 0) ? number_format($all_dept_deduction_being_part_of_cost + $all_proj_deduction_being_part_of_cost) : ''; ?>

                </strong></td>





              <td style="text-align:right"><strong>

                  <?= (number_format($all_dept_salary + $all_proj_salary) > 0) ? number_format($all_dept_salary + $all_proj_salary) : ''; ?>

                </strong></td>







              <?php /*?>    <td style="text-align:right"><strong>

                  <?= number_format($last_total = $last_month_earning_dept_total + $last_month_earning_proj_total, 0) ?>

                </strong></td>

              <td style="text-align:right"><strong>

                  <?



                  $last_dft_total = $total_earning_cash_bank - $last_total;

                  $dft_total = ($last_dft_total * 100) / $last_total;

                  echo number_format($dft_total, 2);

                  ?>

                </strong></td><?php */ ?>

            </tr>

          </table>

          <br>









          <br>

          </br>

          <div style="width:70%; margin:0 auto">

            <div style="float:left; width:25%; text-align:center; font-size:12px;">-------------<br>

              Prepared By</div>

            <div style="float:left; width:25%; text-align:center; font-size:12px;">------------<br>

              Audit</div>

            <!-- <div style="float:left; width:20%; text-align:center; font-size:12px;">------------<br>Accounts</div> -->

            <div style="float:left; width:25%; text-align:center; font-size:12px;">-----------------<br>

              Managing Director</div>

            <div style="float:left; width:25%; text-align:center; font-size:12px;">-----------<br>

              Chairman</div>

          </div>

          <p>&nbsp;</p>

          <p>&nbsp;</p>





















          <!--  ******************************    Tax report Start HERE    ****************************-->











          <!--  for tax report   -->



















        <?







      }

      if ($_POST['report'] == 144658) {







        //$report="Transfer_Report";



        $next_year = $_POST['year'] - 1;











        //previouse dynamic month



        /*$may_month = $_POST['mon']-1;



	$april_month = $_POST['mon']-2;



	$march_month = $_POST['mon']-3;



	$feb_month = $_POST['mon']-4;



	$jan_month = $_POST['mon']-5;



	$dec_month = $_POST['mon']-6;



	$nov_month = $_POST['mon']-7;



	$oct_month = $_POST['mon']-8;



	$sep_month = $_POST['mon']-9;



	$august_month = $_POST['mon']-10;



	$july_month = $_POST['mon']-11;*/



        ?>































          <table width="100%" cellspacing="0" cellpadding="2" border="0">



            <thead>

              <tr>

                <td style="border:0px;" colspan="28"><?= $str ?></td>

              </tr>



              <tr>

                <td style="border:0px;" colspan="28">

                  <div align="center" style="font-size:20px;">Statement of Tax Deducted from Salaries For the month of







                    <? $month_name = date("F", mktime(0, 0, 0, $_POST['mon'], 10)); ?>







                    <?= $month_name ?>-<?= $_POST['year'] ?></div>

                </td>

              </tr>







              <tr>



                <td style="border-left:0px; border-right:0px;" colspan="28">

                  <div align="center" style="font-size:20px;">under section 50 of the Income Tax Ordiance, 1984 (XXXVI of 1984)</div>

                </td>











              </tr>























              <tr>







                <td colspan="4">

                  <div align="center">Particulars of the employee from whom the deduction is made</div>

                </td>







                <td colspan="9">

                  <div align="center">Particulars of salaries</div>

                </td>



                <td>

                  <div align="center"></div>

                </td>



                <td colspan="4">

                  <div align="center">Payment of deducted tax to the credit of the Government</div>

                </td>







                <td colspan="3">

                  <div align="center"></div>

                </td>















              </tr>















              <tr>



                <th rowspan="2">

                  <div align="center">SL </div>

                </th>















                <th rowspan="2">

                  <div align="center">NAME</div>

                </th>







                <th rowspan="2">

                  <div align="center">DESIG.</div>

                </th>







                <th rowspan="2">

                  <div align="center">ETIN</div>

                </th>



















                <th rowspan="2">

                  <div align="center">Basic salary including arrear or advance</div>

                </th>







                <th rowspan="2">

                  <div align="center">House Rent</div>

                </th>







                <th rowspan="2">

                  <div align="center">Medical</div>

                </th>







                <th rowspan="2">

                  <div align="center">Conveyance</div>

                </th>







                <th rowspan="2">

                  <div align="center">Festival Bonus</div>

                </th>











                <th rowspan="2">

                  <div align="center">Allowances and benefits paid in cash</div>

                </th>







                <th rowspan="2">

                  <div align="center">Value of benefit not paid in cash</div>

                </th>







                <th rowspan="2">

                  <div align="center">Any other amount falling under the head "Salaries"</div>

                </th>



                <th rowspan="2">

                  <div align="center">Total</div>

                </th>







                <th rowspan="2">

                  <div align="center"> Amount of Tax deducted</div>

                </th>







                <th rowspan="2">

                  <div align="center">Challan* No</div>

                </th>







                <th rowspan="2">

                  <div align="center">Challan Date</div>

                </th>







                <th rowspan="2">

                  <div align="center">Bank Name</div>

                </th>







                <th rowspan="2">

                  <div align="center">Amount</div>

                </th>







                <th rowspan="2">

                  <div align="center">Cumulative deduction in this month of current year</div>

                </th> <!-- calculatig current finacial year tax amount ex: if select year 2021 and mon nov then report will be jul 2021 to nov 2021 tax amount   -->







                <th rowspan="2">

                  <div align="center">Remarks</div>

                </th>



              </tr>



            </thead>

            <tbody>







              <?















              if ($_POST['department'] != '')



                $tr_con = ' and p.PBI_DEPARTMENT="' . $_POST['department'] . '"';



              if ($_POST['JOB_LOCATION'] != '')



                $tr_con .= ' and p.JOB_LOCATION="' . $_POST['JOB_LOCATION'] . '"';



              if ($_POST['job_status'] != '')



                $tr_con .= ' and p.PBI_JOB_STATUS="' . $_POST['job_status'] . '"';







              /*if($_POST['mon'] !='')



        $tr_con .= ' and i.mon="'.$_POST['mon'].'"';*/







              /*if($_POST['year'] !='')



        $tr_con .= ' and i.year="'.$_POST['year'].'"';*/















              /*if($_POST['year'] !='')



$tr_con .= ' and s.year="'.$_POST['year'].'"';*/















              //i.basic_salary_bank,i.house_rent_bank,i.medical_allowance_bank,i.special_allowance_bank















              $basic_sql = 'select p.ESSENTIAL_TIN_NO,p.PBI_DOJ, p.PBI_ID, p.PBI_NAME,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,



        (select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as designation,(select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project,







        i.gross_salary,i.basic_salary,i.house_rent,i.medical_allowance,i.special_allowance,i.food_allowance,



        i.transport_allowance,i.bank_or_cash,i.mon



        from



		personnel_basic_info p,



		salary_attendence i



		where  i.income_tax>0  and  p.PBI_ID=i.PBI_ID  and i.year in ("' . $_POST['year'] . '","' . $next_year . '") ' . $tr_con . ' group by i.PBI_ID order by i.income_tax desc ';























              $basic_query = mysql_query($basic_sql);



              $sl = 1;



              while ($tf = mysql_fetch_object($basic_query)) {



                $entry_by = $data->entry_by;



                $year = date('Y');



                $tax = find_a_field('salary_attendence', 'sum(income_tax)', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and year="' . $_POST['year'] . '"');







                $fastivel1 = find_a_field('salary_bonus', 'bonus_amt', 'PBI_ID="' . $tf->PBI_ID . '" and bonus_type=1 and mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');



                $fastivel2 = find_a_field('salary_bonus', 'bonus_amt', 'PBI_ID="' . $tf->PBI_ID . '" and bonus_type=2 and mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');







                $fastivel1_bank = find_a_field('salary_bonus', 'bank_paid', 'PBI_ID="' . $tf->PBI_ID . '" and bonus_type=1 and mon="' . $_POST['mon'] . '" and  year="' . $_POST['year'] . '"');



                $fastivel2_bank = find_a_field('salary_bonus', 'bank_paid', 'PBI_ID="' . $tf->PBI_ID . '" and bonus_type=2 and mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');







                //$total_tax = find_a_field('salary_attendence','sum(income_tax)','PBI_ID="'.$tf->PBI_ID.'" and pay>0 and year in ("'.$_POST['year'].'","'.$next_year.'")');











                //for salary condition



                //$salary_given_status=find_a_field('salary_attendence','bank_or_cash','PBI_ID="'.$tf->PBI_ID.'" and pay>0  and mon="'.$_POST['mon'].'" and  year="'.$_POST['year'].'"');







                $salary_given_status = find_a_field('salary_info', 'cash_bank', 'PBI_ID="' . $tf->PBI_ID . '"');  //$tf->bank_or_cash; //







                $Relieving_Date = find_a_field('essential_info', 'ESSENTIAL_RESIG_DATE', 'PBI_ID="' . $tf->PBI_ID . '"');



                $compaire_date = $next_year . '-' . '7' . '-' . '30';























                //emp type 5 only bank portion amount



                $bank_amt = find_a_field('salary_attendence', 'bank_amt', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');







                //for all tax deduct fiscal year wise



                $tax = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');



                //for all Basic salary deduct fiscal year wise



                $basic_salary = find_a_field('salary_attendence', 'basic_salary', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');



                //for all Basic house_rent deduct fiscal year wise



                $house_rent = find_a_field('salary_attendence', 'house_rent', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');



                //for all medical_allowance  deduct fiscal year wise



                $medical_allowance = find_a_field('salary_attendence', 'medical_allowance', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');



                //for all special_allowance  deduct fiscal year wise



                $special_allowance = find_a_field('salary_attendence', 'special_allowance', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');











              ?>







                <?











                //for dynamic month and year



                $jul = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=7 and year="' . $next_year . '"');







                $aug = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=8 and year="' . $next_year . '"');







                $sep = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=9 and year="' . $next_year . '"');







                $oct = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=10 and year="' . $next_year . '"');







                $nov = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=11 and year="' . $next_year . '"');







                $dec_tax = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=12 and year="' . $next_year . '"');







                $jan_tax = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=1 and year="' . $_POST['year'] . '"');







                $feb_tax = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=2 and year="' . $_POST['year'] . '"');







                $mar_tax = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=3 and year="' . $_POST['year'] . '"');







                $apr_tax = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=4 and year="' . $_POST['year'] . '"');







                $may_tax = find_a_field('salary_attendence', 'income_tax', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=5 and year="' . $_POST['year'] . '"');







                $jun_tax = find_a_field('salary_attendence', 'sum(income_tax)', 'PBI_ID="' . $tf->PBI_ID . '" and pay>0 and mon=6 and year="' . $_POST['year'] . '"');







                //Total Amount of tax with financial Year wise



















                $comparing_month = $_POST['mon'];











                if ($comparing_month == 6) {



                  $total_amount_of_tax_jun = $jul + $aug + $sep + $oct + $nov + $dec_tax + $jan_tax + $feb_tax + $mar_tax + $apr_tax + $may_tax + $jun_tax;
                } elseif ($comparing_month == 5) {



                  $total_amount_of_tax_jun = $jul + $aug + $sep + $oct + $nov + $dec_tax + $jan_tax + $feb_tax + $mar_tax + $apr_tax + $may_tax;
                } elseif ($comparing_month == 4) {



                  $total_amount_of_tax_jun = $jul + $aug + $sep + $oct + $nov + $dec_tax + $jan_tax + $feb_tax + $mar_tax + $apr_tax;
                } elseif ($comparing_month == 3) {



                  $total_amount_of_tax_jun = $jul + $aug + $sep + $oct + $nov + $dec_tax + $jan_tax + $feb_tax + $mar_tax;
                } elseif ($comparing_month == 2) {



                  $total_amount_of_tax_jun = $jul + $aug + $sep + $oct + $nov + $dec_tax + $jan_tax + $feb_tax;
                } elseif ($comparing_month == 1) {



                  $total_amount_of_tax_jun = $jul + $aug + $sep + $oct + $nov + $dec_tax + $jan_tax;
                } elseif ($comparing_month == 12) {



                  $total_amount_of_tax_jun = $jul + $aug + $sep + $oct + $nov + $dec_tax;
                } elseif ($comparing_month == 11) {



                  $total_amount_of_tax_jun = $jul + $aug + $sep + $oct + $nov;
                } elseif ($comparing_month == 10) {



                  $total_amount_of_tax_jun = $jul + $aug + $sep + $oct;
                } elseif ($comparing_month == 9) {



                  $total_amount_of_tax_jun = $jul + $aug + $sep;
                } elseif ($comparing_month == 8) {



                  $total_amount_of_tax_jun = $jul + $aug;
                } elseif ($comparing_month == 7) {



                  $total_amount_of_tax_jun = $jul;
                } else {



                  $total_amount_of_tax_jun = 0;
                }















                $total_cumulative_deduction_as_finnacial_year = $total_amount_of_tax_jun;







                ?>



                <tr>



                  <td><?= $sl++; ?></td>







                  <td><?= $tf->PBI_NAME ?></td>



                  <td><?= $tf->designation ?></td>



                  <td><?= $tf->ESSENTIAL_TIN_NO ?></td>



















                  <?php if ($salary_given_status == 5) { ?>















                    <td align="right"><?= ($bank_amt > 0) ? number_format($basic_bank = $bank_amt / 100 * 50) : '';

                                      $totBasic += $basic_bank ?></td>







                    <td align="right"><?= ($bank_amt > 0) ? number_format($house_bank = $bank_amt / 100 * 25) : '';

                                      $totHouse += $house_bank ?></td>







                    <td align="right"><?= ($bank_amt > 0) ? number_format($medical_bank = $bank_amt / 100 * 15) : '';

                                      $totMedical += $medical_bank ?></td>







                    <td align="right"><?= ($bank_amt > 0) ? number_format($allowance_bank = $bank_amt / 100 * 10) : '';

                                      $totspecial += $allowance_bank ?></td>







                  <?php  } else {  ?>







                    <td align="right"><?= ($basic_salary > 0) ? number_format($basic_salary) : '';

                                      $totBasic += $basic_salary ?></td>



                    <td align="right"><?= ($house_rent > 0) ? number_format($house_rent) : '';

                                      $totHouse += $house_rent ?></td>



                    <td align="right"><?= ($medical_allowance > 0) ? number_format($medical_allowance) : '';

                                      $totMedical += $medical_allowance ?></td>



                    <td align="right"><?= ($special_allowance > 0) ? number_format($special_allowance) : '';

                                      $totspecial += $special_allowance ?></td>







                  <?php  } ?>



















                  <?php if ($salary_given_status == 5) { ?>







                    <td align="right"><? echo number_format($festivel_gross_total = $fastivel1_bank + $fastivel2_bank); ?></td>







                  <?php  } else {  ?>







                    <td align="right"><? echo number_format($festivel_gross_total = $fastivel1 + $fastivel2); ?></td>







                  <?php  } ?>



















                  <td></td>







                  <td></td>







                  <td align="right"></td>











                  <?php if ($salary_given_status == 5) { ?>







                    <td align="right"><?= number_format($gross_total = $basic_bank + $house_bank + $medical_bank + $allowance_bank + $fastivel1_bank + $fastivel2_bank, 0) ?></td>











                  <?php  } else {  ?>







                    <td align="right"><?= number_format($gross_total = $basic_salary + $house_rent + $medical_allowance + $special_allowance + $fastivel1 + $fastivel2, 0) ?></td>







                  <?php  } ?>



















                  <td align="right"><?= ($tax > 0) ? number_format($tax, 0) : ''; ?></td>











                  <td></td>







                  <td></td>







                  <td></td>







                  <td align="center"></td>







                  <td align="right"><?= ($total_cumulative_deduction_as_finnacial_year > 0) ? number_format($total_cumulative_deduction_as_finnacial_year, 0) : ''; ?></td>











                  <td align="right"></td>



                </tr>







              <?















                $sum_total_amount_of_salary += $gross_total;







                $sum_total_tax_deduct = $sum_total_tax_deduct + $total_cumulative_deduction_as_finnacial_year;











                $sum_of_tax_deduct += $tax;



















                $fastivelsum += $festivel_gross_total;
              }























              ?>































              <tr>







                <td colspan="3"></td>







                <td>Total</td>















                <td>

                  <div align="center"><strong><?= number_format($totBasic, 0) ?> </strong></div>

                </td>







                <td>

                  <div align="center"><strong><?= number_format($totHouse, 0) ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong><?= number_format($totMedical, 0) ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong><?= number_format($totspecial, 0) ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong><?= number_format($fastivelsum, 0) ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong><? ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong><? ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong><? ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong><?= number_format($sum_total_amount_of_salary, 0) ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong><?= number_format($sum_of_tax_deduct, 0) ?></strong></div>

                </td>















                <td>

                  <div align="center"><strong><? ?></strong></div>

                </td>















                <td>

                  <div align="center"><strong><? ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong><? ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong></strong></div>

                </td>







                <td>

                  <div align="center"><strong><?= number_format($sum_total_tax_deduct, 0) ?> </strong></div>

                </td>







                <td>

                  <div align="center"><strong> </strong></div>

                </td>































              </tr>























            </tbody>







          </table> <br>











































          <!--  ******************************    Tax report Start HERE    ****************************-->











          <!--  for tax report   -->



















        <?







      }

      if ($_POST['report'] == 144659) {







        //$report="Transfer_Report";



        $next_year = $_POST['year'] - 1;











        ?>































          <table width="100%" cellspacing="0" cellpadding="2" border="0">



            <thead>

              <tr>

                <td style="border:0px;" colspan="28"><?= $str ?></td>

              </tr>



              <tr>

                <td style="border:0px;" colspan="28">

                  <div align="center" style="font-size:20px;">Monthly withholding Tax & VAT Calculation







                    <? $month_name = date("F", mktime(0, 0, 0, $_POST['mon'], 10)); ?>







                    <?= $month_name ?>-<?= $_POST['year'] ?></div>

                </td>

              </tr>







              <tr>



                <td style="border-left:0px; border-right:0px;" colspan="28">

                  <div align="center" style="font-size:20px;"></div>

                </td>











              </tr>



























              <tr>



                <th rowspan="2">

                  <div align="center">SL </div>

                </th>















                <th rowspan="2">

                  <div align="center">Supplier's Name</div>

                </th>







                <th rowspan="2">

                  <div align="center">Supplier's Address.</div>

                </th>







                <th rowspan="2">

                  <div align="center">Expense/Cost Head As Per F/S</div>

                </th>







                <th rowspan="2">

                  <div align="center"> Value Paid</div>

                </th>















                <th rowspan="2">

                  <div align="center">Deducted VAT</div>

                </th>







                <th rowspan="2">

                  <div align="center">VDS Code</div>

                </th>







                <th rowspan="2">

                  <div align="center">Base Amount for TDS</div>

                </th>











                <th rowspan="2">

                  <div align="center">Deducted TDS</div>

                </th>







                <th rowspan="2">

                  <div align="center">TDS Section</div>

                </th>







                <th rowspan="2">

                  <div align="center">VDS Rate</div>

                </th>







                <th rowspan="2">

                  <div align="center">TDS Rate</div>

                </th>







                <th rowspan="2">

                  <div align="center"> Date of Deduction </div>

                </th>







                <th rowspan="2">

                  <div align="center">Date of Posting/Transaction</div>

                </th>







                <th rowspan="2">

                  <div align="center">Voucher No.</div>

                </th>







                <th rowspan="2">

                  <div align="center">Type of Voucher</div>

                </th>







                <th rowspan="2">

                  <div align="center">Cost Head/Ledger Head</div>

                </th>







                <th rowspan="2">

                  <div align="center">Cost Center</div>

                </th>







                <th rowspan="2">

                  <div align="center">Sub CC 1</div>

                </th>



                <th rowspan="2">

                  <div align="center">Remarks</div>

                </th>







              </tr>



            </thead>

            <tbody>







              <?















              if ($_POST['department'] != '')



                $tr_con = ' and p.PBI_DEPARTMENT="' . $_POST['department'] . '"';



              if ($_POST['JOB_LOCATION'] != '')



                $tr_con .= ' and p.JOB_LOCATION="' . $_POST['JOB_LOCATION'] . '"';



              if ($_POST['job_status'] != '')



                $tr_con .= ' and p.PBI_JOB_STATUS="' . $_POST['job_status'] . '"';







              $start = $_POST['fdate'];



              $end =  $_POST['tdate'];



              //p.entry_at between



              $basic_sql = 'select  p.*



        from



		journal p



	



		where ledger_id=2066017600000000 and  `tr_from` = "Payment"  and from_unixtime(p.jv_date, "%Y-%m-%d") between "' . $start . '" and "' . $end . '"  ' . $tr_con . ' group by p.tr_no order by p.tr_no';















              $basic_query = mysql_query($basic_sql);



              $sl = 1;



              while ($tf = mysql_fetch_object($basic_query)) {



                $entry_by = $data->entry_by;



                $year = date('Y');











                $value_paid = find_a_field('journal', 'sum(dr_amt)', 'tr_no="' . $tf->tr_no . '" and `tr_from` = "Payment" and ledger_id=2066017600000000');







                $tax_paid = find_a_field('journal', 'sum(cr_amt)', 'tr_no="' . $tf->tr_no . '" and `tr_from` = "Payment" and ledger_id=2063000800000000');







                $vat = find_a_field('journal', 'sum(cr_amt)', 'tr_no="' . $tf->tr_no . '" and `tr_from` = "Payment" and ledger_id=4029003100000000');



















              ?>











                <tr>



                  <td><?= $sl++; ?></td>







                  <td><?= find_a_field('accounts_ledger', 'ledger_name', 'ledger_id="' . $tf->ledger_id . '"'); ?></td>



                  <td>Skylark Mak (8th Floor), House#84, Block#D Bir Uttam Khadamul Bashar Road, Banani C/A 1213 Dhaka</td>



                  <td>Purchase of Materials (Sika)</td>







                  <td align="right"><?= ($value_paid > 0) ? number_format($value_paid) : ''; ?></td>



                  <td align="right"><?= ($vat > 0) ? number_format($vat) : ''; ?></td>







                  <td align="right">S037.00</td>







                  <td align="right"><?= ($vat > 0) ? number_format($base_amt_for_tds = $value_paid - $vat) : '';

                                    $base_for_tds = $value_paid - $vat ?></td>







                  <td align="right"><?= ($tax_paid > 0) ? number_format($tax_paid, 0) : ''; ?></td>







                  <td align="right"> 52 1 (b) </td>







                  <td align="right">7.50%</td>



                  <td>7%</td>







                  <td><?= date('d-M-Y', $tf->jv_date); ?></td>







                  <td><?= date('d-M-Y', strtotime($tf->entry_at)); ?></td>







                  <td align="center"><?= $tf->tr_no; ?></td>



                  <td align="center"><?= $tf->tr_from; ?></td>







                  <td align="center"><?= find_a_field('accounts_ledger', 'ledger_name', 'ledger_id="' . $tf->ledger_id . '"'); ?></td>











                  <td align="center"><?= find_a_field('cost_center', 'center_name', 'id="' . $tf->cc_code . '"'); ?></td>







                  <td align="center"></td>











                  <td align="center"> Paid during the month </td>



                </tr>







              <?







                $tot_value_paid = $tot_value_paid + $value_paid;



                $tot_vat = $tot_vat + $vat;



                $totTase_amt_for_tds = $totTase_amt_for_tds + $base_for_tds;



                $totTax = $totTax + $tax_paid;
              }























              ?>































              <tr>







                <td colspan="3"></td>







                <td>Total</td>















                <td>

                  <div align="center"><strong><?= number_format($tot_value_paid, 0) ?> </strong></div>

                </td>







                <td>

                  <div align="center"><strong><?= number_format($tot_vat, 0) ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong></strong></div>

                </td>







                <td>

                  <div align="center"><strong><?= number_format($totTase_amt_for_tds, 0) ?></strong></div>

                </td>







                <td>

                  <div align="center"><strong><?= number_format($totTax, 0) ?></strong></div>

                </td>







                <td colspan="11">

                  <div align="center"><strong></strong></div>

                </td>







































              </tr>























            </tbody>







          </table> <br>







































        <?


}if ($_POST['report'] == 4763) { ?>



          <table width="100%" cellspacing="0" cellpadding="2" border="0">



            <thead>



              <tr>



                <td style="border:0px;" colspan="28"><?= $str ?></td>



              </tr>



              <tr>



                <td style="border:0px;" colspan="28">

                  <div align="center" style="font-size:20px;">Allowances Sheet for the Period of



                    <? $d = strtotime("-1 Months");



                    echo date("M-Y", $d) . ""; ?>



                    To



                    <? $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');

                    echo date_format($test, 'M-Y') . '<br>' . $depts;  ?>



                  </div>

                </td>



              </tr>



              <tr>



                <td style="border:0px;" colspan="28"><?= $strTime ?></td>



              </tr>



              <tr>



                <th rowspan="2">

                  <div align="center">S/L</div>

                </th>



                <th rowspan="2">

                  <div align="center">ID</div>

                </th>



                <th rowspan="2">

                  <div align="center">Name</div>

                </th>



                <th rowspan="2">

                  <div align="center">Designation</div>

                </th>



                <!--<th rowspan="2"><div align="center">Department</div></th>-->



                <th rowspan="2">

                  <div align="center">Joining Date</div>

                </th>



                <th colspan="9">

                  <div align="center">Allowances</div>

                </th>



                <th rowspan="2">

                  <div align="center">Total Allowances</div>

                </th>



                <th rowspan="2">

                  <div align="center">Bank A/C</div>

                </th>



                <th rowspan="2">

                  <div align="center">Payroll Card</div>

                </th>



                <th rowspan="2">

                  <div align="center">Remarks</div>

                </th>



              </tr>



              <tr>



                <th>

                  <div align="center">Food</div>

                </th>



                <th>

                  <div align="center">Conveyance</div>

                </th>



                <th>

                  <div align="center">Site Visit</div>

                </th>



                <th>

                  <div align="center">Health</div>

                </th>



                <th>

                  <div align="center">Fuel</div>

                </th>



                <th>

                  <div align="center">Overtime</div>

                </th>



                <th>

                  <div align="center">Repair and Maintenance</div>

                </th>



                <th>

                  <div align="center">Hotel</div>

                </th>



                <th>

                  <div align="center">Other Allowances</div>

                </th>



              </tr>



            </thead>



            <tbody>



              <?


if ($_POST['JOB_LOCATION'] != '')
$cv_con .= ' and t.job_location ="' . $_POST['JOB_LOCATION'] . '"';

if ($_POST['department'] != '')
$cv_con .= ' and t.department ="' . $_POST['department'] . '"';

if ($_POST['type'] != '')
$cv_con .= ' and t.type ="' . $_POST['type'] . '"';


$sqldd = 'select t.PBI_ID,a.PBI_CODE,a.PBI_NAME,desg.DESG_DESC,dept.DEPT_DESC,date_format(e.ESSENTIAL_JOINING_DATE,"%d-%b-%y") as joining_date,
SUM(t.food_bill) as food_bill,SUM(t.conveyance) as conveyance,SUM(t.site_visit) as site_visit,SUM(t.health) as health,SUM(t.fule) as fule,SUM(t.others) others,SUM(t.overtime) as overtime,
SUM(t.ifter) as ifter,SUM(t.hotel) as hotel,
i.card_no,i.cash,SUM(t.food_bill+t.conveyance+t.site_visit+t.health+t.fule+t.overtime+t.others+t.ifter+t.hotel) as amount,t.remarks
from







monthly_allowances t,







personnel_basic_info a,







salary_info i,







designation desg,







department dept,



essential_info e















where















i.PBI_ID = t.PBI_ID and







t.designation=desg.DESG_ID and







t.department=dept.DEPT_ID and







t.PBI_ID=e.PBI_ID and







t.job_status="In Service" and







t.mon=' . $_POST['mon'] . ' and







t.year=' . $_POST['year'] . ' and







t.PBI_ID=a.PBI_ID ' . $cv_con . '







group by t.PBI_ID order by a.PBI_NAME asc';























              $querydd = mysql_query($sqldd);







              ini_set('memory_limit', '-1');







              while ($conData = mysql_fetch_object($querydd)) {







                $entry_by = $conData->entry_by;







                $year = date('Y');























































              ?>



                <tr>



                  <td><?= ++$s ?></td>



                  <td><?= $conData->PBI_CODE ?></td>



                  <td nowrap="nowrap"><?= $conData->PBI_NAME ?></td>



                  <td><?= $conData->DESG_DESC ?></td>



                  <?php /*?><td><div align=""><?=$conData->DEPT_DESC?></div></td><?php */ ?>



                  <td>

                    <div align="center">



                      <?= $conData->joining_date ?>



                    </div>

                  </td>



                  <td>

                    <div align="right"><?= ($conData->food_bill > 0) ? number_format($conData->food_bill) : '';

                                        $totFod += $conData->food_bill ?></div>

                  </td>



                  <td>

                    <div align="right"><?= ($conData->conveyance > 0) ? number_format($conData->conveyance) : '';

                                        $totCon += $conData->conveyance ?></div>

                  </td>



                  <td>

                    <div align="right">



                      <?= ($conData->site_visit > 0) ? number_format($conData->site_visit) : '';

                      $totSite += $conData->site_visit ?>



                    </div>

                  </td>



                  <td>

                    <div align="right">



                      <?= ($conData->health > 0) ? number_format($conData->health) : '';

                      $totHealth += $conData->health ?>



                    </div>

                  </td>



                  <td>

                    <div align="right">



                      <?= ($conData->fule > 0) ? number_format($conData->fule) : '';

                      $totFule += $conData->fule ?>



                    </div>

                  </td>















                  <td>

                    <div align="right">



                      <?= ($conData->overtime > 0) ? number_format($conData->overtime) : '';

                      $totOvertime += $conData->overtime ?>



                    </div>

                  </td>







                  <td>

                    <div align="right">



                      <?= ($conData->ifter > 0) ? number_format($conData->ifter) : '';

                      $totIfter += $conData->ifter ?>



                    </div>

                  </td>







                  <td>

                    <div align="right">



                      <?= ($conData->hotel > 0) ? number_format($conData->hotel) : '';

                      $totHotel += $conData->hotel ?>



                    </div>

                  </td>







                  <td>

                    <div align="right">



                      <?= ($conData->others > 0) ? number_format($conData->others) : '';

                      $totOthers += $conData->others ?>



                    </div>

                  </td>















                  <td>

                    <div align="right">



                      <?= number_format($conData->amount); ?>



                    </div>

                  </td>



                  <td>

                    <div align="center">



                      <?= $conData->cash ?>



                    </div>

                  </td>



                  <td>

                    <div align="center">



                      <?= $conData->card_no ?>



                    </div>

                  </td>



                  <td><?= $conData->remarks ?></td>



                </tr>



                <? $totalConvaince += $conData->food_bill + $conData->conveyance + $conData->site_visit + $conData->health + $conData->fule + $conData->others + $conData->overtime + $conData->ifter + $conData->hotel; ?>



              <?  }  ?>



              <tr>



                <td colspan="5" align="right" style="font-weight:bold">Total:</td>



                <td colspan="1" align="right" style="font-weight:bold"><?= ($totFod > 0) ? number_format($totFod, 0) : ''; ?></td>



                <td colspan="1" align="right" style="font-weight:bold"><?= ($totCon > 0) ? number_format($totCon, 0) : ''; ?></td>



                <td colspan="1" align="right" style="font-weight:bold"><?= ($totSite > 0) ? number_format($totSite, 0) : ''; ?></td>



                <td colspan="1" align="right" style="font-weight:bold"><?= ($totHealth > 0) ? number_format($totHealth, 0) : ''; ?></td>



                <td colspan="1" align="right" style="font-weight:bold"><?= ($totFule > 0) ? number_format($totFule, 0) : ''; ?></td>







                <td colspan="1" align="right" style="font-weight:bold"><?= ($totOvertime > 0) ? number_format($totOvertime, 0) : ''; ?></td>







                <td colspan="1" align="right" style="font-weight:bold"><?= ($totIfter > 0) ? number_format($totIfter, 0) : ''; ?></td>



                <td colspan="1" align="right" style="font-weight:bold"><?= ($totHotel > 0) ? number_format($totHotel, 0) : ''; ?></td>







                <td colspan="1" align="right" style="font-weight:bold"><?= ($totOthers > 0) ? number_format($totOthers, 0) : ''; ?></td>







                <td colspan="1" align="right" style="font-weight:bold"><?= ($totalConvaince > 0) ? number_format($totalConvaince, 0) : ''; ?></td>



                <td colspan="3"></td>



              </tr>



            </tbody>



          </table>



          In Words:<? echo convertNumberMhafuz($totalConvaince); ?> <br>



          <br>



          <br>



          <div style="width:100%; margin:0 auto">



            <div style="float:left; width:20%; text-align:center">-------------------<br>



              Prepared By</div>



            <div style="float:left; width:20%; text-align:center">-------------------<br>



              Audit</div>



            <div style="float:left; width:20%; text-align:center">-------------------<br>



              Accounts</div>



            <div style="float:left; width:20%; text-align:center">-------------------<br>



              Managing Director</div>



            <div style="float:left; width:20%; text-align:center">-------------------<br>



              Chairman</div>



          </div>







          <?php /*?><a href="export_primary.php?export=yes&year=<?=$_REQUEST['year']?>&mon=<?=$_POST['mon']?>" target="_blank">  Export</a><?php */ ?>











          </tbody>



        </table>



        <br>



        <br>



        <br>











        <!--***** Sales commission report satart-->







































      <? } elseif ($_POST['report'] == 4764) {
        //$next_year  = $_POST['year']-1;
      ?>

        <table width="100%" cellspacing="0" cellpadding="2" border="0">



          <thead>



            <tr>



              <td style="border:0px;" colspan="28"><?= $str ?></td>



            </tr>



            <tr>



              <td style="border:0px;" colspan="28">

                <div align="center" style="font-size:20px;">Staff Incentive disbursement in the month of


                  <?

                  $com_data = find_all_field('monthly_sales_commission', '', 'year="' . $_POST['year'] . '" and mon="' . $_POST['mon'] . '" order by PBI_ID desc');


                  $fin_start_year = $_POST['dispatched_year'];



                  $next_year  = $_POST['dispatched_year'] + 1;

                  $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');

                  echo date_format($test, 'M-Y'); ?>

                </div>

              </td>

            </tr>

            <tr>

              <td style="border:0px;" colspan="28"><?= $strTime ?></td>

            </tr>

            <tr>

              <th rowspan="2">

                <div align="center">S/L</div>

              </th>

              <th rowspan="2">

                <div align="center">ID</div>

              </th>

              <th rowspan="2">

                <div align="center">Name</div>

              </th>

              <th rowspan="2">

                <div align="center">Designation</div>

              </th>

              <th rowspan="2">

                <div align="center">Joining Date</div>

              </th>


              <th colspan="12">

                <div align="center">Incentive Period</div>

              </th>

              <th rowspan="2">

                <div align="center">Special Incentive</div>

              </th>

              <th rowspan="2">

                <div align="center">Total Incentive</div>

              </th>

              <th rowspan="2">

                <div align="center">Tax Deduction</div>

              </th>

              <th rowspan="2">

                <div align="center">Advance deduction</div>

              </th>

              <th rowspan="2">

                <div align="center">Net payment</div>

              </th>
            </tr>

            <tr>

              <th>

                <div align="center"><?= 'Jul-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Aug-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Sep-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Oct-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Nov-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Dec-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Jan-' . $next_year; ?> </div>

              </th>

              <th>

                <div align="center"><?= 'Feb-' . $next_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Mar-' . $next_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Apr-' . $next_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'May-' . $next_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Jun-' . $next_year; ?></div>

              </th>
            </tr>
          </thead>
          <tbody>

            <?

            if ($_POST['JOB_LOCATION'] != '')

              $cv_con .= ' and t.job_location ="' . $_POST['JOB_LOCATION'] . '"';

            if ($_POST['department'] != '')

              $cv_con .= ' and t.department ="' . $_POST['department'] . '"';

            $start_year = $next_year . '-' . '07' . '-' . '01';

            $end_year   =  $_POST['year'] . '-' . $_POST['mon'] . '-' . '30';


            $sqldd = 'select t.PBI_ID,a.PBI_CODE,a.PBI_NAME,desg.DESG_DESC,dept.DEPT_DESC,date_format(e.ESSENTIAL_JOINING_DATE,"%d-%b-%y") as joining_date,

sum(t.jan_com) as jan_com,sum(t.feb_com) as feb_com,sum(t.mar_com) as mar_com,sum(t.apr_com) as apr_com,sum(t.may_com) as may_com,sum(t.jun_com) as jun_com,

sum(t.jul_com) as jul_com,sum(t.aug_com) as aug_com,sum(t.sep_com) as sep_com,sum(t.oct_com) as oct_com,sum(t.nov_com) as nov_com,sum(t.dec_com) as dec_com,

i.card_no,i.cash,sum(t.special_consideration) as special_consideration,sum(t.tax_deduction) as tax_deduction,sum(t.advance_deduction) as advance_deduction

from

monthly_sales_commission t,

personnel_basic_info a,

salary_info i,

designation desg,

department dept,

essential_info e

where

i.PBI_ID = t.PBI_ID and

t.designation=desg.DESG_ID and

t.department=dept.DEPT_ID and

t.PBI_ID=e.PBI_ID and

t.job_status="In Service" and

t.mon="' . $_POST['mon'] . '"  and

t.year="' . $_POST['year'] . '" and

t.dispatched_year="' . $_POST['dispatched_year'] . '" and

t.PBI_ID=a.PBI_ID ' . $cv_con . '

group by t.PBI_ID

order by a.PBI_NAME';


            $querydd = mysql_query($sqldd);

            ini_set('memory_limit', '-1');

            while ($conData = mysql_fetch_object($querydd)) {

              $entry_by = $conData->entry_by;

              $year = date('Y');

            ?>

              <tr>

                <td><?= ++$s ?></td>

                <td><?= $conData->PBI_CODE ?></td>

                <td nowrap="nowrap"><?= $conData->PBI_NAME ?></td>

                <td><?= $conData->DESG_DESC ?></td>

                <td>

                  <div align="center">
                    <?= $conData->joining_date ?>
                  </div>

                </td>

                <td>
                  <div align="right">
                    <?= ($conData->jul_com > 0) ? number_format($conData->jul_com) : '';

                    $tot_jul_com += $conData->jul_com ?>
                  </div>

                </td>

                <td>

                  <div align="right">
                    <?= ($conData->aug_com > 0) ? number_format($conData->aug_com) : '';

                    $tot_aug_com += $conData->aug_com ?>
                  </div>

                </td>

                <td>

                  <div align="right">
                    <?= ($conData->sep_com > 0) ? number_format($conData->sep_com) : '';

                    $tot_sep_com += $conData->sep_com ?>
                  </div>

                </td>

                <td>

                  <div align="right">
                    <?= ($conData->oct_com > 0) ? number_format($conData->oct_com) : '';

                    $tot_oct_com += $conData->oct_com ?>
                  </div>

                </td>

                <td>

                  <div align="right">
                    <?= ($conData->nov_com > 0) ? number_format($conData->nov_com) : '';

                    $tot_nov_com += $conData->nov_com ?>
                  </div>

                </td>

                <td>

                  <div align="right">
                    <?= ($conData->dec_com > 0) ? number_format($conData->dec_com) : '';

                    $tot_dec_com += $conData->dec_com ?>
                  </div>

                </td>

                <td>
                  <div align="right"><?= ($conData->jan_com > 0) ? number_format($conData->jan_com) : '';

                                      $tot_jan_com += $conData->jan_com ?></div>
                </td>



                <td>
                  <div align="right"><?= ($conData->feb_com > 0) ? number_format($conData->feb_com) : '';

                                      $tot_feb_com += $conData->feb_com ?></div>
                </td>

                <td>
                  <div align="right">
                    <?= ($conData->mar_com > 0) ? number_format($conData->mar_com) : '';

                    $tot_mar_com += $conData->mar_com ?>
                  </div>
                </td>



                <td>
                  <div align="right">
                    <?= ($conData->apr_com > 0) ? number_format($conData->apr_com) : '';

                    $tot_apr_com += $conData->apr_com ?>
                  </div>

                </td>



                <td>

                  <div align="right">
                    <?= ($conData->may_com > 0) ? number_format($conData->may_com) : '';

                    $tot_may_com += $conData->may_com ?>
                  </div>

                </td>

                <td>

                  <div align="right">
                    <?= ($conData->jun_com > 0) ? number_format($conData->jun_com) : '';

                    $tot_jun_com += $conData->jun_com ?>
                  </div>

                </td>

                <td>
                  <div align="right">
                    <?= ($conData->special_consideration > 0) ? number_format($conData->special_consideration) : '';

                    $tot_special_consideration += $conData->special_consideration ?>
                  </div>

                </td>

                <td>
                  <div align="right">
                    <?
                    $net_convaince = $conData->jan_com + $conData->feb_com + $conData->mar_com + $conData->apr_com + $conData->may_com + $conData->jun_com + $conData->jul_com + $conData->aug_com + $conData->sep_com +

                      $conData->oct_com + $conData->nov_com + $conData->dec_com + $conData->special_consideration;
                    echo number_format($net_convaince); ?>
                  </div>

                </td>

                <td>

                  <div align="right">

                    <?= ($conData->tax_deduction > 0) ? number_format($conData->tax_deduction) : '';

                    $tot_tax_deduction += $conData->tax_deduction ?>

                  </div>

                </td>



                <td>

                  <div align="right">

                    <?= ($conData->advance_deduction > 0) ? number_format($conData->advance_deduction) : '';

                    $tot_adv_deduction += $conData->advance_deduction ?>

                  </div>

                </td>



                <td>

                  <div align="right">
                    <?

                    $net_deduction = $conData->tax_deduction + $conData->advance_deduction;

                    $net_payment = $net_convaince - $net_deduction;

                    $total_payment = $total_payment + $net_payment;

                    $total_payment_in_word = round($total_payment);

                    echo number_format($net_payment);

                    ?>
                  </div>
                </td>
              </tr>
              <? $totalConvaince = $totalConvaince + $net_convaince; ?>

            <?  }  ?>
            <tr>
              <td colspan="5" align="right" style="font-weight:bold">Total:</td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_jul_com > 0) ? number_format($tot_jul_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_aug_com > 0) ? number_format($tot_aug_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_sep_com > 0) ? number_format($tot_sep_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_oct_com > 0) ? number_format($tot_oct_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_nov_com > 0) ? number_format($tot_nov_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_dec_com > 0) ? number_format($tot_dec_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_jan_com > 0) ? number_format($tot_jan_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_feb_com > 0) ? number_format($tot_feb_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_mar_com > 0) ? number_format($tot_mar_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_apr_com > 0) ? number_format($tot_apr_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_may_com > 0) ? number_format($tot_may_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_jun_com > 0) ? number_format($tot_jun_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_special_consideration > 0) ? number_format($tot_special_consideration, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($totalConvaince > 0) ? number_format($totalConvaince, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_tax_deduction > 0) ? number_format($tot_tax_deduction, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_adv_deduction > 0) ? number_format($tot_adv_deduction, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($total_payment > 0) ? number_format($total_payment, 0) : ''; ?></td>
            </tr>

          </tbody>

        </table>
        In Words:<? echo convertNumberMhafuz($total_payment_in_word); ?> <br>
        <br>
        <br>
        <div style="width:100%; margin:0 auto">
          <div style="float:left; width:20%; text-align:center">-------------------<br>
            Prepared By</div>
          <div style="float:left; width:20%; text-align:center">-------------------<br>
            Audit</div>
          <div style="float:left; width:20%; text-align:center">-------------------<br>
            Accounts</div>
          <div style="float:left; width:20%; text-align:center">-------------------<br>
            Managing Director</div>
          <div style="float:left; width:20%; text-align:center">-------------------<br>
            Chairman</div>
        </div>
        <?php /*?><a href="export_primary.php?export=yes&year=<?=$_REQUEST['year']?>&mon=<?=$_POST['mon']?>" target="_blank">  Export</a><?php */ ?>
        </tbody>
        </table>
        <br>
        <br>
        <br>

        <!--Sales Commission report end-->









      <? } elseif ($_POST['report'] == 6112023) {
        //$next_year  = $_POST['year']-1;
      ?>

        <table width="100%" cellspacing="0" cellpadding="2" border="0">
          <thead>
            <tr>
              <td style="border:0px;" colspan="28"><?= $str ?></td>
            </tr>
            <tr>
              <td style="border:0px;" colspan="28">

                <div align="center" style="font-size:20px;">Staff Incentive disbursement in the year of

                  <?
                  $com_data = find_all_field('monthly_sales_commission', '', 'year="' . $_POST['year'] . '" and mon="' . $_POST['mon'] . '" order by PBI_ID desc');

                  $fin_start_year = $_POST['dispatched_year'];

                  $next_year  =  $_POST['dispatched_year'] + 1;

                  $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');

                   date_format($test, 'Y'); 
				  
				  // Concatenate with a space and echo the result
					echo $fin_start_year . ' TO ' . $next_year;

				  
				  ?>

                </div>

              </td>

            </tr>

            <tr>

              <td style="border:0px;" colspan="28"><?= $strTime ?></td>

            </tr>

            <tr>

              <th rowspan="2">

                <div align="center">S/L</div>

              </th>

              <th rowspan="2">

                <div align="center">ID</div>

              </th>

              <th rowspan="2">

                <div align="center">Name</div>

              </th>

              <th rowspan="2">

                <div align="center">Designation</div>

              </th>

              <th rowspan="2">

                <div align="center">Joining Date</div>

              </th>


              <th colspan="12">

                <div align="center">Incentive Period</div>

              </th>

              <th rowspan="2">

                <div align="center">Special Consideration</div>

              </th>

              <th rowspan="2">

                <div align="center">Total Incentive</div>

              </th>

              <th rowspan="2">

                <div align="center">Tax Deduction</div>

              </th>

              <th rowspan="2">

                <div align="center">Advance deduction</div>

              </th>

              <th rowspan="2">

                <div align="center">Net payment</div>

              </th>
            </tr>

            <tr>
			
			
			   
              <th>

                <div align="center"><?= 'Jul-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Aug-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Sep-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Oct-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Nov-' . $fin_start_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Dec-' . $fin_start_year; ?></div>

              </th>
			  
			  
			  <th>

                <div align="center"><?= 'Jan-' . $next_year; ?> </div>

              </th>

              <th>

                <div align="center"><?= 'Feb-' . $next_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Mar-' . $next_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Apr-' . $next_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'May-' . $next_year; ?></div>

              </th>

              <th>

                <div align="center"><?= 'Jun-' . $next_year; ?></div>

              </th>


             
            </tr>
          </thead>
          <tbody>

            <?

            if ($_POST['JOB_LOCATION'] != '')

              $cv_con .= ' and t.job_location ="' . $_POST['JOB_LOCATION'] . '"';

            if ($_POST['department'] != '')

              $cv_con .= ' and t.department ="' . $_POST['department'] . '"';

            $start_year = $fin_start_year . '-' . '07' . '-' . '01';

            $end_year   =  $next_year. '-' . $_POST['mon'] . '-' . '30';


             $sqldd = 'select t.PBI_ID,a.PBI_CODE,a.PBI_NAME,desg.DESG_DESC,dept.DEPT_DESC,date_format(e.ESSENTIAL_JOINING_DATE,"%d-%b-%y") as joining_date,

            i.card_no,i.cash,sum(t.special_consideration) as special_consideration,sum(t.tax_deduction) as tax_deduction,
			sum(t.advance_deduction) as advance_deduction

            from

            monthly_sales_commission t,

            personnel_basic_info a,

            salary_info i,

            designation desg,

            department dept,

            essential_info e

            where

            i.PBI_ID = t.PBI_ID and

            t.designation=desg.DESG_ID and

            t.department=dept.DEPT_ID and

            t.PBI_ID=e.PBI_ID and

            t.job_status="In Service" and

            t.financial_year between "' . $start_year . '" and  "' . $end_year . '" and


            t.PBI_ID=a.PBI_ID ' . $cv_con . '

            group by t.PBI_ID

            order by a.PBI_NAME';


            $querydd = mysql_query($sqldd);

            ini_set('memory_limit', '-1');

            while ($conData = mysql_fetch_object($querydd)) {

              $entry_by = $conData->entry_by;

              $year = date('Y');
			  
			  
			 
			  
			  $jul_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$fin_start_year.'" and mon=7');
			  
			  $aug_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$fin_start_year.'" and mon=8');
			  
			   $sep_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$fin_start_year.'" and mon=9');
			  
			  $oct_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$fin_start_year.'" and mon=10');
			  
			  $nov_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$fin_start_year.'" and mon=11');
			  
			  $dec_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$fin_start_year.'" and mon=12');
			  
			  
			   $jan_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$next_year.'" and mon=1');
			  
			  $feb_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$next_year.'" and mon=2');
			  
			  $mar_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$next_year.'" and mon=3');
			  
			  $apr_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$next_year.'" and mon=4');
			  
			  $may_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$next_year.'" and mon=5');
			  
			  $jun_com = find_a_field('monthly_sales_commission','sum(jan_com+feb_com+mar_com+apr_com+may_com+
			  jun_com+jul_com+aug_com+sep_com+oct_com+nov_com+dec_com)','PBI_ID="'.$conData->PBI_ID.'" and year="'.$next_year.'" and mon=6');
			  
	$special_consideration = find_a_field('monthly_sales_commission','sum(special_consideration)','PBI_ID="'.$conData->PBI_ID.'"
	 and financial_year between "' . $start_year . '" and  "' . $end_year . '" ');
	 
	$tax_deduction = find_a_field('monthly_sales_commission','sum(tax_deduction)','PBI_ID="'.$conData->PBI_ID.'" and financial_year between "' . $start_year . '" and  "' . $end_year . '" ');
	
	$advance_deduction = find_a_field('monthly_sales_commission','sum(advance_deduction)','PBI_ID="'.$conData->PBI_ID.'" and 
	financial_year between "' . $start_year . '" and  "' . $end_year . '" ');
	
	
			  
			  
            ?>

              <tr>

                <td><?= ++$s ?></td>

                <td><?= $conData->PBI_CODE ?></td>

                <td nowrap="nowrap"><?= $conData->PBI_NAME ?></td>

                <td><?= $conData->DESG_DESC ?></td>

                <td>

                  <div align="center">
                    <?= $conData->joining_date ?>
                  </div>

                </td>

           
               <td><div align="right"><?= ($jul_com> 0) ? number_format($jul_com) : ''; $tot_jul_com += $jul_com;?></div></td>

               <td><div align="right"><?= ($aug_com> 0) ? number_format($aug_com) : ''; $tot_aug_com += $aug_com;?></div></td>

               <td><div align="right"><?= ($sep_com> 0) ? number_format($sep_com) : ''; $tot_sep_com += $sep_com;?></div></td>

                <td><div align="right"><?= ($oct_com> 0) ? number_format($oct_com) : ''; $tot_oct_com += $oct_com;?></div></td>

               <td><div align="right"><?= ($nov_com> 0) ? number_format($nov_com) : ''; $tot_nov_com += $nov_com;?></div></td>
			   
			    <td><div align="right"><?= ($dec_com> 0) ? number_format($dec_com) : ''; $tot_dec_com += $dec_com;?></div></td>
				
				 <td><div align="right"><?= ($jan_com> 0) ? number_format($jan_com) : ''; $tot_jan_com += $jan_com;?></div></td>

                <td><div align="right"><?= ($feb_com> 0) ? number_format($feb_com) : ''; $tot_feb_com += $feb_com;?></div></td>

                <td><div align="right"><?= ($mar_com> 0) ? number_format($mar_com) : ''; $tot_mar_com += $mar_com;?></div></td>

                <td><div align="right"><?= ($apr_com> 0) ? number_format($apr_com) : ''; $tot_apr_com += $apr_com;?></div></td>

               <td><div align="right"><?= ($may_com> 0) ? number_format($may_com) : ''; $tot_may_com += $may_com;?></div></td>

               <td><div align="right"><?= ($jun_com> 0) ? number_format($jun_com) : ''; $tot_jun_com += $jun_com;?></div></td>
				

                <td><div align="right">
				<?= ($special_consideration > 0) ? number_format($special_consideration) : ''; $tot_special_consideration += $special_consideration?></div>

                </td>

                <td>
                  <div align="right">
                    <?
                    $net_convaince = $jan_com + $feb_com + $mar_com + $apr_com + $may_com + $jun_com + $jul_com + $aug_com + $sep_com +

                      $oct_com + $nov_com + $dec_com + $special_consideration;
                    echo number_format($net_convaince); ?>
                  </div>

                </td>

                <td><div align="right"><?= ($tax_deduction > 0) ? number_format($tax_deduction) : ''; $tot_tax_deduction += $tax_deduction?></div></td>

                <td>

              <div align="right"><?= ($advance_deduction > 0) ? number_format($advance_deduction) : ''; $tot_adv_deduction += $advance_deduction?></div>

                </td>

                <td>

                  <div align="right">
                    <?

                    $net_deduction = $conData->tax_deduction + $conData->advance_deduction;

                    $net_payment = $net_convaince - $net_deduction;

                    $total_payment = $total_payment + $net_payment;

                    $total_payment_in_word = round($total_payment);

                    echo number_format($net_payment);

                    ?>
                  </div>
                </td>
              </tr>
              <? $totalConvaince = $totalConvaince + $net_convaince; ?>

            <?  }  ?>
            <tr>
              <td colspan="5" align="right" style="font-weight:bold">Total:</td>
			  
			 
              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_jul_com > 0) ? number_format($tot_jul_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_aug_com > 0) ? number_format($tot_aug_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_sep_com > 0) ? number_format($tot_sep_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_oct_com > 0) ? number_format($tot_oct_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_nov_com > 0) ? number_format($tot_nov_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_dec_com > 0) ? number_format($tot_dec_com, 0) : ''; ?></td>
			  
			  
			   <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_jan_com > 0) ? number_format($tot_jan_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_feb_com > 0) ? number_format($tot_feb_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_mar_com > 0) ? number_format($tot_mar_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_apr_com > 0) ? number_format($tot_apr_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_may_com > 0) ? number_format($tot_may_com, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_jun_com > 0) ? number_format($tot_jun_com, 0) : ''; ?></td>


             

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_special_consideration > 0) ? number_format($tot_special_consideration, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($totalConvaince > 0) ? number_format($totalConvaince, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_tax_deduction > 0) ? number_format($tot_tax_deduction, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($tot_adv_deduction > 0) ? number_format($tot_adv_deduction, 0) : ''; ?></td>

              <td colspan="1" align="right" style="font-weight:bold"><?= ($total_payment > 0) ? number_format($total_payment, 0) : ''; ?></td>
            </tr>

          </tbody>

        </table>
        In Words:<? echo convertNumberMhafuz($total_payment_in_word); ?> <br>
        <br>
        <br>
        <div style="width:100%; margin:0 auto">
          <div style="float:left; width:20%; text-align:center">-------------------<br>
            Prepared By</div>
          <div style="float:left; width:20%; text-align:center">-------------------<br>
            Audit</div>
          <div style="float:left; width:20%; text-align:center">-------------------<br>
            Accounts</div>
          <div style="float:left; width:20%; text-align:center">-------------------<br>
            Managing Director</div>
          <div style="float:left; width:20%; text-align:center">-------------------<br>
            Chairman</div>
        </div>

        </tbody>
        </table>
        <br>
        <br>
        <br>

        <!--Sales Commission report end-->





      <?
      } elseif ($_POST['report'] == 4513) {  ?>

        <!-- ****************************************************    another report Start From Here    ******************************************** -->































        <table style="width:auto;margin: 0 auto; padding:0px;">















          <tr>















            <td style="text-align: center;border:0px solid white; font-family:bankgothic; font-weight:bold; font-size:18px;"><strong>AKSID CORPORATION LIMITED</strong></td>















          </tr>















          <tr>















            <td style="text-align: center;border:0px solid white; font-size:15px;"><strong>Allowance Summary Sheet</strong></td>















          </tr>















          <tr>















            <td style="text-align: center;border:0px solid white;"><?























                                                                    $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');























                                                                    $_SESSION['year'] = $_POST['year'];















                                                                    echo date_format($test, 'M-Y');















                                                                    if ($_POST['mon'] == 1) {







                                                                      $last_m = 12;







                                                                      $last_y = $_POST['year'] - 1;
                                                                    } else {







                                                                      $last_m = $_POST['mon'] - 1;







                                                                      $last_y = $_POST['year'];
                                                                    }















                                                                    ?>















            </td>















          </tr>















        </table>















        <table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">















          <input name="mon" value="<?= $_POST['mon'] ?>" type="hidden" />















          <input name="year" value="<?= $_POST['year'] ?>" type="hidden" />















          <tr bordercolor="#FFFFFF">















            <th width="100%" colspan="5" style="text-align:center">Total Allowances</th>















          </tr>















          <table width="70%" border="1" cellspacing="0" cellpadding="0" style="margin:0 auto;">















            <tr>















              <th width="80%" style="text-align:center">Job Location</th>







              <th width="20%" style="text-align:center">Last period's net allowances</th>







              <th width="20%" style="text-align:center">Current period's net allowances</th>



              <th width="10%" style="text-align:center">% Change</th>







              <th width="10%" style="text-align:center">Working days</th>



              <th width="10%" style="text-align:center">No. of Employees</th>



              <th width="10%" style="text-align:center">Average (per day)</th>



              <th width="10%" style="text-align:center">Average (per employee)</th>















            </tr>















            <?







            $jl_sql1 = 'select proj.PROJECT_ID,proj.PROJECT_DESC,a.working_days



from







monthly_allowances a,



personnel_basic_info b,



salary_info i,



project proj



where



a.PBI_ID = a.PBI_ID and



a.PBI_ID = i.PBI_ID and



a.PBI_ID = b.PBI_ID and



a.mon in ("' . $_POST['mon'] . '","' . $last_m . '") and



a.job_status="In Service" and



a.year in ("' . $_POST['year'] . '","' . $last_y . '") and



a.job_location = proj.PROJECT_ID GROUP BY proj.PROJECT_ID';















            $jl_query1 = mysql_query($jl_sql1);



            while ($jl1_result1 = mysql_fetch_object($jl_query1)) {







              $wo = find_a_field('monthly_allowances', 'working_days', 'mon="' . $_POST['mon'] . '" and year="' . $_POST['year'] . '"');











              $this_month_earning_proj = find_a_field('monthly_allowances', 'sum(food_bill+conveyance+site_visit+health+fule+others+overtime+ifter+hotel) as total_earning', 'mon="' . $_POST['mon'] . '" and



 year="' . $_POST['year'] . '" and job_location="' . $jl1_result1->PROJECT_ID . '" ');











              $last_month_earning_proj = find_a_field('monthly_allowances', 'sum(food_bill+conveyance+site_visit+health+fule+others+overtime+ifter+hotel) as total_earning', 'mon="' . $last_m . '" and year="' . $last_y . '" and job_location="' . $jl1_result1->PROJECT_ID . '" ');











              $total_project_emp = find_a_field('monthly_allowances', 'COUNT(DISTINCT PBI_ID)', 'mon="' . $_POST['mon'] . '" and



 year="' . $_POST['year'] . '" and job_location="' . $jl1_result1->PROJECT_ID . '" ');











              $last_month_project_name = find_a_field('monthly_allowances', 'job_location', 'mon="' . $last_m . '" and year="' . $last_y . '"');







              $avarage_per_day_project = $this_month_earning_proj / $total_project_emp;







              //$sqlll = 'select sum(food_bill+conveyance+site_visit+health+fule+others) as total_earning from monthly_allowances where mon="'.$last_m.'" and year="'.$last_y.'" and job_location="'.$jl1_result1->PROJECT_ID.'"';











              $last_month_earning_proj_total = $last_month_earning_proj_total + $last_month_earning_proj;







              //$last_proj_dff = $jl1_result1->total_earning-$last_month_earning_proj;



              //$dft = ($last_proj_dff*100)/$jl1_result1->total_earning;







              if ($this_month_earning_proj > 0 && $last_month_earning_proj == 0) {



                $dft = 100;
              } else {



                $dft = ($this_month_earning_proj / $last_month_earning_proj - 1) * 100;
              }



















              $dft_total += $dft;



























            ?>







              <tr style="margin:0px;">







                <td style="margin:0px; width:40%"><?= $jl1_result1->PROJECT_DESC ?>



                  <input type="hidden" name="job_location[]" value="<?= $jl1_result1->PROJECT_DESC ?>" />



                  <input type="hidden" name="tr_type[]" value="all_salary1" />



                </td>











                <td style="text-align:right;width:20%;"><?= number_format($last_month_earning_proj, 0) ?></td>











                <td align="right" style="width:60%">



                  <?= (number_format($this_month_earning_proj) > 0) ? number_format($this_month_earning_proj) : '';

                  $all_proj_salary_earning = $all_proj_salary_earning + $this_month_earning_proj; ?>



                  <input type="hidden" name="salary_amount[]" value="<?= $this_month_earning_proj ?>" />

                </td>







                <td style="text-align:right;width:20%;"><?= number_format($dft, 2) ?></td>











                <td style="text-align:right;width:20%;"><?= $wo; ?></td>



                <td style="text-align:right;width:20%;"><?= $total_project_emp;

                                                        $total_no_emp_pro += $total_project_emp; ?></td>



                <td style="text-align:right;width:20%;"><?= number_format($this_month_earning_proj / $wo); ?></td>



                <td style="text-align:right;width:20%;"><?= number_format($avarage_per_day_project); ?></td>











              </tr>











            <?  } ?>







































            <?







            $jl_sql = 'select DISTINCT  dept.DEPT_ID,dept.DEPT_DESC







from



monthly_allowances a,



personnel_basic_info b,



salary_info i,



department dept



where



a.PBI_ID = b.PBI_ID and



a.job_status="In Service" and



a.PBI_ID = i.PBI_ID and



a.mon in ("' . $_POST['mon'] . '","' . $last_m . '") and a.year in ("' . $_POST['year'] . '","' . $last_y . '") and



a.department = dept.DEPT_ID  and dept.DEPT_ID not in (3,13,16)  GROUP BY dept.DEPT_ID  ';











            $jl_query = mysql_query($jl_sql);



            while ($jl_result = mysql_fetch_object($jl_query)) {







              $last_month_earning_dept = find_a_field('monthly_allowances', 'sum(food_bill+conveyance+site_visit+health+fule+others+overtime+ifter+hotel) as total_earning', 'mon="' . $last_m . '" and year="' . $last_y . '" and department="' . $jl_result->DEPT_ID . '"  and department not in (3,13,16)');







              $this_month_earning_dept = find_a_field('monthly_allowances', 'sum(food_bill+conveyance+site_visit+health+fule+others+overtime+ifter+hotel) as total_earning', 'mon="' . $_POST['mon'] . '" and



year="' . $_POST['year'] . '" and department="' . $jl_result->DEPT_ID . '"  and department not in (3,13,16)');







              $total_deparment_emp = find_a_field('monthly_allowances', 'COUNT(DISTINCT PBI_ID)', 'mon="' . $_POST['mon'] . '" and



year="' . $_POST['year'] . '" and department="' . $jl_result->DEPT_ID . '"  and department not in (3,13,16)');







              $last_month_earning_dept_total = $last_month_earning_dept_total + $last_month_earning_dept;







              $avarage_per_day = $this_month_earning_dept / $total_deparment_emp;







              //$last_dept_dff = $this_month_earning_dept-$last_month_earning_dept;



              //$dft_dept = ($last_dept_dff*100)/$this_month_earning_dept;











              if ($this_month_earning_dept > 0 && $last_month_earning_dept == 0) {



                $dft = 100;
              } else {



                $dft_dept = ($this_month_earning_dept / $last_month_earning_dept - 1) * 100;
              }















              $dft_dept_total += $dft_dept;











































            ?>







              <tr>















                <td style="text-align:left; width:40%;"><?= $jl_result->DEPT_DESC; ?>



                  <input name="job_location[]" value="<?= $jl_result->DEPT_DESC; ?>" type="hidden" />



                  <input type="hidden" name="tr_type[]" value="all_salary2" />



                </td>











                <td style="text-align:right;width:20%"><?= number_format($last_month_earning_dept, 0) ?></td>















                <td align="right" style="width:60%;">



                  <?= (number_format($this_month_earning_dept) > 0) ? number_format($this_month_earning_dept) : '';

                  $all_dept_salary_earning = $all_dept_salary_earning + $this_month_earning_dept; ?>



                  <input type="hidden" name="salary_amount[]" value="<?= $jl_result->total_earning ?>">

                </td>











                <td style="text-align:right;width:20%"><?= number_format($dft_dept, 2) ?></td>











                <td style="text-align:right;width:20%;"><?= $wo; ?></td>



                <td style="text-align:right;width:20%;"><?= $total_deparment_emp;

                                                        $total_no_emp_dep += $total_deparment_emp; ?></td>



                <td style="text-align:right;width:20%;"><?= number_format($this_month_earning_dept / $wo) ?></td>



                <td style="text-align:right;width:20%;"><?= number_format($avarage_per_day); ?></td>











              </tr>



            <?



            }



            ?>























            <td align="left"><strong>Total</strong></td>











            <td style="text-align:right"><strong><?= number_format($last_total = $last_month_earning_dept_total + $last_month_earning_proj_total, 0) ?></strong></td>











            <td style="text-align:right"><strong>



                <?= (number_format($total_earning_cash_bank = $all_dept_salary_earning + $all_proj_salary_earning) > 0) ? number_format($total_earning_cash_bank = $all_dept_salary_earning + $all_proj_salary_earning) : ''; ?>



              </strong></td>



























            <td style="text-align:right"><strong>















                <? $dft_total = ($total_earning_cash_bank / $last_total - 1) * 100; //$dft_total=$dft_dept_total+$dft_total;







                echo number_format($dft_total, 2);







                ?>







              </strong></td>











            <td style="text-align:right;width:20%;"><?= $wo; ?></td>



            <td style="text-align:right;width:20%;"><?= $gross_emp = $total_no_emp_dep + $total_no_emp_pro ?></td>



            <td style="text-align:right;width:20%;"><?= number_format($total_earning_cash_bank / $wo); ?></td>



            <td style="text-align:right;width:20%;"><?= number_format($total_earning_cash_bank / $gross_emp); ?></td>















            </tr>















          </table><br>







          <!--************** CASH ALLOWNCE START **************-->







          <table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">



            <tr bordercolor="#FFFFFF">

              <th width="100%" colspan="3" style="text-align:center">Cash Allowances</th>

            </tr>







            <table width="70%" border="1" cellspacing="0" cellpadding="0" style="margin:0 auto;">



              <tr>



                <th width="60%" style="text-align:center">Job Location</th>



                <th width="40%" style="text-align:center"> Net Allowances</th>



              </tr>







              <?



              $jl_sql1 = 'select proj.PROJECT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning



from







monthly_allowances a,



 personnel_basic_info b,



project proj



where



a.PBI_ID = b.PBI_ID and



a.job_status="In Service" and



mon=' . $_POST['mon'] . ' and



year=' . $_POST['year'] . '  and







a.job_location = proj.PROJECT_ID and



a.bank_or_cash=1 GROUP BY proj.PROJECT_ID';











              $jl_query1 = mysql_query($jl_sql1);



              while ($jl_result1 = mysql_fetch_object($jl_query1)) {







              ?>







                <tr>







                  <td><?= $jl_result1->PROJECT_DESC ?><input name="job_location[]" value="<?= $jl_result1->PROJECT_DESC ?>" type="hidden" />



                    <input name="tr_type[]" value="cash_salary1" type="hidden" />



                  </td>











                  <td style="text-align:right"><?= (number_format($jl_result1->total_earning) > 0) ? number_format($jl_result1->total_earning) : '';

                                                $all_proj_salary2_earning = $all_proj_salary2_earning + $jl_result1->total_earning; ?>



                    <input name="salary_amount[]" value="<?= $jl_result1->total_earning ?>" type="hidden" />



                  </td>







                </tr>















              <?























              }































              ?>















              <?















              $jl_sql = 'select dept.DEPT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning



from







monthly_allowances a,



personnel_basic_info b,



department dept



where



a.PBI_ID = b.PBI_ID and



a.job_status="In Service" and



mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . '



and a.department = dept.DEPT_ID and dept.DEPT_ID not in



(3,13,16)  and a.bank_or_cash=1  GROUP BY dept.DEPT_ID  ';















              $jl_query = mysql_query($jl_sql);



              while ($jl_result = mysql_fetch_object($jl_query)) {







              ?>















                <tr>



                  <td style="text-align:left"><?= $jl_result->DEPT_DESC; ?><input name="job_location[]" value="<?= $jl_result->DEPT_DESC; ?>" type="hidden" /><input name="tr_type[]" value="cash_salary2" type="hidden" /></td>



                  <td style="text-align: right"><?= (number_format($jl_result->total_earning) > 0) ? number_format($jl_result->total_earning) : '';

                                                $all_dept_salary2_earning = $all_dept_salary2_earning + $jl_result->total_earning; ?>



                    <input name="salary_amount[]" value="<?= $jl_result->total_earning ?>" type="hidden" />

                  </td>







                  <?php /*?><td align="right"><?=number_format($jl_result->total_earning); $all_dept_salary2 = $all_dept_salary2 + $jl_result->total_earning;?><input name="salary_amount[]" value="<?=$jl_result->total_earning?>" type="hidden" /></td><?php */ ?>



                </tr>



              <?



              }



              ?>















              <tr>















                <td align="left"><strong>Total</strong></td>















                <td style="text-align:right"><strong>















                    <?= (number_format($tot_dept_proj_earning = ($all_dept_salary2_earning + $all_proj_salary2_earning)) > 0) ? number_format($tot_dept_proj_earning = ($all_dept_salary2_earning + $all_proj_salary2_earning)) : ''; ?>















                  </strong></td>















                <?php /*?><td style="text-align:right"><strong> <?=number_format($tot_dept_proj=($all_dept_salary2+$all_proj_salary2));?> </strong></td><?php */ ?>















              </tr>















            </table>















          </table><br>







          <!-- *************** BKASH PART START FROM HERE  ################-->



          <table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">







            <tr>



              <th width="100%" colspan="3" border="0" style="text-align:center">Bkash Allowances</th>



            </tr>



          </table>











          <table width="70%" border="1" cellspacing="0" cellpadding="0" style="margin:0 auto; padding:0px;">



            <tr>

              <th width="60%" style="text-align:center">Job Location</th>



              <th width="40%" style="text-align:center"> Net Allowances</th>







            </tr>











            <?



            $bkash_sql1 = 'select proj.PROJECT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning from



monthly_allowances a,



personnel_basic_info b,



project proj



where



a.PBI_ID = b.PBI_ID and



a.job_status="In Service" and



mon=' . $_POST['mon'] . ' and







year=' . $_POST['year'] . '  and







a.job_location = proj.PROJECT_ID and



a.bank_or_cash IN("6")  GROUP BY proj.PROJECT_ID';



















            $bks_query1 = mysql_query($bkash_sql1);



            while ($bks_result1 = mysql_fetch_object($bks_query1)) {















            ?>







              <tr>







                <td style="padding:3px;"><?= $bks_result1->PROJECT_DESC ?><input name="job_location[]" value="<?= $bks_result1->PROJECT_DESC ?>" type="hidden" />



                  <span style="margin:0px;"><input name="tr_type[]" value="bank_salary1" type="hidden" /></span>

                </td>







                <td style="text-align:right;">



                  <?= (number_format($bks_result1->total_earning) > 0) ? number_format($bks_result1->total_earning) : '';

                  $all_proj_bkash_earning = $all_proj_bkash_earning + $bks_result1->total_earning; ?>



                  <input name="salary_amount[]" value="<?= $bks_result1->total_earning; ?>" type="hidden" />

                </td>







              </tr>







            <?



            }



            ?>











            <?



            $jl_sql = 'select dept.DEPT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning



from monthly_allowances a,



personnel_basic_info b,



department dept



where a.PBI_ID = b.PBI_ID and a.job_status="In Service" and



mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . '  and a.department = dept.DEPT_ID  and dept.DEPT_ID not in (3,13,16)  and a.bank_or_cash  IN("6")  GROUP BY dept.DEPT_ID  ';







            $jl_query = mysql_query($jl_sql);



            while ($jl_result = mysql_fetch_object($jl_query)) {



            ?>







              <tr>



                <td><?= $jl_result->DEPT_DESC; ?>



                  <input name="job_location[]" value="<?= $jl_result->DEPT_DESC ?>" type="hidden" />



                  <input type="hidden" name="tr_type[]" value="bank_salary2" />



                </td>







                <td style="text-align: right"><input name="salary_amount[]" value="<?= $jl_result->total_earning ?>" type="hidden" />



                  <?= (number_format($jl_result->total_earning) > 0) ? number_format($jl_result->total_earning) : '';

                  $all_dept_bkash_earning = $all_dept_bkash_earning + $jl_result->total_earning; ?>



                </td>







              </tr>







            <?







            }



















            ?>











            <tr>



              <td><strong>Total</strong></td>



              <td style="text-align:right"><strong>



                  <?= (number_format($tot_dept_bkash3_earning = ($all_dept_bkash_earning + $all_proj_bkash_earning)) > 0) ? number_format($tot_dept_bkash3_earning = ($all_dept_bkash_earning + $all_proj_bkash_earning)) : ''; ?>



                </strong></td>



            </tr>















            <tr>







              <td><strong><span style="float:right; font-weight:bold;">Grand Total :</span></strong></td>







              <td><strong><span style="float:right; font-weight:bold;">



                    <?= (number_format($grandTotal = ($tot_dept_bkash3_earning + $tot_dept_bkash_earning)) > 0) ? number_format($grandTotal = ($tot_dept_bkash3_earning + $tot_dept_bkash_earning)) : ''; ?>



                  </span></strong></td>











            </tr>















          </table>















          <!-- *************** NAGAD PART START FROM HERE  ################-->



          <?php /*?><table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">







<tr>



<th width="100%" colspan="3" border="0" style="text-align:center">Nagad Allowances</th>



</tr>



</table>











<table width="70%" border="1" cellspacing="0" cellpadding="0" style="margin:0 auto; padding:0px;">



<tr><th width="60%" style="text-align:center">Job Location</th>



<th width="40%" style="text-align:center"> Net Allowances</th>







</tr>











<?



$nagad_sql1 = 'select proj.PROJECT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning from



monthly_allowances a,



personnel_basic_info b,



project proj



where



a.PBI_ID = b.PBI_ID and



a.job_status="In Service" and



mon='.$_POST['mon'].' and







year='.$_POST['year'].'  and







a.job_location = proj.PROJECT_ID and



a.bank_or_cash IN("7")  GROUP BY proj.PROJECT_ID';



















$nagad_query1= mysql_query($nagad_sql1 );



while($nagad_result1 = mysql_fetch_object($nagad_query1)){















?>







<tr>







<td style="padding:3px;"><?=$nagad_result1->PROJECT_DESC?><input name="job_location[]" value="<?=$nagad_result1->PROJECT_DESC?>" type="hidden" />



<span style="margin:0px;"><input name="tr_type[]" value="bank_salary1" type="hidden" /></span></td>







<td style="text-align:right;">



<?=(number_format($nagad_result1->total_earning)>0)? number_format($nagad_result1->total_earning):''; $all_proj_nagad_earning =$all_proj_nagad_earning + $nagad_result1->total_earning;?>



<input name="salary_amount[]" value="<?=$nagad_result1->total_earning;?>" type="hidden" /></td>







</tr>







<?



}



?>











<?



$jl_sql = 'select dept.DEPT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning



from monthly_allowances a,



personnel_basic_info b,



department dept



where a.PBI_ID = b.PBI_ID and a.job_status="In Service" and



mon='.$_POST['mon'].' and year='.$_POST['year'].'  and a.department = dept.DEPT_ID  and dept.DEPT_ID not in (3,13,16)  and a.bank_or_cash  IN("7")  GROUP BY dept.DEPT_ID  ';







$jl_query= mysql_query($jl_sql );



while($jl_result = mysql_fetch_object($jl_query)){



?>







<tr>



<td><?=$jl_result->DEPT_DESC;?>



<input name="job_location[]" value="<?=$jl_result->DEPT_DESC?>" type="hidden" />



<input type="hidden" name="tr_type[]" value="bank_salary2" />



</td>







<td style="text-align: right"><input name="salary_amount[]" value="<?=$jl_result->total_earning?>" type="hidden" />



<?=(number_format($jl_result->total_earning)>0)? number_format($jl_result->total_earning):'' ; $all_dept_nagad_earning = $all_dept_nagad_earning + $jl_result->total_earning;?>



</td>







</tr>







<?







}



















?>











<tr>



<td><strong>Total</strong></td>



<td style="text-align:right"><strong>



<?=(number_format($tot_dept_nagad_earning=($all_dept_nagad_earning+$all_proj_nagad_earning))>0)? number_format($tot_dept_nagad_earning=($all_dept_nagad_earning+$all_proj_nagad_earning)):'';?>



</strong></td>



</tr>















<tr>







<td><strong><span style="float:right; font-weight:bold;">Grand Total :</span></strong></td>







<td><strong><span style="float:right; font-weight:bold;">



<?=(number_format($grandTotal=($tot_dept_nagad_earning))>0)? number_format($grandTotal=($tot_dept_nagad_earning)):'';?>



 </span></strong></td>











</tr>















  </table><?php */ ?>















          <!-- *************** BANK PART START FROM HERE  ################-->















          <table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">















            <tr>















              <th width="100%" colspan="3" border="0" style="text-align:center">Bank Allowances</th>















            </tr>















          </table>















          <table width="70%" border="1" cellspacing="0" cellpadding="0" style="margin:0 auto; padding:0px;">















            <tr>















              <th width="60%" style="text-align:center">Job Location</th>















              <th width="40%" style="text-align:center"> Net Allowances</th>















              <!--<th width="20%" style="text-align:center"> Net Payable Salary</th>-->















            </tr>















            <?



















            $jl_sql1 = 'select proj.PROJECT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning from



monthly_allowances a,



personnel_basic_info b,



project proj



where



a.PBI_ID = b.PBI_ID and



a.job_status="In Service" and



mon=' . $_POST['mon'] . ' and







year=' . $_POST['year'] . '  and







a.job_location = proj.PROJECT_ID and



a.bank_or_cash NOT IN("1","6","7")  GROUP BY proj.PROJECT_ID';



















            $jl_query1 = mysql_query($jl_sql1);



            while ($jl_result1 = mysql_fetch_object($jl_query1)) {















            ?>







              <tr>







                <td style="padding:3px;"><?= $jl_result1->PROJECT_DESC ?><input name="job_location[]" value="<?= $jl_result1->PROJECT_DESC ?>" type="hidden" />



                  <span style="margin:0px;"><input name="tr_type[]" value="bank_salary1" type="hidden" /></span>

                </td>







                <td style="text-align:right;">



                  <?= (number_format($jl_result1->total_earning) > 0) ? number_format($jl_result1->total_earning) : '';

                  $all_proj_salary3_earning = $all_proj_salary3_earning + $jl_result1->total_earning; ?>



                  <input name="salary_amount[]" value="<?= $jl_result1->total_earning; ?>" type="hidden" />

                </td>







              </tr>







            <?



            }



            ?>











            <?



            $jl_sql = 'select dept.DEPT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning



from monthly_allowances a,



personnel_basic_info b,



department dept



where a.PBI_ID = b.PBI_ID and a.job_status="In Service" and



mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . '  and a.department = dept.DEPT_ID  and dept.DEPT_ID not in (3,13,16)  and a.bank_or_cash NOT IN("1","6","7")  GROUP BY dept.DEPT_ID  ';







            $jl_query = mysql_query($jl_sql);



            while ($jl_result = mysql_fetch_object($jl_query)) {



            ?>







              <tr>



                <td><?= $jl_result->DEPT_DESC; ?>



                  <input name="job_location[]" value="<?= $jl_result->DEPT_DESC ?>" type="hidden" />



                  <input type="hidden" name="tr_type[]" value="bank_salary2" />



                </td>







                <td style="text-align: right"><input name="salary_amount[]" value="<?= $jl_result->total_earning ?>" type="hidden" />



                  <?= (number_format($jl_result->total_earning) > 0) ? number_format($jl_result->total_earning) : '';

                  $all_dept_salary3_earning = $all_dept_salary3_earning + $jl_result->total_earning; ?>



                </td>







              </tr>







            <?







            }



















            ?>











            <tr>



              <td><strong>Total</strong></td>



              <td style="text-align:right"><strong>



                  <?= (number_format($tot_dept_proj3_earning = ($all_dept_salary3_earning + $all_proj_salary3_earning)) > 0) ?



                    number_format($tot_dept_proj3_earning = ($all_dept_salary3_earning + $all_proj_salary3_earning)) : ''; ?>



                </strong></td>



            </tr>















            <tr>







              <td><strong><span style="float:right; font-weight:bold;">Grand Total :</span></strong></td>







              <td><strong><span style="float:right; font-weight:bold;">



                    <?= (number_format($grandTotal = ($tot_dept_proj3_earning + $tot_dept_proj_earning + $tot_dept_bkash3_earning)) > 0) ?



                      number_format($grandTotal = ($tot_dept_proj3_earning + $tot_dept_proj_earning + $tot_dept_bkash3_earning)) : ''; ?>



                  </span></strong></td>











            </tr>















          </table>















          <p></p>















          <p></p>















          <center>















            <div style="font-size:10px; font-weight:bold; width:60%;"> In Word :







              <?











              echo convertNumberMhafuz($grandTotal);















              ?>















            </div>















          </center>















          <table width="100%" border="0" cellpadding="0" cellspacing="0">



            <tr>



              <td style="text-decoration:none; border-bottom:0px;">

                <div align="center">







                  <?php



                  $check_sql = 'select 1 from salary_lock where month=' . $_POST['mon'] . ' and year=' . $_POST['year'] . ' and tr_type="all_salary2"';



                  $check_query2 = mysql_query($check_sql2);











                  $last_check2 = mysql_num_rows($check_query2);



                  if ($last_check2 > 0) { ?>















                    <!--<input name="lock" id="lock" type="submit" value="LOCKED" />-->















                  <?php } else { ?>















                    <!--<input name="lock" id="lock" type="submit" value="LOCK" />-->















                  <?php  }







                  ?>















                </div>

              </td>















            </tr>















          </table>















          <br>















          </br>















          <div style="width:70%; margin:0 auto">















            <div style="float:left; width:20%; text-align:center; font-size:12px;">-------------<br>















              Prepared By</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">------------<br>















              Audit</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">------------<br>















              Accounts</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">-----------------<br>















              Managing Director</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">-----------<br>















              Chairman</div>















          </div>















          <p>&nbsp; </p>















          <p>&nbsp;</p>







































          <!-- cash allowncess summary sheet -->















        <? } elseif ($_POST['report'] == 4514) {  ?>



























          <table style="width:auto;margin: 0 auto; padding:0px;">















            <tr>















              <td style="text-align: center;border:0px solid white; font-family:bankgothic; font-weight:bold; font-size:18px;"><strong>AKSID CORPORATION LIMITED</strong></td>















            </tr>















            <tr>















              <td style="text-align: center;border:0px solid white; font-size:15px;"><strong>Allowance Summary Sheet</strong></td>















            </tr>















            <tr>















              <td style="text-align: center;border:0px solid white;"><?























                                                                      $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');























                                                                      $_SESSION['year'] = $_POST['year'];















                                                                      echo date_format($test, 'M-Y');















                                                                      if ($_POST['mon'] == 1) {







                                                                        $last_m = 12;







                                                                        $last_y = $_POST['year'] - 1;
                                                                      } else {







                                                                        $last_m = $_POST['mon'] - 1;







                                                                        $last_y = $_POST['year'];
                                                                      }















                                                                      ?>















              </td>















            </tr>















          </table>



























          <table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">















            <tr bordercolor="#FFFFFF">















              <th width="100%" colspan="3" style="text-align:center">Cash Allowances</th>















            </tr>















            <table width="70%" border="1" cellspacing="0" cellpadding="0" style="margin:0 auto;">















              <tr>















                <th width="60%" style="text-align:center">Job Location</th>















                <th width="40%" style="text-align:center"> Net Allowances</th>















                <!--<th width="20%" style="text-align:center"> Net Payable Allowances</th>-->















              </tr>















              <?







              $jl_sql1 = 'select proj.PROJECT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning



from







monthly_allowances a,



 personnel_basic_info b,



project proj



where



a.PBI_ID = b.PBI_ID and



mon=' . $_POST['mon'] . ' and



year=' . $_POST['year'] . '  and







a.job_location = proj.PROJECT_ID and



a.bank_or_cash=1 GROUP BY proj.PROJECT_ID';











              $jl_query1 = mysql_query($jl_sql1);



              while ($jl_result1 = mysql_fetch_object($jl_query1)) {























              ?>















                <tr>















                  <td><?= $jl_result1->PROJECT_DESC ?>















                    <input name="job_location[]" value="<?= $jl_result1->PROJECT_DESC ?>" type="hidden" />















                    <input name="tr_type[]" value="cash_salary1" type="hidden" />















                  </td>















                  <td style="text-align:right"><?= (number_format($jl_result1->total_earning) > 0) ? number_format($jl_result1->total_earning) : '';

                                                $all_proj_salary2_earning = $all_proj_salary2_earning + $jl_result1->total_earning; ?>















                    <input name="salary_amount[]" value="<?= $jl_result1->total_earning ?>" type="hidden" />















                  </td>



























                </tr>















              <?























              }































              ?>















              <?















              $jl_sql = 'select dept.DEPT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning



from







monthly_allowances a,



personnel_basic_info b,



department dept



where



a.PBI_ID = b.PBI_ID and



mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . '



and a.department = dept.DEPT_ID and dept.DEPT_ID not in



(3,13,16)  and a.bank_or_cash=1  GROUP BY dept.DEPT_ID  ';















              $jl_query = mysql_query($jl_sql);



              while ($jl_result = mysql_fetch_object($jl_query)) {







              ?>















                <tr>



                  <td style="text-align:left"><?= $jl_result->DEPT_DESC; ?><input name="job_location[]" value="<?= $jl_result->DEPT_DESC; ?>" type="hidden" /><input name="tr_type[]" value="cash_salary2" type="hidden" /></td>



                  <td style="text-align: right"><?= (number_format($jl_result->total_earning) > 0) ? number_format($jl_result->total_earning) : '';

                                                $all_dept_salary2_earning = $all_dept_salary2_earning + $jl_result->total_earning; ?>



                    <input name="salary_amount[]" value="<?= $jl_result->total_earning ?>" type="hidden" />

                  </td>







                  <?php /*?><td align="right"><?=number_format($jl_result->total_earning); $all_dept_salary2 = $all_dept_salary2 + $jl_result->total_earning;?><input name="salary_amount[]" value="<?=$jl_result->total_earning?>" type="hidden" /></td><?php */ ?>



                </tr>



              <?



              }



              ?>















              <tr>















                <td align="left"><strong>Total</strong></td>















                <td style="text-align:right"><strong>















                    <?= (number_format($tot_dept_proj_earning = ($all_dept_salary2_earning + $all_proj_salary2_earning)) > 0) ? number_format($tot_dept_proj_earning = ($all_dept_salary2_earning + $all_proj_salary2_earning)) : ''; ?>















                  </strong></td>















                <?php /*?><td style="text-align:right"><strong> <?=number_format($tot_dept_proj=($all_dept_salary2+$all_proj_salary2));?> </strong></td><?php */ ?>















              </tr>















            </table>















          </table><br>



























          <p></p>















          <p></p>















          <center>















            <div style="font-size:10px; font-weight:bold; width:60%;"> In Word :







              <?











              echo convertNumberMhafuz($tot_dept_proj_earning);















              ?>















            </div>















          </center>















          <table width="100%" border="0" cellpadding="0" cellspacing="0">



            <tr>



              <td style="text-decoration:none; border-bottom:0px;">

                <div align="center">







                  <?php



                  $check_sql = 'select 1 from salary_lock where month=' . $_POST['mon'] . ' and year=' . $_POST['year'] . ' and tr_type="all_salary2"';



                  $check_query2 = mysql_query($check_sql2);











                  $last_check2 = mysql_num_rows($check_query2);



                  if ($last_check2 > 0) { ?>















                    <!--<input name="lock" id="lock" type="submit" value="LOCKED" />-->















                  <?php } else { ?>















                    <!--<input name="lock" id="lock" type="submit" value="LOCK" />-->















                  <?php  }







                  ?>















                </div>

              </td>















            </tr>















          </table>















          <br>















          </br>















          <div style="width:70%; margin:0 auto">















            <div style="float:left; width:20%; text-align:center; font-size:12px;">-------------<br>















              Prepared By</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">------------<br>















              Audit</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">------------<br>















              Accounts</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">-----------------<br>















              Managing Director</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">-----------<br>















              Chairman</div>















          </div>















          <p>&nbsp; </p>















          <p>&nbsp;</p>



















          <!--Cash Allownces report details -->































          <!-- Bkash allowncess summary sheet -->















        <? } elseif ($_POST['report'] == 4516) {  ?>



























          <table style="width:auto;margin: 0 auto; padding:0px;">















            <tr>















              <td style="text-align: center;border:0px solid white; font-family:bankgothic; font-weight:bold; font-size:18px;"><strong>AKSID CORPORATION LIMITED</strong></td>















            </tr>















            <tr>















              <td style="text-align: center;border:0px solid white; font-size:15px;"><strong>Allowance Summary Sheet</strong></td>















            </tr>















            <tr>















              <td style="text-align: center;border:0px solid white;"><?























                                                                      $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');























                                                                      $_SESSION['year'] = $_POST['year'];















                                                                      echo date_format($test, 'M-Y');















                                                                      if ($_POST['mon'] == 1) {







                                                                        $last_m = 12;







                                                                        $last_y = $_POST['year'] - 1;
                                                                      } else {







                                                                        $last_m = $_POST['mon'] - 1;







                                                                        $last_y = $_POST['year'];
                                                                      }















                                                                      ?>















              </td>















            </tr>















          </table>



























          <table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">















            <tr bordercolor="#FFFFFF">















              <th width="100%" colspan="3" style="text-align:center">BKASH Allowances</th>















            </tr>















            <table width="70%" border="1" cellspacing="0" cellpadding="0" style="margin:0 auto;">















              <tr>















                <th width="60%" style="text-align:center">Job Location</th>















                <th width="40%" style="text-align:center"> Net Allowances</th>















                <!--<th width="20%" style="text-align:center"> Net Payable Allowances</th>-->















              </tr>















              <?







              $jl_sql1 = 'select proj.PROJECT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning



from







monthly_allowances a,



 personnel_basic_info b,



project proj



where



a.PBI_ID = b.PBI_ID and



mon=' . $_POST['mon'] . ' and



year=' . $_POST['year'] . '  and







a.job_location = proj.PROJECT_ID and



a.bank_or_cash=6 GROUP BY proj.PROJECT_ID';











              $jl_query1 = mysql_query($jl_sql1);



              while ($jl_result1 = mysql_fetch_object($jl_query1)) {























              ?>















                <tr>















                  <td><?= $jl_result1->PROJECT_DESC ?>















                    <input name="job_location[]" value="<?= $jl_result1->PROJECT_DESC ?>" type="hidden" />















                    <input name="tr_type[]" value="cash_salary1" type="hidden" />















                  </td>















                  <td style="text-align:right"><?= (number_format($jl_result1->total_earning) > 0) ? number_format($jl_result1->total_earning) : '';

                                                $all_proj_salary2_earning = $all_proj_salary2_earning + $jl_result1->total_earning; ?>















                    <input name="salary_amount[]" value="<?= $jl_result1->total_earning ?>" type="hidden" />















                  </td>



























                </tr>















              <?























              }































              ?>















              <?















              $jl_sql = 'select dept.DEPT_DESC,sum(a.food_bill+a.conveyance+a.site_visit+a.health+a.fule+a.others+a.overtime+a.ifter+a.hotel) as total_earning



from







monthly_allowances a,



personnel_basic_info b,



department dept



where



a.PBI_ID = b.PBI_ID and



mon=' . $_POST['mon'] . ' and year=' . $_POST['year'] . '



and a.department = dept.DEPT_ID and dept.DEPT_ID not in



(3,13,16)  and a.bank_or_cash=6  GROUP BY dept.DEPT_ID  ';















              $jl_query = mysql_query($jl_sql);



              while ($jl_result = mysql_fetch_object($jl_query)) {







              ?>















                <tr>



                  <td style="text-align:left"><?= $jl_result->DEPT_DESC; ?><input name="job_location[]" value="<?= $jl_result->DEPT_DESC; ?>" type="hidden" /><input name="tr_type[]" value="cash_salary2" type="hidden" /></td>



                  <td style="text-align: right"><?= (number_format($jl_result->total_earning) > 0) ? number_format($jl_result->total_earning) : '';

                                                $all_dept_salary2_earning = $all_dept_salary2_earning + $jl_result->total_earning; ?>



                    <input name="salary_amount[]" value="<?= $jl_result->total_earning ?>" type="hidden" />

                  </td>







                  <?php /*?><td align="right"><?=number_format($jl_result->total_earning); $all_dept_salary2 = $all_dept_salary2 + $jl_result->total_earning;?><input name="salary_amount[]" value="<?=$jl_result->total_earning?>" type="hidden" /></td><?php */ ?>



                </tr>



              <?



              }



              ?>















              <tr>















                <td align="left"><strong>Total</strong></td>















                <td style="text-align:right"><strong>















                    <?= (number_format($tot_dept_proj_earning = ($all_dept_salary2_earning + $all_proj_salary2_earning)) > 0) ? number_format($tot_dept_proj_earning = ($all_dept_salary2_earning + $all_proj_salary2_earning)) : ''; ?>















                  </strong></td>















                <?php /*?><td style="text-align:right"><strong> <?=number_format($tot_dept_proj=($all_dept_salary2+$all_proj_salary2));?> </strong></td><?php */ ?>















              </tr>















            </table>















          </table><br>



























          <p></p>















          <p></p>















          <center>















            <div style="font-size:10px; font-weight:bold; width:60%;"> In Word :







              <?











              echo convertNumberMhafuz($tot_dept_proj_earning);















              ?>















            </div>















          </center>















          <table width="100%" border="0" cellpadding="0" cellspacing="0">



            <tr>



              <td style="text-decoration:none; border-bottom:0px;">

                <div align="center">







                  <?php



                  $check_sql = 'select 1 from salary_lock where month=' . $_POST['mon'] . ' and year=' . $_POST['year'] . ' and tr_type="all_salary2"';



                  $check_query2 = mysql_query($check_sql2);











                  $last_check2 = mysql_num_rows($check_query2);



                  if ($last_check2 > 0) { ?>















                    <!--<input name="lock" id="lock" type="submit" value="LOCKED" />-->















                  <?php } else { ?>















                    <!--<input name="lock" id="lock" type="submit" value="LOCK" />-->















                  <?php  }







                  ?>















                </div>

              </td>















            </tr>















          </table>















          <br>















          </br>















          <div style="width:70%; margin:0 auto">















            <div style="float:left; width:20%; text-align:center; font-size:12px;">-------------<br>















              Prepared By</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">------------<br>















              Audit</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">------------<br>















              Accounts</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">-----------------<br>















              Managing Director</div>















            <div style="float:left; width:20%; text-align:center; font-size:12px;">-----------<br>















              Chairman</div>















          </div>















          <p>&nbsp; </p>















          <p>&nbsp;</p>



















          <!--BKASH Allownces report details -->











        <? } elseif ($_POST['report'] == 4515) {  ?>







          <table width="100%" cellspacing="0" cellpadding="2" border="0">



            <thead>



              <tr>



                <td style="border:0px;" colspan="28"><?= $str ?></td>



              </tr>



              <tr>



                <td style="border:0px;" colspan="28">

                  <div align="center" style="font-size:20px;">Cash Allowances Sheet for the Period of



                    <? $d = strtotime("-1 Months");



                    echo date("M-Y", $d) . ""; ?>



                    To



                    <? $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');

                    echo date_format($test, 'M-Y') . '<br>' . $depts;  ?>



                  </div>

                </td>



              </tr>



              <tr>



                <td style="border:0px;" colspan="28"><?= $strTime ?></td>



              </tr>



              <tr>



                <th rowspan="2">

                  <div align="center">S/L</div>

                </th>



                <th rowspan="2">

                  <div align="center">ID</div>

                </th>



                <th rowspan="2">

                  <div align="center">Name</div>

                </th>



                <th rowspan="2">

                  <div align="center">Designation</div>

                </th>



                <th rowspan="2">

                  <div align="center">Department</div>

                </th>



                <th rowspan="2">

                  <div align="center">Joining Date</div>

                </th>



                <th colspan="9">

                  <div align="center">Allowances</div>

                </th>



                <th rowspan="2">

                  <div align="center">Total Allowances</div>

                </th>



                <th rowspan="2">

                  <div align="center">Bank A/C</div>

                </th>



                <th rowspan="2">

                  <div align="center">Payroll Card</div>

                </th>



                <th rowspan="2">

                  <div align="center">Remarks</div>

                </th>



              </tr>



              <tr>



                <th>

                  <div align="center">Food</div>

                </th>



                <th>

                  <div align="center">Conveyance</div>

                </th>



                <th>

                  <div align="center">Site Visit</div>

                </th>



                <th>

                  <div align="center">Health</div>

                </th>



                <th>

                  <div align="center">Fuel</div>

                </th>







                <th>

                  <div align="center">Overtime</div>

                </th>







                <th>

                  <div align="center">Ifter</div>

                </th>



                <th>

                  <div align="center">Hotel</div>

                </th>



                <th>

                  <div align="center">Others</div>

                </th>



              </tr>



            </thead>



            <tbody>



              <?















              if ($_POST['JOB_LOCATION'] != '')







                $cv_con .= ' and t.job_location ="' . $_POST['JOB_LOCATION'] . '"';







              if ($_POST['department'] != '')







                $cv_con .= ' and t.department ="' . $_POST['department'] . '"';



























              $sqldd = 'select t.PBI_ID,a.PBI_CODE,a.PBI_NAME,desg.DESG_DESC,dept.DEPT_DESC,date_format(e.ESSENTIAL_JOINING_DATE,"%d-%b-%y") as joining_date,t.food_bill,t.conveyance,



t.site_visit,t.health,t.fule,t.overtime,t.hotel,t.others,i.card_no,i.cash,(t.food_bill+t.conveyance+t.site_visit+t.health+t.fule+t.overtime+t.others+t.ifter+t.hotel) as amount,t.remarks







from







monthly_allowances t,







personnel_basic_info a,







salary_info i,







designation desg,







department dept,



essential_info e















where











t.bank_or_cash=1 and



i.PBI_ID = t.PBI_ID and







t.designation=desg.DESG_ID and







t.department=dept.DEPT_ID and







t.PBI_ID=e.PBI_ID and























t.mon=' . $_POST['mon'] . ' and







t.year=' . $_POST['year'] . ' and







t.PBI_ID=a.PBI_ID ' . $cv_con . '







order by a.PBI_NAME asc';























              $querydd = mysql_query($sqldd);







              ini_set('memory_limit', '-1');







              while ($conData = mysql_fetch_object($querydd)) {







                $entry_by = $conData->entry_by;







                $year = date('Y');























































              ?>



                <tr>



                  <td><?= ++$s ?></td>



                  <td><?= $conData->PBI_CODE ?></td>



                  <td nowrap="nowrap"><?= $conData->PBI_NAME ?></td>



                  <td><?= $conData->DESG_DESC ?></td>



                  <td>

                    <div align="">



                      <?= $conData->DEPT_DESC ?>



                    </div>

                  </td>



                  <td>

                    <div align="center">



                      <?= $conData->joining_date ?>



                    </div>

                  </td>



                  <td>

                    <div align="right"><?= ($conData->food_bill > 0) ? number_format($conData->food_bill) : '';

                                        $totFod += $conData->food_bill ?></div>

                  </td>



                  <td>

                    <div align="right"><?= ($conData->conveyance > 0) ? number_format($conData->conveyance) : '';

                                        $totCon += $conData->conveyance ?></div>

                  </td>



                  <td>

                    <div align="right">



                      <?= ($conData->site_visit > 0) ? number_format($conData->site_visit) : '';

                      $totSite += $conData->site_visit ?>



                    </div>

                  </td>



                  <td>

                    <div align="right">



                      <?= ($conData->health > 0) ? number_format($conData->health) : '';

                      $totHealth += $conData->health ?>



                    </div>

                  </td>



                  <td>

                    <div align="right">



                      <?= ($conData->fule > 0) ? number_format($conData->fule) : '';

                      $totFule += $conData->fule ?>



                    </div>

                  </td>















                  <td>

                    <div align="right">



                      <?= ($conData->overtime > 0) ? number_format($conData->overtime) : '';

                      $totOvertime += $conData->overtime ?>



                    </div>

                  </td>











                  <td>

                    <div align="right">



                      <?= ($conData->ifter > 0) ? number_format($conData->ifter) : '';

                      $totIfter += $conData->ifter ?>



                    </div>

                  </td>











                  <td>

                    <div align="right">



                      <?= ($conData->hotel > 0) ? number_format($conData->hotel) : '';

                      $totHotel += $conData->hotel ?>



                    </div>

                  </td>











                  <td>

                    <div align="right">



                      <?= ($conData->others > 0) ? number_format($conData->others) : '';

                      $totOthers += $conData->others ?>



                    </div>

                  </td>















                  <td>

                    <div align="right">



                      <?= number_format($conData->amount); ?>



                    </div>

                  </td>











                  <td>

                    <div align="center">



                      <?= $conData->cash ?>



                    </div>

                  </td>



                  <td>

                    <div align="center">



                      <?= $conData->card_no ?>



                    </div>

                  </td>



                  <td><?= $conData->remarks ?></td>



                </tr>



                <? $totalConvaince += $conData->food_bill + $conData->conveyance + $conData->site_visit + $conData->health + $conData->fule + $conData->others + $conData->overtime; ?>



              <?  }  ?>



              <tr>



                <td colspan="6" align="right" style="font-weight:bold">Total:</td>



                <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totFod > 0) ? number_format($totFod, 0) : ''; ?></td>



                <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totCon > 0) ? number_format($totCon, 0) : ''; ?></td>



                <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totSite > 0) ? number_format($totSite, 0) : ''; ?></td>



                <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totHealth > 0) ? number_format($totHealth, 0) : ''; ?></td>



                <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totFule > 0) ? number_format($totFule, 0) : ''; ?></td>



                <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totOvertime > 0) ? number_format($totOvertime, 0) : ''; ?></td>



                <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totIfter > 0) ? number_format($totIfter, 0) : ''; ?></td>



                <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totHotel > 0) ? number_format($totHotel, 0) : ''; ?></td>



                <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totOthers > 0) ? number_format($totOthers, 0) : ''; ?></td>



                <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totalConvaince > 0) ? number_format($totalConvaince, 0) : ''; ?></td>



                <td colspan="3"></td>



              </tr>



            </tbody>



          </table>



          In Words:<? echo convertNumberMhafuz($totalConvaince); ?> <br>



          <br>



          <br>



          <div style="width:100%; margin:0 auto">



            <div style="float:left; width:20%; text-align:center">-------------------<br>



              Prepared By</div>



            <div style="float:left; width:20%; text-align:center">-------------------<br>



              Audit</div>



            <div style="float:left; width:20%; text-align:center">-------------------<br>



              Accounts</div>



            <div style="float:left; width:20%; text-align:center">-------------------<br>



              Managing Director</div>



            <div style="float:left; width:20%; text-align:center">-------------------<br>



              Chairman</div>



          </div>







          <?php /*?><a href="export_primary.php?export=yes&year=<?=$_REQUEST['year']?>&mon=<?=$_POST['mon']?>" target="_blank">  Export</a><?php */ ?>











          </tbody>



        </table>



        <br>



        <br>



        <br>











































        <!--BKASH Allownces report details -->











      <? } elseif ($_POST['report'] == 4517) {  ?>







        <table width="100%" cellspacing="0" cellpadding="2" border="0">



          <thead>



            <tr>



              <td style="border:0px;" colspan="28"><?= $str ?></td>



            </tr>



            <tr>



              <td style="border:0px;" colspan="28">

                <div align="center" style="font-size:20px;">Bkash Allowances Sheet for the Period of



                  <? $d = strtotime("-1 Months");



                  echo date("M-Y", $d) . ""; ?>



                  To



                  <? $test = new DateTime('01-' . $_POST['mon'] . '-' . $_POST['year'] . ' ');

                  echo date_format($test, 'M-Y') . '<br>' . $depts;  ?>



                </div>

              </td>



            </tr>



            <tr>



              <td style="border:0px;" colspan="28"><?= $strTime ?></td>



            </tr>



            <tr>



              <th rowspan="2">

                <div align="center">S/L</div>

              </th>



              <th rowspan="2">

                <div align="center">ID</div>

              </th>



              <th rowspan="2">

                <div align="center">Name</div>

              </th>



              <th rowspan="2">

                <div align="center">Designation</div>

              </th>



              <th rowspan="2">

                <div align="center">Department</div>

              </th>



              <th rowspan="2">

                <div align="center">Joining Date</div>

              </th>



              <th colspan="9">

                <div align="center">Allowances</div>

              </th>



              <th rowspan="2">

                <div align="center">Total Allowances</div>

              </th>



              <th rowspan="2">

                <div align="center">Wallet No</div>

              </th>







              <th rowspan="2">

                <div align="center">Remarks</div>

              </th>



            </tr>



            <tr>



              <th>

                <div align="center">Food</div>

              </th>



              <th>

                <div align="center">Conveyance</div>

              </th>



              <th>

                <div align="center">Site Visit</div>

              </th>



              <th>

                <div align="center">Health</div>

              </th>



              <th>

                <div align="center">Fuel</div>

              </th>







              <th>

                <div align="center">Overtime</div>

              </th>







              <th>

                <div align="center">Ifter</div>

              </th>



              <th>

                <div align="center">Hotel</div>

              </th>



              <th>

                <div align="center">Others</div>

              </th>



            </tr>



          </thead>



          <tbody>



            <?















            if ($_POST['JOB_LOCATION'] != '')







              $cv_con .= ' and t.job_location ="' . $_POST['JOB_LOCATION'] . '"';







            if ($_POST['department'] != '')







              $cv_con .= ' and t.department ="' . $_POST['department'] . '"';



























            $sqldd = 'select t.PBI_ID,a.PBI_CODE,a.PBI_NAME,desg.DESG_DESC,dept.DEPT_DESC,date_format(e.ESSENTIAL_JOINING_DATE,"%d-%b-%y") as joining_date,t.bkash_no,







SUM(t.food_bill) as food_bill,SUM(t.conveyance) as conveyance,SUM(t.site_visit) as site_visit,SUM(t.health) as health,SUM(t.fule) as fule,SUM(t.others) others,SUM(t.overtime) as overtime,



SUM(t.ifter) as ifter,SUM(t.hotel) as hotel,



SUM(t.food_bill+t.conveyance+t.site_visit+t.health+t.fule+t.overtime+t.others+t.ifter+t.hotel) as amount,t.remarks







from







monthly_allowances t,







personnel_basic_info a,







salary_info i,







designation desg,







department dept,



essential_info e















where











t.bank_or_cash=6 and



i.PBI_ID = t.PBI_ID and







t.designation=desg.DESG_ID and







t.department=dept.DEPT_ID and







t.PBI_ID=e.PBI_ID and



t.job_status="In Service" and



t.mon=' . $_POST['mon'] . ' and







t.year=' . $_POST['year'] . ' and







t.PBI_ID=a.PBI_ID ' . $cv_con . ' group by t.PBI_ID







order by a.PBI_NAME asc';























            $querydd = mysql_query($sqldd);







            ini_set('memory_limit', '-1');







            while ($conData = mysql_fetch_object($querydd)) {







              $entry_by = $conData->entry_by;







              $year = date('Y');























































            ?>



              <tr>



                <td><?= ++$s ?></td>



                <td><?= $conData->PBI_CODE ?></td>



                <td nowrap="nowrap"><?= $conData->PBI_NAME ?></td>



                <td><?= $conData->DESG_DESC ?></td>



                <td>

                  <div align="">



                    <?= $conData->DEPT_DESC ?>



                  </div>

                </td>



                <td>

                  <div align="center">



                    <?= $conData->joining_date ?>



                  </div>

                </td>



                <td>

                  <div align="right"><?= ($conData->food_bill > 0) ? number_format($conData->food_bill) : '';

                                      $totFod += $conData->food_bill ?></div>

                </td>



                <td>

                  <div align="right"><?= ($conData->conveyance > 0) ? number_format($conData->conveyance) : '';

                                      $totCon += $conData->conveyance ?></div>

                </td>



                <td>

                  <div align="right">



                    <?= ($conData->site_visit > 0) ? number_format($conData->site_visit) : '';

                    $totSite += $conData->site_visit ?>



                  </div>

                </td>



                <td>

                  <div align="right">



                    <?= ($conData->health > 0) ? number_format($conData->health) : '';

                    $totHealth += $conData->health ?>



                  </div>

                </td>



                <td>

                  <div align="right">



                    <?= ($conData->fule > 0) ? number_format($conData->fule) : '';

                    $totFule += $conData->fule ?>



                  </div>

                </td>















                <td>

                  <div align="right">



                    <?= ($conData->overtime > 0) ? number_format($conData->overtime) : '';

                    $totOvertime += $conData->overtime ?>



                  </div>

                </td>











                <td>

                  <div align="right">



                    <?= ($conData->ifter > 0) ? number_format($conData->ifter) : '';

                    $totIfter += $conData->ifter ?>



                  </div>

                </td>











                <td>

                  <div align="right">



                    <?= ($conData->hotel > 0) ? number_format($conData->hotel) : '';

                    $totHotel += $conData->hotel ?>



                  </div>

                </td>











                <td>

                  <div align="right">



                    <?= ($conData->others > 0) ? number_format($conData->others) : '';

                    $totOthers += $conData->others ?>



                  </div>

                </td>















                <td>

                  <div align="right">



                    <?= number_format($conData->amount); ?>



                  </div>

                </td>











                <td>

                  <div align="center">



                    <?= $conData->bkash_no ?>



                  </div>

                </td>







                <td><?= $conData->remarks ?></td>



              </tr>



              <? $totalConvaince += $conData->amount;







              //$conData->food_bill+$conData->conveyance+$conData->site_visit+$conData->health+$conData->fule+$conData->others+$conData->overtime;

              ?>



            <?  }  ?>



            <tr>



              <td colspan="6" align="right" style="font-weight:bold">Total:</td>



              <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totFod > 0) ? number_format($totFod, 0) : ''; ?></td>



              <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totCon > 0) ? number_format($totCon, 0) : ''; ?></td>



              <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totSite > 0) ? number_format($totSite, 0) : ''; ?></td>



              <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totHealth > 0) ? number_format($totHealth, 0) : ''; ?></td>



              <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totFule > 0) ? number_format($totFule, 0) : ''; ?></td>



              <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totOvertime > 0) ? number_format($totOvertime, 0) : ''; ?></td>



              <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totIfter > 0) ? number_format($totIfter, 0) : ''; ?></td>



              <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totHotel > 0) ? number_format($totHotel, 0) : ''; ?></td>



              <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totOthers > 0) ? number_format($totOthers, 0) : ''; ?></td>



              <td colspan="1" style="font-weight:bold; text-align:right"><?= ($totalConvaince > 0) ? number_format($totalConvaince, 0) : ''; ?></td>



              <td colspan="2"></td>



            </tr>



          </tbody>



        </table>



        In Words:<? echo convertNumberMhafuz($totalConvaince); ?> <br>



        <br>



        <br>



        <div style="width:100%; margin:0 auto">



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Prepared By</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Audit</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Accounts</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Managing Director</div>



          <div style="float:left; width:20%; text-align:center">-------------------<br>



            Chairman</div>



        </div>







        <?php /*?><a href="export_primary.php?export=yes&year=<?=$_REQUEST['year']?>&mon=<?=$_POST['mon']?>" target="_blank">  Export</a><?php */ ?>











        </tbody>



        </table>



        <br>



        <br>



        <br>























      <? } ?>