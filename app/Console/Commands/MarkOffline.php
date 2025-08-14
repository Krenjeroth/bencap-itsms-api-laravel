<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Profile;

class MarkOffline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:mark-offline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark users as offline if inactive for more than 2 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timeout = Carbon::now()->subMinutes(2);

        Profile::where('status', Profile::STATUS_ONLINE)
        ->where('last_seen_at', '<', $timeout)
        ->update(['status' => Profile::STATUS_OFFLINE]);

        $this->info('Inactive users marked offline.');
    }
}
