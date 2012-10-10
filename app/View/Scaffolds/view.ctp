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
	<li><?php echo __d('cake', 'View %s', $singularHumanName); ?></li>
</ul>
<div class="<?php echo $pluralVar; ?>">
	<div class="row">
		<div class="span3">
			<div class="well" style="padding: 8px 0;">
				<ul class="nav nav-list">
					<li class="nav-header"><?php echo __d('cake', 'Actions'); ?></li>
<?php
	echo "\t\t\t\t\t<li>" . $this->Html->link(__d('cake', 'Edit %s', $singularHumanName), array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey])) . "</li>\n";
	echo "\t\t\t\t\t<li>" . $this->Form->postLink(__d('cake', 'Delete %s', $singularHumanName), array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]), false, __d('cake', 'Are you sure you want to delete').' #' . ${$singularVar}[$modelClass][$primaryKey] . '?') . "</li>\n";
	echo "\t\t\t\t\t<li>" . $this->Html->link(__d('cake', 'List %s', $pluralHumanName), array('action' => 'index')) . "</li>\n";
	echo "\t\t\t\t\t<li>" . $this->Html->link(__d('cake', 'New %s', $singularHumanName), array('action' => 'add')) . "</li>\n";

	$done = array();
	foreach ($associations as $_type => $_data) {
		foreach ($_data as $_alias => $_details) {
			if ($_details['controller'] != $this->name && !in_array($_details['controller'], $done)) {
?>
					<li class="divider"></li>
<?php
				echo "\t\t\t\t\t<li>" . $this->Html->link(__d('cake', 'List %s', Inflector::humanize(Inflector::pluralize(Inflector::underscore($_alias)))), array('controller' => $_details['controller'], 'action' => 'index')) . "</li>\n";
				echo "\t\t\t\t\t<li>" . $this->Html->link(__d('cake', 'New %s', Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'add')) . "</li>\n";
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
			<dl>
<?php
$i = 0;
foreach ($scaffoldFields as $_field) {
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $_alias => $_details) {
			if ($_field === $_details['foreignKey']) {
				$isKey = true;
				echo "\t\t\t\t<dt>" . Inflector::humanize($_alias) . "</dt>\n";
				echo "\t\t\t\t<dd>\n\t\t\t\t\t" . $this->Html->link(${$singularVar}[$_alias][$_details['displayField']], array('controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])) . "\n\t\t\t\t&nbsp;</dd>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t\t\t<dt>" . Inflector::humanize($_field) . "</dt>\n";
		echo "\t\t\t\t<dd>" . h(${$singularVar}[$modelClass][$_field]) . "&nbsp;</dd>\n";
	}
}
?>
			</dl>
<?php
if (!empty($associations['hasOne'])) :
foreach ($associations['hasOne'] as $_alias => $_details): ?>
			<div class="related">
				<h3><?php echo __d('cake', "Related %s", Inflector::humanize($_details['controller'])); ?></h3>
<?php if (!empty(${$singularVar}[$_alias])): ?>
				<dl>
<?php
		$i = 0;
		$otherFields = array_keys(${$singularVar}[$_alias]);
		foreach ($otherFields as $_field) {
			echo "\t\t\t\t<dt>" . Inflector::humanize($_field) . "</dt>\n";
			echo "\t\t\t\t<dd>\n\t\t\t" . ${$singularVar}[$_alias][$_field] . "\n&nbsp;</dd>\n";
		}
?>
				</dl>
<?php endif; ?>
				<div class="actions">
					<ul>
						<li>
							<?php
								echo $this->Html->link(__d('cake', 'Edit %s', Inflector::humanize(Inflector::underscore($_alias))), array('controller' => $_details['controller'], 'action' => 'edit', ${$singularVar}[$_alias][$_details['primaryKey']])) . "\n";
							?>
						</li>
					</ul>
				</div>
				<!--/.actions -->
			</div>
			<!--/.related -->
<?php
endforeach;
endif;
Debugger::dump($associations);
Debugger::dump(${$singularVar});
if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $_alias => $_details):
	$otherSingularVar = Inflector::variable($_alias);
?>
			<div class="related">
				<h3><?php echo __d('cake', "Related %s", Inflector::humanize($_details['controller'])); ?></h3>
<?php if (!empty(${$singularVar}[$_alias])): ?>
				<table class="table table-striped">
					<tr>
<?php
		$otherFields = array_keys(${$singularVar}[$_alias][0]);
		if (isset($_details['with'])) {
			$index = array_search($_details['with'], $otherFields);
			unset($otherFields[$index]);
		}
		foreach ($otherFields as $_field) {
			if ($_field !== 'created' && $_field !== 'modified') {
				echo "\t\t\t\t\t\t<th>" . Inflector::humanize($_field) . "</th>\n";
			}
		}
?>
						<th class="actions">Actions</th>
					</tr>
<?php
		$i = 0;
		$displayed = array();
		foreach (${$singularVar}[$_alias] as ${$otherSingularVar}):
			if (!in_array(${$otherSingularVar}['id'], $displayed)) {
				$displayed[] = ${$otherSingularVar}['id'];
				echo "\t\t\t\t\t<tr>\n";
				foreach ($otherFields as $_field) {
					if ($_details['displayField'] === $_field) {
						echo "\t\t\t\t\t\t<td>" . $this->Html->link(${$otherSingularVar}[$_field], array('controller' => $_details['controller'], 'action' => 'view', ${$otherSingularVar}[$_details['primaryKey']])) . "</td>\n";
					} else {
						if ($_field !== 'created' && $_field !== 'modified') {
							echo "\t\t\t\t\t\t<td>" . ${$otherSingularVar}[$_field] . "</td>\n";
						}
					}
				}
				echo "\t\t\t\t\t\t<td class=\"actions\">\n";
				echo "\t\t\t\t\t\t\t" . $this->Html->link(__d('cake', 'Edit'), array('controller' => $_details['controller'], 'action' => 'edit', ${$otherSingularVar}[$_details['primaryKey']]), array('class' => 'btn-mini btn-primary')). "\n";
				echo "\t\t\t\t\t\t\t" . $this->Form->postLink(__d('cake', 'Delete'), array('controller' => $_details['controller'], 'action' => 'delete', ${$otherSingularVar}[$_details['primaryKey']]), array('class' => 'btn-mini btn-danger'), __d('cake', 'Are you sure you want to delete', true).' #' . ${$otherSingularVar}[$_details['primaryKey']] . '?'). "\n";
				echo "\t\t\t\t\t\t</td>\n";
				echo "\t\t\t\t\t</tr>\n";
			}
		endforeach;
?>
				</table>
<?php endif; ?>
				<div class="btn-toolbar">
					<div class="btn-group">
						<a class="btn btn-success" href="<?php echo $this->Html->url(array('controller' => $_details['controller'], 'action' => 'add')); ?>">
							<i class="icon-plus-sign icon-white"></i>
							<?php echo __d('cake', "New %s", Inflector::humanize(Inflector::underscore($_alias))) . "\n"; ?>
						</a>
					</div>
					<!--/.btn-group -->
				</div>
				<!--/.btn-toolbar -->
<?php endforeach; ?>
			</div>
			<!--/.related -->
		</div>
		<!--/.span9 -->
	</div>
	<!--/.row -->
</div>
<!--/.<?php echo $pluralVar; ?> -->
