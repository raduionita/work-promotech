<?php

namespace Promo\MainBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use EmagUI\ThemeBundle\Menu\BreadcrumbsFactoryInterface;
use EmagUI\ThemeBundle\Menu\DefaultMenuItem;
use EmagUI\ThemeBundle\Menu\MenuFactoryInterface;

class MenuService implements MenuFactoryInterface, BreadcrumbsFactoryInterface {

    /** @var \Symfony\Component\DependencyInjection\ContainerInterface $container */
    protected $container;
    /**
     * @var null
     */
    protected $currentRouteName = null;
    /**
     * @var array
     */
    protected $menuItems = array();
    /**
     * @var array
     */
    protected $breadcrumbsItems = array();

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getMenuItems()
    {
        //@todo: get menu items from memcache

        $router = $this->container->get('router');

        /**
         * Main layout category
         */
        $mainLayout = array(
            //new DefaultMenuItem('Page template', $router->generate('wba_boilerplate_page'), 'fa fa-thumb-tack'),
            //new DefaultMenuItem('NavBar', $router->generate('wba_nav_standard'), 'fa fa-thumb-tack'),
            new DefaultMenuItem('Sidebar', '#', 'fa fa-thumb-tack'),
            new DefaultMenuItem('Breadcrumbs', '#', 'fa fa-thumb-tack'),
            new DefaultMenuItem('Footer', '#', 'fa fa-thumb-tack')
        );

        /**
         * Wba general category
         */
        $wbaGeneral = array(
            //new DefaultMenuItem('Branding', $router->generate('wba_boilerplate_page'), 'fa fa-thumb-tack'),
            //new DefaultMenuItem('Typography', $router->generate('wba_nav_standard'), 'fa fa-thumb-tack'),
            //new DefaultMenuItem('Buttons', $router->generate('wba_buttons'), 'fa fa-thumb-tack'),
            //new DefaultMenuItem('Forms', $router->generate('wba_forms_page'), 'fa fa-thumb-tack'),
            new DefaultMenuItem('Widgets', '#', 'fa fa-thumb-tack'),
            //new DefaultMenuItem('Tables', $router->generate('wba_tables'), 'fa fa-thumb-tack'),
            //new DefaultMenuItem('Utilities', $router->generate('wba_utilities'), 'fa fa-thumb-tack')
        );

        /**
         * Wba plugins category
         */
        $wbaPlugins = array(
            new DefaultMenuItem('Forms', '#', 'fa fa-thumb-tack'),
            new DefaultMenuItem('Widgets', '#', 'fa fa-thumb-tack')
        );

        /**
         * Wba for testing category
         */
        $wbaForTesting = array(
            new DefaultMenuItem('1 For testing', '#', 'fa fa-thumb-tack'),
            new DefaultMenuItem('1 For testing', '#', 'fa fa-thumb-tack')
        );

        /**
         * Sidepanel testing category
         */
        $sidepanelTesting = array(
            new DefaultMenuItem('For testing', '#', 'fa fa-thumb-tack',$wbaForTesting),
            new DefaultMenuItem('For testing', '#', 'fa fa-thumb-tack',$wbaForTesting)
        );

        /**
         * Useful page category
         */
        $usefulPage = array(
            new DefaultMenuItem('Login & Register', '#', 'fa fa-thumb-tack'),
            new DefaultMenuItem('F.A.Q', '#', 'fa fa-thumb-tack'),
            new DefaultMenuItem('Error page', '#', 'fa fa-thumb-tack'),
            new DefaultMenuItem('Email templates', '#', 'fa fa-thumb-tack'),
            new DefaultMenuItem('Sidepanel Testing', '#', 'fa fa-thumb-tack',$sidepanelTesting)
        );

        /**
         * The menu itself
         */
        $this->menuItems = array(
            //new DefaultMenuItem('Dashboard', $router->generate('wba_dashboard_page'), 'fa fa-dashboard'),
            new DefaultMenuItem('Main Layout', '#', 'fa fa-file-text',$mainLayout),
            new DefaultMenuItem('WBA General', '#', 'fa fa-bolt',$wbaGeneral),
            new DefaultMenuItem('WBA Plugins','#','fa fa-plug',$wbaPlugins),
            new DefaultMenuItem('Useful pages','#','fa fa-folder',$usefulPage),
            new DefaultMenuItem('Settings','#','fa fa-cog')
        );

        return $this->menuItems;
    }

    /**
     * Get an array of the tree path for the currently selected menu item.
     * Returns an empty array if no menu item is currently selected.
     *
     * @return array
     */
    public function getBreadcrumbsItems()
    {
        return null;
    }
}