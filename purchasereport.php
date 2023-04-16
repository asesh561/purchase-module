purchase report<?php 
session_start();$currencyunits=$_SESSION['currency'];
ob_start();
include "config.php";
include "../getemployee.php";
if($currencyunits == "")
{
$currencyunits = "Rs";
if($_SESSION[db] == "alkhumasiyabrd")
       $currencyunits = "SR";
}
if(!isset($_GET['fdate']))
$fdate = date("Y-m-d");
else
$fdate = date("Y-m-d",strtotime($_GET['fdate']));
$datef = date($datephp,strtotime($fdate));
if(!isset($_GET['tdate']))
$tdate = date("Y-m-d");
else
$tdate = date("Y-m-d",strtotime($_GET['tdate']));
$datet = date($datephp,strtotime($tdate));


$date1 = "1970-01-01";
$totalquantity = $totalamount = 0;

if(!isset($_GET['company'])  $_GET['branch']=='All' )
{
$branch = "All";
$condw .="";
}
else
{
$branch = $_GET['branch'];
$condw .="and warehouse in (select distinct(farm) from broiler_farm where branch ='".$branch."')";
}
$condw="";
if(!isset($_GET['branch'])  $_GET['warehouse']=='All' )
{
$warehouse = "All";
$condw .="";
}

else
{
$warehouse = $_GET['warehouse'];
$condw .="and warehouse='$warehouse'";
}

if(!isset($_GET['code'])  !isset($_GET['desc'])  $_GET['supplier']=='All' )
{
$supplier = "All";
$conds="";
}
else
{
$supplier = $_GET['supplier'];
$conds="and vendor='$supplier'";
}


if(!isset($_GET['comid'])  $_GET['comid']=='All' )
{
$comidShow = "All";
$comidConds="";
}
else
{
$comidShow = $_GET['comid'];
$comidconds=" and company='$comidShow'";
}
$avgweight = 0;
$avgqty = 0;
$x_totalquantity = 0;
?>


<?php

if($_GET['cat']!='' && $_GET['cat']!='All')
{
$selcat=$_GET['cat'];
$mmq=mysql_query("select code from ims_itemcodes where cat='$selcat'",$conn1);    
while($mma=mysql_fetch_assoc($mmq)){
    $nxx.="'".$mma['code']."',";
}
$nxx=substr($nxx,0,-1);

$selcatcond=" and cat='$selcat'";
$selcatcond1=" and (category='$selcat' or code in ($nxx))";
}
else
{
    $selcat='All';
    $selcatcond="";
}

$itemar=array(array());
$query1 = "SELECT distinct(code) as code,description,cat FROM ims_itemcodes WHERE  client = '$client' order by code";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
    $itemar[]=array('cat'=>$rows1['cat'],'code'=>$rows1['code'],'desc'=>$rows1['description']);
}
$itemdetails= json_encode($itemar);

$hide = 1;
$result = mysql_query("SHOW COLUMNS FROM `pp_sobi` LIKE '%tcs%'");
  $exists = (mysql_num_rows($result))?TRUE:FALSE;
  if($exists == TRUE)
    $hide = 0;

?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "../../getemployee.php"; ?>
<?php include "reportheader_AV1.php"; ?>

<table align="center" border="0">
<!-- <tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Purchase Report</font></strong></td>
</tr> -->

<tr>
 <td colspan="1" align="center"><strong><font color="#3e3276">From : </font></strong><?php echo date($datephp,strtotime($datef)); ?></td>&nbsp;&nbsp;&nbsp;
<td colspan="1" align="center"><strong><font color="#3e3
276">To : </font></strong><?php echo date($datephp,strtotime($datet)); ?></td>
<td colspan="1" align="center"><strong><font color="#3e3276">Company Name: </font></strong><?php 
$comid= $_GET['comid']; 
$comquery = "select distinct company from home_logo_multi_company where id='$comid'";
$comresult = mysql_query($comquery);
while($row = mysql_fetch_assoc($comresult)) {
  
  
  echo "<option value=\"\">" . ($row['company'] ? $row1['company'] : "--All--") . "</option>";
  echo '<option value="">--select state--</option>';
}


?></td>


 </tr>


<tr>
  <td colspan="1" align="center"><strong><font color="#3e3276">Branch : </font></strong><?php echo $branch; ?></td>
 <td colspan="1" align="center"><strong><font color="#3e3276">Warehouse : </font></strong><?php echo $warehouse; ?></td>
 <td colspan="1" align="center"><strong><font color="#3e3276">Supplier : </font></strong><?php echo $supplier; ?></td>
</tr>
<tr>
 <td colspan="1" align="center"><strong><font color="#3e3276">Category : </font></strong><?php echo $selcat; ?></td>
 <td colspan="1" align="center"><strong><font color="#3e3276">Item Code : </font></strong><?php echo $code; ?></td>
 <td colspan="1" align="center"><strong><font color="#3e3276">Item Description : </font></strong><?php echo $desc; ?></td>
 <td colspan="1" align="center"><strong><font color="#3e3276">Company: </font></strong><?php echo $comidShow; ?></td>
</tr>
</table>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "salesreport", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "salesreport_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "salesreport_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "salesreport_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "salesreport_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "salesreport_orderby", TRUE);


?>
<?php
$sExport = @$_GET["export"]; // Load export request
if ($sExport == "html") {

  // Printer friendly
}
if ($sExport == "excel") {
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
  header('Content-Type: application/vnd.ms-word');
  header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.doc');
}
?>
<?php

// Initialize common variables
// Paging variables

$nRecCount = 0; // Record count
$nStartGrp = 0; // Start group
$nStopGrp = 0; // Stop group
$nTotalGrps = 0; // Total groups
$nGrpCount = 0; // Group count
$nDisplayGrps = "ALL"; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
?>
<?php

// Field variables
$x_party = NULL; $x_partycode = NULL;
$x_date = NULL;
$x_invoice = NULL;
$x_totalquantity = NULL;
$x_finaltotal = NULL;

