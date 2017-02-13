<?php

use Illuminate\Foundation\Application;
use Cartalyst\Extensions\ExtensionInterface;
use Cartalyst\Settings\Repository as Settings;
use Cartalyst\Permissions\Container as Permissions;

return [

	/*
	|--------------------------------------------------------------------------
	| Name
	|--------------------------------------------------------------------------
	|
	| This is your extension name and it is only required for
	| presentational purposes.
	|
	*/

	'name' => 'Bcsettings',

	/*
	|--------------------------------------------------------------------------
	| Slug
	|--------------------------------------------------------------------------
	|
	| This is your extension unique identifier and should not be changed as
	| it will be recognized as a new extension.
	|
	| Ideally, this should match the folder structure within the extensions
	| folder, but this is completely optional.
	|
	*/

	'slug' => 'abcflorida/bcsettings',

	/*
	|--------------------------------------------------------------------------
	| Author
	|--------------------------------------------------------------------------
	|
	| Because everybody deserves credit for their work, right?
	|
	*/

	'author' => 'Brian Clinton',

	/*
	|--------------------------------------------------------------------------
	| Description
	|--------------------------------------------------------------------------
	|
	| One or two sentences describing the extension for users to view when
	| they are installing the extension.
	|
	*/

	'description' => 'extend core settings',

	/*
	|--------------------------------------------------------------------------
	| Version
	|--------------------------------------------------------------------------
	|
	| Version should be a string that can be used with version_compare().
	| This is how the extensions versions are compared.
	|
	*/

	'version' => '0.1.0',

	/*
	|--------------------------------------------------------------------------
	| Requirements
	|--------------------------------------------------------------------------
	|
	| List here all the extensions that this extension requires to work.
	| This is used in conjunction with composer, so you should put the
	| same extension dependencies on your main composer.json require
	| key, so that they get resolved using composer, however you
	| can use without composer, at which point you'll have to
	| ensure that the required extensions are available.
	|
	*/

	'require' => [
		'platform/settings',
	],

	/*
	|--------------------------------------------------------------------------
	| Autoload Logic
	|--------------------------------------------------------------------------
	|
	| You can define here your extension autoloading logic, it may either
	| be 'composer', 'platform' or a 'Closure'.
	|
	| If composer is defined, your composer.json file specifies the autoloading
	| logic.
	|
	| If platform is defined, your extension receives convetion autoloading
	| based on the Platform standards.
	|
	| If a Closure is defined, it should take two parameters as defined
	| bellow:
	|
	|	object \Composer\Autoload\ClassLoader      $loader
	|	object \Illuminate\Foundation\Application  $app
	|
	| Supported: "composer", "platform", "Closure"
	|
	*/

	'autoload' => 'composer',

	/*
	|--------------------------------------------------------------------------
	| Service Providers
	|--------------------------------------------------------------------------
	|
	| Define your extension service providers here. They will be dynamically
	| registered without having to include them in app/config/app.php.
	|
	*/

	'providers' => [
            'Abcflorida\Bcsettings\Providers\BcsettingsServiceProvider',
	],

	/*
	|--------------------------------------------------------------------------
	| Routes
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is started. You can register
	| any custom routing logic here.
	|
	| The closure parameters are:
	|
	|	object \Cartalyst\Extensions\ExtensionInterface  $extension
	|	object \Illuminate\Foundation\Application        $app
	|
	*/

	'routes' => function (ExtensionInterface $extension, Application $app) {
            if (! $app->routesAreCached()) {
                Route::group([
                    'prefix'    => admin_uri().'/settings',
                    'namespace' => 'Abcflorida\Bcsettings\Controllers\Admin'
                ], function () {
                    Route::get('/', ['as' => 'admin.settings', 'uses' => 'BcsettingsController@index' ]);

                    Route::get('{namespace}', ['as' => 'admin.setting', 'uses' => 'BcsettingsController@edit' ])->where('namespace', '.*');
                    Route::post('{namespace}', ['as' => 'admin.setting', 'uses' => 'BcsettingsController@update' ])->where('namespace', '.*');
                });
            }
        },

	/*
	|--------------------------------------------------------------------------
	| Database Seeds
	|--------------------------------------------------------------------------
	|
	| Platform provides a very simple way to seed your database with test
	| data using seed classes. All seed classes should be stored on the
	| `database/seeds` directory within your extension folder.
	|
	| The order you register your seed classes on the array below
	| matters, as they will be ran in the exact same order.
	|
	| The seeds array should follow the following structure:
	|
	|	Vendor\Namespace\Database\Seeds\FooSeeder
	|	Vendor\Namespace\Database\Seeds\BarSeeder
	|
	*/

	'seeds' => [

	],

	/*
	|--------------------------------------------------------------------------
	| Permissions
	|--------------------------------------------------------------------------
	|
	| Register here all the permissions that this extension has. These will
	| be shown in the user management area to build a graphical interface
	| where permissions can be selected to allow or deny user access.
	|
	| For detailed instructions on how to register the permissions, please
	| refer to the following url https://cartalyst.com/manual/permissions
	|
	*/

	'permissions' => function(Permissions $permissions)
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Widgets
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is started. You can register
	| all your custom widgets here. Of course, Platform will guess the
	| widget class for you, this is just for custom widgets or if you
	| do not wish to make a new class for a very small widget.
	|
	*/

	'widgets' => function()
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Settings
	|--------------------------------------------------------------------------
	|
	| Register any settings for your extension. You can also configure
	| the namespace and group that a setting belongs to.
	|
	*/

	'settings' => function (Settings $settings, Application $app) {
            
        //dd( session()->get('admin.current_site'));
            
        $settings->find('platform')->section('core', function ($s) {
            $s->name = trans('abcflorida/bcsettings::settings.title');

            $s->fieldset('admin', function ($f) {
                $f->name = trans('abcflorida/bcsettings::settings.admin.title');

                $f->field('help', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.admin.field.help');
                    $f->type   = 'radio';
                    $f->config = 'platform.app.help';

                    $f->option('no', function ($o) {
                        $o->value = false;
                        $o->label = trans('common.no');
                    });

                    $f->option('yes', function ($o) {
                        $o->value = true;
                        $o->label = trans('common.yes');
                    });
                });
            });

            $s->fieldset('app', function ($f) {
                $f->name = trans('abcflorida/bcsettings::settings.application.title');

                $f->field('title', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.application.field.title');
                    $f->rules  = 'required';
                    $f->config = 'platform.app.title';
                });

                $f->field('tagline', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.application.field.tagline');
                    $f->type   = 'textarea';
                    $f->config = 'platform.app.tagline';
                });

                $f->field('copyright', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.application.field.copyright');
                    $f->config = 'platform.app.copyright';
                });
            });

            $s->fieldset('email', function ($f) {
                $f->name = trans('abcflorida/bcsettings::settings.email.title');

                $f->field('driver', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.email.field.driver');
                    $f->config = 'mail.driver';

                    $f->option('mail', function ($o) {
                        $o->value = 'mail';
                        $o->label = 'PHP mail()';
                    });

                    $f->option('smtp', function ($o) {
                        $o->value = 'smtp';
                        $o->label = 'SMTP';
                    });

                    $f->option('sendmail', function ($o) {
                        $o->value = 'sendmail';
                        $o->label = 'Sendmail';
                    });

                    $f->option('mailgun', function ($o) {
                        $o->value = 'mailgun';
                        $o->label = 'Mailgun';
                    });

                    $f->option('mandrill', function ($o) {
                        $o->value = 'mandrill';
                        $o->label = 'Mandrill';
                    });

                    $f->option('log', function ($o) {
                        $o->value = 'log';
                        $o->label = 'Log';
                    });
                });

                $f->field('host', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.email.field.host');
                    $f->config = 'mail.host';
                });

                $f->field('port', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.email.field.port');
                    $f->config = 'mail.port';
                });

                $f->field('encryption', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.email.field.encryption');
                    $f->config = 'mail.encryption';

                    $f->option('disabled', function ($o) {
                        $o->value = '';
                        $o->label = trans('common.disabled');
                    });

                    $f->option('tls', function ($o) {
                        $o->value = 'tls';
                        $o->label = 'TLS';
                    });

                    $f->option('ssl', function ($o) {
                        $o->value = 'ssl';
                        $o->label = 'SSL';
                    });
                });

                $f->field('from_address', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.email.field.from_address');
                    $f->config = 'mail.from.address';
                });

                $f->field('from_name', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.email.field.from_name');
                    $f->config = 'mail.from.name';
                });

                $f->field('username', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.email.field.username');
                    $f->config = 'mail.username';
                });

                $f->field('password', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.email.field.password');
                    $f->config = 'mail.password';
                });

                $f->field('sendmail', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.email.field.sendmail_path');
                    $f->config = 'mail.sendmail';
                });

                $f->field('pretend', function ($f) {
                    $f->name   = trans('abcflorida/bcsettings::settings.email.field.pretend');
                    $f->config = 'mail.pretend';

                    $f->option('enabled', function ($o) {
                        $o->value = true;
                        $o->label = trans('common.enabled');
                    });

                    $f->option('disabled', function ($o) {
                        $o->value = false;
                        $o->label = trans('common.disabled');
                    });
                });
            });
        });
    },

	/*
	|--------------------------------------------------------------------------
	| Menus
	|--------------------------------------------------------------------------
	|
	| You may specify the default various menu hierarchy for your extension.
	| You can provide a recursive array of menu children and their children.
	| These will be created upon installation, synchronized upon upgrading
	| and removed upon uninstallation.
	|
	| Menu children are automatically put at the end of the menu for extensions
	| installed through the Operations extension.
	|
	| The default order (for extensions installed initially) can be
	| found by editing app/config/platform.php.
	|
	*/

	'menus' => [

		'admin' => [

			[
				'slug'  => 'admin-abcflorida-bcsettings',
				'name'  => 'Bcsettings',
				'class' => 'fa fa-circle-o',
				'uri'   => 'bcsettings',
				'regex' => '/:admin\/bcsettings/i',
			],

		],

		'main' => [

		],

	],

];
