<?php 

require_once(dirname(__FILE__, 2) . '/innout/src/config/config.php');
require_once(dirname(__FILE__, 2) . '/innout/src/models/User.php');

$user = new User(['name' => 'Erick', 'email' => 'erick@gmail.com']);
//echo $user->getSelect();
//echo User::getSelect(['id' => '1'], 'name', 'email');

print_r(User::get(['name' => 'Chaves'], 'id, name, email'));
echo '<br>';

foreach(User::get([], 'name') as $user) {
    echo $user->name;
    echo '<br>';
}