// Group variables
$o_party = NULL; $o_partycode = NULL; $g_party = NULL; $dg_party = NULL; $t_party = NULL; $ft_party = 200; $gf_party = $ft_party; $gb_party = ""; $gi_party = "0"; $gq_party = ""; $rf_party = NULL; $rt_party = NULL;

// Detail variables
$o_date = NULL; $t_date = NULL; $ft_date = 133; $rf_date = NULL; $rt_date = NULL;
$o_invoice = NULL; $t_invoice = NULL; $ft_invoice = 200; $rf_invoice = NULL; $rt_invoice = NULL;
$o_totalquantity = NULL; $t_totalquantity = NULL; $ft_totalquantity = 5; $rf_totalquantity = NULL; $rt_totalquantity = NULL;
$o_finaltotal = NULL; $t_finaltotal = NULL; $ft_finaltotal = 5; $rf_finaltotal = NULL; $rt_finaltotal = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 5;
$nGrps = 2;
$val = ewrpt_InitArray($nDtls, 0);
$cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ewrpt_InitArray($nDtls, 0);
$grandmn = ewrpt_InitArray($nDtls, NULL);
$grandmx = ewrpt_InitArray($nDtls, NULL);
// Set up if accumulation required
$col = array(FALSE, FALSE, FALSE, TRUE, TRUE);

// Set up groups per page dynamically
SetUpDisplayGrps();

// Set up popup filter
SetupPopup();

// Extended filter
$sExtendedFilter = "";

// Build popup filter
$sPopupFilter = GetPopupFilter();

//echo "popup filter: " . $sPopupFilter . "<br>";
if ($sPopupFilter <> "") {
  if ($sFilter <> "")
    $sFilter = "($sFilter) AND ($sPopupFilter)";
  else
    $sFilter = $sPopupFilter;
}

// No filter
$bFilterApplied = FALSE;

// Get sort
$sSort = getSort();

// Get total group count

// Show header
$bShowFirstHeader = true;

//$bShowFirstHeader = TRUE; // Uncomment to always show header
// Set up start position if not export all

if (EW_REPORT_EXPORT_ALL && @$sExport <> "")
    $nDisplayGrps = $nTotalGrps;
else
    SetUpStartGroup(); 

// Get current page groups
$rsgrp = GetGrpRs($sSql, $nStartGrp, $nDisplayGrps);

// Init detail recordset
$rs = NULL;
?>
<?php include "phprptinc/header.php"; ?>
<?php if (@$sExport == "") { ?>
<script type="text/javascript">
var EW_REPORT_DATE_SEPARATOR = "-";
if (EW_REPORT_DATE_SEPARATOR == "") EW_REPORT_DATE_SEPARATOR = "/"; // Default date separator
</script>
<script type="text/javascript" src="phprptjs/ewrpt.js"></script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<script type="text/javascript">
var EW_REPORT_POPUP_ALL = "(All)";
var EW_REPORT_POPUP_OK = "  OK  ";
var EW_REPORT_POPUP_CANCEL = "Cancel";
var EW_REPORT_POPUP_FROM = "From";
var EW_REPORT_POPUP_TO = "To";
var EW_REPORT_POPUP_PLEASE_SELECT = "Please Select";
var EW_REPORT_POPUP_NO_VALUE = "No value selected!";


// popup fields
</script>

<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" align="center" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="PurchaseReportnew.php?export=html&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&warehouse=<?php echo $warehouse; ?>&supplier=<?php echo $supplier; ?>&code=<?php echo $code; ?>&desc=<?php echo $desc; ?>&cat=<?php echo $selcat; ?>&branch=<?php echo $branch; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="PurchaseReportnewExcel.php?export=excel&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&warehouse=<?php echo $warehouse; ?>&supplier=<?php echo $supplier; ?>&code=<?php echo $code; ?>&desc=<?php echo $desc; ?>&cat=<?php echo $selcat; ?>&branch=<?php echo $branch; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="PurchaseReportnew.php">Reset All Filters</a>
<?php } ?>



<?php if (@$sExport == "") { ?>
<br /><br />
</div></td></tr>
<!-- Top Container (End) -->
<tr>
  <!-- Left Container (Begin) -->
  <td valign="top"><div id="ewLeft" class="phpreportmaker">
  <!-- Left slot -->
  </div></td>
  <!-- Left Container (End) -->
  <!-- Center Container - Report (Begin) -->
  <td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
  <!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary" align="center">
<table align="center" class="ewGrid" cellspacing="0" ><tr>
  <td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<table  border="0" cellspacing="0" cellpadding="0" >
<tr>
<td>
<span class="phpreportmaker">
From Date
<input type="text" size="8" id="fdate" name="fdate" value="<?php echo date($datephp,strtotime($fdate));?>" class="datepicker" readonly />


To Date
<input type="text" size="8" id="tdate" name="tdate" value="<?php echo date($datephp,strtotime($tdate));?>" class="datepicker" readonly />

Branch
<select id="branch" name="branch" >
<option value="All" >All</option>
<?php
$query1 = "SELECT distinct branch as branch FROM broiler_farm WHERE  client = '$client' order by branch";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['branch']; ?>" title="<?php echo $rows1['branch']; ?>" <?php if($branch == $rows1['branch']) { ?> selected="selected" <?php } ?>><?php echo $rows1['branch']; ?></option>
<?php
}?>
</select>

Warehouse
<select id="warehouse" name="warehouse" >
<option value="All" >All</option>

<?php
$query1 = "SELECT distinct warehouse as sector FROM pp_sobi WHERE  client = '$client' order by warehouse";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['sector']; ?>" title="<?php echo $rows1['sector']; ?>" <?php if($warehouse == $rows1['sector']) { ?> selected="selected" <?php } ?>><?php echo $rows1['sector']; ?></option>
<?php
}?>
</select>

Supplier
<select id="supplier" name="supplier" >
<option value="All" >All</option>

