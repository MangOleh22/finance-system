<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Models\Debt;
use App\Models\BankAccount;
use App\Models\Feedback;
use App\Policies\TransactionPolicy;
use App\Policies\DebtPolicy;
use App\Policies\BankAccountPolicy;
use App\Policies\FeedbackPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Transaction::class => TransactionPolicy::class,
        Debt::class => DebtPolicy::class,
        BankAccount::class => BankAccountPolicy::class,
        Feedback::class => FeedbackPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
