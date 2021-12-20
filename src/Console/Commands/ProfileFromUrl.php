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
    protected $signature = 'pconnector:generate {url : URL api} {profile? : Name of profile}';

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
        if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) === false) {
            return $this->error('Not a valid URL!');
        }

        // Publish the config
        \Artisan::call('vendor:publish', ['--provider' => 'MedianetDev\PConnector\PConnectorServiceProvider', '--tag' => 'config']);

        // Extract profile from url
        $gateway = parse_url($url);

        $profiles = config('p-connector.profiles');
        $profile_name = $this->argument('profile') ?? 'profile';

        // Check existing profile name
        if (isset($profiles[$profile_name])) {
            return $this->error('Please check your profile name');
        }

        // Merge profiles
        $profiles = $profiles +
        [
            $profile_name => [
                'protocol' => $gateway['scheme'] ?? 'http',
                'host' => $gateway['host'] ?? 'foo.bar',
                'port' => $gateway['port'] ?? 80,
                'prefix' => $gateway['path'] ?? '/',
            ],
        ];

        // Add profile into config
        $path = config_path('p-connector.php');
        config(['p-connector.profiles' => $profiles]);

        // Set new Config
        if (file_exists($path)) {
            file_put_contents($path, "<?php \n return \n {$this->var_export_format(config('p-connector'))};");
        }

        $this->info('Profile added successfully.');
    }

    private function var_export_format($var, $indent="")
    {
        switch (gettype($var)) {
            case 'string':
                return '"'.addcslashes($var, "\\\$\"\r\n\t\v\f").'"';
            case 'array':
                $indexed = array_keys($var) === range(0, count($var) - 1);
                $r = [];
                foreach ($var as $key => $value) {
                    $r[] = "$indent    "
                        .($indexed ? '' : $this->var_export_format($key).' => ')
                        .$this->var_export_format($value, "$indent    ");
                }
                return "[\n".implode(",\n", $r)."\n".$indent.']';
            case 'boolean':
                return $var ? 'TRUE' : 'FALSE';
            case 'integer':  case 'double': return $var;
            default:
                return var_export($var, true);
        }
    }
}
