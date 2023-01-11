<main class="content">
 <?php
    renderTitle(
        'Relatório Mensal',
        'Acompanhe Seu Saldo De Horas',
        'icofont-ui-calendar'
    );
 ?>
 <div>
	<form class="mb-4" action="#" method="post">
		<div class="input-group">
			<?php if($user->is_admin): ?>
			<select name="user" class="form-control mr-2" placeholder="Selecionar o Usuario...">
				<option value="">Selecione o Usúario</option>
				<?php
					foreach($users as $user) {
						$selected = $user->id === $selectUserId ? 'selected' : '';
						echo utf8_encode("<option value='{$user->id}' {$selected}>{$user->name}</option>");
					}
				?>
			</select>
			<?php endif ?>
			<select name="period" class="form-control" placeholder="Selecionar o Periodo...">
				<?php
					foreach($periods as $key => $month) {
						$selected = $key === $selectedPeriod ? 'selected' : '';
						echo utf8_encode("<option value='{$key}' {$selected}>{$month}</option>");
					}
				?>
			</select>
			<button class="btn btn-primary ml-2">
				<i class="icofont-search"></i>
			</button>
		</div>
	</form>
    <table class="table table-bordered table-striped table-hover">
		<thead>
			<th>Dia</th>
			<th>Entrada 1</th>
			<th>Saida 1</th>
			<th>Entrada 2</th>
			<th>Saida 2</th>
			<th>Saldo</th>
		</thead>
		<tbody>
			<?php foreach($report as $registry): ?>
				<tr>
					<td><?= utf8_encode(formatDateWithLocale($registry->work_date, '%A, %d de %B de %Y')) ?></td>
					<td><?=$registry->time1 ?></td>
					<td><?=$registry->time2 ?></td>
					<td><?=$registry->time3 ?></td>
					<td><?=$registry->time4 ?></td>
					<td><?=$registry->getBalance()?></td>
				</tr>
			<?Php endforeach ?>
			<tr class="bg-primary text-white">
				<td>Horas Trabalhadas</td>
				<td colspan="3"><?= $sumOfWorkedTime?></td>
				<td>Saldo Mensal</td>
				<td><?= $balance ?></td>
			</tr>
		</tbody>
    </table>
 </div>
</main>