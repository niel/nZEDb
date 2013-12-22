<?php
/**
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program (see LICENSE.txt in the base directory.  If
 * not, see:
 *
 * @link <http://www.gnu.org/licenses/>.
 * @author Niel Archer <niel.archer@gmail.com>
 * @copyright 2013 nZEDb
 */

use \li3_nzedb\models\Sites;
?>
<div class="none">
	<table class="data">
		<tr>
			<th>Username:</th>
			<td><?= $user['username'] ?></td>
		</tr>
<?php if ($user['role'] == 2): ?>
		<tr>
			<th title="Not public">Email:</th>
			<td><?= $user['email'] ?></td>
		</tr>
<?php endif; ?>
		<tr>
			<th>Registered:</th>
			<td title="<?= $user['createddate']; ?>">{$user.createddate|date_format}  ({$user.createddate|timeago} ago)</td>
		</tr>
		<tr>
			<th>Last Login:</th>
			<td title="<?= $user['lastlogin']; ?>">{$user.lastlogin|date_format}  ({$user.lastlogin|timeago} ago)</td>
		</tr>
		<tr>
			<th>Role:</th>
			<td>{$user.rolename}</td>
		</tr>
<?php if ($user['role'] == 2): ?>
		<tr>
			<th title="Not public">Site Api/Rss Key:</th>
			<td><a href="{$smarty.const.WWW_TOP}/rss?t=0&amp;dl=1&amp;i={$userdata.id}&amp;r={$userdata.rsstoken}">{$user.rsstoken}</a></td>
		</tr>
<?php endif; ?>
		<tr>
			<th>Grabs:</th>
			<td>{$user.grabs}</td>
		</tr>
<?php if ($user['role'] == 2 && Sites::get('registerstatus') == 1): ?>
		<tr>
			<th title="Not public">Invites:</th>
			<td>{$user.invites}
<?php if ($user['invites'] > 0): ?>
				[<a id="lnkSendInvite" onclick="return false;" href="#">Send Invite</a>]
				<span title="Your invites will be reduced when the invitation is claimed." class="invitesuccess" id="divInviteSuccess">Invite Sent</span>
				<span class="invitefailed" id="divInviteError"></span>
				<div style="display:none;" id="divInvite">
					<form id="frmSendInvite" method="GET">
						<label for="txtInvite">Email:</label>
						<input type="text" id="txtInvite" />
						<input type="submit" value="Send"/>
					</form>
				</div>
<?php endif; ?>
			</td>
		</tr>
<?php endif; ?>
<?php if (isset($user['invitedby']) && $userinvitedb['username'] != ''): ?>
		<tr>
			<th>Invited By:</th>
			<td><a title="View {$userinvitedby.username}'s profile" href="{$smarty.const.WWW_TOP}/profile?name={$userinvitedby.username}">{$userinvitedby.username}</a></td>
		</tr>
<?php endif; ?>
		<tr><th>UI Preferences:</th>
			<td>
				<?php echo $user['movieview'] ? "View movie covers</br>\n" : "View standard movie category<br />\n"; ?>
				<?php echo $user['musicview'] ? "View music covers</br>\n" : "View standard music category<br />\n"; ?>
				<?php echo $user['consoleview'] ? "View console covers</br>\n" : "View standard console category<br />\n"; ?>
				<?php echo $user['bookview'] ? "View book covers</br>\n" : "View standard book category<br />\n"; ?>
			</td>
		</tr>
<?php if ($user['role'] == 2): ?>
<?php endif; ?>
		<tr>
			<th title="Not public">Excluded Categories:</th>
			<td>{$exccats|replace:",":"<br/>"}</td>
		</tr>
<?php if (Sites::get('sabintegrationtype') == 2 && $user['role'] == 2): ?>
		<tr>
			<th>SABnzbd Integration:</th>
			<td>
				Url: <?php echo empty($user['saburl']) ? 'N/A<br />' : $user['saburl'] . '<br />' ?>
				Key: <?php echo empty($user['sabapikey']) ? 'N/A<br />' : $user['sabapikey'] . '<br />' ?>
				Type: <?php echo empty($user['sabapikeytype']) ? 'N/A<br />' : $user['sabapikeytype'] . '<br />' ?>
				Priority: <?php echo empty($user['sabpriority']) ? 'N/A<br />' : $user['sabpriority'] . '<br />' ?>
				Storage: <?php echo empty($user['sabsetting']) ? 'N/A<br />' : $user['sabsetting'] . '<br />' ?>
			</td>
		</tr>
<?php endif; ?>
<?php if ($user['role'] == 2): ?>
		<tr>
			<th>My TV Shows:</th>
			<td><?= $this->html->link('Manage', '/profiles/myshows'); ?></td>
		</tr>
		<tr>
			<th>My Movies:</th>
			<td><?= $this->html->link('Manage', '/profiles/mymovies'); ?></td>
		</tr>
<?php endif; ?>
<?php if ($user['role'] == 2): ?>
		<tr>
			<td class="centred" colspan="2"><?= $this->html->link('Edit', '/profiles/edit'); ?></td>
		</tr>
<?php endif; ?>
<?php if ($user['role'] == 2): ?>
<?php endif; ?>
	</table>
</div>
