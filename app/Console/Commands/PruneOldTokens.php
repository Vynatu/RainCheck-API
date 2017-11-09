<?php

namespace RainCheck\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Laravel\Passport\Token;

class PruneOldTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oauth:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prunes old tokens that are past their expiration date';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = Token::where('expires_at', '<=', Carbon::now())->delete();

        if ($count == 0) {
            $this->output->note('No tokens to delete');
        } else {
            $this->output->success("Deleted {$count} stale tokens");
        }
    }
}
