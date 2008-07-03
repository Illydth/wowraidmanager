<?php
/**
* DESCRIPTION:
* The ReportList class is designed for easy and extremely functional output of array
* data to HTML and other formats of lists.
*
* AUTHOR(S):
* David Clark (www.theCalico.com)
*
* IMPORTANT NOTE:
* There is no warranty, implied or otherwise with this software.
*
* LICENSE:
* This code has been placed in the Public Domain for all to enjoy.
*
* VERSION FEATURE NOTES:
* No crosstab support, multi-line list support untested.
*
* @version 1.0.1
* @access public
*/
class ReportList
{
	var $_arrTitleInfo;
	var $_arrRowInfo;
	var $_arrLinkInfo;
	var $_arrSortInfo;
	var $_arrPagingInfo;
	var $_arrColumnInfo;
	var $_arrCrossTabInfo;

    var $_blnRowIsOdd;
    var $_blnDoNoBreaks;

    /* --- Public Methods ---  */

    /**
	* Constructor method for the ReportList class.
	* @param string $strMainAttributes Any global attributes (table attributes, styles, class, etc.) for the overall
	* 	Html table that will comprise this list.
	* @return void
	* @access public
	*/
    function ReportList($strMainAttributes = 'cellspacing="0" cellpadding="3" border="1"', $strEvenRowAttributes = '', $strOddRowAttributes = '', $strHoverRowAttributes = '')
    {
		$this->_arrTitleInfo = array('strMainAttributes'=>$strMainAttributes, 'strListTitle'=>'', 'strTitleOpenAttributes'=>'', 'strTitleCloseAttributes'=>'', 'strSubTitle'=>'', 'strSubTitleOpenAttributes'=>'', 'strSubTitleCloseAttributes'=>'', 'blnShowRecordCount'=>true, 'strCaptionAttributes'=>'', 'strPageNavigatorAttributes'=>'', 'strFieldHeadingAttributes'=>'');
		$this->_arrRowInfo = array('strEvenRowAttributes'=>$strEvenRowAttributes, 'strOddRowAttributes'=>$strOddRowAttributes, 'strHoverRowAttributes'=>$strHoverRowAttributes);
    	$this->_arrLinkInfo = array('blnAllowLink'=>false, 'strLinkURL' => '', 'strLinkAttributes'=>'', 'arrLinkParamFields'=>array());
		$this->_arrSortInfo = array('blnAllowSort'=>false, 'blnSortDescending'=>false, 'strSortField'=>'', 'strSortURL'=>'', 'blnUsePathParams'=>0, 'strSortAnchor'=>'');
		$this->_arrPagingInfo = array('blnAllowPaging'=>false, 'strPagingURL'=>'', 'intStartRecord'=>0, 'intNumRecords'=>0, 'strPagingAnchor'=>'');
		$this->_arrColumnInfo = array('blnShowColumnNames'=>true, 'blnUseAllColumns'=>true, 'arrColumnsToUse'=>array(), 'arrSectionKeys'=>array());
		$this->_arrCrossTabInfo = array('blnShowSummaryCol'=>true, 'blnShowSummaryRow'=>true);
        return;
    }

	/**
	* Set the main attributes (table attributes, style, class settings, etc.) for the overall Html table
	* 	that will be used to build this report list.
	* @param string $strMainAttributes Any global attributes (table attributes, styles, class, etc.) for the overall
	* 	Html table that will comprise this list.
	* @return void
	* @access public
	*/
	function setMainAttributes($strMainAttributes)
	{
		$this->_arrTitleInfo['strMainAttributes'] = $strMainAttributes;
		return;
	}

	/**
	* Set the primary title (and its attributes) to be used for this report.
	* @param string $strTitle The title to use for the report
	* @param string $strTitleOpenAttributes Any additional attributes to use for the title, e.g. style/class settings, etc.
	* @param string $strTitleCloseAttributes Any closing tags necessary to complete the $strTitleOpenAttributes
	* @return void
	* @access public
	*/
    function setTitle($strTitle, $strTitleOpenAttributes = '', $strTitleCloseAttributes = '')
    {
    	$this->_arrTitleInfo['strListTitle'] = $strTitle;
    	$this->_arrTitleInfo['strTitleOpenAttributes'] = $strTitleOpenAttributes;
    	$this->_arrTitleInfo['strTitleCloseAttributes'] = $strTitleCloseAttributes;
        return;
    }

	/**
	* Set the sub-title (and its attributes) to be used for this report.  This is useful for adding disclaimers to reports.
	* @param string $strSubTitle The sub-title to use for this report
	* @param string $strSubTitleOpenAttributes Any additional attributes to use for the sub-title, e.g. style/class settings, etc.
	* @param string $strSubTitleCloseAttributes Any closing tags necessary to complete the $strSubTitleOpenAttributes
	* @return void
	* @access public
	*/
    function setSubTitle($strSubTitle, $strSubTitleOpenAttributes = '', $strSubTitleCloseAttributes = '')
    {
    	$this->_arrTitleInfo['strListSubTitle'] = $strSubTitle;
    	$this->_arrTitleInfo['strSubTitleOpenAttributes'] = $strSubTitleOpenAttributes;
    	$this->_arrTitleInfo['strSubTitleCloseAttributes'] = $strSubTitleCloseAttributes;
        return;
    }

    /**
	* Set whether or not to show the report record count.
	* @param boolean $blnDoShow True/False for whether or not to show the record count
	* @return void
	* @access public
	*/
    function showRecordCount($blnDoShow)
    {
        $this->_arrTitleInfo['blnShowRecordCount'] = $blnDoShow;
        return;
    }

	/**
	* Sets additional attributes (style/class tags, etc.) for the caption (record count) of the report
	* @param string $strAttributes Any additional attributes to use for displaying/formatting the report caption
	* @return void
	* @access public
	*/
    function setCaptionAttributes($strAttributes)
    {
    	$this->_arrTitleInfo['strCaptionAttributes'] = $strAttributes;
    	//$this->_strCaptionAttributes = $strAttributes;
		return;
    }

	/**
	* Sets additional attributes (style/class tags, etc.) for the page navigation links of the report
	* @param string $strAttributes Any additional attributes to use for displaying/formatting the page navigators
	* @return void
	* @access public
	*/
    function setPageNavigatorAttributes($strAttributes)
    {
    	$this->_arrTitleInfo['strPageNavigatorAttributes'] = $strAttributes;
    	return;
    }

