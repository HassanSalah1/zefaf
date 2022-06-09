<?php

namespace App\Providers;

use App\Entities\UserRoles;
use App\Models\Permission\Permission;
use App\Models\Permission\PermissionGroup;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        date_default_timezone_set('Africa/Cairo');

        view()->composer('*' , function ($view) {
            $user = auth()->user();
            if ($user && ($user->role == UserRoles::EMPLOYEE)) {
                if($user->role == UserRoles::EMPLOYEE){
                    $group = PermissionGroup::where(['user_id' => $user->id])->first();
                    if($group){
                        $permissions = Permission::where(['id' => $group->permission_id])->first();
                        $view->with('permissions', $permissions);
                    }
                }
            }
        });

        /*ADD THIS LINES*/
        $this->commands([
            InstallCommand::class,
            ClientCommand::class,
            KeysCommand::class,
        ]);
    }
}
