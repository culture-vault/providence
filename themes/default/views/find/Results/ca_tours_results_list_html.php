<?php
/* ----------------------------------------------------------------------
 * themes/default/views/find/ca_tours_list_html.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011-2012 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */

	$t_display				= $this->getVar('t_display');
	$va_display_list 		= $this->getVar('display_list');
	$vo_result 				= $this->getVar('result');
	$vn_items_per_page 		= $this->getVar('current_items_per_page');
	$vs_current_sort 		= $this->getVar('current_sort');
	$vs_default_action		= $this->getVar('default_action');
	$vo_ar				= $this->getVar('access_restrictions');
?>
<div id="scrollingResults">
	<form id="caFindResultsForm">
		<table class="listtable" width="100%" border="0" cellpadding="0" cellspacing="1">
			<thead>
			<tr>
			<th style="width:10px; text-align:center;" class='list-header-nosort'>
				<input type='checkbox' name='record' value='' id='addItemToSetSelectAllControl' class='addItemToSetControl' onchange="jQuery('.addItemToSetControl').attr('checked', jQuery('#addItemToSetSelectAllControl').attr('checked'));"/>
			</th>
			<th class='list-header-nosort'>
				<?php print ($vs_default_action	== "Edit" ? _t("Edit") : _t("View")); ?>
			</th>

	<?php
			// output headers
			$vn_id_count = 0;
			foreach($va_display_list as $va_display_item) {
				if ($va_display_item['is_sortable']) {
					if ($vs_current_sort == $va_display_item['bundle_sort']) {
						print "<th class='list-header-sorted-asc'><span id='listHeader".$vn_id_count."'><nobr>".((unicode_strlen($va_display_item['display']) > 17) ? strip_tags(mb_substr($va_display_item['display'], 0, 15))."..." : $va_display_item['display'])."</nobr></span></th>";
							TooltipManager::add('#listHeader'.$vn_id_count , _t("Currently sorting by ").$va_display_item['display']);
					} else {
						print "<th class='list-header-unsorted'><span id='listHeader1".$vn_id_count."'><nobr>".caNavLink($this->request, ((unicode_strlen($va_display_item['display']) > 17) ? strip_tags(mb_substr($va_display_item['display'], 0, 15))."..." : $va_display_item['display']), '', $this->request->getModulePath(), $this->request->getController(), 'Index', array('sort' => $va_display_item['bundle_sort'])) ."</nobr></span></th>";
							TooltipManager::add('#listHeader1'.$vn_id_count , _t("Click to sort by ").$va_display_item['display']);
					}
				} else {
					print "<th class='list-header-nosort'><span id='listHeader2".$vn_id_count."'><nobr>".((unicode_strlen($va_display_item['display']) > 17) ? strip_tags(mb_substr($va_display_item['display'], 0, 15))."..." : $va_display_item['display'])."</nobr></span></th>";
						TooltipManager::add('#listHeader2'.$vn_id_count , $va_display_item['display']);
				}
				$vn_id_count++;
			}
	?>
			</tr></thead><tbody>
	<?php
			$i = 0;
			$vn_item_count = 0;
			
			while(($vn_item_count < $vn_items_per_page) && $vo_result->nextHit()) {
				$vn_tour_id = $vo_result->get('tour_id');
			
				($i == 2) ? $i = 0 : "";
	?>
				<tr <?php print ($i ==1) ? "class='odd'" : ""; ?>>
					<td style="width:10px">
						<input type='checkbox' name='add_to_set_ids' value='<?php print (int)$vn_tour_id; ?>' class="addItemToSetControl" />
					</td>
	<?php
					print "<td style='width:5%;'>".caEditorLink($this->request, caNavIcon($this->request, __CA_NAV_BUTTON_EDIT__), '', 'ca_tours', $vn_tour_id, array())."</td>";
					foreach($va_display_list as $vn_placement_id => $va_display_item) {
						print "<td>".$t_display->getDisplayValue($vo_result, $vn_placement_id, array('request' => $this->request))."</td>";
					}
	?>	
				</tr>
	<?php
				$i++;
				$vn_item_count++;
			}
	?>
				</tbody></table>
	</form>
</div><!--end scrollingResults -->