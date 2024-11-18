<?php


session_start();
ob_start();


require "../support/inc.all.php";



$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


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




if (isset($_POST["import"])) {


$mon = $_POST['mon'];
$year = $_POST['year'];
$type = $_POST['type'];

//deleting previouse data
$del_sql2 = 'delete from monthly_allowances where effect_date="'.$_POST['effect_date'].'" and mon="'.$_POST['mon'].'" and 
year="'.$_POST['year'].'" and lock_status=0';
mysql_query($del_sql2);
   
if($_POST['type']==2){


  
 /*___________ NEW CODES _________________*/  
 
$table = 'monthly_allowances';
$unique = 'id';
$crud = new crud($table);
$now = time();

if (!isset($_FILES["retailer_file"])) {
    die('<span style="color:red; font-weight:bold">File not uploaded</span>');
}

$filename = $_FILES["retailer_file"]["tmp_name"];
$ext = strtolower(pathinfo($_FILES["retailer_file"]["name"], PATHINFO_EXTENSION));
$allowedExtensions = ['xlsx', 'xls', 'csv'];

if (in_array($ext, $allowedExtensions)) {
    if ($_FILES["retailer_file"]["size"] > 0) {
        $file = fopen($filename, "r");
        if ($file === FALSE) {
            die('<span style="color:red; font-weight:bold">Error opening file</span>');
        }

        $count = 0;
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            $count++;
            if ($count > 0) {
                // Sanitize and assign CSV data to variables
                $PBI_ID = isset($getData[0]) ? mysql_real_escape_string($getData[0]) : "";
                $food_bill = isset($getData[1]) ? mysql_real_escape_string($getData[1]) : "";
                $conveyance = isset($getData[2]) ? mysql_real_escape_string($getData[2]) : "";
                $site_visit = isset($getData[3]) ? mysql_real_escape_string($getData[3]) : "";
                $health = isset($getData[4]) ? mysql_real_escape_string($getData[4]) : "";
                $fule = isset($getData[5]) ? mysql_real_escape_string($getData[5]) : "";
                $overtime = isset($getData[6]) ? mysql_real_escape_string($getData[6]) : "";
                $ifter = isset($getData[7]) ? mysql_real_escape_string($getData[7]) : "";
                $hotel = isset($getData[8]) ? mysql_real_escape_string($getData[8]) : "";
                $others = isset($getData[9]) ? mysql_real_escape_string($getData[9]) : "";
                $remarks = isset($getData[10]) ? mysql_real_escape_string($getData[10]) : "";
                $working_days = isset($getData[11]) ? mysql_real_escape_string($getData[11]) : "";

                $entry_by = $_SESSION['user']['id'];
                $PBI_ID_NEW = find_a_field('personnel_basic_info', 'PBI_ID', 'PBI_CODE="'.$PBI_ID.'"');
                $PBI = find_all_field('personnel_basic_info', '', 'PBI_ID="'.$PBI_ID_NEW.'"');
                $PBI_SALARY_INFO = find_all_field('salary_info', '', 'PBI_ID="'.$PBI_ID_NEW.'"');

                $query = 'INSERT INTO `monthly_allowances` (
                    `mon`, `year`, `PBI_ID`, `food_bill`, `conveyance`, `site_visit`, `health`, `fule`, `others`, 
                    `overtime`, `ifter`, `hotel`, `remarks`, `designation`, `department`, `job_location`, `entry_by`, 
                    `bank_or_cash`, `cash`, `card_no`, `job_status`, `working_days`, `bkash_no`, `nagad_no`, `effect_date` ,`type`
                ) VALUES (
                    "'.$_POST['mon'].'", "'.$_POST['year'].'", "'.$PBI->PBI_ID.'", "'.$food_bill.'", "'.$conveyance.'", 
                    "'.$site_visit.'", "'.$health.'", "'.$fule.'", "'.$others.'", "'.$overtime.'", "'.$ifter.'", "'.$hotel.'", 
                    "'.$remarks.'", "'.$PBI->PBI_DESIGNATION.'", "'.$PBI->PBI_DEPARTMENT.'", "'.$PBI->JOB_LOCATION.'", 
                    "'.$entry_by.'", "'.$PBI_SALARY_INFO->cash_bank.'", "'.$PBI_SALARY_INFO->cash.'", "'.$PBI_SALARY_INFO->card_no.'", 
                    "'.$PBI->PBI_JOB_STATUS.'", "'.$working_days.'", "'.$PBI_SALARY_INFO->bkash_no.'", 
                    "'.$PBI_SALARY_INFO->nagad_no.'", "'.$_POST['effect_date'].'" , "'.$_POST['type'].'"
                )';

                 $query . "<br>"; // Display the query for debugging

                $result = mysql_query($query);

                if ($result) {
                    $message = '<span style="color:green; font-weight:bold">Successfully Uploaded</span>';
                } else {
                    $message = '<span style="color:red; font-weight:bold">Oops! Try again</span>';
                }
            }
        }
        fclose($file);
    }
} else {
    $message = '<span style="color:red; font-weight:bold">Oops! Invalid Data. Please upload as per system format!</span>';
}



}

}







