<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use App\Models\Application;
use App\Policies\ApplicationPolicy;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Event;

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
    */
   public function register(): void
   {
      // Backward compatibility for moved models (Queue deshielding)
      $models = [
         'User',
         'Application',
         'TeamSize',
         'FinanceInformation',
         'FinanceInformationByPeople',
         'Inquiry',
         'PropertySecurity',
         'Document',
         'Role',
         'Setting',
         'Status',
         'ReviewNote',
         'AssessorReviewNote',
         'UserLogs',
         'BusinessStructure',
         'BusinessType',
         'SystemEventLog',
         'CreditScoreEventLogs',
         'StatusHistory',
         'StatusHistoryes',
         'ApplicationDocuments',
         'ApplicationStatus',
         'ApprovedDocuments',
         'ApplicationApprovedDocuments',
         'AssessorReviewDocuments',
         'EmailSend',
         'EmailSendAttachment',
         'EmailTemplate',
         'OtpVerification',
         'ReviewDocument',
         'TokenIdentifiers',
      ];

      foreach ($models as $model) {
         if (!class_exists('App\\' . $model)) {
            class_alias('App\\Models\\' . $model, 'App\\' . $model);
         }
      }
   }

   /**
    * Bootstrap any application services.
    */
   public function boot(): void
   {
      // Register Policies
      foreach ($this->policies as $model => $policy) {
         Gate::policy($model, $policy);
      }

      // Event Listeners
      Event::listen(
         Registered::class,
         SendEmailVerificationNotification::class
      );

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

      Gate::define('isLoanApplicant', function ($user) {
         return $user->roles()->first()->slug == 'loan-applicant';
      });

      Gate::define('update-application', [ApplicationPolicy::class, 'update']);
      Gate::define('delete-application', [ApplicationPolicy::class, 'delete']);

      /**
      End Gates
      *************/

      Schema::defaultStringLength(191);
   }
}
