<?php

session_start();
ob_start();
require "../support/inc.all.php";



$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';



do_calander('#ijdb');



do_calander('#ijda');



do_calander('#ppjdb');



do_calander('#ppjda');



if($_POST['mon']!=''){

$mon=$_POST['mon'];}

else{

$mon=date('n');

}



if($_POST['year']!=''){

$year=$_POST['year'];}

else{

$year=date('Y');

}



if(isset($_POST['lock'])){

	$check_sql = 'select 1 from salary_lock where month='.$_POST['mon'].' and year='.$_POST['year'].'';

	

	$check_query = mysql_query($check_sql);

	$last_check = mysql_num_rows($check_query );

	

	if($last_check >0){

		echo "<h3 style='text-align:center;background-color:red;color:white;'>This month and Year Salary Exist. Lock down is not possible</h3>";

		}else{

	for($i=0;$i<count($_POST['tr_type']);$i++){

		 $sql = 'INSERT INTO `salary_lock`( `month`, `year`, `job_location`, `salary_amount`, `tr_type`) 

		VALUES ("'.$_POST['mon'].'","'.$_POST['year'].'","'.$_POST['job_location'][$i].'" , "'.$_POST['salary_amount'][$i].'" ,"'.$_POST['tr_type'][$i].'" )';

		

		mysql_query($sql);

	}

		echo "<h3 style='text-align:center;background-color:green;color:white;'>Salary is been Locked</h3>";

		}

		

		

		



}



 //auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_JOB_STATUS)','PBI_ID','1','PBI_ID');



?>



<style>

	.body{
		min-width: 0!important;
	}

.frmSearch {border: 1px solid #a8d4b1;}

#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;}

#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}

#country-list li:hover{background:#ece3d2;cursor: pointer;}

#id_no{padding: 10px;border: #a8d4b1 1px solid;}

</style>






<form action="primary_report.php" target="_blank" method="post">

  <div class="oe_view_manager oe_view_manager_current">

    <div class="oe_view_manager_body">

      <div  class="oe_view_manager_view_list"></div>

      <div class="oe_view_manager_view_form">

        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

          <div class="oe_form_buttons"></div>

          <div class="oe_form_sidebar"></div>

          <div class="oe_form_pager"></div>

          <div class="oe_form_container">

            <div class="oe_form">

              <div class="">

               

                    <div  class="oe_view_manager_view_list">

                      <div  class="oe_list oe_view">

                        <table width="100%" border="0" class="oe_list_content">

                          <thead>

                            <tr class="oe_list_header_columns">

                              <th colspan="4"><span style="text-align: center; font-size:19px; color:#089c84"><center>   </center></span></th>

                            </tr>

                            <tr class="oe_list_header_columns">

                              <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>

                            </tr>

                          </thead>

                          <tr>

                                <td colspan="2" align="center" class="alt"><strong></strong></td>

                                <td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>

                          <tbody>

                            <tr>

                              <td width="13%" align="right" class="alt" style="font-size:14px"><strong>Company : </strong></td>

                              <td width="33%" align="left" class="alt"><span class="oe_form_group_cell">

                                <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">

                                  <? //foreign_relation('user_group','id','group_name',$PBI_ORG);?>

								  <option selected value="2">Aksid Corporation Limited</option>

                                </select>

                                </span></td>

                              <td width="25%" align="right" class="alt" style="font-size:14px"><strong>Department :</strong></td>

                              <td width="29%"><span class="oe_form_group_cell">

                                <select name="department" style="width:160px;" id="department">

                                  <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT);?>

                                </select>

                                </span></td>

                            </tr>
							  
							<tr>

                                <td colspan="2" align="center" class="alt"><strong></strong></td>

                                <td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>

                            <tr class="alt">

                              <td align="right" style="font-size:14px"><strong>Job Status :</strong>
								</td>

                              <td><span class="oe_form_group_cell">

                                <select name="job_status" style="width:160px;">

                                  <option selected="selected"></option>

                                  <option>IN SERVICE</option>

                                  <option>NOT IN SERVICE</option>

                                </select>

                                </span></td>

                              <td align="right" style="font-size:14px"><strong>Job Location :</strong></td>

                              <td><span class="oe_form_group_cell">

                                <select name="JOB_LOCATION" id="JOB_LOCATION" style="width:160px;">

                                  <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOCATION'],'1');?>

                                </select>

                                </span></td>

                            </tr>

                        <tr>

                                <td colspan="2" align="center" class="alt"><strong></strong></td>

                                <td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>

                           

                       

                            <tr >

                            

							  

							  

                             <td align="right" style="font-size:14px"><strong>ID NO :</strong></td>

                              <td align="center"><span class="oe_form_group_cell">

                               <div class="frmSearch">

