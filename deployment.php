<?php

namespace Deployer;

import('recipe/laravel.php');

set('project_prefix', 'undersiege_');
set('php_container', '{{project_prefix}}php');

set('release_name', function () {
    return (new \DateTime())->format('Y-m-d_His');
});

set('writable_dirs', [
    ...get('writable_dirs'),
    'vendor',
    'public',
]);

set('bin/php', function () {
    return which('docker') . ' exec -w{{release_or_current_path}} {{php_container}} php';
});

set('bin/composer', function () {
    return which('docker') . ' exec -w{{release_or_current_path}} {{php_container}} composer';
});

set('bin/node', function () {
    return which('docker') . ' run --rm -v{{deploy_path}}:/project -w/project/release node:16.14';
});

task('build', function () {
    cd('{{release_or_current_path}}');
    run('{{bin/node}} npm install');
    run('{{bin/node}} npm run prod');
});


after('deploy:vendors', 'build');
before('artisan:config:cache', 'artisan:down');
after('deploy:symlink', 'artisan:up');
after('deploy:symlink', function(){
    writeln("<info>Restart worker ...</info>");
    run(which('docker') . ' restart {{project_prefix}}worker');
});