	/**
	* Customize the appearance of rows.  This allows you to specify different attributes (appearances)
	* for odd vs. even rows, and some style attributes to apply on mouse overs.
	* @param string $strOddRowAttributes The styles/attributes to apply to odd rows
	* @param string $strEvenRowAttributes The styles/attributes to apply to even rows
	* @param string $strHoverRowClassName A style class name to apply to active rows on the mouseover event
	* @return void
	* @access public
	*/
    function setRowAttributes($strOddRowAttributes, $strEvenRowAttributes, $strHoverRowClassName)
    {
    	$this->_arrRowInfo['strOddRowAttributes'] = $strOddRowAttributes;
    	$this->_arrRowInfo['strEvenRowAttributes'] = $strEvenRowAttributes;
    	$this->_arrRowInfo['strHoverRowClassName'] = $strHoverRowClassName;

    	// See if we can parse a class name out of the even and odd row attributes
		$strLCase = strtolower($strOddRowAttributes);
		$iPos = strpos($strLCase, 'class');
		if ($iPos !== false) {
			$strClass = substr($strOddRowAttributes, $iPos + 5);
			$strClass = trim(str_replace("'", '', str_replace('"', '', str_replace('=', '', $strClass))));
			$jPos = strpos($strClass, ' ');
			if ($jPos !== false) { $strClass = substr($strClass, 0, $jPos); }
		}
		else { $strClass = ''; }
		$this->_arrRowInfo['strOddRowClassName'] = $strClass;

		$strLCase = strtolower($strEvenRowAttributes);
		$iPos = strpos($strLCase, 'class');
		if ($iPos !== false) {
			$strClass = substr($strEvenRowAttributes, $iPos + 5);
			$strClass = trim(str_replace("'", '', str_replace('"', '', str_replace('=', '', $strClass))));
			$jPos = strpos($strClass, ' ');
			if ($jPos !== false) { $strClass = substr($strClass, 0, $jPos); }
		}
		else { $strClass = ''; }
		$this->_arrRowInfo['strEvenRowClassName'] = $strClass;

        return;
    }

	/**
	* Sets additional attributes (style/class tags, etc.) for the field/column headings of the report
	* @param string $strAttributes Any additional attributes to use for displaying/formatting the field headings
	* @return void
	* @access public
	*/
    function setFieldHeadingAttributes($strAttributes)
    {
    	$this->_arrTitleInfo['strFieldHeadingAttributes'] = $strAttributes;
    	return;
    }

	/**
	* Configure linking for this report, to allow individual row values to link to other pages.
	* 	Intended primarily for use in linking to sub-reports, or detailed views of data.
	* @param boolean $blnAllowLink True/False for whether or not to allow linking from this report list
	* @param string $strLinkURL Any URL information for the site to link to; valid examples
	* 	require_once: "thisPage.php", "thisPage.php?SomeInfo=1&SomeOtherInfo=2", or
	* 	"http://www.somesite.com/thisPage.php".  For lists where the base URL is different for every
	*	record, you can require_once a variable URL by using %% variable indicators, such as:
	*	"%%strPageName%%.php" - in this case the value of the "strPageName" field for each
	* 	record will be substituted into the Link URL.
	* @param array $arrParamFields An array of information about which fields from the data
	* 	behind this report list, should be used in constructing the row link.  A valid array must
	* 	require_once the following information: "name" the exact name of the field in the report's data
	* 	array, and optionally "marker" which is the name to use for this parameter in the row link URL.
	*	For example: $arrParamFields = array(
	*																array('name'=>'Id', 'marker'='userId'),
	*																array('name'=>'Type', 'marker'=>'userType')
	*															) would be a valid argument.
	* @param string $strLinkAttributes Any additional attributes to be used in constructing the
	* 	row link URL, e.g. style/class settings, target modifiers, etc.
	* @param string $strLinkAnchor The HREF anchor for the link target
	* @return void
	* @access public
	*/
    function allowLink($blnAllowLink = '', $strLinkURL = '', $arrParamFields = '', $strLinkAttributes = '', $strLinkAnchor = '')
    {
    	$this->_arrLinkInfo['blnAllowLink'] = $blnAllowLink;
    	$this->_arrLinkInfo['strLinkURL'] = $strLinkURL;
    	$this->_arrLinkInfo['arrLinkParamFields'] = $arrParamFields;
    	$this->_arrLinkInfo['strLinkAttributes'] = $strLinkAttributes;
    	$this->_arrLinkInfo['strLinkAnchor'] = $strLinkAnchor;

        return;
    }

    /**
	* Configures pagination for the report list.
	* @param boolean $blnAllowPaging True/False for whether or not to allow pagination of report results
	* @param string $strPagingURL The URL to submit GET requests to when moving between pages
	* @param string $strPagingAnchor The HREF anchor to use in pagination links
	* @return void
	* @access public
	*/
    function allowPaging($blnAllowPaging, $strPagingURL, $strPagingAnchor = '')
    {
        $this->_arrPagingInfo['blnAllowPaging'] = $blnAllowPaging;
        $this->_arrPagingInfo['strPagingURL'] = $strPagingURL;
        $this->_arrPagingInfo['strPagingAnchor'] = trim($strPagingAnchor);
        return;
    }

    /**
	* Configures column sorting for the report list.
	* @param boolean $blnAllowSort True/False for whether or not to allow sorting of report results
	* @param string $strSortField The name of the field to sort by
	* @param boolean $blnSortDescending True/False for whether or not to sort in descending order
	* 	by the specified field
	* @param string $strSortURL The URL to submit GET requests to when a sort "command" is issued
	* 	by clicking on any of the visible columns
	* @param boolean $blnUsePathParams True/False for whether or not to use path syntax for parameter
	* 	values instead of normal ?,&,= syntax (i.e. &Sort=SortField&SortDescending=1 vs.
	*	/Sort-SortField/SortDescending-1)
	* @param string $strSortAnchor The HREF anchor to use in sort target links
	* @return void
	* @access public
	*/
    function allowSort($blnAllowSort, $strSortField, $blnSortDescending, $strSortURL, $blnUsePathParams = 0, $strSortAnchor = '')
    {
		// Make sure the specified URL does NOT have the Sort & SortDescending parameters
		$iPos = strpos($strSortURL, '&Sort=');
		if ($iPos === false) { $iPos = strpos($strSortURL, '?Sort='); }
		if (!($iPos === false)) {
			$jPos = strpos($strSortURL, '&', $iPos + 1);
			if ($jPos === false) { $jPos = strlen($strSortURL); }

			$strSortURL = substr($strSortURL, 0, $iPos) .
							substr($strSortURL, $jPos);
		}

		$iPos = strpos($strSortURL, '&SortDescending=');
		if ($iPos === false) { $iPos = strpos($strSortURL, '?SortDescending='); }
		if (!($iPos === false)) {
			$jPos = strpos($strSortURL, '&', $iPos + 1);
			if ($jPos === false) { $jPos = strlen($strSortURL); }

			$strSortURL = substr($strSortURL, 0, $iPos) .
							substr($strSortURL, $jPos);
		}

		// For later simplicity force the URL to end with Sort= (or Sort- if we're using the path form of parametization)
		if ($blnUsePathParams) {
    		if (substr($strSortURL, strlen($strSortURL) - 1, 1) === '/') {
    			$strSortURL .= 'Sort-';
    		}
    		else { $strSortURL .= '/Sort-'; }
		}
		else {
    		if (strpos($strSortURL, '?') === false) {
    			$strSortURL .= '?Sort=';
    		}
    		else { $strSortURL .= '&Sort='; }
		}

        $this->_arrSortInfo['blnAllowSort'] = $blnAllowSort;
        $this->_arrSortInfo['strSortField'] = $strSortField;
        $this->_arrSortInfo['blnSortDescending'] = intval($blnSortDescending);
        $this->_arrSortInfo['strSortURL'] = $strSortURL;
      	$this->_arrSortInfo['blnUsePathParams'] = intval($blnUsePathParams);
      	if (trim($strSortAnchor) != '') {
      		$this->_arrSortInfo['strSortAnchor'] = '#' . trim($strSortAnchor);
      	}

        return;
    }

