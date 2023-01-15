<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'desplegar_laravel');

// Project repository
set('repository', 'git@github.com:Byvictor25/todo-laravel.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('192.168.56.107')
    ->set('deploy_path', '/var/www/prog-ud4-a4/html')
    ->identityFile('~/.ssh/id_rsa.pub')
    ->user('ddaw-ud4-deployer');
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

// Declaració de la tasca
task('reload:php-fpm', function () {
 run('sudo /etc/init.d/php8.1-fpm restart');
});

// inclusió en el cicle de desplegament
after('deploy', 'reload:php-fpm');
