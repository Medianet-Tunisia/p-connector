<?php

namespace MedianetDev\PConnector\Console\Commands;

use Illuminate\Console\Command;

class ProfileFromUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pconnector:generate {url : URL api} {name? : Name of profile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a PConnector profile';

    

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {

        $url = $this->argument('url');

        // Validate the Url
        if (filter_var($url, FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED) === FALSE) {
            return $this->error('Not a valid URL!');
        }

        // Publish the config
        \Artisan::call('vendor:publish', ['--provider' => 'MedianetDev\PConnector\PConnectorServiceProvider', '--tag' => 'config']);

        // Extract profile from url
        $profile = parse_url($url);

        $profiles = config('p-connector.profiles');
        $profiles = $profiles +
        [
            $this->argument('name') ?? 'profile' => [
                'protocol' => $profile['scheme'] ?? 'http',
                'host' => $profile['host'] ?? 'http',
                'port' => $profile['port'] ?? 80,
                'prefix' => $profile['path'] ?? '/',
            ],
        ];

        // Add profile into config
        $path = config_path('p-connector.php');
        if (file_exists($path)) {
            file_put_contents($path, 
                str_replace(
                    json_encode(config('p-connector.profiles')), json_encode($profiles), file_get_contents($path)
                )
            );
        }


        // // Another Method
        // $config = config('p-connector');
        // $config['profiles'] = $config['profiles'] +
        // [
        //     $this->argument('name') ?? 'profile' => [
        //         'protocol' => $profile['scheme'] ?? 'http',
        //         'host' => $profile['host'] ?? 'http',
        //         'port' => $profile['port'] ?? 80,
        //         'prefix' => $profile['path'] ?? '/',
        //     ],
        // ];

        // // Add profile into config
        // $path = config_path('p-connector.php');

        // $string = '<?php return' . var_export( $config, true );
        // file_put_contents($path, $string);
        

        $this->info('Profile added successfully.');
    }
    
}