<?php
$query1 = "SELECT distinct vendor  FROM pp_sobi WHERE  client = '$client' order by vendor";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['vendor']; ?>" title="<?php echo $rows1['vendor']; ?>" <?php if($supplier == $rows1['vendor']) { ?> selected="selected" <?php } ?>><?php echo $rows1['vendor']; ?></option>
<?php
}?>
</select>

&nbsp;
Category
<select id="cat" name="cat" onchange="getItems(this.value);">
<option value="All" >All</option>
<?php
$query1 = "SELECT distinct(type) as cat FROM ims_itemtypes WHERE  client = '$client' order by type";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['cat']; ?>" title="<?php echo $rows1['cat']; ?>" <?php if($selcat == $rows1['cat']) { ?> selected="selected" <?php } ?>><?php echo $rows1['cat']; ?></option>
<?php
}?>
</select>

Item Code
<select id="code" name="code" onchange="document.getElementById('desc').options[this.selectedIndex].selected='selected'; ">
<option value="All" >All</option>
<?php

$query1 = "SELECT code,description FROM ims_itemcodes WHERE  client = '$client' $selcatcond order by code";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['code']; ?>" title="<?php echo $rows1['description']; ?>" <?php if($code == $rows1['code']) { ?> selected="selected" <?php } ?>><?php echo $rows1['code']; ?></option>
<?php
}?>
</select>

Item Description
<select id="desc" name="desc" onchange="document.getElementById('code').options[this.selectedIndex].selected='selected'; ">
<option value="All" >All</option>
<?php
$query1 = "SELECT code,description FROM ims_itemcodes WHERE  client = '$client' $selcatcond order by code";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['description']; ?>" title="<?php echo $rows1['code']; ?>" <?php if($desc == $rows1['description']) { ?> selected="selected" <?php } ?>><?php echo $rows1['description']; ?></option>
<?php
}?>
</select>
Company Name
<select id="company" name="company">
  <option value="All" <?php if(!isset($_GET['company'])  $_GET['company'] == 'All') { echo 'selected'; } ?>>All</option>
  <?php
    $sql= "select id, company from home_logo_multi_company";
    $result = mysql_query($sql);
    while($row= mysql_fetch_assoc($result)) {
      $selected = '';
      if(isset($_GET['company']) && $_GET['company'] == $row['company']) {
        $selected = 'selected';
      }
      echo "<option value=\"" . $row['id'] . "\"" . $selected . ">" . $row['company'] . "</option>";
    }
  ?>
</select>





    

<input type="button" name="report" id="report" value="Report"  onclick="reloadpage();"/>
</td>


</tr>
</table>
</div>
<?php } 
$grandqty = $grandamount = 0;
?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table align="center" class="ewTable ewTableSeparate" cellspacing="0">
<?php

// Set the last group to display if not export all
if (EW_REPORT_EXPORT_ALL && @$sExport <> "") {
  $nStopGrp = $nTotalGrps;
} else {
  $nStopGrp = $nStartGrp + $nDisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($nStopGrp) > intval($nTotalGrps))
  $nStopGrp = $nTotalGrps;
$nRecCount = 0;

// Get first row
if ($nTotalGrps > 0) {
  GetGrpRow(1);
  $nGrpCount = 1;
}

  // Show header
  if ($bShowFirstHeader) {
?>
  <thead>
  <tr>  
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Date
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Date</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Company Name
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Company Name</td>
      </tr></table>
    </td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Invoice
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Invoice</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Sobi Number
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Sobi Number</td>
      </tr></table>
    </td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Supplier
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Supplier</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Branch
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Branch</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Warehouse
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Warehouse</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Flock
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Flock</td>
      </tr></table>
    </td>
<?php } ?>
<?php  if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Driver Name
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Driver Name</td>
      </tr></table>
    </td>
<?php } ?>
<?php  if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Vehicle No
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Vehicle No</td>
      </tr></table>
    </td>
<?php } ?>
<?php  if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Item Category
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Item Category</td>
      </tr></table>
    </td>
<?php } ?>
<?php  if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Item Code
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Item Code</td>
      </tr></table>
    </td>
<?php } ?>
<?php  if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Item Description
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Item Description</td>
      </tr></table>
    </td>
<?php } ?>

<?php
$colsql = mysql_query("SHOW COLUMNS FROM ims_itemcodes LIKE 'hsncode'");
$exists = (mysql_num_rows($colsql))? TRUE : FALSE;
if($exists)
{
?>

<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    HSN
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>HSN</td>
      </tr></table>
    </td>
<?php } ?>

<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Sent Quantity
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Sent Quantity</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Received Quantity
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Received Quantity</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Free Quantity
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Free Quantity</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Weight
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Weight</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Price
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Price</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Actual Amount
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Actual Amount</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Discount
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Discount</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Discount %
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Discount %</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Freight Amount
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Freight Amount</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Freight Dated
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Freight Dated</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Cash Code
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Cash Code</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Tax%
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Tax%</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Tax Amount
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Tax Amount</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Amount
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Amount</td>
      </tr></table>
    </td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Total Quantity
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
<table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Total Quantity</td>
      </tr></table>
    </td>
<?php } ?>
<?php if($hide == 0){ ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    TCS Amount
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>TCS Amount</td>
      </tr></table>
    </td>
<?php } ?>
<?php } ?>
<?php if (@$sExport <> "") { ?>
    <td valign="bottom" class="ewTableHeader">
    Total Amount
    </td>
<?php } else { ?>
    <td class="ewTableHeader">
      <table cellspacing="0" class="ewTableHeaderBtn"><tr>
      <td>Total Amount</td>
      </tr></table>
    </td>
<?php } ?>

  </tr>
  </thead>
  <tbody>
