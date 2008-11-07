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
	global $phpraid_config, $db_raid;
	
	$table_headers = array();
	
	// Get all the columns from the column_header table
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "column_headers WHERE view_name = %s ORDER BY position", quote_smart($view_name));
	
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	// Fail if something isn't returned.
	if (!$db_raid->sql_numrows($result) || $db_raid->sql_numrows($result) < 1)
		return FALSE;

	// Cycle all the columns in the table name view.
	while($data = $db_raid->sql_fetchrow($result, true)) 
	{
		//Replace Columns that start with @ with the proper header names (used to replace
		//  generic "Role1" header with the proper "Role1" header from config.)
		$column_name = $data['column_name'];
		if (strncmp($column_name, '@r', 1) == 0)
		{
			//It's a replacement variable, determine what replacement.
			$repstr = substr($column_name, 1);
			switch($repstr)
			{
				case "role1":
					$column_name = ucfirst($phpraid_config['role1_name']);
					break;
				case "role2":
					$column_name = ucfirst($phpraid_config['role2_name']);
					break;
				case "role3":
					$column_name = ucfirst($phpraid_config['role3_name']);
					break;
				case "role4":
					$column_name = ucfirst($phpraid_config['role4_name']);
					break;
				case "role5":
					$column_name = ucfirst($phpraid_config['role5_name']);
					break;
				case "role6":
					$column_name = ucfirst($phpraid_config['role6_name']);
					break;
			}
		}

		array_push($table_headers,
			array(
				'column_name'=>$column_name,
				'visible'=>$data['visible'],
				'img_url'=>$data['img_url']
			)
		);
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
function paginate_sort_and_format($dataArray, $sortField, $sortDesc, $startRecord, $viewName)
{
	$sortedArray = array();
	$trimmedArray = array();
	$formattedArray = array();
	
	// First we need to sort the data in the array.
	$sortedArray = sortData($dataArray, $sortField, $sortDesc);
	
	// Next we Paginate and limit the data returned for display
	$trimmedArray = paginateData($sortedArray, $startRecord);
	
	// Finally we parse each column on it's format type and apply formatting properly
	//$formattedArray = $trimmedArray;
	// We're done, Return the Data array for display.
	//return $formattedArray;
	return $trimmedArray;
}

/**
* Takes in an inital array of data and sorts the data based upon an input field.  Should be
* called only by "paginate_sort_and_format()".
* @param array $dataArray - Array holding the data for sorting.
* @param string $sortField - Field Name to Sort By, blank is an unsorted array.
* @param boolean $sortDesc - A True/False flag for whether or not to sort in descending order (TRUE = Descending Sort).
* @return array $dataArray - The array of sorted data.
* @access private
*/
function sortData($dataArray, $sortField, $sortDesc)
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
function paginateData($dataArray, $startRecord)
{
	global $phpraid_config;
	
	$pagedData = array();
	//$maxPerPage = $phpraid_config['records_per_page'];
	$maxPerPage = 2;
	
	$intTotalRecords = count($dataArray);
	if ($intTotalRecords == 0) 
	{
		// No records to work with
		return($dataArray);
	}

	// Figure out how many of the results we're actually supposed to show
	$intFirstRecord = $startRecord;
	if ($intFirstRecord + $maxPerPage >= $intTotalRecords) 
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
function formatData($dataArray, $viewName)
{
	$formattedData = array();
	return $formattedData;
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
	
	//$recPerPage = $phpraid_config['records_per_page'];
	$recPerPage = 2;
	$intTotalRecords = count($dataArray); // Gets the total number of records to page.
	$totalPages = ceil($intTotalRecords / $recPerPage); // Gets the total number of pages.
	$currPage = ceil($startRecord / $recPerPage); // Gets the Current Page Number
	$prevPage = $currPage - 1; // Get the page number for the "<< Prev" link.
	$nextPage = $currPage + 1; // Get the page number for teh "Next >>" link.
	
	if (($currPage == $totalPages)||($totalPages == 0))
		return;
	
	// Start Calculating the HRefs.
	
	//Add Prev Link
	if ($prevPage == 0)
		$jumpMenu = "<< Prev | ";
	else
	{
		$recordBase = (($prevPage - 1) * $recPerPage) + 1;
		$jumpMenu = '<a href="' . $pageURL . 'Base=' . $recordBase . '&amp;Sort=' . $sortField . '&SortDescending=' . $sortDesc . '">&lt;&lt; Prev</a>';
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
			$recordBase = (($i - 1) * $recPerPage) + 1;
			$jumpMenu = '<a href="' . $pageURL . 'Base=' . $recordBase . '&amp;Sort=' . $sortField . '&SortDescending=' . $sortDesc . '">' . $i . '</a>';			
		}
	}
	//Add Next Link
	if ($currPage == $totalPages)
		$jumpMenu .= "Next >>";
	else
	{
		$recordBase = ($currPage * $recPerPage) + 1;
		$jumpMenu .= '<a href="' . $pageURL . 'Base=' . $recordBase . '&amp;Sort=' . $sortField . '&SortDescending=' . $sortDesc . '">Next &gt;&gt;</a>';
	}
	
	return $jumpMenu;
}
?>