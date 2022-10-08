<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';
// Config

set('repository', 'https://github.com/TushBT/laravelzerodown.git');
set ('ssh_multiplexing', false);
// Hosts

host('134.209.151.187')
    ->set('remote_user', 'ubuntu')
    ->set('deploy_path', '/home/ubuntu/www.livealoo.com/prod/');

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
        'deploy:publish',
        'artisan:horizon:terminate',
    ]);

    task('npm:run:build', function () {
        cd('{{deploy_path}}' . '/current/');
        run('npm run build');
    });

after('deploy:symlink', 'npm:run:build');

after('deploy:failed', 'deploy:unlock');