<?php
    $bShowFirstHeader = FALSE;
  }
  $quant=0;$price=0;$desc=0;$totala=0;$totalq=0;$total=0;$tweight=0;$totalprice=0;$count=0;$freightamt=0;
  $tottcs = 0;
  $sql="select * from pp_sobi where date between '$fdate' and '$tdate' $condw  $conds $condc $selcatcond1 $comidconds order by date asc,invoice";
  $res=mysql_query($sql);
  while($row=mysql_fetch_array($res))
  {
    if(isset($row['tcsamount']))
      $tcs = $row['tcsamount'];
    else
      $tcs = 0;
    if($tcs == "")
      $tcs = 0;
    $count++;
    if($row['taxie']=='Exclude')
    {
      if($row['weight'] > 0)
         $amount=($row['weight']*$row['rateperunit'])+$row['taxamount']-$row['discountamount'];
       else
        if($row['qtytype'] == 2){
          $amount=($row['receivedquantity']*$row['rateperunit'])+$row['taxamount']-$row['discountamount'];
        }else{
          $amount=($row['sentquantity']*$row['rateperunit'])+$row['taxamount']-$row['discountamount'];
        }
    }
    else
    {
      if($row['weight'] > 0)
        $amount=($row['weight']*$row['rateperunit'])-$row['discountamount'];
      else
        if($row['qtytype'] == 2){
          $amount=($row['receivedquantity']*$row['rateperunit'])-$row['discountamount'];
        }else{
          $amount=($row['sentquantity']*$row['rateperunit'])-$row['discountamount'];
        }
    }
    if($row['freightie']=='Exclude')
    {
      $amount=$amount+$row['freightamount'];
    }
    
    
?>
  <tr>
 <td class="ewRptGrpField2" align="left" title='Date'>
<?php echo ewrpt_ViewValue(date('d.m.Y',strtotime($row['date']))) ?>
</td>
<td  align="left" title='Company Name'>
<!-- $comid = $_GET['comid'] -->

<?php
    if ($comid == 1) {
        $comquery = "SELECT DISTINCT company FROM home_logo_multi_company";
    } else {
        $comquery = "SELECT DISTINCT company FROM home_logo_multi_company WHERE id = '$comid'";
    }
    $comresult = mysql_query($comquery);
    if (mysql_num_rows($comresult) > 0) {
        $row = mysql_fetch_assoc($comresult);
        echo $row['company'];
    echo '<script>document.getElementById("company").value= "'. $row['company'] .'";</script>';
    } else {
        echo "all";
    }
?>
</td>
<td class="ewRptGrpField2" align="left" title='Invoice'>
<?php echo ewrpt_ViewValue($row['invoice']) ?>
</td>
<td class="ewRptGrpField2" align="left" title='Sobi Number'>
<?php echo ewrpt_ViewValue($row['so']) ?>
</td>
<td class="ewRptGrpField2" align="left" title='Customer'>
<?php echo ewrpt_ViewValue($row['vendor']) ?>
</td>
<?php $qry="select distinct(branch) from broiler_farm where farm ='".$row['warehouse']."' limit 1"; 
 $rlt=mysql_query($qry);
$rw=mysql_fetch_assoc($rlt);
 ?>
<td class="ewRptGrpField2" align="left" title='Warehouse'>
<?php echo ewrpt_ViewValue($rw['branch']) ?>
</td>
<td class="ewRptGrpField2" align="left" title='Warehouse'>
<?php echo ewrpt_ViewValue($row['warehouse']) ?>
</td>
<td class="ewRptGrpField2" align="left" title='Flock'>
<?php echo ewrpt_ViewValue($row['flock']) ?>
</td>
<td class="ewRptGrpField2" align="left" title='Driver Name'>
<?php echo ewrpt_ViewValue($row['driver']) ?>
</td>
<td class="ewRptGrpField2" align="left" title='Vehicle No'>
<?php echo ewrpt_ViewValue($row['vno']) ?>
</td>
<td class="ewRptGrpField2" align="left" title='Item Category'>
<?php 
  $q=mysql_fetch_assoc(mysql_query("select cat from ims_itemcodes where code='$row[code]'"));
  
echo ewrpt_ViewValue($q['cat']) ?>
</td>
<td class="ewRptGrpField2" align="left" title='Item Code'>
<?php echo ewrpt_ViewValue($row['code']) ?>
</td>
<td class="ewRptGrpField2" align="left" title='Item Description'>
<?php echo ewrpt_ViewValue($row['description']) ?>
</td>

<?php
$colsql = mysql_query("SHOW COLUMNS FROM ims_itemcodes LIKE 'hsncode'");
$exists = (mysql_num_rows($colsql))? TRUE : FALSE;
if($exists)
{
  $sql99 = "select hsncode from ims_itemcodes where description = '".$row['description']."'";
  $query99 = mysql_query($sql99,$conn1);
  $row99 = mysql_fetch_array($query99);
?>
<td class="ewRptGrpField2" align="left" title='Item Description'>
<?php echo ewrpt_ViewValue($row99['hsncode']) ?>
</td>
<?php } ?>

<td class="ewRptGrpField2" align="right" title='Sent Quantity'>
<?php if($row['sentquantity']!=''){echo ewrpt_ViewValue(changeprice($row['sentquantity'])); $squant+=$row['sentquantity'];}else{echo ewrpt_ViewValue(0.00);} ?>
</td>
<td class="ewRptGrpField2" align="right" title='Received Quantity'>
<?php if($row['receivedquantity']!=''){echo ewrpt_ViewValue(changeprice($row['receivedquantity'])); $rquant+=$row['receivedquantity'];}else{echo ewrpt_ViewValue(0.00);} ?>
</td>
<td class="ewRptGrpField2" align="right" title='Free Quantity'>
<?php if($row['fqty']!=''){echo ewrpt_ViewValue(changeprice($row['fqty'])); $free+=$row['fqty'];}else{echo ewrpt_ViewValue(0.00);} ?>
</td>
<td class="ewRptGrpField2" align="right" title='Weight'>
<?php if($row['weight']!=''){echo ewrpt_ViewValue(changeprice($row['weight'])); $tweight+=$row['weight'];}else{echo ewrpt_ViewValue(0.00);} ?>
</td>
<td class="ewRptGrpField2" align="right" title='Frice'>
<?php echo ewrpt_ViewValue(changeprice($row['rateperunit']));
$totalprice=$totalprice+$row['rateperunit'];  ?>
</td>
<td class="ewRptGrpField2" align="right" title='Price'>
<?php if($row['qtytype'] == 2){$act_amount = $row['receivedquantity']*$row['rateperunit'];}else{$act_amount = $row['sentquantity']*$row['rateperunit'];} echo ewrpt_ViewValue(changeprice($act_amount));
$tot_act_amount = $tot_act_amount+$act_amount;  ?>
</td>
<td class="ewRptGrpField2" align="right" title='Discount'>
<?php if($row['discountamount']!=''){echo ewrpt_ViewValue(changeprice($row['discountamount'])); $disc+=$row['discountamount'];}else{echo ewrpt_ViewValue(0.00);} ?>
</td>
<td class="ewRptGrpField2" align="right" title='Price'>
<?php $discount_per = ($row['discountamount']/$act_amount)*100; echo ewrpt_ViewValue($discount_per."%");
?>
</td>
<td class="ewRptGrpField2" align="right" title='Freight Amount'>
<?php if($row['freightamount']!=''){echo ewrpt_ViewValue(changeprice($row['freightamount'])); if($prev_invoice != $row['invoice'])$freightamt+=$row['freightamount'];}else{echo ewrpt_ViewValue(0.00);} ?>
</td>
<td class="ewRptGrpField2" align="right" title='Freight Dated'>
<?php echo ewrpt_ViewValue(date('d.m.Y',strtotime($row['datedf']))) ?>
</td>
<td class="ewRptGrpField2" align="right" title='Cash Code'>
<?php echo ewrpt_ViewValue($row['cashbankcode']) ?>
</td>
<td class="ewRptGrpField2" align="right" title='Tax%'>
<?php if($row['taxamount']!=''){echo ewrpt_ViewValue(($row['taxvalue']));}else{echo ewrpt_ViewValue(0);}?>
</td>
<td class="ewRptGrpField2" align="right" title='Tax Amount'>
<?php if($row['taxamount']!=''){echo ewrpt_ViewValue(changeprice($row['taxamount'])); $tax+=$row['taxamount'];}else{echo ewrpt_ViewValue(0.00);}?>
</td>
<td class="ewRptGrpField2" align="right" title='Amount'>
<?php echo ewrpt_ViewValue(changeprice($amount)); $total+=$amount; ?>
</td>
<td class="ewRptGrpField2" align="right" title='Total Quantity'>
<?php if($row['totalquantity']!=''){echo ewrpt_ViewValue(changeprice($row['receivedquantity']+$row['fqty']));}else{echo ewrpt_ViewValue(0.00);} ?>
</td>
<?php if($hide == 0){ ?>
<td class="ewRptGrpField2" align="right" title='TCS Amount'>
<?php echo ewrpt_ViewValue(changeprice($tcs)); ?>
</td>
<?php } ?>
<td class="ewRptGrpField2" align="right" title='Total Amount'>
<?php if($row['grandtotal']!=''){echo ewrpt_ViewValue(changeprice($row['grandtotal']));}else{echo ewrpt_ViewValue(0.00);} ?>
</td>
<?php 
 if(in_array($row['so'],$allinv)) {
   
 }
 else
 {
   //echo $row['tcsamount'];
   $totalq+=$row['totalquantity'];
   $totala+=$row['grandtotal'];
   $tottcs += $tcs;
 }
 $allinv[] = $row['so'];
 
 $prev_invoice = $row['invoice'];
 ?>
  </tr>
  
  
<?php 
  }

    // Accumulate page summary
    AccumulateSummary();

    // Save old group values
    $o_party = $x_party;

    // Get next record
    GetRow(2);

    // Show Footers


  // Next group
  $o_party = $x_party; // Save old group value
  GetGrpRow(2);
  $nGrpCount++;
 // End while
