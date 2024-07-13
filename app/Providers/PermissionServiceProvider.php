<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        $permissions = ItemPermission::group('System')
            ->addPermission('platform.systems.contacts', 'Contacts');

//        $permissions = ItemPermission::group('modules')
//            ->addPermission('contacts.all', 'Access to all contacts');

        $dashboard->registerPermissions($permissions);
    }
}
