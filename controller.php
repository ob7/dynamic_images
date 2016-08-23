<?php
namespace Concrete\Package\DynamicImages;

use Package;
use BlockType;

class Controller extends Package
{
    protected $pkgHandle = 'dynamic_images';
    protected $appVersionRequired = '5.7.5.1';
    protected $pkgVersion = '0.9.9.1';

    public function getPackageName()
    {
        return t('Dynamic Images');
    }

    public function getPackageDescription()
    {
        return t('Creates blocks with multiple images and options');
    }

    public function install()
    {
        $pkg = parent::install();
        $bt = BlockType::getByHandle('dynamic_images');
        if (!is_object($bt)) {
            $bt = BlockType::installBlockType('dynamic_images', $pkg);
        }
    }

    public function on_start()
    {
        $al = \Concrete\Core\Asset\AssetList::getInstance();
        $al->register('javascript', 'dynamic_images_form_js', 'blocks/dynamic_images/form.js', array(), 'dynamic_images');
        $al->register('css', 'dynamic_images_form_css', 'blocks/dynamic_images/form.css', array(), 'dynamic_images');
        $al->registerGroup('dynamic_images_form', array(
            array('javascript', 'dynamic_images_form_js'),
            array('css', 'dynamic_images_form_css')
        ));
    }
}