?>
<tr>
  <?php
  $colsql = mysql_query("SHOW COLUMNS FROM ims_itemcodes LIKE 'hsncode'");
  $exists = (mysql_num_rows($colsql))? TRUE : FALSE;
  if($exists)
  {
  ?>
  <td colspan="13" class="ewRptGrpField3" align="Right"><strong>Total</strong> </td>
  <?php }else{ ?>
  <td colspan="12" class="ewRptGrpField3" align="Right"><strong>Total</strong> </td>
  <?php } ?>
  <td class="ewRptGrpField3" align="right" title='Sent Quantity'><b><?php echo changeprice($squant); ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Received Quantity'><b><?php echo changeprice($rquant); ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Free Quantity'><b><?php echo changeprice($free); ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Weight'><b><?php echo changeprice($tweight); ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Price'><b><?php echo changeprice(round(($total/($rquant+$free)),2)); ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Discount'><b><?php echo changeprice($tot_act_amount); ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Discount'><b><?php echo changeprice($disc); ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Discount'><b><?php $tot_disc_per = ($disc/$tot_act_amount)*100; echo changeprice($tot_disc_per)."%"; ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Discount'><b><?php echo changeprice($freightamt); ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Discount'><b></b></td>
  <td></td><td></td>
  <td class="ewRptGrpField3" align="right" title='Tax'><b><?php echo changeprice($tax); ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Amount'><b><?php echo changeprice($total); ?></b></td>
  <td class="ewRptGrpField3" align="right" title='Total Quantity'><b><?php echo changeprice($rquant+$free); ?></b></td>
  <?php if($hide == 0){ ?>
    <td class="ewRptGrpField3" align="right" title='TCS Amount'><b><?php echo changeprice($tottcs); ?></b></td>
  <?php } ?>
  <td class="ewRptGrpField3" align="right" title='Total Amount'><b><?php echo changeprice($totala); ?></b></td>
  </tr>
  

  </tbody>
  <tfoot>

  </tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?> 
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel" style="display:none">
<form action="salesreportsmry1.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
  <table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
  <?php if ($Pager->FirstButton->Enabled) { ?>
  <td><a href="salesreportsmry1.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
  <?php } else { ?>
  <td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
  <?php } ?>
