<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php echo Configure::read('Application.name') ?> - <?php echo !empty($title_for_layout) ? $title_for_layout : ''; ?></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<style>
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
		</style>
<?php
	echo "\t\t" . $this->Html->css('normalize') . "\n";
	echo "\t\t" . $this->Html->css('bootstrap') . "\n";
	echo "\t\t" . $this->Html->css('bootstrap-responsive.min') . "\n";
	echo "\t\t" . $this->Html->css('styles') . "\n";
	echo "\t\t" . $this->Html->script('modernizr') . "\n";
?>
	</head>
	<body>
		<!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar">
						</span>
						<span class="icon-bar">
						</span>
						<span class="icon-bar">
						</span>                  </a>
					<?php echo $this->Html->link( Configure::read('Application.name') ,"/",array('class' => 'brand')). "\n" ?>
					<div class="nav-collapse">
						<ul class="nav">
<?php
	$navigation = array('employees' => 'Employees', 'clients' => 'Clients', 'projects' => 'Projects', 'tasks' => 'Tasks');
	//Debugger::dump($this); exit;
	foreach ($navigation as $controller => $label) {
		$activeClass = $this->name === $label ? ' class="active"' : '';
		echo "\t\t\t\t\t\t\t<li" . $activeClass . ">" . $this->Html->link(
			$label,
			array('controller' => $controller, 'action' => 'index')
		) . "</li>\n";
	}
?>
						</ul>
<?php if( AuthComponent::user('id') ) { ?>
						<ul class="nav pull-right">
							<li id="fat-menu" class="dropdown">
								<a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-black icon-user"></i>
									<?php echo AuthComponent::user('username') ?>
									<b class="caret"></b></a>
								<ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
									<li>
										<?php echo $this->Html->link(
			                                '<i class="icon-black icon-off"></i> Logout','/users/logout',
			                                array(
			                                  'tabindex' => '-1',
			                                  'escape' => false
			                                  )
										) ?>
									</li>
								</ul>
							</li>
						</ul>
<?php } ?>
					</div>
					<!--/.nav-collapse -->
				</div>
				<!--/.container -->
			</div>
			<!--/.navbar-inner -->
		</div>
		<!--/.navbar -->
		<div class="container" role="main" id="main">
<?php echo $this->Session->flash();?>
			<!-- CONTENT -->
<?php echo $this->fetch('content'); ?>
			<!-- /CONTENT -->
			<hr>
			<footer>
				<p>
					&copy; <?php echo Configure::read('Application.name') ?> 2012
				</p>
			</footer>
		</div>
		<!-- /.container -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
		<script>
			window.jQuery || document.write('<script src="<?php echo $this->params->webroot ?>js/jquery.min.js"><\/script>');
		</script>
		<?php echo $this->Html->script(array('bootstrap.min'));?>
<?php echo $this->element('sql_dump'); ?>
	</body>
</html>