<?php
/***************************************************************************
*                            functions_tables.php
*                            --------------------
*   begin                : Wednesday, Nov 5, 2008
*   copyright            : (C) 2007-2009 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2009 Douglas Wagner
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
****************************************************************************/

/**
* Gets a list of column names from the column_header table for the input report view name.
*	The column name, visibility and image url for the column is returned in sorted order
*	by "position".
* @param string $view_name - The name of the report view to return columns for.
* @return array $table_headers - The array of data including column name, visibility, and image URL
* @access public
*/
function getVisibleColumns($view_name) 
{
	global $phpraid_config, $db_raid, $phprlang, $col_mod;
	global $wrm_global_resistance, $wrm_global_classes, $wrm_global_roles;
	
	$table_headers = array();
	$position_counter = 0; // Position addend that will incriment for classes and roles.
	
	// Get all the columns from the column_header table
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "column_headers WHERE view_name = %s ORDER BY position", quote_smart($view_name));
	
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	// Fail if something isn't returned.
	if (!$db_raid->sql_numrows($result) || $db_raid->sql_numrows($result) < 1)
		return FALSE;

	// Cycle all the columns in the table name view.
	while($data = $db_raid->sql_fetchrow($result, true)) 
	{		
		$column_name = $data['column_name'];

		// Modify Column Visibility from the $col_mod array.
		$visibility = $data['visible'];
		for ($i = 0; $i < count($col_mod); $i++)
		{
			if ($column_name == $col_mod[$i]['name'])
				$visibility = $col_mod[$i]['visibility'];
		}
				
		//Replace Columns that start with @ with the proper header names (used to replace
		//  generic "Role1" header with the proper "Role1" header from config.)
		if (strncmp($column_name, '@', 1) == 0)
		{
			//It's a replacement variable, determine what replacement.
			$repstr = substr($column_name, 1);
			if ($repstr == 'role')
			{
				foreach ($wrm_global_roles as $global_role)
				{
					array_push($table_headers,
						array(
							'column_name'=>$global_role['role_name'],
							'visible'=>$visibility,
							'position'=>$data['position']+$position_counter,
							'img_url'=>$global_role['image'],
							'col_text'=>$global_role['role_name'],
							'format_code'=>$data['format_code'],
							'default_sort'=>$data['default_sort'],
						)
					);			
					$position_counter++;
				}
			}
			elseif ($repstr == 'class')
			{
				foreach ($wrm_global_classes as $global_class)
				{
					array_push($table_headers,
						array(
							'column_name'=>$global_class['class_id'],
							'visible'=>$visibility,
							'position'=>$data['position']+$position_counter,
							'img_url'=>$global_class['image'],
							'col_text'=>$global_class['lang_index'],
							'format_code'=>$data['format_code'],
							'default_sort'=>$data['default_sort'],
						)
					);	
					$position_counter++;		
				}
			}
			elseif ($repstr == 'resistance')
			{
				foreach ($wrm_global_resistance as $global_resistance)
				{
					array_push($table_headers,
						array(
							'column_name'=>$global_resistance['resistance_name'],
							'visible'=>$visibility,
							'position'=>$data['position']+$position_counter,
							'img_url'=>$global_resistance['image'],
							'col_text'=>$global_resistance['lang_index'],
							'format_code'=>$data['format_code'],
							'default_sort'=>$data['default_sort'],
						)
					);	
					$position_counter++;		
				}
			}
			else
			{
				echo "Invalid replacement variable";
			}
		}
		else
		{
			// Determine what the Actual Text of the Column Should Be.
			// To hide Role columns you must pass the role name as listed in the config.
			if ($data['lang_idx_hdr']=='')
				$col_head_text = $column_name;
			else
				$col_head_text = $phprlang[$data['lang_idx_hdr']];
			
			// Modify Column Visibility from the $col_mod array.
			$visibility = $data['visible'];
			for ($i = 0; $i < count($col_mod); $i++)
			{
				if ($column_name == $col_mod[$i]['name'])
					$visibility = $col_mod[$i]['visibility'];
			}
				
			array_push($table_headers,
				array(
					'column_name'=>$column_name,
					'visible'=>$visibility,
					'position'=>$data['position'],
					'img_url'=>$data['img_url'],
					'col_text'=>$col_head_text,
					'format_code'=>$data['format_code'],
					'default_sort'=>$data['default_sort'],
				)
			);
		}
	}
	return $table_headers;
}