<!--previous page button-->
  <?php if ($Pager->PrevButton->Enabled) { ?>
  <td><a href="salesreportsmry1.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
  <?php } else { ?>
  <td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
  <?php } ?>
<!--current page number-->
  <td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
  <?php if ($Pager->NextButton->Enabled) { ?>
  <td><a href="salesreportsmry1.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>  
  <?php } else { ?>
  <td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
  <?php } ?>
<!--last page button-->
  <?php if ($Pager->LastButton->Enabled) { ?>
  <td><a href="salesreportsmry1.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>  
  <?php } else { ?>
  <td><img src="phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
  <?php } ?>
  <td><span class="phpreportmaker">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
  </tr></table>
  </td>  
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td>
  <span class="phpreportmaker"> <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
  <?php if ($sFilter == "0=101") { ?>
  <span class="phpreportmaker">Please enter search criteria</span>
  <?php } else { ?>
  <span class="phpreportmaker">No records found</span>
  <?php } ?>
<?php } ?>
    </td>
<?php if ($nTotalGrps > 0) { ?>
    <td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="right" valign="top" nowrap><span class="phpreportmaker">Groups Per Page&nbsp;
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">
<option value="1"<?php if ($nDisplayGrps == 1) echo " selected" ?>>1</option>
<option value="2"<?php if ($nDisplayGrps == 2) echo " selected" ?>>2</option>
<option value="3"<?php if ($nDisplayGrps == 3) echo " selected" ?>>3</option>
<option value="4"<?php if ($nDisplayGrps == 4) echo " selected" ?>>4</option>
<option value="5"<?php if ($nDisplayGrps == 5) echo " selected" ?>>5</option>
<option value="10"<?php if ($nDisplayGrps == 10) echo " selected" ?>>10</option>
<option value="20"<?php if ($nDisplayGrps == 20) echo " selected" ?>>20</option>
<option value="50"<?php if ($nDisplayGrps == 50) echo " selected" ?>>50</option>
<option value="500"<?php if ($nDisplayGrps == 500) echo " selected" ?>>500</option>
<option value="ALL"<?php if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] == -1) echo " selected" ?>>All</option>
</select>
    </span></td>
<?php } ?>
  </tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
