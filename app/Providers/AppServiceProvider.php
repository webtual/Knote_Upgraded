<?php

namespace App\Providers;




use App\Application;
use App\Policies\ApplicationPolicy;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; //NEW: Import Schema
use Illuminate\Support\Facades\Gate; //New: RoleGate
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;



class AppServiceProvider extends ServiceProvider
{

   /**
    * The policy mappings for the application.
    *
    * @var array
    */
   protected $policies = [
      Application::class => ApplicationPolicy::class,
   ];


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

      /**
      Gates
      **********/
      Gate::define('isAdminUser', function ($user) {
         return $user->roles()->first()->type == 1;
      });

      Gate::define('isUser', function ($user) {
         return $user->roles()->first()->type == 0;
      });


      Gate::define('isAdmin', function ($user) {
         return $user->roles()->first()->slug == 'admin';
      });

      Gate::define('isBroker', function ($user) {
         return $user->roles()->first()->slug == 'broker';
      });

      Gate::define('isAssistant', function ($user) {
         return $user->roles()->first()->slug == 'assistant';
      });

      Gate::define('isLoanApplicant', function ($user) {
         return $user->roles()->first()->slug == 'loan-applicant';
      });

      Gate::define('isEntrepreneur', function ($user) {
         return $user->roles()->first()->slug == 'entrepreneur';
      });

      Gate::define('isInvestor', function ($user) {
         return $user->roles()->first()->slug == 'investor';
      });




      Gate::define('update-application', 'App\Policies\ApplicationPolicy@update');
      Gate::define('delete-application', 'App\Policies\ApplicationPolicy@delete');

      /**
      End Gates
      *************/


      //
      Schema::defaultStringLength(191); //NEW: Increase StringLength
   }
}
