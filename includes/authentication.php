<?php
/***************************************************************************
 *                            authentication.php
 *                           --------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: authentication.php,v 2.00 2008/03/03 14:16:52 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2008 Douglas Wagner
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
if(PAGE_LVL != 'anonymous')
{
	if($_SESSION['priv_' . PAGE_LVL] != 1) {
		$errorTitle = $phprlang['priv_title'];
		$errorMsg = $phprlang['priv_msg'];
		$errorDie = 1;
	}
}
?>