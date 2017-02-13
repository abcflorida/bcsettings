<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Abcflorida\Bcsettings\Repository;

use Platform\Settings\Repositories\SettingRepository;
use Illuminate\Container\Container;
use Cartalyst\Extensions\ExtensionBag;
use Cartalyst\Settings\SectionPrepare;
use Cartalyst\Settings\SectionValidate;
use Illuminate\Config\Repository as Config;
use Cartalyst\Settings\Repository as Settings;
use Abcflorida\Bcsettings\Controllers\Admin\BcsettingsController as Bcsettings;

class BcsettingsRepository extends SettingRepository
{
    
    /**
     * The Config instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;
    
    protected $request;
    
    /**
     * The Settings repository.
     *
     * @var \Cartalyst\Settings\Repository
     */
    protected $settings;
    

    /* Platform\Settings\Repository\SettingRepository@update() */
    public function __construct(
            Container $app,
            Config $config,
            Settings $settings,
            SectionPrepare $prepare,
            ExtensionBag $extensions,
            SectionValidate $validator
            ) {
        
        // for the prepare function 
        $this->request = request();
        
        $this->config = $config;
        $this->settings = $settings;
        
        $this->siteDomain = Bcsettings::getSiteDomain();
        
        //dd( session()->get('admin.current_site'));
        
        parent::__construct(
            $app,
            $config,
            $settings,
            $prepare,
            $extensions,
            $validator
                ); 
        
        
        
    }
    
    public function update($id, $data)
    {

        //dd( $this->siteDomain );
        $config = $this->config;

        foreach ($this->findSectionById($id)->all() as $fieldset) {
            
            //dd( $fieldset );
            foreach ($fieldset->all() as $field) {
                
                //dd ( $this->siteDomain . '.' . $field->config );

                $config->persist( $this->siteDomain . '.' . $field->config, input($field->id) );
                
            }
        }

    }
    
    
    public function prepareSectionFieldsets($section)
    {
        return $this->prepare($section);
    }
    
    public function prepare($section)
    {
        $data = $section->all();
    
        foreach ($data as $fieldset) {
            foreach ($fieldset->all() as $field) {
                if ( ! $config = $this->siteDomain . '.' . $field->config) {
                    throw new InvalidArgumentException("Field [{$field->id}] from section [$section->id] is missing the \"config\" attribute!");
                }

                $field->value = $this->request->old($field->id, $this->config->get($config));
            }
        }

        return $data;
    }
    
}