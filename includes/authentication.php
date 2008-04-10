<?php
/***************************************************************************
 *                            authentication.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2005 Kyle Spraggs
 *   email                : spiffyjr@gmail.com
 *
 *   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
if(PAGE_LVL != 'anonymous')
{
	if($_SESSION['priv_' . PAGE_LVL] != 1) {
		$errorTitle = $phprlang['priv_title'];
		$errorMsg = $phprlang['priv_msg'];
		$errorDie = 1;
	}
}
?>