/**
* Takes in an inital array of data, sorts the data based upon an input field, paginates
* the data according to a start record and the $phpraid_config['records_per_page'] config
* item, and then formats each of the columns according to the database format field.
* @param array $dataArray - Array holding the data for formatting.
* @param string $sortField - Field Name to Sort By, blank is an unsorted array.
* @param boolean $sortDesc - A True/False flag for whether or not to sort in descending order (TRUE = Descending Sort).
* @param int $startRecord - The Record Number to start at.
* @param string $viewName - The name of the report view the data pertains to, used for formatting fields.
* @return array $formattedArray - The array of data sorted, trimmed for pagination, and formatted.
* @access public
*/
function paginateSortAndFormat($dataArray, $sortField, $sortDesc, $startRecord, $viewName)
{
	$sortedArray = array();
	$trimmedArray = array();
	$formattedArray = array();
	
	if (empty($dataArray))
		return $dataArray;
		
	// First we need to sort the data in the array.
	$sortedArray = _sortData($dataArray, $sortField, $sortDesc);
	
	// Next we Paginate and limit the data returned for display
	$trimmedArray = _paginateData($sortedArray, $startRecord);

	// Finally we parse each column on it's format type and apply formatting properly
	$formattedArray = _formatData($trimmedArray, $viewName);
	
	// We're done, Return the Data array for display.
	return $formattedArray;
}

/**
* Calculates Start, End, and Total records in data set, as well as the count of columns of data.
* @param array $dataArray - Array holding the data for which counting should occur.
* @param array $headerArray - Array holding the column headers for which counting should occur. 
* @param number $startRecord - The Starting Record for the page.
* @return array $recCountArr - Array holding the various needed counts.
* @access public
*/
function getRecordCounts($dataArray, $headerArray, $startRecord)
{
	global $phpraid_config, $phprlang;
	
	$recCountArr = array();

	$totalRecords = count($dataArray);
	$endRecord = $startRecord + $phpraid_config['records_per_page'] - 1;
	if ($endRecord > $totalRecords) 
		$endRecord = $totalRecords;
	
	$column_count = count($headerArray);
		
	$recCountArr['startRecord'] = $startRecord;
	$recCountArr['endRecord'] = $endRecord;
	$recCountArr['totalRecords'] = $totalRecords;
	$recCountArr['columnCount'] = $column_count;
	$recCountArr['recordHeader'] =$phprlang['records'] . " " . $startRecord . " " . $phprlang['to'] . " " . 
								$endRecord . " " . $phprlang['of'] . " " . $totalRecords . " " . $phprlang['total'] . ".";		
		
	return $recCountArr;
}