</div>
<!-- Summary Report Ends -->
<?php if (@$sExport == "") { ?>
  </div><br /></td>
  <!-- Center Container - Report (End) -->
  <!-- Right Container (Begin) -->
<td valign="top"><div id="ewRight" class="phpreportmaker">
  <!-- Right slot -->
  </div></td>
  <!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
  <!-- Bottom slot -->
  </div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php
$conn->Close();

// display elapsed time
if (defined("EW_REPORT_DEBUG_ENABLED"))
  echo ewrpt_calcElapsedTime($starttime);
?>
<?php include "phprptinc/footer.php"; ?>
<?php

// Check level break
function ChkLvlBreak($lvl) {
  switch ($lvl) {
    case 1:
      return (is_null($GLOBALS["x_party"]) && !is_null($GLOBALS["o_party"])) 
        (!is_null($GLOBALS["x_party"]) && is_null($GLOBALS["o_party"])) 
        ($GLOBALS["x_party"] <> $GLOBALS["o_party"]);
  }
}

// Accummulate summary
function AccumulateSummary() {
  global $smry, $cnt, $col, $val, $mn, $mx;
  $cntx = count($smry);
  for ($ix = 0; $ix < $cntx; $ix++) {
    $cnty = count($smry[$ix]);
    for ($iy = 1; $iy < $cnty; $iy++) {
      $cnt[$ix][$iy]++;
      if ($col[$iy]) {
        $valwrk = $val[$iy];
        if (is_null($valwrk)  !is_numeric($valwrk)) {

          // skip
        } else {
          $smry[$ix][$iy] += $valwrk;
          if (is_null($mn[$ix][$iy])) {
            $mn[$ix][$iy] = $valwrk;
            $mx[$ix][$iy] = $valwrk;
          } else {
            if ($mn[$ix][$iy] > $valwrk) $mn[$ix][$iy] = $valwrk;
            if ($mx[$ix][$iy] < $valwrk) $mx[$ix][$iy] = $valwrk;
          }
        }
      }
    }
  }
  $cntx = count($smry);
  for ($ix = 1; $ix < $cntx; $ix++) {
    $cnt[$ix][0]++;
  }
}

// Reset level summary
function ResetLevelSummary($lvl) {
  global $smry, $cnt, $col, $mn, $mx, $nRecCount;

  // Clear summary values
  $cntx = count($smry);
  for ($ix = $lvl; $ix < $cntx; $ix++) {
    $cnty = count($smry[$ix]);
    for ($iy = 1; $iy < $cnty; $iy++) {
      $cnt[$ix][$iy] = 0;
      if ($col[$iy]) {
        $smry[$ix][$iy] = 0;
        $mn[$ix][$iy] = NULL;
        $mx[$ix][$iy] = NULL;
      }
    }
  }
  $cntx = count($smry);
  for ($ix = $lvl; $ix < $cntx; $ix++) {
    $cnt[$ix][0] = 0;
  }

  // Clear old values
  if ($lvl <= 1) $GLOBALS["o_party"] = "";

  // Reset record count
  $nRecCount = 0;
}

// Accummulate grand summary
function AccumulateGrandSummary() {
  global $cnt, $col, $val, $grandsmry, $grandmn, $grandmx;
  @$cnt[0][0]++;
  for ($iy = 1; $iy < count($grandsmry); $iy++) {
    if ($col[$iy]) {
      $valwrk = $val[$iy];
      if (is_null($valwrk)  !is_numeric($valwrk)) {

        // skip
      } else {
        $grandsmry[$iy] += $valwrk;
        if (is_null($grandmn[$iy])) {
          $grandmn[$iy] = $valwrk;
          $grandmx[$iy] = $valwrk;
        } else {
          if ($grandmn[$iy] > $valwrk) $grandmn[$iy] = $valwrk;
          if ($grandmx[$iy] < $valwrk) $grandmx[$iy] = $valwrk;
        }
      }
    }
  }
}

// Get group count
function GetGrpCnt($sql) {
  global $conn;

  //echo "sql (GetGrpCnt): " . $sql . "<br>";
  $rsgrpcnt = $conn->Execute($sql);
  $grpcnt = ($rsgrpcnt) ? $rsgrpcnt->RecordCount() : 0;
  return $grpcnt;
}

// Get group rs
function GetGrpRs($sql, $start, $grps) {
  global $conn;
  $wrksql = $sql . " LIMIT " . ($start-1) . ", " . ($grps);

  //echo "wrksql: (rsgrp)" . $sSql . "<br>";
  $rswrk = $conn->Execute($wrksql);
  return $rswrk;
}

// Get group row values
function GetGrpRow($opt) {
  global $rsgrp;
  if (!$rsgrp)
    return;
  if ($opt == 1) { // Get first group

    //$rsgrp->MoveFirst(); // NOTE: no need to move position
  } else { // Get next group
    $rsgrp->MoveNext();
  }
  if ($rsgrp->EOF) {
    $GLOBALS['x_party'] = "";
  } else {
    $GLOBALS['x_party'] = $rsgrp->fields('party');
  }
}
// Get row values
function GetRow($opt) {
  global $rs, $val;
  if (!$rs)
    return;
  if ($opt == 1) { // Get first row
    $rs->MoveFirst();
  } else { // Get next row
    $rs->MoveNext();
  }
  if (!$rs->EOF) {
    $GLOBALS['x_date'] = $rs->fields('date');
    $GLOBALS['x_invoice'] = $rs->fields('invoice');
    $GLOBALS['x_totalquantity'] = $rs->fields('totalquantity');
    $GLOBALS['x_finaltotal'] = $rs->fields('finaltotal');
    $GLOBALS['x_bookinvoice'] = $rs->fields('bookinvoice');
    $val[1] = $GLOBALS['x_date'];
    $val[2] = $GLOBALS['x_invoice'];
    $val[3] = $GLOBALS['x_totalquantity'];
    $val[4] = $GLOBALS['x_finaltotal'];
    $val[5] = $GLOBALS['x_bookinvoice'];
  } else {
    $GLOBALS['x_date'] = "";
    $GLOBALS['x_invoice'] = "";
    $GLOBALS['x_totalquantity'] = "";
    $GLOBALS['x_finaltotal'] = "";
    $GLOBALS['x_bookinvoice'] = "";
  }
}

//  Set up starting group
function SetUpStartGroup() {
  global $nStartGrp, $nTotalGrps, $nDisplayGrps;

  // Exit if no groups
  if ($nDisplayGrps == 0TABLE_START_GROUP] != "") {
    $nStartGrp = $_GET[EW_REPORT_TABLE_START_GROUP];
    $_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
  } elseif (@$_GET["pageno"] != "") {
    $nPageNo = $_GET["pageno"];
    if (is_numeric($nPageNo)) {
      $nStartGrp = ($nPageNo-1)*$nDisplayGrps+1;
      if ($nStartGrp <= 0) {
        $nStartGrp = 1;
      } elseif ($nStartGrp >= intval(($nTotalGrp["sel_$sName"]) : 0;
      if ($cntValues > 0) {
        $arValues = ewrpt_StripSlashes($_POST["sel_$sName"]);
        if (trim($arValues[0]) == "") // Select all
          $arValues = EW_REPORT_INIT_VALUE;
        $_SESSION["sel_$sName"] = $arValues;
        $_SESSION["rf_$sName"] = ewrpt_StripSlashes(@$_POST["rf_$sName"]);
        $_SESSION["rt_$sName"] = ewrpt_StripSlashes(@$_POST["rt_$sName"]);
        ResetPager();
      }
    }

  // Get 'reset' command
  } elseif (@$_GET["cmd"] <> "") {
    $sCmd = $_GET["cmd"];
    if (strtolower($sCmd) == "reset") {
      ResetPager();
    }
  }

  // Load selection criteria to array
}

// Reset pager
function ResetPager() {

  // Reset start position (reset command)
  global $nStartGrp, $nTotalGrps;
  $nStartGrp = 1;
  $_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
}
?>
<?php
// Set up number of groups displayed per page
function SetUpDisplayGrps() {
  global $nDisplayGrps, $nStartGrp;
  $sWrk = @$_GET[EW_REPORT_TABLE_GROUP_PER_PAGE];
  if ($sWrk <> "") {
    if (is_numeric($sWrk)) {
      $nDisplayGrps = intval($sWrk);
    } else {
      if (strtoupper($sWrk) == "ALL") { // display all groups
        $nDisplayGrps = -1;
      } else {
        $nDisplayGrps = "ALL"; // Non-numeric, load default
      }
    }
    $_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] = $nDisplayGrps; // Save to session

    // Reset start position (reset command)
    $nStartGrp = 1;
    $_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
  } else {
    if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] <> "") {
      $nDisplayGrps = $_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE]; // Restore from session
    } else {
      $nDisplayGrps = "ALL"; // Load default
    }
  }
}
?>
<?php

// Return poup filter
function GetPopupFilter() {
  $sWrk = "";
  return $sWrk;
}
?>
<?php

