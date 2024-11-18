<?php
session_start();
ob_start();
require "../support/inc.all.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
if(isset($_POST['create']))
{
$mon=$_POST['mon'];
$dept=$_POST['dept'];
$year=$_POST['year'];
$bonus=$_POST['bonus'];
}else{
$mon=date('n');
$year=date('Y');
}



?>


<style type="text/css">
.click {
border: 1px solid #00FF7C;
position: relative;
top: 0px;
transition: all ease 0.3s;
}
.click:active {
box-shadow: 0 5px 0 #00823F;
top: 5px;
}
</style>
<script>
function getXMLHTTP() { //fuction to return the xml http object
var xmlhttp=false;	
try{
xmlhttp=new XMLHttpRequest();
}

catch(e)	{		
         try{			
         xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
         }
       catch(e){
         try{
         xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
         }

        catch(e1){
        xmlhttp=false;
                 }
            }

          }
   return xmlhttp;
  }
function update_value(id)
 {


var PBI_ID=id; // Rent
var food_bill=(document.getElementById('food_bill_'+id).value)*1; // Other
var conveyance=(document.getElementById('conveyance_'+id).value)*1; // Rent + Other
var site_visit=(document.getElementById('site_visit_'+id).value)*1; // Other
var health=(document.getElementById('health_'+id).value)*1; // Other
var fule=(document.getElementById('fule_'+id).value)*1; // Rent + Other
var others=(document.getElementById('others_'+id).value)*1; // Rent + Other
var overtime=(document.getElementById('overtime_'+id).value)*1; // Rent + Other
var remarks=document.getElementById('remarks_'+id).value; // Rent + Other
var mon=document.getElementById('mon').value;
var year=document.getElementById('year').value;

var strURL="mobile_food_other_deduction_ajax.php?PBI_ID="+PBI_ID+"&food_bill="+food_bill+"&conveyance="+conveyance+"&site_visit="+site_visit+"&health="+health+"&fule="+fule+"&others="+others+"&overtime="+overtime+"&remarks="+remarks+"&mon="+mon+"&year="+year;

var req = getXMLHTTP();
if (req) {
req.onreadystatechange = function() {
if (req.readyState == 4) {
// only if "OK"
if (req.status == 200) {						
document.getElementById('divi_'+id).style.display='inline';
document.getElementById('divi_'+id).innerHTML=req.responseText;						
} else {
alert("There was a problem while using XMLHTTP:\n" + req.statusText);
}
}				
}
req.open("GET", strURL, true);
req.send(null);
}

	
}
function cal_all(id)
{
var PBI_ID=id; // Rent
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=(document.getElementById('lt_'+id).value)*1; 
var ab=(document.getElementById('ab_'+id).value)*1;
var lv=(document.getElementById('lv_'+id).value)*1;
var lwp=(document.getElementById('lwp_'+id).value)*1;
var ltd=lt/3; 
var ltdd=Math.floor(ltd);
var pre=td - (od + hd + ab + lv + lwp );
var pay=td - ab - ltdd - lwp;
document.getElementById('pay_'+id).value=pay;
document.getElementById('pre_'+id).value=pre;
}

function cal_mobileBill(id){
var mobile_bill_limit=(document.getElementById('mobile_bill_limit_'+id).value)*1;
var mobile_bill_amt=(document.getElementById('mobile_bill_amt_'+id).value)*1;
if(mobile_bill_amt > mobile_bill_limit){
var bill_deduct=(mobile_bill_amt-mobile_bill_limit);
document.getElementById('mobile_deduction_'+id).value=bill_deduct;
}else{
document.getElementById('mobile_deduction_'+id).value=0;
}}
</script>



<form action=""  method="post">
<div class="oe_view_manager oe_view_manager_current">
<div class="oe_view_manager_body">
<div  class="oe_view_manager_view_list"></div>
<div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">



        <div class="oe_form_buttons"></div>



        <div class="oe_form_sidebar"></div>



        <div class="oe_form_pager"></div>



        <div class="oe_form_container"><div class="oe_form">



          <div class="">