	/**
	* Legacy functionality.  This allows you to specify that the list class should wrap all data in <nobr> tags
	* to prevent any kind of line wrapping within cells.
	* @param boolean $blnAllowNoBreaks Whether or not to wrap all data in <nobr> tags
	* @return void
	* @access public
	*/
    function allowNoBreaks($blnAllowNoBreaks)
    {
        $this->_blnDoNoBreaks = $blnAllowNoBreaks;
        return;
    }

	/**
	* Aids in pagination of report results by setting which record to begin showing results for, and how
	*	many records to show per page.
	* @param integer $intStartRecord The number of the first record to display results for
	* @param integer $intNumRecords The number of records to show per page (0 or less mean
	* 	show all results on a single page
	* @return void
	* @access public
	*/
    function setListRange($intStartRecord, $intNumRecords)
    {
        $this->_arrPagingInfo['intStartRecord'] = intval($intStartRecord);
        $this->_arrPagingInfo['intNumRecords'] = intval($intNumRecords);
        return;
    }

    /**
	* Sets whether or not to show column names above each column in the report.
	* @param boolean $blnDoShow True/False for whether or not to show column names
	* @return void
	* @access public
	*/
    function showColumnNames($blnDoShow)
    {
    	$this->_arrColumnInfo['blnShowColumnNames'] = $blnDoShow;
    	return;
    }

	/**
	* Resets column display information.  Primarily used if the same list object is being used multiple
	*	times during the same page processing.
	* @return void
	* @access public
	*/
    function clearOutputColumns()
    {
        $this->_arrColumnInfo['blnUseAllColumns'] = true;
        $this->_arrColumnInfo['arrColumnsToUse'] = array();
        return;
    }

	/**
	* Adds a particular field from the data as a visible (display or output) column in the report list.
	* @param string $strFieldName The name (from data) of the field to show
	* @param string $strColumnTitle The name to show as the title of this field in the output
	* @param string $strFormat A named format type to use when outputting the value of this field.
	* 	Supported options currently require_once: phone, ucase, lcase, pcase, decimal, money, dollars, date,
	* 	datetime, and wrapped
	* @param string $strAlign	A horizontal alignment for the field (left, middle, right)
	* @param integer $intLine For use with multi-line reports, this is what line of output this particular field
	* 	should be displayed on
	* @param string $strFieldLink Additional information/parameters to be require_onced in the link that is constructed
	*	for values in this particular column.  Only used when report linking is turned on (i.e. for sub-reports).  Can
	* 	also be set to the special flag value of "__NOLINK__" which will disable linking for this single column.
	* @param string $strLinkDesc Similar to Alt tags for images, this value will be displayed as a pop-up information
	* 	information display automatically (in supported browsers) when a link for this column is hovered over
	* @return void
	* @access public
	*/
    function addOutputColumn($strFieldName, $strColumnTitle, $strFormat = null, $strAlign = null, $intLine = null, $strFieldLink = '__NOLINK__', $strLinkDesc = null)
    {
        // Make sure we track that the user is customizing the output columns
        $this->_arrColumnInfo['blnUseAllColumns'] = false;

        $arrColumn['name'] = $strFieldName;
        $arrColumn['title'] = $strColumnTitle;
        $arrColumn['format'] = $strFormat;
        $arrColumn['align'] = $strAlign;
        $arrColumn['line'] = $intLine;
        $arrColumn['fldlink'] = $strFieldLink;
        $arrColumn['linkdesc'] = $strLinkDesc;

        array_push($this->_arrColumnInfo['arrColumnsToUse'], $arrColumn);
        return;
    }

    /**
	* Configure which data fields/columns will serve as a "key" value in deciding which records
	*	belong in which section of the report.
	* @param string $strFieldNamesCommaSep a comma-delimited string of field names that
	* 	should comprise the "key" value for each section (ex: "lngRecordId,intRecordType")
	* @return void
	* @access public
	*/
    function setSectionBreakFields($strFieldNamesCommaSep)
    {
        $strFieldNamesCommaSep = trim($strFieldNamesCommaSep);
        if ($strFieldNamesCommaSep == '') {
            $this->_arrColumnInfo['arrSectionKeys'] = array();
        }
        else {
            $strFieldNamesCommaSep = eregi_replace(' ', '', $strFieldNamesCommaSep);
            $this->_arrColumnInfo['arrSectionKeys'] = explode(',', $strFieldNamesCommaSep);
        }
        return;
    }

	/**
	* A public accessor to our internal formatting function.
	* @param string $strValue The data value/input to be formatted
	* @param string $strFormat The named format to use for outputting the value to be displayed
	* @return void
	* @access public
	*/
    function formatValue($strValue, $strFormat)
    {
        return($this->_formatListValue($strValue, strtolower($strFormat)));
    }

	/**
	* Executes the specified SQL statement against the specified database, and directly outputs
	*	the results of the report list constructed from the results as a download to the client browser.
	*	Because this routine controls the headers that are sent to the client browser, no other header
	* 	information should be sent prior to executing this routine (unless output buffering is enabled).
	* @param object $pearDB An open PEAR database connection to a database
	* @param string $strSQL The desired SQL statement(s) to execute to produce the report list data
	* @param object $arrParams Any parameter information that is needed to execute the above SQL statement
	* @param string $strOutputMethod The desired output format of the report.  Currently supported options
	*	are: html (default, also works well for MS Word downloads), tab (tab-delimited, as for MS Excel
	*	downloads), csv (comma separated), and xml.
	* @return void
	* @access public
	*/
    function downloadListFromSQL($pearDB, $strSQL, $arrParams = null, $strOutputMethod = null)
    {
        // Execute the SQL statement and get an array of the results
        $arrResult = $pearDB->getAll($strSQL, $arrParams, DB_FETCHMODE_ASSOC);
        if (DB::isError($arrResult)) {
            $arrResult = array();
        }

        $this->downloadListFromArray($arrResult, $strOutputMethod);
        return;
    }

