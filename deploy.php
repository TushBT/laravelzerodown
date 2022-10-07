<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/TushBT/laravelzerodown.git');

// Hosts

host('13.233.54.179')
    ->set('remote_user', 'mylaravel')
    ->set('deploy_path', '/home/mylaravel/htdocs/www.livealoo.com')
    ->set('ssh_multiplexing', true);

    task('deploy', [
        'deploy:prepare',
        'deploy:vendors',
        'artisan:storage:link',
        'artisan:config:cache',
        'artisan:route:cache',
        'artisan:view:cache',
        'artisan:event:cache',
        'artisan:migrate',
        'deploy:publish',
        'artisan:horizon:terminate',
    ]);

after('deploy:failed', 'deploy:unlock');