<div class="oe_form_sheetbg">



        <div class="oe_form_sheet oe_form_sheet_width">







          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">



<table width="100%" border="0" class="oe_list_content"><thead>



<tr class="oe_list_header_columns">
<th colspan="4"><span style="text-align: center; font-size:19px; color:#3d6485"><center>MONTHLY Allowances ENTRY </center></span></th>
</tr>



<tr class="oe_list_header_columns">
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
</tr>


<tr class="oe_list_header_columns">
<th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
</tr>


<tr class="oe_list_header_columns">
 <td>&nbsp;</td>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
</tr



></thead><tfoot>



</tfoot><tbody>







  <tr  class="alt">



    <td align="right"><strong>Year:</strong></td>



    <td><select name="year" style="width:160px;" id="year" required="required">



        <option <?=($year=='2023')?'selected':''?>>2023</option>



        <option <?=($year=='2024')?'selected':''?>>2024</option>



		<option <?=($year=='2021')?'selected':''?>>2021</option>



		<option <?=($year=='2022')?'selected':''?>>2022</option>



    </select></td>



    <td align="right"><strong>Month:</strong></td>



    <td><span class="oe_form_group_cell">



      <select name="mon" style="width:160px;" id="mon" required="required">



        <option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>



        <option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>



        <option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>



        <option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>



        <option value="5" <?=($mon=='5')?'selected':''?>>May</option>



        <option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>



        <option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>



        <option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>



        <option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>



        <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>



        <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>



        <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>



      </select>



    </span></td>



  </tr>



  <tr >



    <td align="right" class="alt">Concern Company :</td>



    <td align="left" class="alt"><span class="oe_form_group_cell">



      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" required>



        <? //=foreign_relation('user_group','id','group_name',$_POST['PBI_ORG']);?>



		<option selected value="2">Aksid Corporation Limited</option>



      </select>



    </span></td>



    <td align="right"><strong>Department:</strong></td>



    <td><span class="oe_form_group_cell">



      <select name="dept" style="width:160px;" id="dept">



	  



        <?=foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['dept']);?>



      </select>



    </span></td>



    </tr>



  <tr >



    <td align="right" class="alt">&nbsp;</td>



    <td align="left" class="alt">&nbsp;</td>



    <td align="right"><strong>Project Name : </strong></td>



    <td><span class="oe_form_group_cell">



      <select name="JOB_LOCATION" style="width:160px;" id="JOB_LOCATION">



        <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOCATION'],'1');?>



      </select>



    </span></td>



    </tr>



  



  



  </tbody></table>



<br /><div style="text-align:center">



<table width="100%" class="oe_list_content">



  <thead>



<tr class="oe_list_header_columns">



  <th colspan="4"><input name="create" type="submit" id="create" value="View Sheet" /></th>



  </tr>



  </thead>



  <tfoot>



  </tfoot>



  <tbody>



    </tbody>



</table>



