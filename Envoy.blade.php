@servers(['web' => 'beto@financiero.com.br'])

@task('list', ['on' => 'web'])
    ls -l
@endtask

@setup
    $repository = 'git@gitlab.com:vivetix/vivetix-web.git';
    $releases_dir = [
      'master' => '/var/www/b3',
    ];
    $app_dir = '/var/www/';
    $dir = $releases_dir[$branch ?? 'master'];
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $sudoPassword = env('SUDO_PASSWORD');
@endsetup

@task('update')
    echo "Moving for deploying dir {{$dir}}"
    cd {{$dir}}
    git reset --hard
    echo  'Dowloading'
    git pull
    php artisan view:clear
    php artisan clear-compiled
    php artisan cache:clear file
@endtask

@task('db_copy')
    echo 'Coping Database'
    mysqldump -u vivetix --routines --triggers -pc7gz2vyqur2cs3q4 -h mysqlsmall-do-user-8077173-0.b.db.ondigitalocean.com -P 25060 --ignore-table=master.logs --ignore-table=master.failed_jobs --set-gtid-purged=OFF master | sed -e 's/,NO_AUTO_CREATE_USER//g' | sed -e 's/DEFINER=.[^@"`]*.@.%.//g' | sed -e 's/`vivetix`\.//g' | perl -0777 -i -pe 's/SET \@\@GLOBAL.GTID_PURGED=[^;]+;//g' | sed -e '1s/^/set sql_require_primary_key=off;\n/' | sed -e 's/SET @@SESSION.SQL_LOG_BIN= 0;//g' | sed -e 's/SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;//g'| mysql -u vivetix -pc7gz2vyqur2cs3q4 -h mysqlsmall-do-user-8077173-0.b.db.ondigitalocean.com -P 25060 develop
@endtask

@task('migration')
    echo 'Moving for deploying dir'
    cd {{$dir}}
    php artisan migrate
@endtask

@task('composer')
    echo "Executing composer"
    echo {{$dir}}
    cd {{ $dir  }}
    rm -rf {{$dir}}/vendor
    echo "vendor dir removed"
    composer install
    echo "finish!"
@endtask

@task('npm')
    @php
    $task = $branch == 'dev' ? 'dev' : 'production' ;
    @endphp
    echo "Executing NPM"
    rm -rf {{$dir}}/node_modules
    echo "modules dir removed"
    cd {{ $dir  }}
    echo "installing modules"
    npm install
    echo "compiling"
    npm run {{$task}}
    echo "end";
@endtask

@task('update_symlinks')
    echo "Linking storage directory"
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage

    echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env

    echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask

@task('cache')
    echo "Moving for deploying dir {{$dir}}"
    cd {{$dir}}
    php artisan cache:clear file
    php artisan cache:clear redis
    php artisan view:clear
@endtask

@story('deploy')
    update
    @if($composer)
        composer
    @endif
    npm
    queue
@endstory

@task('queue')
    echo 'Moving for deploying dir'
    cd {{$dir}}
    php artisan view:clear
    php artisan queue:restart
    php artisan horizon:terminate
    echo "{{$sudoPassword}}" | sudo -S supervisorctl restart horizon:*
@endtask

@task('queue-retry')
    echo 'Moving for deploying dir'
    cd {{$dir}}
    php artisan queue:retry all
@endtask