<input type="text" id="id_no" name="id_no" placeholder="Employee Name..." />

<div id="suggesstion-box"></div>

</div>

                                 <? //foreign_relation('personnel_basic_info','PBI_ID','CONCAT("",PBI_ID,"","-", " ",PBI_NAME )',$PBI_ID);?>

								 

                                

                                </span></td>

							  

							  

                            </tr>
							  
							  <tr>

                                <td colspan="2" align="center" class="alt"><strong></strong></td>

                                <td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>
							  
							  
							  
							  

                            <tr>

                              <td align="right" style="background-color:#089c84; color:#FFFFFF; font-size:16px"><span>Month:</span> </td>

                              <td align="left" style="background-color:#089c84; color:#FFFFFF; font-size:16px"><span class="oe_form_group_cell">

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

                              <td align="right" style="background-color:#089c84; color:#FFFFFF; font-size:16px; "><span style="float:right">Year  :</span></td>

                              <td style="background-color:#089c84; font-size:16px;padding-top:4px"><select name="year" style="width:160px;" id="year" required="required">

                                  <option <?=($year=='2024')?'selected':''?>>2024</option>
                                  <option <?=($year=='2022')?'selected':''?>>2022</option>
								  
                                  <option <?=($year=='2023')?'selected':''?>>2023</option>

                                  <option <?=($year=='2018')?'selected':''?>>2018</option>

                                  <option <?=($year=='2019')?'selected':''?>>2019</option>

                                  <option <?=($year=='2020')?'selected':''?>>2020</option>

                                  <option <?=($year=='2021')?'selected':''?>>2021</option>

                                </select></td>

                            </tr>

                          </tbody>

                        </table>

                        
						   <br>
						   <br>

                        <div style="text-align:center">

                          <table width="100%" class="oe_list_content" border="3">

                            <thead>

                              <tr>

                                <th class="oe_list_header_columns"  colspan="8" style="text-align: center!important; font-size: 16px">
									<p style="color:#089C84">Select Report									</p>
								</th>

                              </tr>

                            </thead>

                            <tfoot>

                            </tfoot>

                            <tbody>
							
							
							 

             							  
							  

							  <tr>

                                <td align="center"><input name="report" type="radio" class="radio" value="1" /></td>

                                <td class="alt" align="left"><strong>Basic </strong> <strong>Information</strong></td>

                                <td align="left">&nbsp;</td>

                                <td>&nbsp;</td>
								
								<td align="center">&nbsp;</td>

                                <td>&nbsp;</td>
								
								<td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>
							  
							  
							  <tr>

                                <td align="center"><input name="report" type="radio" class="radio" value="9999"/></td>

                                <td class="alt" align="left"><strong>Salary Summery Sheet</strong></td>

                                <td align="left">&nbsp;</td>

                                <td>&nbsp;</td>
								
								<td align="center">&nbsp;</td>

                                <td>&nbsp;</td>
								
								<td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>
							  
							  
							  <tr>

                                <th class="oe_list_header_columns"  colspan="8" style="text-align: center!important; font-size: 16px">
									<p style="color:#089C84">
									Allowance Report </p>
								</th>
                              </tr>
							  
								
							 <tr>

                                <td colspan="2" align="center" class="alt"><strong></strong></td>

                                <td align="center">&nbsp;</td>

                                <td>&nbsp;</td>

                              </tr>
							  
													  
							  
							  <tr> 
                                <td  class="alt">
									<input name="report" type="radio" class="radio" value="4513" />
								</td>
							    <td class="alt" align="left">
									<strong>Allowances Summery Sheet (All)</strong>
								</td>
								
								
								<td class="alt">
									<input name="report" type="radio" class="radio" value="4514" />
								</td>
							    <td class="alt" align="left">
									<strong> Allowances Summery Sheet (Cash)</strong>
								</td>
								
								
								<td class="alt">
									<input name="report" type="radio" class="radio" value="4516" />
								</td>
							    <td class="alt" align="left">
									<strong>Allowances Summery Sheet (Bkash)</strong>
								</td>
								
								
							    <td  class="alt"><input name="report" type="radio" class="radio" value="" /></td>

							    <td class="alt" align="left"><strong>  Allowances Summery Sheet (Nagad) </strong></td>
						      </tr>
							  
							  
							 
							  
							  
							  
							  <tr>

                                <td class="alt"><input name="report" type="radio" class="radio" value="4763" /></td>   

                                <td class="alt" align="left"><strong>Allowances Reports</strong>
								</td>

                                 <td class="alt"><input name="report" type="radio" class="radio" value="4515"/></td>

							    <td class="alt" align="left"><strong>Allowances Report (Cash)</strong></td>
								
								
								 <td class="alt"><input name="report" type="radio" class="radio" value="4517" /></td>

							    <td class="alt" align="left"><strong> Allowances Report (Bkash)</strong></td>
								
								<td class="alt"><input name="report" type="radio" class="radio" value="4519" /></td>

							    <td class="alt" align="left"><strong> Allowances Report (Nagad)</strong></td>

                              </tr>
							  
							  
							  
							  
							   
							  
							  
							  
							  
							  
							  
							  
							  
							  
							  
							  
							  <tr>

							    <td class="alt"><input name="report" type="radio" class="radio" value="4512" /></td>

							    <td class="alt" align="left"><strong>Allowances Advice (Bank)</strong></td>
								
								
								<td>&nbsp;</td>

                                <td>&nbsp;</td>
								

							  	<td class="alt"><input name="report" type="radio" class="radio" value="4518" /></td>

							    <td class="alt" align="left"><strong>Allowances Advice (Bkash)</strong></td>
								
								
									<td class="alt"><input name="report" type="radio" class="radio" value="" /></td>

							    <td class="alt" align="left"><strong>Allowances Advice (Nagad)</strong></td>

						      </tr>
													  
								
								
                            </tbody>

                          </table>

                          <p>
                            <input name="submit" type="submit" id="submit" value="SHOW" />
                          </p>

                        </div>

                      </div>

                    </div>

                  </div>

                </div>

                <div class="oe_chatter">

                  <div class="oe_followers oe_form_invisible">

                    <div class="oe_follower_list"></div>

                  </div>

                </div>

              </div>

        

        </div>

      </div>

    </div>

  </div>

</form>



		

<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<script>

$(document).ready(function(){

	$("#id_no").keyup(function(){

		$.ajax({

		type: "POST",

		url: "auto_com.php",

		data:'keyword='+$(this).val(),

		beforeSend: function(){

			$("#id_no").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");

		},

		success: function(data){

			$("#suggesstion-box").show();

			$("#suggesstion-box").html(data);

			$("#id_no").css("background","#FFF");

		}

		});

	});

});



function selectCountry(val) {

$("#id_no").val(val);

$("#suggesstion-box").hide();

}

</script>

<?







$main_content=ob_get_contents();







ob_end_clean();







include ("../template/main_layout.php");







?>
