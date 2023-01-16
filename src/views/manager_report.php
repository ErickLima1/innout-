<main class="content"> 
    <?php
    renderTitle(
        'Relátorio Gerencial',
        'Resumo Das Horas Trabalhada Dos Funcionarios',
        'icofont-chart-histogram'
        );
    ?>
    <div class="summary-boxes">
        <div class="summary-box bg-primary">
            <i class="icon icofont-users"></i>
            <p class="title">Quantidade De Funcionarios</p>
            <h3 class="value"><?= $activeUsersCount ?></h3>
        </div>
        <div class="summary-box bg-danger">
            <i class="icon icofont-patient-bed"></i>
            <p class="title">Faltas</p>
            <h3 class="value"><?= count($absentUsers) ?></h3>
        </div>
        <div class="summary-box bg-success">
            <i class="icon icofont-sand-clock"></i>
            <p class="title">Horas Trabalhada No Mês</p>
            <h3 class="value"><?= $hoursInMonth ?></h3>
        </div>
    </div>

    <?php if(count($absentUsers) > 0): ?>
        <div class=" mt-4">
            <div class="card-header">
                <h4 class="card-title">Faltosos Do Dia</h4>
                <p class="card-category mb-0">Relação Dos Funcionarios Que Ainda não Bateram o ponto</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <th>Nome</th>
                    </thead>
                    <tbody>
                        <?php foreach($absentUsers as $name):?>
                            <tr>
                                <td><?= $name ?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif ?>
</main>