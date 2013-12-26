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
<?=$this->flashMessage->show(); ?>
<div id="login">
			<?=$this->form->create(null); ?>

				<?=$this->form->field('username'); ?>

				<?=$this->form->field('email'); ?>

				<?=$this->form->field('firstname'); ?>

				<?=$this->form->field('lastname'); ?>

				<?=$this->form->field('password', array('type' => 'password')); ?>

				<?=$this->form->field('password2', array('label' => 'Repeat password', 'type' => 'password')); ?>
				<div><p> </p></div>
				<?=$this->form->submit('Join'); ?>

			<?=$this->form->end(); ?>
</div>
