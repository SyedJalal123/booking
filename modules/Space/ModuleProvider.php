<?php
namespace Modules\Space;
use Modules\Core\Helpers\SitemapHelper;
use Modules\ModuleServiceProvider;
use Modules\Space\Models\Bus;

class ModuleProvider extends ModuleServiceProvider
{

    // public function boot(SitemapHelper $sitemapHelper){

    //     $this->loadMigrationsFrom(__DIR__ . '/Migrations');

    //     if(is_installed() and Space::isEnable()){
    //         $sitemapHelper->add("space",[app()->make(Space::class),'getForSitemap']);
    //     }
    // }

    //Edited
    public function boot(){
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getAdminMenu()
    {
        if(!Bus::isEnable()) return [];
        return [
            'space'=>[
                "position"=>41,
                'url'        => route('space.admin.index'),
                'title'      => __('Bus'),
                'icon'       => 'ion-md-bus',
                'permission' => 'space_view',
                'children'   => [
                    'add'=>[
                        'url'        => route('space.admin.index'),
                        'title'      => __('All Buses'),
                        'permission' => 'space_view',
                    ],
                    'airline'=>[
                        'url'        => route('space.admin.bus_companies.index'),
                        'title'      => __('Bus Service'),
                    ],
                    'airport'=>[
                        'url'        => route('space.admin.bus_stops.index'),
                        'title'      => __('Bus Stop'),
                    ],
                    'seat_type'=>[
                        'url'        => route('space.admin.seat_type.index'),
                        'title'      => __('Bus Seat Type'),
                    ],
                    'create'=>[
                        'url'        => route('space.admin.create'),
                        'title'      => __('Add new Bus'),
                        'permission' => 'space_create',
                    ],
                    'attribute'=>[
                        'url'        => route('space.admin.attribute.index'),
                        'title'      => __('Attributes'),
                        'permission' => 'space_manage_attributes',
                    ],
                ]
            ]
        ];
    }

    public static function getBookableServices()
    {
        if(!Bus::isEnable()) return [];
        return [
            'space'=>Bus::class
        ];
    }

    public static function getMenuBuilderTypes()
    {
        // if(!Bus::isEnable()) 
        return [];
        // return [
        //     'space'=>[
        //         'class' => Space::class,
        //         'name'  => __("Spaces"),
        //         'items' => Space::searchForMenu(),
        //         'position'=>41
        //     ]
        // ];
    }

    public static function getUserMenu()
    {
        $res = [];
        if (Bus::isEnable()) {
            $res['space'] = [
                'url'        => route('space.vendor.index'),
                'title'      => __("Manage Bus"),
                'icon'       => Bus::getServiceIconFeatured(),
                'position'   => 32,
                'permission' => 'space_view',
                'children'   => [
                    [
                        'url'   => route('space.vendor.index'),
                        'title' => __("All Buses"),
                    ],
                    [
                        'url'        => route('space.vendor.create'),
                        'title'      => __("Add Bus"),
                        'permission' => 'space_create',
                    ],
                    // [
                    //     'url'        => route('space.vendor.availability.index'),
                    //     'title'      => __("Availability"),
                    //     'permission' => 'space_create',
                    // ],
                    // [
                    //     'url'   => route('space.vendor.recovery'),
                    //     'title'      => __("Recovery"),
                    //     'permission' => 'space_create',
                    // ],
                ]
            ];
        }
        return $res;
    }

    public static function getTemplateBlocks(){
        if(!Bus::isEnable()) return [];
        return [
            'form_search_space'=>"\\Modules\\Space\\Blocks\\FormSearchSpace",
            // 'list_space'=>"\\Modules\\Space\\Blocks\\ListSpace",
            // 'space_term_featured_box'=>"\\Modules\\Space\\Blocks\\SpaceTermFeaturedBox",
        ];
    }
}