?>

<form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
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
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <div  class="oe_view_manager_view_list">
                      <div  class="oe_list oe_view">
                        <table width="100%" border="0" class="oe_list_content">
                          <thead>
                            <tr class="oe_list_header_columns">
                              <th colspan="4"><span style="text-align: center; font-size:19px; color:#3d6485">
                                <center>
                                  Monthly allowances upload<br>
                                  <?=$message?>
                                </center>
                                </span></th>
                            </tr>
                            <tr class="oe_list_header_columns">
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr class="oe_list_header_columns">
                              <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            <tr class="oe_list_header_columns">
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr  class="alt">
                              <td align="right"><strong>Year:</strong></td>
                              <td><select name="year" style="width:160px;" id="year" required="required">
                                  <option <?=($year=='2024')?'selected':''?>>2024</option>
                                  <option <?=($year=='2023')?'selected':''?>>2023</option>
                                  <option <?=($year=='2022')?'selected':''?>>2022</option>
                                </select></td>
                              <td align="right"><strong>Month:</strong></td>
                              <td><span class="oe_form_group_cell">
                                <select name="mon" style="width:160px;" id="mon" required="required" >
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
                              <td align="right" class="alt"><strong> Type  : </strong></td>
                              <td align="left" class="alt"><span class="oe_form_group_cell">
                                <select name="type" id="type" required="required">
								  <option></option>
                                  <option value="1" <?=($type=='1')?'selected':''?>>All Convynace</option>
                                  <option value="2" <?=($type=='2')?'selected':''?>> Only Sales </option>
                                </select>
                                </span></td>
                              <td align="right"><strong>Select .CSV File Only   :</strong></td>
                              <td><span class="oe_form_group_cell">
                                <input type="file" name="retailer_file" id="retailer_file" accept=".csv" />
                                </span></td>
                            </tr>
                            <tr>
                              <td align="right" class="alt"><strong>Effect Date  : </strong></td>
                              <td align="left" class="alt"><span class="oe_form_group_cell">
                                <input type="date" name="effect_date" id="effect_date"  />
                                </span></td>
                              <td align="right"><strong></strong></td>
                              <td><span class="oe_form_group_cell"></span></td>
                            </tr>
                          </tbody>
                        </table>
                        <br />
                        
                        
                        
                           <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="form-group row m-0">
              <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"></label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                            
							<a href="demo2.csv" download>Click To Download Example File</a>
              </div>
            </div>


          </div>

        </div>
		</div>
		
		
		
                        <div style="text-align:center">
                          <table width="100%" class="oe_list_content">
                            <thead>
                              <tr class="oe_list_header_columns">
                                <th colspan="4" align="center"><button type="submit" id="submit" name="import" class="btn-submit">Import</button></th>
                              </tr>
                            </thead>
                            <tfoot>
                            </tfoot>
                            <tbody>
                            </tbody>
                          </table>
                          <p> </p>
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
    </div>
  </div>
</form>
<?















$main_content=ob_get_contents();















ob_end_clean();















include ("../template/main_layout.php");















?>