/**
* Takes an inital array of data and calculates the "jump to" links for the page.  This should
* return a string of links with | in between for each page.  Previous and Next buttons included.
* @param array $dataArray - Array holding the data for which pagination should occur.
* @param string $startRecord - The "current page" start record to calculate which page should not be linked. 
* @return string $jumpMenu - The string of anchor tags to jump between the various data.
* @access public
*/
function getPageNavigation($dataArray, $startRecord, $pageURL, $sortField, $sortDesc)
{	
	global $phpraid_config;
	
	$maxPerPage = $phpraid_config['records_per_page'];
	$intTotalRecords = count($dataArray); // Gets the total number of records to page.
	$totalPages = ceil($intTotalRecords / $maxPerPage); // Gets the total number of pages.
	$currPage = ceil($startRecord / $maxPerPage); // Gets the Current Page Number
	$prevPage = $currPage - 1; // Get the page number for the "<< Prev" link.
	$nextPage = $currPage + 1; // Get the page number for teh "Next >>" link.
	
	if ((($currPage == $totalPages)&&$currPage == 1)||($totalPages == 0))
		return;
	
	// Start Calculating the HRefs.
	
	//Add Prev Link
	if ($prevPage == 0)
		$jumpMenu = "<< Prev | ";
	else
	{
		$recordBase = (($prevPage - 1) * $maxPerPage) + 1;
		$jumpMenu = '<a href="' . $pageURL . 'Base=' . $recordBase . '&amp;Sort=' . $sortField . '&SortDescending=' . $sortDesc . '">&lt;&lt; Prev</a> | ';
	}
	//Add Page Number Links 
	for ($i = 1; $i <= $totalPages; $i++)
	{
		if ($i == $currPage)
		{
			$jumpMenu .= $i . ' | ';
		}
		else
		{
			$recordBase = (($i - 1) * $maxPerPage) + 1;
			$jumpMenu .= '<a href="' . $pageURL . 'Base=' . $recordBase . '&amp;Sort=' . $sortField . '&SortDescending=' . $sortDesc . '">' . $i . '</a> | ';			
		}
	}
	//Add Next Link
	if ($currPage == $totalPages)
		$jumpMenu .= "Next >>";
	else
	{
		$recordBase = ($currPage * $maxPerPage) + 1;
		$jumpMenu .= '<a href="' . $pageURL . 'Base=' . $recordBase . '&amp;Sort=' . $sortField . '&SortDescending=' . $sortDesc . '">Next &gt;&gt;</a>';
	}
	
	return $jumpMenu;
}

/**
* Overrides the default column visibility value in the column table and sets the column to
* hidden.  This is done so that specific fields can be made available only to specific groups
* of users.
* 
* @param string $colName The name of the column to hide.
* @return bool A TRUE/FALSE value identifying success or failure.
* @access public
*/
function hideCol($colName)
{
	global $col_mod;
	
	$arrSize = count($col_mod);
	$colFound = FALSE;
	
	for ($i = 0; $i < $arrSize; $i++)
	{
		if ($colName == $col_mod[$i]['name'])
			$col_mod[$i]['visibility'] = FALSE;
		$colFound = TRUE; 
	}
	if ($colFound == FALSE)
	{
		$col_mod[$i]['name'] = $colName;
		$col_mod[$i]['visibility'] = FALSE;
	}
	return TRUE;
}

/**
* Overrides the default column visibility value in the column table and sets the column to
* visible.  This is done so that specific fields can be made available only to specific groups
* of users.
* 
* @param string $colName The name of the column to show.
* @return bool A TRUE/FALSE value identifying success or failure.
* @access public
*/
function showCol($colName)
{
	global $col_mod;
	
	$arrSize = count($col_mod);
	$colFound = FALSE;
	
	for ($i = 0; $i < $arrSize; $i++)
	{
		if ($colName == $col_mod[$i]['name'])
			$col_mod[$i]['visibility'] = TRUE;
		$colFound = TRUE; 
	}
	if ($colFound == FALSE)
	{
		$col_mod[$i]['name'] = $colName;
		$col_mod[$i]['visibility'] = TRUE;
	}
	return TRUE;
}

/*******************************
 * Internal Targets
 * *****************************/

/**
* Takes in an inital array of data and sorts the data based upon an input field.  Should be
* called only by "paginate_sort_and_format()".
* @param array $dataArray - Array holding the data for sorting.
* @param string $sortField - Field Name to Sort By, blank is an unsorted array.
* @param boolean $sortDesc - A True/False flag for whether or not to sort in descending order (TRUE = Descending Sort).
* @return array $dataArray - The array of sorted data.
* @access private
*/
function _sortData($dataArray, $sortField, $sortDesc)
{
	$sortarray = array();
	
	// Sort results before displaying, if necessary
    if ($sortField != '') 
    {
    	// Sort the array on the specified value
		foreach ($dataArray as $curRecord)
		   	$sortarray[] = $curRecord[$sortField];

		array_multisort($sortarray, $dataArray);
		
		// Sort descending, if necessary
		if ($sortDesc) 
			$dataArray = array_reverse($dataArray);
  	}
  	
  	return $dataArray;
}

