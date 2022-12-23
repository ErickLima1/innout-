<?php

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

//Constantes gerais
define('DAILY_TIME', 60 * 60 * 8);

//Pastas
define('MODEL_PATH', realpath(dirname(__FILE__). '/../models'));
define('VIEW_PATH', realpath(dirname(__FILE__). '/../views'));
define('TEMPLATE_PATH', realpath(dirname(__FILE__). '/../views/template'));
define('CONTROLLER_PATH', realpath(dirname(__FILE__). '/../controllers'));
define('EXECPTION_PATH', realpath(dirname(__FILE__). '/../execptions'));

//Arquivos
require_once(realpath(dirname(__FILE__). '/database.php'));
require_once(realpath(dirname(__FILE__). '/loader.php'));
require_once(realpath(dirname(__FILE__). '/session.php'));
require_once(realpath(dirname(__FILE__). '/date_utils.php'));
require_once(realpath(MODEL_PATH . '/Model.php'));
require_once(realpath(MODEL_PATH . '/User.php'));
require_once(realpath(EXECPTION_PATH . '/AppExecption.php'));
require_once(realpath(EXECPTION_PATH . '/ValidationExecption.php'));

