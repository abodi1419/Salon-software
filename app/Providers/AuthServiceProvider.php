<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('purchase_invoices',function ($user){
            if($user->employee->jobTitle['view_purchase_invoices']==1){
                return true;
            }else
                return false;
        });
        Gate::define('purchase_invoices_edit',function ($user){
            if($user->employee->jobTitle['edit_purchase_invoices']==1){
                return true;
            }else
                return false;
        });
        Gate::define('purchase_invoices_delete',function ($user){
            if($user->employee->jobTitle['delete_purchase_invoices']==1){
                return true;
            }else
                return false;
        });
        Gate::define('purchase_invoices_create',function ($user){
            if($user->employee->jobTitle['create_purchase_invoices']==1){
                return true;
            }else
                return false;
        });

        Gate::define('sale_invoices',function ($user){
            if($user->employee->jobTitle['view_sale_invoices']==1){
                return true;
            }else
                return false;
        });

        Gate::define('sale_invoices_edit',function ($jobTitle){
            if($jobTitle['edit_sale_invoices']==1){
                return true;
            }else
                return false;
        });
        Gate::define('sale_invoices_delete',function ($jobTitle){
            if($jobTitle['delete_sale_invoices']==1){
                return true;
            }else
                return false;
        });
        Gate::define('sale_invoices_create',function ($jobTitle){
            if($jobTitle['create_sale_invoices']==1){
                return true;
            }else
                return false;
        });
    }
}