//-------------------------------------------------------------------------------
// Function getSort
// - Return Sort parameters based on Sort Links clicked
// - Variables setup: Session[EW_REPORT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
function getSort()
{

  // Check for a resetsort command
  if (strlen(@$_GET["cmd"]) > 0) {
    $sCmd = @$_GET["cmd"];
    if ($sCmd == "resetsort") {
      $_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "";
      $_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = 1;
      $_SESSION["sort_salesreport_party"] = "";
      $_SESSION["sort_salesreport_date"] = "";
      $_SESSION["sort_salesreport_invoice"] = "";
      $_SESSION["sort_salesreport_totalquantity"] = "";
      $_SESSION["sort_salesreport_finaltotal"] = "";
    }

  // Check for an Order parameter
  } elseif (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY]) > 0) {
    $sSortSql = "";
    $sSortField = "";
    $sOrder = @$_GET[EW_REPORT_TABLE_ORDER_BY];
    if (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE]) > 0) {
      $sOrderType = @$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE];
    } else {
      $sOrderType = "";
    }
  }

  // Set up default sort
  if (@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] == "") {
    @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "oc_cobi.invoice ASC";
    $_SESSION["sort_salesreport_invoice"] = "ASC";
  }
  return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
<script type="text/javascript">
           
    var itemdetails=<?php echo $itemdetails; ?>;
    var itemdetailslen=0;
    
    if(itemdetails!=null)
        itemdetailslen=itemdetails.length;
    
    
    function getItems(val)
    {
        
        var coderef=document.getElementById('code');
        var descref=document.getElementById('desc');
        coderef.options.length=1;
        descref.options.length=1;        
        if(val=='All')
        {
            for( var i=0;i<itemdetailslen;i++)
            {               
                    theOption1=document.createElement("OPTION");
                    theText1=document.createTextNode(itemdetails[i]['code']);
                    theOption1.value = itemdetails[i]['code'];
                    theOption1.title = itemdetails[i]['desc'];
                    theOption1.appendChild(theText1);
                    coderef.appendChild(theOption1);
                    
                    theOption1=document.createElement("OPTION");
                    theText1=document.createTextNode(itemdetails[i]['desc']);
                    theOption1.value = itemdetails[i]['desc'];
                    theOption1.title = itemdetails[i]['code'];
                    theOption1.appendChild(theText1);
                    descref.appendChild(theOption1);
             
            }
        }
        else
        {            
            for( var i=0;i<itemdetailslen;i++)
            {
                
                if(val==itemdetails[i]['cat'])
                {
                    theOption1=document.createElement("OPTION");
                    theText1=document.createTextNode(itemdetails[i]['code']);
                    theOption1.value = itemdetails[i]['code'];
                    theOption1.title = itemdetails[i]['desc'];
                    theOption1.appendChild(theText1);
                    coderef.appendChild(theOption1);
                    
                    theOption1=document.createElement("OPTION");
                    theText1=document.createTextNode(itemdetails[i]['desc']);
                    theOption1.value = itemdetails[i]['desc'];
                    theOption1.title = itemdetails[i]['code'];
                    theOption1.appendChild(theText1);
                    descref.appendChild(theOption1);
                }
            }
        }
    }
    
function reloadpage()
{
      var str1 = document.getElementById("fdate").value;
            var str2 = document.getElementById("tdate").value;
            var warehouse=document.getElementById('warehouse').value;
      var branch=document.getElementById('branch').value;
      var code=document.getElementById('code').value;
      var desc=document.getElementById('desc').value;
      var supplier=document.getElementById('supplier').value;
      var supplier=document.getElementById('supplier').value;
      var comid = document.getElementById('company').value;
            var cat=document.getElementById('cat').value;
                        
            var dt1  = parseInt(str1.substring(0,2),10);
            var mon1 = parseInt(str1.substring(3,5),10);
            var yr1  = parseInt(str1.substring(6,10),10);
            var dt2  = parseInt(str2.substring(0,2),10);
            var mon2 = parseInt(str2.substring(3,5),10);
            var yr2  = parseInt(str2.substring(6,10),10);
            var date1 = new Date(yr1, mon1, dt1);
            var date2 = new Date(yr2, mon2, dt2);
            if(date2 < date1)
            {
                alert("From date cannot be greater than to date");
        return false;
                                
            }
      else{
  
  
  document.location = "PurchaseReportnew_AV1.php?fdate=" + str1 + "&tdate=" + str2 + "&warehouse=" + warehouse+ "&supplier=" + supplier+ "&code=" + code+ "&desc=" + desc+ "&cat=" + cat+ "&branch=" + branch+ "&comid="+comid;
}
  
}
function checkfdate()
{
      var str1 = document.getElementById("fdate").value;
            var str2 = document.getElementById("tdate").value;
            var dt1  = parseInt(str1.substring(0,2),10);
            var mon1 = parseInt(str1.substring(3,5),10);
            var yr1  = parseInt(str1.substring(6,10),10);
            var dt2  = parseInt(str2.substring(0,2),10);
            var mon2 = parseInt(str2.substring(3,5),10);
            var yr2  = parseInt(str2.substring(6,10),10);
            var date1 = new Date(yr1, mon1, dt1);
            var date2 = new Date(yr2, mon2, dt2);
            if(date2 < date1)
            {
                alert("From date cannot be greater than to date");
        return false;
                                
            }
      else
      {
        reloadpage();
      }
}
function checktdate()
{
      var str1 = document.getElementById("fdate").value;
            var str2 = document.getElementById("tdate").value;
            var dt1  = parseInt(str1.substring(0,2),10);
            var mon1 = parseInt(str1.substring(3,5),10);
            var yr1  = parseInt(str1.substring(6,10),10);
            var dt2  = parseInt(str2.substring(0,2),10);
            var mon2 = parseInt(str2.substring(3,5),10);
            var yr2  = parseInt(str2.substring(6,10),10);
            var date1 = new Date(yr1, mon1, dt1);
            var date2 = new Date(yr2, mon2, dt2);
            if(date2 < date1)
            {
        alert("To date should not be less than from date");
        return false;
                                
            }
      else
      {
        reloadpage();
      }
}  





</script>

