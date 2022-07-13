<?php

namespace App\Console\Commands;

use App\Models\Promoter;
use App\Models\User;
use Illuminate\Console\Command;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

Use Exception;

class BatchImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotori:import {filename}';

    protected $mimetype = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Batch import promotori da file Excel';
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
        $this->output->title('Starting import');
        $filename =  $this->argument('filename');
        $this->output->writeln('Input filename: ' . $filename );

        if (!File::exists( $filename )) {
            $this->output->error('File not found');
            return;
        };

        $mimetype = File::mimeType($filename);
        if ($mimetype !== $this->mimetype) {
            $this->output->error('File type not allowed');
            return;
        };

        Promoter::truncate();
        User::where('role', 'promoter')->delete();
        $error = (new UsersImport)->import($filename);

        DB::update('update users set email = lower(trim(email))', []);

        DB::update('update promoters set firstname = trim(firstname), lastname = trim(lastname), mobile = trim(mobile),
                role = trim(role), area = trim(area), company = trim(company), team = trim(team)', []);

        DB::update('update promoters set mobile = concat(left(mobile,3), \' \', mid(mobile,4)) where id > 0', []);

        DB::update('update promoters set phone1 = replace(phone1, \'.\', \'\'), phone2 = replace(phone2, \'.\', \'\'), phone3 = replace(phone3, \'.\', \'\')', []);


        if ($error) {
            $this->output->error('command completed with errors');
        } else
            $this->output->success('command completed');
    }
}
