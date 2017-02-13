<?php

/**
 * Part of the Platform Settings extension.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Platform Settings extension
 * @version    4.0.1
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Abcflorida\Bcsettings\Providers;

use Platform\Settings\Providers\SettingsServiceProvider;

class BcsettingsServiceProvider extends SettingsServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function boot()
    {
        
        $this->registerSettingBladeWidget();
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        
        $this->bindIf('platform.settings', 'Abcflorida\Bcsettings\Repository\BcsettingsRepository');
        
        $this->bindIf('abcflorida.settings', 'Abcflorida\Bcsettings\Repositories\BcsettingsRepository');

        $this->app->register('Abcflorida\Cacheconfig\ServiceProvider\CacheconfigServiceProvider');
        
    }

    /**
     * Register the Blade @setting extension.
     *
     * @return void
     */
    protected function registerSettingBladeWidget()
    {
        $this->app['blade.compiler']->directive('setting', function ($value) {
            return "<?php echo app('config')->get$value; ?>";
        });
    }
}
