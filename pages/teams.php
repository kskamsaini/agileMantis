<?php
	# agileMantis - makes Mantis ready for Scrum

	# agileMantis is free software: you can redistribute it and/or modify
	# it under the terms of the GNU General Public License as published by
	# the Free Software Foundation, either version 2 of the License, or
	# (at your option) any later version.
	#
	# agileMantis is distributed in the hope that it will be useful,
	# but WITHOUT ANY WARRANTY; without even the implied warranty of
	# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	# GNU General Public License for more details.
	#
	# You should have received a copy of the GNU General Public License
	# along with agileMantis. If not, see <http://www.gnu.org/licenses/>.
	
	html_page_top(plugin_lang_get( 'manage_teams_title' )); 
?>
<br>
<?php include(PLUGIN_URI.'/pages/footer_menu.php');?>
<br>
<?php

# delete team
if($_POST['deleteTeam'] != ""){
	$team_id = (int) $_POST['team_id'];
	$team->deleteTeamMember($team_id);
	$team->deleteTeam($team_id);
}

# get all teams
$teams = $team->getTeams();
?>
<table align="center" class="width100" cellspacing="1">
	<tr>
		<td colspan="6"><b><?php echo plugin_lang_get( 'manage_teams_title' )?></b>  <form action="<?php echo plugin_page("edit_team.php")?>" method="post"><input type="submit" name="submit" value="<?php echo plugin_lang_get( 'manage_teams_add' )?>"></form></td>
	</tr>
	<tr>
		<td class="category"><a href="<?php echo plugin_page("teams.php")?>&sort_by=name">Name</a></td>
		<td class="category"><a href="<?php echo plugin_page("teams.php")?>&sort_by=description"><?php echo plugin_lang_get( 'common_description' )?></a></td>
		<td class="category"><a href="<?php echo plugin_page("teams.php")?>&sort_by=product_backlog">Product Backlog</a></td>
		<td class="category"><a href="<?php echo plugin_page("teams.php")?>&sort_by=product_owner">Product Owner</a></td>
		<td class="category"><a href="<?php echo plugin_page("teams.php")?>&sort_by=scrum_master">Scrum Master</a></td>
		<td class="category"><?php echo plugin_lang_get( 'common_actions' )?></td>
	</tr>
	<?php if(!empty($teams)){foreach($teams AS $num => $row){?>
	<tr <?php echo helper_alternate_class() ?>>
		<td><?php echo $row['name']?></td>
		<td><?php echo $row['description']?></td>
		<td><?php echo $team->getTeamBacklog($row['product_backlog'])?></td>
		<td><?php echo $team->getProductOwner($row['id'])?></td>
		<td><?php echo $team->getScrumMaster($row['id'])?></td>
		<td class="right" width="205">
			<form method="post" action="<?php echo plugin_page('edit_team.php') ?>">
				<input type="submit" name="edit[<?php echo $row['id']?>]" value="<?php echo plugin_lang_get( 'button_edit' )?>" style="width:100px;"> 
			</form>
			<form method="post" action="<?php echo plugin_page('delete_team.php') ?>">
				<input type="hidden" name="team_id" value="<?php echo $row['id'] ?>">
				<input type="submit" name="deleteTeam" value="<?php echo plugin_lang_get( 'button_delete' )?>" style="width:100px;" <?php if($team->hasSprints($row['id']) > 0){?>disabled<?php }?>> 
			</form>
		</td>
	</tr>
	<?php }}?>
</table>
<?php html_page_bottom() ?>