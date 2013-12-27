<?php
/**
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
 * @author niel
 * @copyright 2013 nZEDb
 */

?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title>Application &gt; <?php echo $this->title(); ?></title>
	<?php echo $this->html->style(array('lithified',
		'font-awesome.min',
		'bootstrap-combined.no-icons.min',
		'jquery.qtip',
		'style',
		'nzedb'
		)); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->styles(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<body class="lithified">
	<div class="container-medium">
		<div class="masthead">
			<?php if (false && $vars['reset']): ?>
			<ul class="nav nav-pills pull-right">
				<li><?php echo $this->html->link('Reset', '/reset') ?></li>
			</ul>
			<?php endif; ?>
			<a  class="logolink" title="nZEDb Logo" href="/"><?= $this->html->image('logo.png', array('class' => 'logoimg', 'alt' => "nZEDb Logo"))?></a>
		</div>

		<hr>

		<div class="content">
			<?php echo $this->content(); ?>
		</div>

		<hr>

		<div class="footer">
			<p class="right">&copy; nZEDb 2013</p>
			<?php if (isset($debug)) var_dump ($debug); ?>
		</div>
	</div>
</body>
</html>
