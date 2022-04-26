<?php

namespace App\Console\Commands;

use App\Models\BookLending;
use App\Notifications\DeadlineReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class SendReminderEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deadline:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends reminder emails to users that should return books in five days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $no_of_days_before_deadline = 5;
        $to_date = now()->addDays($no_of_days_before_deadline);
        $select_lendings = BookLending::whereRaw("DATEDIFF(deadline, '$to_date') = 0")
                                        ->get();

        $grouped = $select_lendings->groupBy('user.id');

        $lendings = [];

        foreach($grouped as $key => $borrowed_books) {
            $user = User::find($key);
            $user_name = $user->name;
            foreach ($borrowed_books as $book) {
                $lendings[] = $book;
            }
//            Notification::send($user, new DeadlineReminderNotification($lendings, $no_of_days_before_deadline, $user_name));

            $lendings = [];
        }
        $this->info('Success');
    }
}
