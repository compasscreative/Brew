<?php
use Brew\Bundle\Leads\Lead;

$this->id = 'admin_leads_page';
$this->title = 'Leads';
$this->insert('admin::partials/header');
?>

<div class="panel">
	<div class="header">
		<div class="title">Leads</div>
	</div>
	<div class="body">
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Date submitted</th>
				</tr>
			</thead>
			<tbody>
			<?php if($this->leads){ ?>
				<?php foreach($this->leads as $lead){ ?>
					<tr>
						<td><a href="/admin/leads/edit/<?=$lead->id?>/"><?=$lead->name?></a></td>
						<td><?=$lead->email?></td>
						<td><?=$lead->phone?></td>
						<td><?=date_create($lead->date)->format('F j, Y \a\t g:i a')?></td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="4">No records found.</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php $this->insert('admin::partials/footer'); ?>