	/**
	* Builds and directly initiates a download of a report list from the specified array of data.  Because this routine
	* 	controls the headers that are sent to the client browser, no other header information should be sent
	*	prior to executing this routine (unless output buffering is enabled).
	* @param array $arrRecords The array of data to build a report list for
	* @param string $strOutputMethod The desired output format of the report.  Currently supported options
	*	are: html (default, also works well for MS Word downloads), tab (tab-delimited, as for MS Excel
	*	downloads), csv (comma separated), and xml.
	* @return void
	* @access public
	*/
    function downloadListFromArray($arrRecords, $strOutputMethod = null)
    {
    	$strDownloadName = trim($this->_downloadName);
    	if ($strDownloadName == '') { $strDownloadName = 'ReportList_' . rand(1, 9); }
		$strDownloadType = trim($this->_downloadType);

    	// See if any particular download type was specified; if not default to one based on the output method
		if ($strDownloadType == '') {
			switch ($strOutputMethod) {
				case 'tab' :
					$strDownloadType = 'txt';
					break;
				case 'csv' :
					$strDownloadType = 'csv';
					break;
				case 'html' :
					$strDownloadType ='doc';
					break;
				case 'xml' :
					$strDownloadType = 'xml';
					break;
				default :
					$strDownloadType = 'xls';
					$strOutputMethod = 'tab';
					break;
			}
		}

        // Determine how we should mark the download type
		switch ($strDownloadType) {
			case 'txt' :
	            $strType = 'text/plain';
    	        $strName = $strDownloadName . ".txt";
				break;
			case 'csv' :
	            $strType = 'text/plain';
    	        $strName = $strDownloadName . ".csv";
				break;
			case 'doc' :
                $strType = 'application/msword';
                $strName = $strDownloadName . ".doc";
				break;
			case 'xml' :
				$strType = 'text/plain';
				$strName = $strDownloadName . ".xml";
				break;
			default :
                $strType = 'application/msexcel';
                $strName = $strDownloadName . ".xls";
				break;
		}

        // Send directly back to the client; set the document type and suggested name
        header("Content-Type: $strType");
        header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: public");
        echo $this->getListFromArray($arrRecords, true, $strOutputMethod);

        return;
    }

	/**
	* Executes the specified SQL statement against the specified database, and directly outputs
	*	the results of the report list constructed from the results.
	* @param object $pearDB An open PEAR database connection to a database
	* @param string $strSQL The desired SQL statement(s) to execute to produce the report list data
	* @param object $arrParams Any parameter information that is needed to execute the above SQL statement
	* @param string $strOutputMethod The desired output format of the report.  Currently supported options
	*	are: html (default, also works well for MS Word downloads), tab (tab-delimited, as for MS Excel
	*	downloads), csv (comma separated), and xml.
	* @return void
	* @access public
	*/
    function makeListFromSQL($pearDB, $strSQL, $arrParams = null, $strOutputMethod = null)
    {
    	echo $this->getListFromSQL($pearDB, $strSQL, $arrParams, false, $strOutputMethod);
    	return;
    }

	/**
	* Executes the specified SQL statement against the specified database, and returns a report list
	*	constructed from the subsequent results.
	* @param object $pearDB An open PEAR database connection to a database
	* @param string $strSQL The desired SQL statement(s) to execute to produce the report list data
	* @param object $arrParams Any parameter information that is needed to execute the above SQL statement
	* @param boolean $blnDoForDownload True/False for whether it is intended the results of this report
	* 	will be used in a download (offline) file.  This will affect whether record linking, page navigation, etc.
	*	is available
	* @param string $strOutputMethod The desired output format of the report.  Currently supported options
	*	are: html (default, also works well for MS Word downloads), tab (tab-delimited, as for MS Excel
	*	downloads), csv (comma separated), and xml.
	* @return string The fully formatted list to output
	* @access public
	*/
    function getListFromSQL($pearDB, $strSQL, $arrParams = null, $blnDoForDownload = false, $strOutputMethod = null)
    {
        // Execute the SQL statement and get an array of the results
        $arrResult = $pearDB->getAll($strSQL, $arrParams, DB_FETCHMODE_ASSOC);
        if (DB::isError($arrResult)) {
            $arrResult = array();
        }

        // Return the actual list that gets built from the queried data
        return($this->getListFromArray($arrResult, $blnDoForDownload, $strOutputMethod));
    }

	/**
	* Builds and directly outputs a report list from the specified array of data.
	* @param array $arrRecords The array of data to build a report list for
	* @param string $strOutputMethod The desired output format of the report.  Currently supported options
	*	are: html (default, also works well for MS Word downloads), tab (tab-delimited, as for MS Excel
	*	downloads), csv (comma separated), and xml.
	* @return void
	* @access public
	*/
    function makeListFromArray($arrRecords, $strOutputMethod = null)
    {
        echo $this->getListFromArray($arrRecords, false, $strOutputMethod);
        return;
    }

