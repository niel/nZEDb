<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, nZEDb (http://nzedb.com)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title>Application &gt; <?php echo $this->title(); ?></title>
	<?php echo $this->html->style(array('lithified',
		'font-awesome.min',
		/*'bootstrap-combined.no-icons.min',*/
		'bootstrap.min',
		'jquery.qtip',
		'style'
		)); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->styles(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<body class="lithified">
	<div class="container-medium">

		<div class="masthead">
			<a  class="logolink" title="nZEDb Logo" href="/"><?= $this->html->image('logo.png', array('class' => 'logoimg', 'alt' => "nZEDb Logo"))?></a>
		</div>

		<hr>

		<div class="content">
			<?php echo $this->content(); ?>
		</div>

		<hr>

		<div class="footer">
			<p class="pull-right">&copy; nZEDb 2013</p>
		</div>

	</div>
</body>
</html>