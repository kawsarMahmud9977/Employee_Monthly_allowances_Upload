<?
session_start();
require "../support/inc.all.php";
$crud   =new crud('monthly_allowances');
$unique = 'id';
//echo 'PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ';

$salaryInfo = find_all_field('monthly_allowances','','PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'" ');
$_POST[$unique] = $$unique = $salaryInfo->id;
if($$unique>0)
{

$_REQUEST['total_deduction']=$salaryInfo->total_deduction+$_REQUEST['food_bill']+$_REQUEST['conveyance']+$_REQUEST['site_visit']+$_REQUEST['health']+$_REQUEST['fule']+$_REQUEST['others']+$_REQUEST['overtime']+$_REQUEST['remarks'];


$_REQUEST['total_payable'] = $salaryInfo->total_payable-($_REQUEST['food_deduction']+$_REQUEST['mobile_deduction']+$_REQUEST['other_deduction']);



$_REQUEST['total_earning'] = $salaryInfo->total_earning-($_REQUEST['food_deduction']+$_REQUEST['mobile_deduction']+$_REQUEST['other_deduction']);



$_REQUEST['edit_by']=$_SESSION['user']['id'];



$_REQUEST['edit_at']=date('Y-m-d h:i:s');



echo 'Updated!';



$crud->update($unique);



$up  ='update monthly_allowances set 
food_bill="'.$_REQUEST['food_bill'].'",
conveyance="'.$_REQUEST['conveyance'].'",
site_visit="'.$_REQUEST['site_visit'].'",
health="'.$_REQUEST['health'].'",
fule="'.$_REQUEST['fule'].'",
others="'.$_REQUEST['others'].'",
overtime="'.$_REQUEST['overtime'].'",
remarks="'.$_REQUEST['remarks'].'"

where PBI_ID="'.$_REQUEST['PBI_ID'].'" and mon="'.$_REQUEST['mon'].'" and year="'.$_REQUEST['year'].'"';

mysql_query($up);

}



?>