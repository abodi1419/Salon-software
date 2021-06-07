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

        Gate::define('sale_invoices_edit',function ($user){
            if($user->employee->jobTitle['edit_sale_invoices']==1){
                return true;
            }else
                return false;
        });
        Gate::define('sale_invoices_delete',function ($user){
            if($user->employee->jobTitle['delete_sale_invoices']==1){
                return true;
            }else
                return false;
        });
        Gate::define('sale_invoices_create',function ($user){
            if($user->employee->jobTitle['create_sale_invoices']==1){
                return true;
            }else
                return false;
        });


        Gate::define('product',function ($user){
            if($user->employee->jobTitle['view_product']==1){
                return true;
            }else
                return false;
        });
        Gate::define('product_edit',function ($user){
            if($user->employee->jobTitle['edit_product']==1){
                return true;
            }else
                return false;
        });
        Gate::define('product_delete',function ($user){
            if($user->employee->jobTitle['delete_product']==1){
                return true;
            }else
                return false;
        });
        Gate::define('product_create',function ($user){
            if($user->employee->jobTitle['create_product']==1){
                return true;
            }else
                return false;
        });

        Gate::define('service',function ($user){
            if($user->employee->jobTitle['view_service']==1){
                return true;
            }else
                return false;
        });
        Gate::define('service_edit',function ($user){
            if($user->employee->jobTitle['edit_service']==1){
                return true;
            }else
                return false;
        });
        Gate::define('service_delete',function ($user){
            if($user->employee->jobTitle['delete_service']==1){
                return true;
            }else
                return false;
        });
        Gate::define('service_create',function ($user){
            if($user->employee->jobTitle['create_service']==1){
                return true;
            }else
                return false;
        });

        Gate::define('employee',function ($user){
            if($user->employee->jobTitle['view_employee']==1){
                return true;
            }else
                return false;
        });
        Gate::define('employee_edit',function ($user){
            if($user->employee->jobTitle['edit_employee']==1){
                return true;
            }else
                return false;
        });
        Gate::define('employee_delete',function ($user){
            if($user->employee->jobTitle['delete_employee']==1){
                return true;
            }else
                return false;
        });
        Gate::define('employee_create',function ($user){
            if($user->employee->jobTitle['create_employee']==1){
                return true;
            }else
                return false;
        });
    }
}
