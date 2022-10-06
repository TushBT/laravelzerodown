<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';

// Config

set('repository', 'https://github.com/TushBT/laravelzerodown.git');
set ('ssh_multiplexing', false);
// Hosts

host('13.233.107.109')
    ->set('remote_user', 'mylaravel')
    ->set('deploy_path', '/home/mylaravel/htdocs/mylaravel.com');

// Hooks
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:config:cache',
    'artisan:route:cache',
    'artisan:view:cache',
    'artisan:event:cache',
    'artisan:migrate',
    'npm:install',
    'npm:run:prod',
    'deploy:publish',
	'artisan:horizon:terminate',
]);

task('npm:run:prod', function () {
    cd('{{release_path}}');
    run('npm run prod');
});

after('deploy:failed', 'deploy:unlock');
