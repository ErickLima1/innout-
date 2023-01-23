<?php error_reporting(E_ERROR | E_PARSE)?>
<main class="content">
    <?php
        renderTitle(
            'Cadastrando Usuarios',
            'Crie e Atualize os Usuarios',
            'icofont-user'
        );

        include(TEMPLATE_PATH . "/messages.php");
    ?>
    <form action="#" method="post">
      <input type="hidden" name="id" value="<?= $id ?? "" ?>">
      <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Nome</label>
            <input type="text" id="name" name="name" placeholder="informe o nome" class="form-control
                <?= $errors['name'] ? 'is-invalid' : '' ?>" value="<?= $name ?? ""?>">
            <div class="invalid-feedback">
                <?= $errors['name'] ?>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Informe o email" class="form-control 
                <?= $errors['email'] ? 'is-invalid' : '' ?>" value="<?= $email ?? "" ?>">
            <div class="invalid-feedback">
                <?= $errors['email'] ?>
            </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password">Senha</label> <!--Parte da senha-->
            <input type="password" id="password" name="password" placeholder="informe a senha" class="form-control
                <?= $errors['password'] ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback">
                <?= $errors['password'] ?>
            </div>
        </div>
        <div class="form-group col-md-6"> <!--Parte da Senha-->
            <label for="confirm_password">Digite Novamente sua senha</label>
            <input type="password" id="confirm_password" name="confirm_password" 
                placeholder="Confirme a sua senha" class="form-control 
                <?= $errors['confirm_password'] ? 'is-invalid' : '' ?>">
            <div class="invalid-feedback">
                <?= $errors['confirm_password'] ?>
            </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
            <label for="start_date">Data de Admissão</label>
            <input type="date" id="start_date" name="start_date" class="form-control
                <?= $errors['start_date'] ? 'is-invalid' : '' ?>" value="<?= $start_date ?>">
            <div class="invalid-feedback">
                <?= $errors['start_date'] ?>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="end_date">Data de Desligamento</label>
            <input type="date" id="end_date" name="end_date" class="form-control 
                <?= $errors['end_date'] ? 'is-invalid' : '' ?>" value="<?= $end_date ?>">
            <div class="invalid-feedback">
                <?= $errors['end_date'] ?>
            </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
            <label for="is_admin">Administrador</label>
            <input type="checkbox" id="is_admin" name="is_admin" 
                class="form-control <?= $errors['is_admin'] ? 'is-invalid' : ''?>"
                <?= isset($is_admin) && $is_admin ? 'checked' : '' ?>>
            <div class="invalid-feedback">
                <?= $errors['is_admin'] ?>
            </div>
        </div>
      </div>
        <div>
            <button class="btn btn-primary btn-lg">Salvar</button>
            <a href="/users.php" class="btn btn-secondary btn-lg">Cancelar</a>
        </div>
    </form>
</main>