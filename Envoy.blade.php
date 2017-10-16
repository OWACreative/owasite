@servers(['localhost' => '127.0.0.1', 'production' => 'montag@montag.webfactional.com'])


@story('deploy')
    backup
    sync_production
    clear_cache
@endstory

@task('sync_production', ['on' => 'localhost'])
    echo "sync-production"
    cd Projects/owa/site
    rsync -avr --log-file=rsync.log --exclude-from rsync-exclude.txt  ./ montag@montag.webfactional.com:/home/montag/webapps/owa
@endtask

@task('backup', ['on' => 'production'])
    cd webapps/owa
    php70 bin/grav backup
    mv backup/* ../../_backups/
@endtask

@task('clear_cache', ['on' => 'production'])
    cd webapps/owa
    php70 bin/grav clear-cache
@endtask