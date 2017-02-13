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

namespace Abcflorida\Bcsettings\Controllers\Admin;

use Platform\Settings\Controllers\Admin\SettingsController;
use Platform\Settings\Repositories\SettingRepositoryInterface;
use Cartalyst\Themes\Laravel\Facades\Asset;

class BcsettingsController extends SettingsController
{
    /**
     * The Settings repository.
     *
     * @var \Platform\Settings\Repositories\SettingRepositoryInterface
     */
    protected $settings;

    /**
     * Constructor.
     *
     * @param  \Platform\Settings\Repositories\SettingRepositoryInterface  $settings
     * @return void
     */
    public function __construct( SettingRepositoryInterface $settings )
    {
        parent::__construct( $settings );

        $this->settings = $settings;
        
    }
    
    public function edit($section)
    {
        // Get the current section
        if (! $section = $this->settings->findSectionById($section)) {
            return redirect()->route('admin.settings');
        }
        
        // Get the all the available sections
        $sections = $this->settings->findAllSections();
        
 
        // Get all the fieldsets for the current section
        $fieldsets = $this->settings->prepareSectionFieldsets($section);

        Asset::queue('script', 'abcflorida/bcsettings::js/script.js', array('bootstrap', 'jquery'));
        
        return view('abcflorida/bcsettings::index', compact('sections', 'section', 'fieldsets'));
    }
    
    public function index() {
        
        $section = $this->settings->getFirstSection();

        return redirect()->route('admin.setting', $section->id);
        
    }
    
    public static function getSessionDomain () {
        
        if ( session()->get('admin.current_site') ) {
            
           return session()->get('admin.current_site');
            
        }
        else {
          
          $thisDomain = request()->server( 'HTTP_HOST' ); 
          
          session()->set('siteDomain',$thisDomain);
                    
          return $thisDomain;
            
        }
    }
    
    public static function getSiteDomain () {
        
        
       return self::getSessionDomain();
        
    }
    

    /**
     * Save the given section's values.
     *
     * @param  string  $section
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($section)
    {
        
        $data = request()->except('_token');
        
        $messages = $this->settings->validForUpdate($section, $data);
        
        if ($messages->isEmpty()) { 

            $this->settings->update($section, $data);

            $this->alerts->success(trans('platform/settings::message.success.update'));

            return redirect()->back();
        }

        $this->alerts->error($messages, 'form');

        return redirect()->back()->withInput();
    }
}