    /**
	* This is the primary workhorse routine of the entire class, and produces a string (containing the
	* 	entire report list output) for the given array of data.
	* @param array $arrRecords The data array for which to build the report list
	* @param boolean $blnDoForDownload True/False for whether or not the list is intended for
	*	download (offline) viewing.  This wil affect the availability/use of page navigators, links, etc.
	* @param string $strOutputMethod The desired output format of the report.  Currently supported options
	*	are: html (default, also works well for MS Word downloads), tab (tab-delimited, as for MS Excel
	*	downloads), csv (comma separated), and xml.
	* @return string The fully formatted list to output
	* @access public
	*/
    function getListFromArray($arrRecords, $blnDoForDownload = false, $strOutputMethod = null)
    {
		global $phprlang;

    	// TODO - Properly re-enable support for multi-line lists
		$blnDoMultiLineList = false;
		$this->_blnRowIsOdd = true;

		// Default to outputting html
		if ($strOutputMethod === null) { $strOutputMethod = 'html'; }

    	// Start with an empty list
        $strList = '';

        $intTotalRecords = count($arrRecords);
        if ($intTotalRecords == 0) {
            // No records to work with
            $strList .= $this->_makeListHeader($strOutputMethod);
            $strList .= $this->_makeListCaption($this->_strListTitle, $strOutputMethod);
            $strList .= $this->_makeListTitles('<th>' . $phprlang['no_data'] . '</th>', $strOutputMethod);
            $strList .= $this->_makeListFooter($strOutputMethod);
            return($strList);
        }

        // Figure out how many of the results we're actually supposed to show
		$intFirstRecord = $this->_arrPagingInfo['intStartRecord'];
        if ($this->_arrPagingInfo['intNumRecords'] <= 0) {
            // Show all the records
            $intLastRecord = $intTotalRecords;
        }
        else {
            // Show only the specified number of records per page
            $intLastRecord = $intFirstRecord + $this->_arrPagingInfo['intNumRecords'];
            if ($intLastRecord > $intTotalRecords) { $intLastRecord = $intTotalRecords; }
        }

        // Sort results before displaying, if necessary
        if ($this->_arrSortInfo['blnAllowSort'] && $this->_arrSortInfo['strSortField'] != '') {
        	// Sort the array on the specified value
			foreach ($arrRecords as $curRecord) {
			      $sortarray[] = $curRecord[$this->_arrSortInfo['strSortField']];
			}
			array_multisort($sortarray, $arrRecords);

			// Sort descending, if necessary
			if ($this->_arrSortInfo['blnSortDescending']) {
				$arrRecords = array_reverse($arrRecords);
			}
        }

        // Which and how many columns are we using?
        $this->_determineColumnsToUse($arrRecords[0], $arrColumnsToUse);
        $intNumCols = count($arrColumnsToUse);

        // Start writing our list
        $strList .= $this->_makeListHeader($strOutputMethod);

        // Show a title for the list if possible
		if ($strOutputMethod == 'xml') {
			$strList .= "<ListDescription>\r\n" .
								"\t<listTitle>" . trim($this->_arrTitleInfo['strListTitle']) . "</listTitle>\r\n" .
								"\t<listSubTitle>" . trim($this->_arrTitleInfo['strListSubTitle']) . "</listSubTitle>\r\n";
			if ($this->_arrTitleInfo['blnShowRecordCount']) {
				$strList .= "\t<listCaption>Record(s) " . ($intFirstRecord + 1) . " to $intLastRecord of $intTotalRecords total.</listCaption>\r\n";
			}
			$strList .= "</ListDescription>\r\n";
		}
		else {
            $strCaption = trim($this->_arrTitleInfo['strTitleOpenAttributes'] . $this->_arrTitleInfo['strListTitle'] . $this->_arrTitleInfo['strTitleCloseAttributes']);
            if (trim($this->_arrTitleInfo['strListSubTitle']) != '') { $strCaption .= '<br />' . trim($this->_arrTitleInfo['strSubTitleOpenAttributes'] . $this->_arrTitleInfo['strListSubTitle'] . $this->_arrTitleInfo['strSubTitleCloseAttributes']); }
            if ($this->_arrTitleInfo['blnShowRecordCount']) {
                if ($strCaption != '') { $strCaption .= '<br />'; }

                // Only show the record counts if we're doing a list w/out section breaks
                // Otherwise, show the section heading
                if ((count($this->_arrColumnInfo['arrSectionKeys']) == 0) || (!($blnDoForDownload)) || ($strOutputMethod == 'tab')) {
                    $strCaption .= 'Record(s) ' . ($intFirstRecord + 1) . " to $intLastRecord of $intTotalRecords total.";
                }
                else { $strCaption .= 'Section: %%SECTION_KEY%%'; }
            }
            $strList .= $this->_makeListCaption($strCaption, $strOutputMethod);
		}

        // If all the records won't fit on one page, show the necessary
        // navigation controls (if allowed by the caller)
        if (!($blnDoForDownload) && $this->_arrPagingInfo['blnAllowPaging']) {
            $strList .= $this->_makePageNavigators($intTotalRecords, $intNumCols);
        }

        // Show the column headings (titles) if allowed
        if (!($blnDoMultiLineList) && $this->_arrColumnInfo['blnShowColumnNames'] && ($strOutputMethod != 'xml')) {
            $strRow = '';
            foreach ($arrColumnsToUse as $arrCol) {
                // Handle cell alignment if necessary
                if ($arrCol['align'] != '') {
                    $strRow .= '<th align="' . $arrCol['align'] . '">';
                }
                else { $strRow .= '<th>'; }

                $strColTitle = $arrCol['title'];

                // Show sort order links
                if ($this->_arrSortInfo['blnAllowSort'] && !($blnDoForDownload)) {
                	if ($arrCol['name'] == $this->_arrSortInfo['strSortField'] && !($this->_arrSortInfo['blnSortDescending'])) {
                		// Give the option to sort descending
						if ($this->_arrSortInfo['blnUsePathParams'] == 1) {
		                	$strColTitle = '<a href="' . $this->_arrSortInfo['strSortURL'] . urlencode($arrCol['name']) . '/SortDescending-1" title="Click here to sort (in descending order) by ' . htmlspecialchars(strip_tags($strColTitle)) . '">' . $strColTitle . '</a>';
						}
						else {
		                	$strColTitle = '<a href="' . $this->_arrSortInfo['strSortURL'] . urlencode($arrCol['name']) . '&SortDescending=1' . $this->_arrSortInfo['strSortAnchor'] . '" title="Click here to sort (in descending order) by ' . htmlspecialchars(strip_tags($strColTitle)) . '">' . $strColTitle . '</a>';
						}
                	}
                	else {
                		// Give the option to sort (ascending) by this field
                		$strColTitle = '<a href="' . $this->_arrSortInfo['strSortURL'] . urlencode($arrCol['name']) . $this->_arrSortInfo['strSortAnchor'] . '" title="Click here to sort (in ascending order) by ' . htmlspecialchars(strip_tags($strColTitle)) . '">' . $strColTitle . '</a>';
                	}
                }

                // Allow for setting "no break" tags within cells
                if ($this->_blnDoNoBreaks){
                    $strRow .= '<nobr>' . $strColTitle . '</nobr></th>';
                }
                else { $strRow .= $strColTitle . '</th>'; }
            }

            $strList .= $this->_makeListTitles($strRow, $strOutputMethod);
        }

        // Save the list header so far, in case we need to use it again later, as
        // in MS Word downloads with section breaks
        $strListHeader = $strList;

        // Show each record
        $strSectionKey = '';
        for ($iRow = $intFirstRecord; $iRow < $intLastRecord; $iRow++) {
            // If we allow linking from this list, then build our full hyperlink URL for this record here
            if ($this->_arrLinkInfo['blnAllowLink']) {
                $strHyperlink = $this->_buildLinkURLFromRecord($arrRecords[$iRow], false);
            }
            else { $strHyperlink = ''; }

            // Watch for section breaks when doing html downloads (intended for MS Word)
            if ((count($this->_arrColumnInfo['arrSectionKeys']) > 0) && ($blnDoForDownload) && !($strOutputMethod == 'tab')) {
                if ($iRow > $this->_arrPagingInfo['intStartRecord']) {
                    $strCurSection = $this->_getSectionKeyValue($arrRecords[$iRow]);
                    if ($strCurSection != $strSectionKey) {
                        // Start a new section
                        $strList .= $this->_makeListFooter($strOutputMethod) .
                                    		"<br /><br clear=all style='mso-special-character:line-break;page-break-before:always' />\r\n" .
                                    		ereg_replace('%%SECTION_KEY%%', $strCurSection, $strListHeader);
                        $strSectionKey = $strCurSection;
                        $this->_blnRowIsOdd = false;
                    }
                }
                else {
                    $strSectionKey =  $this->_getSectionKeyValue($arrRecords[$iRow]);
                    $strList = ereg_replace('%%SECTION_KEY%%', $strSectionKey, $strList);
                }
            }

            // Cycle through each column that we're supposed to show and build a string representing that set of data
            $iLine = 0;
            $strRow = '';
            foreach ($arrColumnsToUse as $arrCol) {
                // Do any necessary formatting of the value
                $strValue = $arrRecords[$iRow][$arrCol['name']];
                $strValue = $this->_formatListValue($strValue, $arrCol['format']);
                if ($strOutputMethod == 'html') {
                    // Don't allow blanks (they make HTML tables look bad)
                    if ($strValue == '') { $strValue = '&nbsp;'; }
                }
				else if ($strOutputMethod == 'csv') {
                	// In CSV downloads, you need to watch out for embedded commas or quotes
					if (strpos($strValue, ',') !== false || strpos($strValue, '"') !== false) {
						$strValue = '"' . $strValue . '"';
					}
                }
                else if ($strOutputMethod == 'xml') {
                	// Enclose each value in the XML tags necessary for this field
                	$strValue = '<' . $arrCol['name'] . '>' . htmlspecialchars($strValue) . '</' . $arrCol['name'] . '>';
                }

                if (!($blnDoForDownload)) {
                    // If we allow linking from this page to another, then add the link here
                    if ($strHyperlink != '' && $arrCol['fldlink'] != '__NOLINK__') {
                    	// Show "alt" tags (i.e. descriptions/titles) for links
                    	if ($arrCol['linkdesc'] != '') {
                    		$strTitle = $arrCol['linkdesc'];

                    		// See if there are any variables to replace in this title
                    		if (strpos($strTitle, '%%') !== false) {
					            foreach ($arrColumnsToUse as $arrColReplace) {
					                $strValueReplace = $arrRecords[$iRow][$arrColReplace['name']];
					                $strValueReplace = $this->_formatListValue($strValueReplace, $arrColReplace['format']);

					                $strTitle = str_replace('%%' . $arrColReplace['name'] . '%%', $strValueReplace, $strTitle);
					            }
                    		}
                    		$strTitle = htmlspecialchars($strTitle);
                    		$strTitle = ' title="' . $strTitle . '"';
                    	}
                    	else { $strTitle = ''; }

                        $strValue = "<a href=$strHyperlink" . $arrCol['fldlink'] . "\"$strTitle " . $this->_arrLinkInfo['strLinkAttributes'] . ">$strValue</a>";
                    }
                }

                if ($blnDoMultiLineList) {
                    // New line, or the same one?
                    if ($strRow == '') { $strRow = '<td>'; }
                    while ($iLine != $arrCol['line']) {
                        $strRow .= '&nbsp;<br />';
                        $iLine++;
                    }

                    // Add the value itself
                    $strRow .= '<b><u>' . $arrCol['title'] . ':</u></b> ' . $strValue . "&nbsp;&nbsp;&nbsp;\t";
                }
                else {
                    // Standard, one-record-per-row type of list/report
                    // Handle cell alignment if necessary
                    if (trim($arrCol['align']) != '') {
                        $strRow .= '<td align="' . $arrCol['align'] . '">';
                    }
                    else { $strRow .= '<td>'; }

                    // Allow for using the <nobr> tag
                    if ($this->_blnDoNoBreaks) {
                        $strRow .= "<nobr>$strValue</nobr></td>";
                    }
                    else { $strRow .= "$strValue</td>"; }
                }
            }
            if ($blnDoMultiLineList) { $strRow .= '<br />&nbsp;</td>'; }

            // Ouput this record to our list
            $strList .= $this->_makeListRow($strRow, $strOutputMethod);
        }

        // Finish up our list
        $strList .= $this->_makeListFooter($strOutputMethod);

        // If necessary, show a disclaimer at the bottom of the report
        if (($blnDoForDownload) && ($this->_arrTitleInfo['strSubTitle'] != '') && ($strOutputMethod != 'xml')) {
            if ($strOutputMethod == 'html') { $strList .= '<p>'; }
            $strList .= "\r\n" . $this->_arrTitleInfo['strSubTitle'];
        }

        if ($blnDoForDownload && ($strOutputMethod == 'html')) {
            // Doing a download to MS Word; require_once some style attributes that
            // will help the report look a little better on initial download
            $strList = $this->_strHtmlDownloadHeader . "\r\n" .
                       		$strList . "\r\n" .
                       		$this->_strHtmlDownloadFooter;
        }

        return($strList);
    }

