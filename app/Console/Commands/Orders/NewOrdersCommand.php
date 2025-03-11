<?php

namespace App\Console\Commands\Orders;

use App\Enums\RoleEnum;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NewOrdersNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class NewOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:new-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email with the count of latest orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where(
            'created_at',
            '<',
            now()->subDays(30)->toDateTimeString()
        )->get();


        Notification::send(
            User::role(RoleEnum::ADMIN->value)->get(),
            app(
                NewOrdersNotification::class,
                ['orders' => $orders]
            )
        );
    }
}
