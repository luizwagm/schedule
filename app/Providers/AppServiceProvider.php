<?php

namespace App\Providers;

use App\Services\FinancialDeposit\FinancialDepositService;
use App\Services\FinancialDeposit\FinancialDepositServiceInterface;
use App\Services\Others\AuthorizationTransactionService;
use App\Services\Others\AuthorizationTransactionServiceInterface;
use App\Services\Others\SendEmailService;
use App\Services\Others\SendEmailServiceInterface;
use App\Services\Transaction\TransactionService;
use App\Services\Transaction\TransactionServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(FinancialDepositServiceInterface::class, FinancialDepositService::class);
        $this->app->bind(AuthorizationTransactionServiceInterface::class, AuthorizationTransactionService::class);
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(SendEmailServiceInterface::class, SendEmailService::class);
    }
}