    /* --- Private Methods ---  */

	/**
	* Determines which columns/fields should be used for outputting the report list
	* results; mainly useful in the case where no particular output columns have been
	* specified.
	* @param array $arrRecord A sample record (the first in the dataset)
	* 	which can be used to determine the available columns
	* @param output array $arrColumnsToUse The actual array of column
	*	information which will be used for displaying the report.  This array will
	* 	contain one row for every column to output, with the following fields:
	*		name: specifies the actual field name in the records array for this column
	*		title: specifies the output title to show for this column
	*		format: empty
	*		align: empty
	* @return void
	* @access private
	*/
    function _determineColumnsToUse($arrRecord, &$arrColumnsToUse)
    {
        if ($this->_arrColumnInfo['blnUseAllColumns']) {
            // Use every column available in the records array
            $arrColumnsToUse = array();

			foreach ($arrRecord as $strCurKey=>$val) {
                $arrColInfo['name'] = $strCurKey;
                $arrColInfo['title'] = $strCurKey;
                $arrColInfo['format'] = '';
                $arrColInfo['align'] = '';

                array_push($arrColumnsToUse, $arrColInfo);
            }
        }
        else {
            // Use only the user-specified columns
            $arrColumnsToUse = $this->_arrColumnInfo['arrColumnsToUse'];
        }

        return;
    }

	/**
	* Initiates a report list (e.g. outputs the initial <table> tag for html format, the initial <?xml> tag for xml, etc.)
	* @param string @strOutputMethod The desired output method for this row (html, tab, or csv)
	* @return string The necessary header line(s) for the specified format
	* @access private
	*/
    function _makeListHeader($strOutputMethod = 'html')
    {
        // Since we just started the list, our first record will be odd
        $this->_blnRowIsOdd = false;

        if ($strOutputMethod == 'tab' || $strOutputMethod == 'csv') {
            return('');
        }
        else if ($strOutputMethod == 'xml') {
        	return("<?xml version=\"1.0\" standalone=\"yes\"?>\r\n<NewDataSet>\r\n");
        }
        else {
            return '<table ' . $this->_arrTitleInfo['strMainAttributes'] . ">\r\n";
        }
    }

	/**
	* Creates a "title" section (really column headers and page navigators) for the specified row of information.  Essentially used
	* to convert the default "html" style output method of the report into the specified output method (tab or csv).
	* @param string $strRow The current row of data to encode as a title
	* @param string @strOutputMethod The desired output method for this row (html, tab, or csv)
	* @return string The encoded title row string
	* @access private
	*/
    function _makeListTitles($strRow, $strOutputMethod = 'html')
    {
        if ($strRow == '') { return ''; }

        if ($strOutputMethod == 'tab') {
            $strRow = eregi_replace('&nbsp;', '', $strRow);
            $strRow = eregi_replace('<br />', ' ', $strRow);
            $strRow = eregi_replace('</td>', "\t", $strRow);
            $strRow = eregi_replace('</th>', "\t", $strRow);
            $strRow = strip_tags($strRow);
            return ($strRow . "\r\n");
        }
        else if ($strOutputMethod == 'csv') {
            $strRow = eregi_replace('&nbsp;', '', $strRow);
            $strRow = eregi_replace('<br />', ' ', $strRow);
            $strRow = eregi_replace('</td><td ', ',<td', $strRow);
            $strRow = eregi_replace('</th><th ', ',<td', $strRow);
            $strRow = eregi_replace('</td><td>', ',', $strRow);
            $strRow = eregi_replace('</th><th>', ',', $strRow);
            $strRow = strip_tags($strRow);
            return ($strRow . "\r\n");
        }
        else if ($strOutputMethod == 'xml') {
            $strRow = eregi_replace('<br />', "\r\n", $strRow);
        	$strRow = eregi_replace('</td>', '', $strRow);
        	$strRow = eregi_replace('</th>', '', $strRow);

        	$strRow = eregi_replace('<th>', '<td>', $strRow);
        	$strRow = eregi_replace('<th ', '<td>', $strRow);
        	$strRow = eregi_replace('<td ', '<td>', $strRow);

        	$arrOut = array();
        	$arrPieces = split('<', $strRow);
        	for ($i = 0; $i < count($arrPieces); $i++) {
        		if (substr($arrPieces[$i], 0, 3) !== 'td>') {
        			array_push($arrOut, $arrPieces[$i]);
        		}
        	}
        	$strRow = join('<', $arrOut);

            return ("<Table1>\r\n\t$strRow\r\n</Table1>\r\n");
        }
        else {
        	return '<tr ' . $this->_arrTitleInfo['strFieldHeadingAttributes'] . ">$strRow</tr>\r\n";
        }
    }

