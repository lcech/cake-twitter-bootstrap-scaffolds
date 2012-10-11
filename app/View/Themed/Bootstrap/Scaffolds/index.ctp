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
	<li><?php echo __d('cake', 'List') . ' ' . $pluralHumanName; ?></li>
</ul>
<div class="<?php echo $pluralVar; ?>">
<?php if (0) { ?>
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
		</div>
		<div class="span9">
<?php } ?>
			<div class="btn-toolbar">
				<div class="btn-group">
					<a class="btn btn-success" href="<?php echo $this->Html->url(array('action' => 'add'), array('class' => 'btn')); ?>">
						<i class="icon-plus-sign icon-white"></i>
						<?php echo __d('cake', 'New %s', $singularHumanName); ?>
					</a>
				</div>
			</div>
			<table class="table table-striped">
				<tr>
<?php
	//Debugger::dump($scaffoldFields);
	foreach ($scaffoldFields as $key => $_field):
		if ($_field === 'id' || $_field === 'created' || $_field === 'modified') {
			unset($scaffoldFields[$key]);
		} else {
?>
					<th><?php echo $this->Paginator->sort($_field); ?></th>
<?php
		}
	endforeach;
?>
					<th><?php echo __d('cake', 'Actions'); ?></th>
				</tr>
<?php
	$i = 0;
	//Debugger::dump($scaffoldFields);
	//Debugger::dump(${$pluralVar});
	foreach (${$pluralVar} as ${$singularVar}):
		echo "\t\t\t\t<tr>";
			foreach ($scaffoldFields as $_field) {
				$isKey = false;
				if (!empty($associations['belongsTo'])) {
					foreach ($associations['belongsTo'] as $_alias => $_details) {
						if ($_field === $_details['foreignKey']) {
							$isKey = true;
							echo "\t\t\t\t\t<td><span class=\"label\" style=\"background: #" . substr(dechex(crc32(${$singularVar}[$_alias][$_details['displayField']])), 0, 6) . ";\">" . $this->Html->link(${$singularVar}[$_alias][$_details['displayField']], array('controller' => $_details['controller'], 'action' => 'view', ${$singularVar}[$_alias][$_details['primaryKey']])) . "</span></td>\n";
							break;
						}
					}
				}
				if ($isKey !== true) {
					if ($this->viewVars['displayField'] === $_field) {
						echo "\t\t\t\t\t<td>" . $this->Html->link(h(${$singularVar}[$modelClass][$_field]), array('action' => 'view', ${$singularVar}[$modelClass][$primaryKey])) . "</td>\n";
					} else {
						echo "\t\t\t\t\t<td>" . h(${$singularVar}[$modelClass][$_field]) . "</td>\n";
					}
				}
			}

			echo "\t\t\t\t\t<td class=\"actions\">\n";
			echo $this->Html->link(__d('cake', 'Edit'), array('action' => 'edit', ${$singularVar}[$modelClass][$primaryKey]), array('class' => 'btn-mini btn-primary')) . ' ';
			echo $this->Form->postLink(
				__d('cake', 'Delete'),
				array('action' => 'delete', ${$singularVar}[$modelClass][$primaryKey]),
				array('class' => 'btn-mini btn-danger'),
				__d('cake', 'Are you sure you want to delete').' #' . ${$singularVar}[$modelClass][$primaryKey]
			);
			echo "\t\t\t\t\t\t</td>\n";
		echo "\t\t\t\t</tr>\n";
	endforeach;
?>
			</table>
			<p>
				<?php
					echo $this->Paginator->counter(array(
						'format' => __d('cake', 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
					)) . "\n";
				?>
			</p>
			<div class="paging">
				<?php
					echo $this->Paginator->prev('< ' . __d('cake', 'previous'), array(), null, array('class' => 'btn disabled')) . ' ';
					echo $this->Paginator->numbers(array('separator' => '')) . ' ';
					echo $this->Paginator->next(__d('cake', 'next') .' >', array(), null, array('class' => 'btn disabled')) . "\n";
				?>
			</div>
<?php if (0) { ?>
		</div>
	</div>
<?php } ?>
</div>
