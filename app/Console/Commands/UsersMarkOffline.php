<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Profile;

class UsersMarkOffline extends Command
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
        $threshold = now()->subMinutes(2);
        // $threshold = now()->subSeconds(5);

        $affected = Profile::where('status', [
                Profile::STATUS_ONLINE,
                Profile::STATUS_BUSY, // 🔑 catch busy too
            ])
            ->where('last_seen_at', '<', $threshold)
            ->update([
                'status' => Profile::STATUS_OFFLINE,
                'engagement' => null, // clear busy state if dropped
                'updated_at' => now(),
            ]);

        $this->info("✅ Marked {$affected} users offline.");
        return Command::SUCCESS;
    }
}