	/**
	* Creates a "caption" section (typically record counts) for the specified piece of information.  Essentially used to
	*	convert the default "html" style output method of the report into the specified output method (tab or csv).
	* @param string $strCaption The current piece of data to encode as a title
	* @param string @strOutputMethod The desired output method for this row (html, tab, or csv)
	* @return string The encoded title caption string
	* @access private
	*/
    function _makeListCaption($strCaption, $strOutputMethod = 'html')
    {
        if ($strCaption == '') { return(''); }

		if ($strOutputMethod == 'tab' || $strOutputMethod == 'csv' || $strOutputMethod == 'xml') {
			return($this->_makeListTitles($strCaption, $strOutputMethod));
        }
        else {
        	if ($this->_arrTitleInfo['strCaptionAttributes'] === null) {
	        	return "<caption align=\"middle\"><font size='+1'><nobr>$strCaption</nobr></font></caption>\r\n";
        	}
        	else { return '<caption ' . $this->_arrTitleInfo['strCaptionAttributes'] . ">$strCaption</caption>\r\n"; }
        }
    }

	/**
	* Creates a data row section out of the specified row of information.  Essentially used to
	*	convert the default "html" style output method of the report into the specified output method (tab or csv).
	* @param string $strRow The current row of data to encode as a title
	* @param string @strOutputMethod The desired output method for this row (html, tab, or csv)
	* @return string The encoded data row string
	* @access private
	*/
    function _makeListRow($strRow, $strOutputMethod = 'html')
	{
		if ($strOutputMethod == 'tab' || $strOutputMethod == 'csv' || $strOutputMethod == 'xml') {
    		return($this->_makeListTitles($strRow, $strOutputMethod));
        }
        else {
                if ($this->_blnRowIsOdd) {
		        	$strRowAttribs = $this->_arrRowInfo['strOddRowAttributes'];
		        	$strClassName = $this->_arrRowInfo['strOddRowClassName'];
                }
                else {
                	$strRowAttribs = $this->_arrRowInfo['strEvenRowAttributes'];
		        	$strClassName = $this->_arrRowInfo['strEvenRowClassName'];
                }

                if ($this->_arrLinkInfo['blnAllowLink']) {
                	if ($this->_arrRowInfo['strHoverRowClassName'] != '') {
                        $strHoverScript = 'onmouseover="this.className=\'' . $this->_arrRowInfo['strHoverRowClassName'] . '\';" '.
    	                                				'onmouseout="this.className=\'' . $strClassName . '\';"';
                	}
                	else { $strHoverScript = ''; }

                    $strResult = "<tr $strRowAttribs $strHoverScript>$strRow</tr>";
                }
                else { $strResult = "<tr $strRowAttribs>$strRow</tr>\r\n"; }
        }

		// Track whether we're on an even or odd row
     	$this->_blnRowIsOdd = !($this->_blnRowIsOdd);

        return($strResult);
    }

	/**
	* Closes a report list in the specified manner.
	* @param string $strOutputMethod The desired output method for this report
	* @return string The required closing value for this output method
	* @access private
	*/
    function _makeListFooter($strOutputMethod = 'html')
    {
        if ($strOutputMethod == 'html') {
        	return("</table>\r\n");
        }
        else if ($strOutputMethod == 'xml') {
        	return("</NewDataSet>");
        }
        else { return(''); }
    }

