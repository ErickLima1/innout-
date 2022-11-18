<?php
loadModel('User');

class Login extends model {

    public function validate() {
        $errors = [];
        if(!$this->email) {
            $errors['email'] = 'E-mail é um Campo Obrigatorio!!!';
        }

        if(!$this->password) {
            $errors['password'] = 'Por Favor Informe a Senha!!!';
        }

        if(count($errors) > 0) {
            throw new ValidationExecption($errors);
        }
    }

    public function checkLogin() {
        $this->validate();
        $user = User::getOne(['email' => $this->email]);
        if($user) {
            if($user->end_date) {
                throw new AppException('Usuário está Desligado da empresa.');
            }

            if(password_verify($this->password, $user->password)) {
                return $user;
            }
        }
        throw new AppException('Usuário/Senha Inválidos.');
    }
}