/**
* Takes in an inital array of data and paginates the data based upon a max records per page
* parameter set by the user.  Should be called only by "paginate_sort_and_format()".
* @param array $dataArray - Array holding the data for pagination.
* @param string $startRecord - Record Number to Start with. (this is a "1" based number).
* @return array $dataArray - The array of paginated data...only the data belonging to the correct "page" will be returned.
* @access private
*/
function _paginateData($dataArray, $startRecord)
{
	global $phpraid_config;
	
	$pagedData = array();
	$maxPerPage = $phpraid_config['records_per_page'];
	
	$intTotalRecords = count($dataArray);
	if ($intTotalRecords == 0) 
	{
		// No records to work with
		return($dataArray);
	}

	// Figure out how many of the results we're actually supposed to show
	$intFirstRecord = $startRecord;
	if ($intTotalRecords <= $maxPerPage) 
	{
		// Show all the records
		$intLastRecord = $intTotalRecords;
	}
	else 
	{
		// Show only the specified number of records per page
		$intLastRecord = $intFirstRecord + $maxPerPage - 1;
		if ($intLastRecord > $intTotalRecords)  
			$intLastRecord = $intTotalRecords; 
	}
	
	// At this point we have $intFirstRecord, $intLastRecord set, process $dataArray to 
	//    $pagedData to write sorted records for the page.
	$X = 0; // Set Paged Data Index.
	for ($i = $intFirstRecord; $i <= $intLastRecord; $i++)
	{
		$pagedData[$X] = $dataArray[$i-1];
		$X=$X+1;
	}
	
	return $pagedData;
}

/**
* Takes in an inital array of data and formats the data based upon a formatting code attached
* to the column in the wrm_column_headers table.  Should be called only by "paginate_sort_and_format()".
* @param array $dataArray - Array holding the data for formatting...the data should already be sorted.
* @param string $viewName - "view_name" from the wrm_column_headers table for what view to work with. 
* @return array $formattedData - The array of data for which all columns are formatted according to the database value.
* @access private
*/
function _formatData($dataArray, $viewName)
{
	global $phpraid_config, $db_raid;
	
	$formattedArray = array();
	$formattedData = array();
	
	$tableColumns = getVisibleColumns($viewName);
	
	$numRecs = count($dataArray);
	
	$x=0;
	for ($x = 0; $x < $numRecs; $x++)
	{
		foreach($tableColumns as $colName)
		{
			if ($colName['format_code'] != '')
			{
				$formattedData = _formatListValue($dataArray[$x][$colName['column_name']], $colName['format_code']);
				$dataArray[$x][$colName['column_name']] = $formattedData;
			}
		}
	}
	
	return $dataArray;
}

/**
*Used to obtain a two letter representation of the day of the week that is internationalized.
* @param array $varDate An array of date data obtained from the "GetDate" function.
* @return string - The two letter representation of the day of the week, obtaned from the language files.
* @access private
*/
function _getDayString($varDate)
{
	global $phprlang;
		
	$dayofweek = $varDate['wday'];
		
	switch ($dayofweek) {
		case '0' :
			$daystr = $phprlang['2ltrsunday'];
			break;
		case '1' :
			$daystr = $phprlang['2ltrmonday'];
			break;
		case '2' :
			$daystr = $phprlang['2ltrtuesday'];
			break;
		case '3' :
			$daystr = $phprlang['2ltrwednesday'];
			break;
		case '4' :
			$daystr = $phprlang['2ltrthursday'];
			break;
		case '5' :
			$daystr = $phprlang['2ltrfriday'];
			break;
		case '6' :
			$daystr = $phprlang['2ltrsaturday'];
			break;
		default :
			$daystr = '';
			break;
	}
	return $daystr;
}

