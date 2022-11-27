<?php

namespace Classiebit\Eventmie\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageServiceProviderLaravel5;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Classiebit\Eventmie\Traits\Seedable;
use Classiebit\Eventmie\EventmieServiceProvider;
use Facades\Classiebit\Eventmie\Eventmie;

use Illuminate\Support\Facades\File;  

class UpdateassetsCommand extends Command
{
 
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'azooma:updateassets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Azooma  Updater';

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production', null],
        ];
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }

        return 'composer';
    }

    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        $this->info('Initializing update process...');
     
        $this->update($filesystem);
    }

    private function update(Filesystem $filesystem)
    {
        // ---- Check if everything good so far ----
        $this->info('---- publish assets ----');
        $this->call('vendor:publish', ['--provider' => EventmieServiceProvider::class]);

        // Copy missing extras folder's files to storage
        $dir = str_replace('src/Commands', '', __DIR__);
        File::copyDirectory($dir.'publishable/dummy_content/extras', storage_path('app/public/extras'));
        File::copyDirectory($dir.'publishable/pwa', public_path('/'));

        // 3. Run cache clear commands
        $this->info('3. Clearing application cache');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('cache:clear');
        
        // Finish
        $version = Eventmie::getVersion();
        $this->info('Congrats! Azooma  updated successfully to version '.$version);
    }
    
}