<div class="oe_form_sheetbg">



        <div class="oe_form_sheet oe_form_sheet_width">







          <div class="oe_view_manager_view_list"><div class="oe_list oe_view">



          <? if(isset($_POST['create'])){?>



		<table width="100%" class="oe_list_content"><thead><tr class="oe_list_header_columns" style="font-size:10px;padding:3px; background:#2ECCFA;" align="center">



        <th rowspan="2">S/L</th>



        <th rowspan="2">ID</th>



        <th rowspan="2">Full Name</th>



        <th rowspan="2">Designation</th>






        <th colspan="7" style="border-bottom:#000000"><div align="center">Allowances</div></th>



      



        <th rowspan="2">Remarks</th>



        <th rowspan="2">&nbsp;</th>



        </tr>



		    <tr class="oe_list_header_columns" style="font-size:10px;padding:3px; border-top:#ccc; background:#2ECCFA;">



		      <th style="border:1px solid #ccc;">Food</th>



		      <th  style="border:1px solid #ccc;">Convience</th>



		      <th  style="border:1px solid #ccc;">Site Visit</th>
			  
			  
			  
			   <th style="border:1px solid #ccc;">Health</th>



		      <th  style="border:1px solid #ccc;">Fuel</th>

              <th  style="border:1px solid #ccc;">Others</th>
			  
			  <th  style="border:1px solid #ccc;">Overtime</th>



		    </tr>



		</thead>



        <tbody>



        <? 



//$startTime = $days1=mktime(0,0,0,($mon-1),26,$year);



//$endTime = $days2=mktime(0,0,0,$mon,25,$year);







$startTime = $days1=mktime(0,0,0,$mon,01,$year);



$endTime = $days2=mktime(0,0,0,$mon,date('t',$startTime),$year);







$days_in_month = date('t',$endTime);







$startTime1 = $days1=mktime(0,0,0,($mon),01,$year);



$endTime1 = $days2=mktime(0,0,0,$mon,$days_in_month,$year);







$startday = date('Y-m-d',$startTime);



$endday = date('Y-m-d',$endTime);



	







//$start_date = $year.'-'.($mon-1).'-26';



//$end_date = $year.'-'.$mon.'-25';







$start_date =$starting_date = $year.'-'.$mon.'-01';



$end_date =$ending_date = $year.'-'.$mon.'-'.date('t',$startTime);







$days_mon=ceil(($endTime - $startTime)/(3600*24))+1;







for ($i = $startTime1; $i <= $endTime1; $i = $i + 86400) {



$day   = date('l',$i);



${'day'.date('N',$i)}++;







//if(isset($$day))



//$$day .= ',"'.date('Y-m-d', $i).'"';



//else



//$$day .= '"'.date('Y-m-d', $i).'"';



}



$r_count=${'day5'};



?>



<input name="fd" type="hidden" id="fd" value="<?=$r_count;?>" />



<?		


$holy_day=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$year.'-'.$mon.'-'.'01'.'" and "'.$year.'-'.$mon.'-'.$days_mon.'"');



		if($_POST['PBI_BRANCH']!='')	$con .= " and PBI_BRANCH = '".$_POST['PBI_BRANCH']."'";



		if($_POST['PBI_ZONE']!='')		$con .= " and PBI_ZONE = '".$_POST['PBI_ZONE']."'";



		if($_POST['PBI_GROUP']!='')		$con .= " and PBI_GROUP = '".$_POST['PBI_GROUP']."'";




		if($_POST['dept']!='')	$con .= " and p.PBI_DEPARTMENT = '".$_POST['dept']."'";



		if($_POST['JOB_LOCATION']!='')  $con .= " and p.JOB_LOCATION = '".$_POST['JOB_LOCATION']."'";



		//echo $jday=date('d').' <br>';



		$j_date=date('Y-m-d',mktime(0,0,0,$_POST['mon'],31,$_POST['year']));



