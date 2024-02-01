<?php
// This script and data application were generated by AppGini 5.70
// Download AppGini for free from https://bigprof.com/appgini/download/
	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/schedule.php");
	include("$currDir/schedule_dml.php");
	// mm: can the current member access this page?
	$perm=getTablePermissions('schedule');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}
	$x = new DataList;
	$x->TableName = "schedule";
	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`schedule`.`id`" => "id",
		"`schedule`.`date`" => "date",
		"`schedule`.`time`" => "time",
		"`schedule`.`presenter`" => "presenter",
		"`schedule`.`event`" => "event"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`schedule`.`id`',
		2 => '`schedule`.`date`',
		3 => '`schedule`.`time`',
		4 => '`schedule`.`presenter`',
		5 => '`schedule`.`event`'
	);
	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`schedule`.`id`" => "id",
		"`schedule`.`date`" => "date",
		"`schedule`.`time`" => "time",
		"`schedule`.`presenter`" => "presenter",
		"`schedule`.`event`" => "event"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`schedule`.`id`" => "ID",
		"`schedule`.`date`" => "Date",
		"`schedule`.`time`" => "Time",
		"`schedule`.`presenter`" => "Presenter",
		"`schedule`.`event`" => "Event"
	);
	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`schedule`.`id`" => "id",
		"`schedule`.`date`" => "date",
		"`schedule`.`time`" => "time",
		"`schedule`.`presenter`" => "presenter",
		"`schedule`.`event`" => "event"
	);
	// Lookup fields that can be used as filterers
	$x->filterers = array();
	$x->QueryFrom = "`schedule` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';
	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = true;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 1;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 1;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "schedule_view.php";
	$x->RedirectAfterInsert = "schedule_view.php?SelectedID=#ID#";
	$x->TableTitle = "Schedule";
	$x->TableIcon = "resources/table_icons/award_star_bronze_2.png";
	$x->PrimaryKey = "`schedule`.`id`";
	$x->ColWidth   = array(  150, 150, 150, 150, 150);
	$x->ColCaption = array("Date", "Time", "Presenter", "Event");
	$x->ColFieldName = array('date', 'time', 'presenter', 'event');
	$x->ColNumber  = array(2, 3, 4, 5);
	// template paths below are based on the app main directory
	$x->Template = 'templates/schedule_templateTV.html';
	$x->SelectedTemplate = 'templates/schedule_templateTVS.html';
	$x->TemplateDV = 'templates/schedule_templateDV.html';
	$x->TemplateDVP = 'templates/schedule_templateDVP.html';
	$x->ShowTableHeader = 1;
	$x->ShowRecordSlots = 0;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';
	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `schedule`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='schedule' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `schedule`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='schedule' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`schedule`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: schedule_init
	$render=TRUE;
	if(function_exists('schedule_init')){
		$args=array();
		$render=schedule_init($x, getMemberInfo(), $args);
	}
	if($render) $x->Render();
	// hook: schedule_header
	$headerCode='';
	if(function_exists('schedule_header')){
		$args=array();
		$headerCode=schedule_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}
	echo $x->HTML;
	// hook: schedule_footer
	$footerCode='';
	if(function_exists('schedule_footer')){
		$args=array();
		$footerCode=schedule_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>