	/**
	* Creates the page navigation section of controls for the report.  This will
	* 	result in a series of links of the form:
    *	[<< Prev] | [Back] | 1 | 2 | ... | 10 | [More] | [Next >>]
    *	No more than 10 pages will be allowed at any time, and the current
    *	page will not be a hyperlink.
	* @param integer $intTotalRecords The total number of records in the data
	* @param integer $intNumListColumns The number of fields that are being
	*	displayed for the report.
	*/
    function _makePageNavigators($intTotalRecords, $intNumListColumns)
    {
    	$intStartRecord = $this->_arrPagingInfo['intStartRecord'];
    	$intNumRecords = $this->_arrPagingInfo['intNumRecords'];
        if ($intTotalRecords <= $intNumRecords || $intNumRecords <= 0) {
            // All the records will fit on one page; nothing to do
            return;
        }

        $intNumPagesNeeded = ceil($intTotalRecords / $intNumRecords);
        $strRow = "<td colspan=\"$intNumListColumns\" align=\"left\">";

        // What's the base for this SET of records?
        $intSetBaseRecord = 0;
        for ($iPage = 1; $iPage < $intNumPagesNeeded; $iPage++) {
            if (($iPage * 10 * $intNumRecords) > $intStartRecord) {
                // Found our page set
                $intSetBaseRecord = ($iPage - 1) * 10 * $intNumRecords;
                break;
            }
        }

        if ($intNumPagesNeeded > 10) {
            if ($intSetBaseRecord > 0) {
                $blnNeedLessButton = true;
            }
            else {
                $blnNeedLessButton = false;
            }
            if ($intSetBaseRecord < ($intTotalRecords - 10 * $intNumRecords)) {
                $blnNeedMoreButton = true;
            }
            else {
                $blnNeedMoreButton = false;
            }
        }
        else {
            $blnNeedLessButton = false;
            $blnNeedMoreButton = false;
        }

        // DGC 8-8-2003 Handle any sort order options
        if ($this->_arrSortInfo['blnAllowSort'] && $this->_arrSortInfo['strSortField'] != '') {
        	if ($this->_arrSortInfo['blnUsePathParams'] == 1) {
        		$strSortOptions = '/Sort-' . $this->_arrSortInfo['strSortField'] . '/SortDescending-' . intval($this->_arrSortInfo['blnSortDescending']);
        	}
        	else {
        		$strSortOptions = '&Sort=' . $this->_arrSortInfo['strSortField'] . '&SortDescending=' . intval($this->_arrSortInfo['blnSortDescending']);
        	}
        }
        else { $strSortOptions = ''; }

        // DGC 3-28-2004 While we're at it, if there's an HREF anchor target specified, grab that here
		if ($this->_arrPagingInfo['strPagingAnchor'] != '') {
			$strSortOptions .= '#' . $this->_arrPagingInfo['strPagingAnchor'];
		}

        // Show the prior page and prior set navigators
        if ($intStartRecord > 0) {
            // Not showing the first page; show a link to the prior page
            $intBase = $intStartRecord - $intNumRecords;
            $strLink = '<a href="' . $this->_arrPagingInfo['strPagingURL'] . $intBase . $strSortOptions . '">';
            $strRow .= "$strLink&lt;&lt; Prev</a> | ";

            if ($blnNeedLessButton) {
                // Show the Back option to move to a different set of pages
                $intBase = $intSetBaseRecord - (10 * $intNumRecords);
                $strLink = '<a href="' . $this->_arrPagingInfo['strPagingURL'] . $intBase . $strSortOptions . '">';
                $strRow .= $strLink . 'Back</a> | ';
            }
            else {
                $strRow .= 'Back | ';
            }
        }
        else {
            $strRow .= '&lt;&lt; Prev | ';
            $strRow .= 'Back | ';
        }

        // Show the regular page count navigators
        for ($iPage = 0; $iPage < $intNumPagesNeeded; $iPage++) {
            if (($iPage * $intNumRecords) >= ($intSetBaseRecord + 10 * $intNumRecords)){
                break;
            }

            if (($iPage * $intNumRecords) >= $intSetBaseRecord) {
                if (($iPage * $intNumRecords) == $intStartRecord) {
                    // Found the current page
                    $strRow .= ($iPage + 1 ) . ' | ';
                }
                else {
                    $intBase = $iPage * $intNumRecords;
                    $strLink = '<a href="' . $this->_arrPagingInfo['strPagingURL'] . $intBase . $strSortOptions . '">';
                    $strRow .= $strLink . ($iPage + 1) . '</a> | ';
                }
            }
        }

        // Show the next page and next set navigators
        if ($intStartRecord < ($intTotalRecords - $intNumRecords)) {
            if ($blnNeedMoreButton) {
                // Show the Back option to move to a different set of pages
                $intBase = $intSetBaseRecord + 10 * $intNumRecords;
                $strLink = '<a href="' . $this->_arrPagingInfo['strPagingURL'] . $intBase . $strSortOptions . '">';
                $strRow .= $strLink . 'More</a> | ';
            }
            else {
                $strRow .= 'More | ';
            }

            // Not showing the first page; show a link to the prior page
            $intBase = $intStartRecord + $intNumRecords;
            $strLink = '<a href="' . $this->_arrPagingInfo['strPagingURL'] . $intBase . $strSortOptions . '">';
            $strRow .= $strLink . 'Next &gt;&gt;</a>';
        }
        else {
            $strRow .= 'More | ';
            $strRow .= 'Next &gt;&gt;';
        }

		$strResult = $this->_makeListTitles($strRow . '</td>');
		$strResult = str_replace('<tr ' . $this->_arrTitleInfo['strFieldHeadingAttributes'] . '>', '<tr ' . $this->_arrTitleInfo['strPageNavigatorAttributes'] . '>', $strResult);
		return($strResult);
    }

    /**
	* Used to construct the HREF link for each data value in reports that are configured with linking
	* @param array $arrRecord The array of data for the current record (any field of which can be
	*	used in constructing the link
	* @param boolean $blnCloseQuotes True/False for whether or not to close the quotes of the link,
	*	useful in case additional parameters must be added to the link by some other method
	* @return string
	* @access private
	*/
    function _buildLinkURLFromRecord($arrRecord, $blnCloseQuotes = true)
    {
        $strURL = '"' . $this->_arrLinkInfo['strLinkURL'];

        // See if we need to do dynamic value replacement into the LinkURL target, i.e.
		// does our link target have variables in the base such as "%%strPageName%%.php"
		if (strpos($strURL, '%%') !== false) {
			foreach ($arrRecord as $key=>$val) {
				$strURL = str_replace('%%' . $key . '%%', $val, $strURL);
			}
		}

        $intNumParams = count($this->_arrLinkInfo['arrLinkParamFields']);
        if ($intNumParams == 0) {
        	if ($blnCloseQuotes) {
            	return($strURL . '"');
        	}
        	else { return($strURL); }
        }

        // Check to see if a ''?'' is already in the URL, in which case
        // we should start using the ''&'' right away
        if (strpos($strURL, '?')) {
            $strConcat = '&';
        }
        else { $strConcat = '?'; }

		$arrLinkParamFields = $this->_arrLinkInfo['arrLinkParamFields'];
        for ($iParam = 0; $iParam < $intNumParams; $iParam++) {
            $strCurParamMarker = $arrLinkParamFields[$iParam]['marker'];
            $strCurParamName = $arrLinkParamFields[$iParam]['name'];

            $strCurParamValue = $arrRecord[$strCurParamName];

            // POSSIBLE TODO: make the param name and value safe for including in a URL

            $strURL .= "$strConcat$strCurParamMarker=$strCurParamValue";
            $strConcat = '&';
        }

		if ($this->_arrLinkInfo['strLinkAnchor'] != '') { $strURL .= '#' . $this->_arrLinkInfo['strLinkAnchor']; }
        if ($blnCloseQuotes) { $strURL .= '"'; }
        return($strURL);
    }

	/**
	* Gets the section "key" (unique identifier) for the specified record, i.e. what section
	* 	of the report does this record belong in.  Used for multi-line lists.
	* @param array $curRecord The current record to examine for section key information
	* @return string The section "key" for this record
	* @access private
	*/
    function _getSectionKeyValue($curRecord)
    {
        $strValue = '';
        $arrKeys = $this->_arrColumnInfo['arrSectionKeys'];
        foreach ($arrKeys as $keyField) {
            if ($strValue == '') {
                $strValue .= $curRecord[$keyField];
            }
            else { $strValue .= ', ' . $curRecord[$keyField]; }
        }

        return $strValue;
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
        switch ($strFormat) {
            case 'phone' :
                $strValue = trim($strValue);
                switch (strlen($strValue)) {
                case 7 :
                    // 6060801 -> 606-0801
                    $strValue = substr($strValue, 0, 3) . '-' .
                                substr($strValue, 3);
                    break;
                case 10 :
                    // 8016060801 -> (801) 606-0801
                    $strValue = '(' . substr($strValue, 0, 3) . ') ' .
                                substr($strValue, 3, 3) . '-' .
                                substr($strValue, 6);
                    break;
                default :
                    break;
                }

                break;
            case 'ucase' :
                $strValue = strtoupper($strValue);
                break;
            case 'lcase' :
                $strValue = strtolower($strValue);
                break;
            case 'pcase' :
                $strValue = ucwords(strtolower($strValue));
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
			case 'unixtime' :
				$strValue = ' <script type="text/javascript"> document.write(formatTime(new Date(' . $strValue . ' * 1000))) </script>';
				break;
  default :
                break;
        }

        return $strValue;
    }
}
?>