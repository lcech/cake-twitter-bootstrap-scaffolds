<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Scaffolds
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<ul class="breadcrumb">
	<li><?php echo $this->Html->link(__d('cake', 'Home'), '/'); ?> <span class="divider">/</span></li>
	<li><?php echo $this->Html->link(__d('cake', 'List') . ' ' . $pluralHumanName, array('action' => 'index')); ?> <span class="divider">/</span></li>
	<li><?php echo __d('cake', 'Edit %s', $singularHumanName); ?></li>
</ul>
<div class="<?php echo $pluralVar; ?>">
	<div class="row">
		<div class="span3">
			<div class="well" style="padding: 8px 0;">
				<ul class="nav nav-list">
					<li class="nav-header"><?php echo __d('cake', 'Actions'); ?></li>
<?php
		$done = array();
		foreach ($associations as $_type => $_data) {
			foreach ($_data as $_alias => $_details) {
				if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
?>
					<li class="divider"></li>
<?php
					echo "\t\t\t\t\t<li><a href=\"" . $this->Html->url(array('controller' => $_details['controller'], 'action' => 'index')) . "\">";
					echo __d('cake', 'List %s', Inflector::humanize(Inflector::pluralize(Inflector::underscore($_alias))));
					echo "</a></li>\n";
					echo "\t\t\t\t\t<li><a href=\"" . $this->Html->url(array('controller' => $_details['controller'], 'action' => 'add')) . "\">";
					echo __d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias)));
					echo "</a></li>\n";
					$done[] = $_details['controller'];
				}
			}
		}
?>
				</ul>
			</div>
			<!--/.well -->
		</div>
		<!--/.span3 -->
		<div class="span9">
<?php
	echo $this->Form->create();
	echo $this->Form->inputs($scaffoldFields, array('created', 'modified'));
?>
			<div class="form-actions">
				<?php
					echo $this->Form->end(array(
						'label' => __d('cake', 'Save'),
						'class' => 'btn btn-large btn-primary',
						'div' => false
					)) . "\n";
					echo $this->Html->link(__d('cake', 'Cancel'), array('action' => 'index'), array('class' => 'btn'));
					/*if ($this->request->action != 'add') { 
						echo $this->Form->create($modelClass, array('url' => array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]), 'type' => 'post', 'class' => 'form-inline'));
						echo $this->Form->end(array(
							'label' => __d('cake', 'Delete'),
							'class' => 'btn btn-danger',
							'div' => false
						));
					}*/
				?>
			</div>
			<!--/.form-actions -->
		</div>
		<!--/.span9 -->
	</div>
	<!--/.row -->
</div>
<!--/.<?php echo $pluralVar; ?> -->