$sql = "select p.*, d.DEPT_DESC, g.DESG_DESC from personnel_basic_info p,monthly_allowances s, designation g, department d 
      where 
	  
	  p.PBI_DEPARTMENT=d.DEPT_ID and 
	  p.PBI_DESIGNATION=g.DESG_ID and 
	  p.PBI_JOB_STATUS='In Service' and
	  p.PBI_ID=s.PBI_ID".$con." and p.PBI_DOJ<'".$j_date."' group by p.PBI_ID  order by p.PBI_ID asc";



		



		$query = mysql_query($sql);



		while($info=mysql_fetch_object($query))



		{



$leave_days_lv = 0;



$leave_days_lwp = 0;



		$new_emp_days = 0;



		$new_emp_off = 0;



		$new_emp_holy_day = 0;



		if(strtotime($info->PBI_DOJ)>strtotime($starting_date))



		{}



		if($info->PBI_DEPARTMENT=='S&M')



		$r_count = 0;



		$data = find_all_field('salary_attendence','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');



		if($data->td>0)



		{



			$status='Edit';



		}



		else



		{}
		
		
$food_bill = find_a_field('monthly_allowances','food_bill','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'"');
if($food_bill>0)
{

$food_bill_amt += $food_bill;

 }		
		

$conveyance_bill = find_a_field('monthly_allowances','conveyance','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'"');
  if($conveyance_bill>0)

{

$conveyance_bill_amt += $conveyance_bill;

}

$m_billing = find_a_field('monthly_allowances','site_visit','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'"');
  if($m_billing>0)

{

$site_billing_amt += $m_billing;

}


$helth_billing = find_a_field('monthly_allowances','health','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'"');
  if($helth_billing>0)

{

$healh_billing_amt += $helth_billing;

}


$fule_billing = find_a_field('monthly_allowances','fule','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'"');
  if($fule_billing>0)

{

$fule_billing_amt += $fule_billing;

}

$others_billing = find_a_field('monthly_allowances','others','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'"');
  if($others_billing>0)

{

$others_billing_amt += $others_billing;

}


$overtime_billing = find_a_field('monthly_allowances','overtime','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'"');
  if($overtime_billing>0)

{

$overtime_billing_amt += $overtime_billing;

}

  

 
 
else

{
$total_bill_amt = $total_bill_amt+$m_billing_amt;

}

     






		?>



        <tr style="font-size:10px; padding:3px; "><td><?=++$S?></td>



          <td><?=$info->PBI_ID?>



            <input name="dept_<?=$info->PBI_ID?>" type="hidden" id="dept_<?=$info->PBI_ID?>"  value="<?=$info->PBI_DEPARTMENT;?>" />



            <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>



          <td><?=$info->PBI_NAME?></td>
		  <td><?=$info->DESG_DESC?></td>
		  
		  
		  



<td align="center"><input name="mobile_bill_limit_<?=$info->PBI_ID?>" type="text" id="food_bill_<?=$info->PBI_ID?>" style="font-size:10px; width:50px; min-width:20px;" value="<?=find_a_field('monthly_allowances','food_bill','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'" and PBI_ID='.$info->PBI_ID)?>" onchange="cal_all(<?=$info->PBI_ID?>)"  /></td>



<td align="center"><input name="conveyance_<?=$info->PBI_ID?>" type="text" id="conveyance_<?=$info->PBI_ID?>" style="font-size:10px; width:50px; min-width:20px;" 
value="<?=find_a_field('monthly_allowances','conveyance','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'" and PBI_ID='.$info->PBI_ID)?>"onkeyup="cal_all(<?=$info->PBI_ID?>)" /></td>


<td align="center"><input name="site_visit_<?=$info->PBI_ID?>" type="text" id="site_visit_<?=$info->PBI_ID?>" style="font-size:10px; width:50px; min-width:20px;" 
value="<?=find_a_field('monthly_allowances','site_visit','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'" and PBI_ID='.$info->PBI_ID)?>" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>



<td align="center"><input name="health_<?=$info->PBI_ID?>" type="text" id="health_<?=$info->PBI_ID?>" style="font-size:10px; width:50px; min-width:20px;" 
value="<?=find_a_field('monthly_allowances','health','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'" and PBI_ID='.$info->PBI_ID)?>" onchange="cal_all(<?=$info->PBI_ID?>)"  /></td>



<td align="center"><input name="fule_<?=$info->PBI_ID?>" type="text" id="fule_<?=$info->PBI_ID?>" style="font-size:10px; width:50px; min-width:20px;" 
value="<?=find_a_field('monthly_allowances','fule','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'" and PBI_ID='.$info->PBI_ID)?>"  onkeyup="cal_mobileBill(<?=$info->PBI_ID?>)" /></td>



<td align="center"><input name="others_<?=$info->PBI_ID?>" type="text" id="others_<?=$info->PBI_ID?>" style="font-size:10px; width:50px; min-width:20px;" 
value="<?=find_a_field('monthly_allowances','others','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'" and PBI_ID='.$info->PBI_ID)?>" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>

<td align="center"><input name="overtime_<?=$info->PBI_ID?>" type="text" id="overtime_<?=$info->PBI_ID?>" style="font-size:10px; width:50px; min-width:20px;" 
value="<?=find_a_field('monthly_allowances','overtime','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'" and PBI_ID='.$info->PBI_ID)?>" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>







<td align="center"><input name="remarks_<?=$info->PBI_ID?>" type="text" id="remarks_<?=$info->PBI_ID?>" style="font-size:10px; width:100px; min-width:20px;" 
value="<?=find_a_field('monthly_allowances','remarks','year="'.$_POST['year'].'" and mon="'.$_POST['mon'].'" and PBI_ID='.$info->PBI_ID)?>" /></td>



<td align="center"><span id="divi_<?=$info->PBI_ID?>">



            <? 



			  if($status=='Edit')



			  {?>



			  <input type="button" name="Button" value="Edit" class="click"  onclick="update_value(<?=$info->PBI_ID?>)" style="font-size:11px; font-weight: bold; background-color: #1c5fcc; padding:5px 8px; border-radius:3px; border:2px solid #CCC; box-shadow:2px 2px 2px 2px BLUE; color:white; width:50px; height:40px; text-align:center"/>



			  <? }



			  else{



			  ?>



			  <input type="button" name="Button" value="Edit" class="click" onclick="update_value(<?=$info->PBI_ID?>)" style="font-size:10px; font-weight: bold; background-color: #1c5fcc; padding:5px 8px; border-radius:3px; border:2px solid #CCC; box-shadow:2px 2px 2px 2px BLUE; color:white;width:50px; height:40px; text-align:center"/><? }?>



          </span>&nbsp;</td>



          </tr>



        <?



		



		}



		?>



        <tr>



		<td colspan="4" align="right">Total</td>
		
        <td align="center"><input type="text" value="<?=($food_bill_amt>0)? number_format($food_bill_amt,0) : '';?>" style="width:50px; background-color:#FFFF99" readonly /></td>
        <td align="center"><input type="text" value="<?=($conveyance_bill_amt>0)? number_format($conveyance_bill_amt,0) : '';?>" style="width:50px; background-color:#99CCFF" readonly /></td>
        <td align="center"><input type="text" value="<?=($site_billing_amt>0)? number_format($site_billing_amt,0) : '';?>" style="width:50px; background-color:#999999" readonly /></td>
        <td align="center"><input type="text" value="<?=($healh_billing_amt>0)? number_format($healh_billing_amt,0) : '';?>" style="width:50px; background-color:#66FF66" readonly /></td>
        <td align="center"><input type="text" value="<?=($fule_billing_amt>0)? number_format($fule_billing_amt,0) : '';?>" style="width:50px; background-color:#CC99CC" readonly /></td>
		<td align="center"><input type="text" value="<?=($others_billing_amt>0)? number_format($others_billing_amt,0) : '';?>" style="width:50px; background-color:#33CCFF" readonly /></td>
		
		<td align="center"><input type="text" value="<?=($overtime_billing_amt>0)? number_format($overtime_billing_amt,0) : '';?>" style="width:50px; background-color:#33CCFF" readonly /></td>
		
		
		



		</tr>



		</tbody>



        



        <tfoot>



        <tr><td colspan="2"></td><td></td><td></td><td></td><td colspan="3"></td>



          <td></td>



          <td></td>



          <td></td>



          </tr>



        </tfoot>



        </table>



		<? }?>          </div></div>



          </div>



    </div>



<p>



  <input name="save" type="submit" id="save" value="SAVE" />



</p>



  </div></div></div>



          </div>



    </div>



    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">



      <div class="oe_follower_list"></div>



    </div></div></div></div></div>



    </div></div>



            



        </div>



  </div>



</form>







<?



$main_content=ob_get_contents();
ob_end_clean();
include ("../template/main_layout.php");


?>