/**
* Formats a given string value for display, to the specified format type.  Currently
* 	supported formats are: phone, ucase, lcase, pcase, decimal, money, dollars, date,
* 	datetime, and wrapped.  Date and datetime formats suffer the same limitations
* 	as many date formatters in *nix, i.e. dates prior to the Unix date epoch are often
* 	problematic.  Wrapped breaks lines at 100 characters using <br> tags.  Dollars
*	will use American dollar signs in front of money values (ex: $3.54 or ($546.78) for
*	negative values).
* @param string $strValue The current value to format
* @param string $strFormat The format type to conform to (phone, ucase, etc.)
* @return string The formatted value for dispaly
* @access private
*/
function _formatListValue($strValue, $strFormat)
{
	global $phpraid_config;

	switch ($strFormat) {
		case 'phone' :
			$strValue = trim($strValue);
			switch (strlen_wrap($strValue, "UTF-8")) {
				case 7 :
					// 6060801 -> 606-0801
					$strValue = substr_wrap($strValue, 0, 3, "UTF-8") . '-' .
								substr_wrap($strValue, 3, strlen_wrap($strValue, "UTF-8") - 3, "UTF-8");
					break;
				case 10 :
					// 8016060801 -> (801) 606-0801
					$strValue = '(' . substr_wrap($strValue, 0, 3, "UTF-8") . ') ' .
									substr_wrap($strValue, 3, 3, "UTF-8") . '-' .
									substr_wrap($strValue, 6, strlen_wrap($strValue, "UTF-8") - 6, "UTF-8");
					break;
				default :
					break;
			}
			break;
		case 'ucase' :
			$strValue = strtoupper_wrap($strValue, "UTF-8");
			break;
		case 'lcase' :
			$strValue = strtolower_wrap($strValue, "UTF-8");
			break;
		case 'pcase' :
			$strValue = convertcase_wrap(strtolower_wrap($strValue, "UTF-8"), MB_CASE_TITLE, "UTF-8");
			break;
		case 'money' :
			$strValue = number_format($strValue, 2);
			break;
		case 'dollars' :
			$dblValue = doubleval($strValue);
			if ($dblValue < 0) {
				$strValue = number_format(-1 * $dblValue, 2);
				$strValue = '($' . $strValue . ')';
			}
			else {
				$strValue = number_format($dblValue, 2);
				$strValue = '$' . $strValue;
			}
			break;
		case 'decimal' :
		case 'wrapped' :
			$strValue = wordwrap($strValue, 100, '<br />');
			break;
		case 'date' :
			if ($strValue == '') {
				$strValue = '';
			}
			else {
				if (strlen($strValue) < 6) {
					$strValue = '';
				}
				else {
					$varDate = getDate(strtotime($strValue));
					$strValue = sprintf('%\'02d', $varDate['mon']) . '/' .
								sprintf('%\'02d', $varDate['mday']) . '/' .
								sprintf('%\'04d', $varDate['year']);
				}
			}
			break;
		case 'datetime' :
			if ($strValue == '') {
				$strValue = '';
			}
			else {
				if (strlen($strValue) < 6) {
					$strValue = '';
				}
				else {
					$varDate = getDate(strtotime($strValue));
					$strValue = sprintf('%\'02d', $varDate['mon']) . '/' .
								sprintf('%\'02d', $varDate['mday']) . '/' .
								sprintf('%\'04d', $varDate['year']) . ' ' .
								sprintf('%\'02d', $varDate['hours']) . ':' .
								sprintf('%\'02d', $varDate['minutes']);
				}
			}
			break;
		case 'wrmdate' :
			if ($strValue == '') {
				$strValue = '';
			}
			else {
				$varDate = strtotime($strValue);
				$daystr = _getDayString(getDate($varDate));
				$date_format = $phpraid_config['date_format'];
				$strValue = date($date_format, $varDate);
				$strValue = $daystr . ": " . $strValue;
			}
			break;
		case 'wrmtime' :
			if ($strValue == '') {
				$strValue = '';
			}
			else {
				$varDate = strtotime($strValue);
				$date_format = $phpraid_config['time_format'];
				$strValue = date($date_format, $varDate);
			}
			break;
		case 'wrmdatetime' :
			if ($strValue == '') {
				$strValue = '';
			}
			else {
				$varDate = strtotime($strValue);
				$daystr = _getDayString(getDate($varDate));
				$date_format = $phpraid_config['date_format'] . " " . $phpraid_config['time_format'];
				$strValue = date($date_format, $varDate);
				$strValue = $daystr . ": " . $strValue;
			}
			break;
		default :
			break;
	}

	return $strValue;
}



?>