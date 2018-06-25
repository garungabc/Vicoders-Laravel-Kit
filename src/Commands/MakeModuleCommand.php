<?php

namespace Vicoders\LaravelKit\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Vicoders\LaravelKit\Support;

class MakeModuleCommand extends Command
{
    protected $root_dir = Support::ROOT_DIR;

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'make:module';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create a new module.';

    /**
     * Execute the command.
     *
     * @see fire()
     * @return void
     */
    public function handle()
    {
        $this->laravel->call([$this, 'fire'], func_get_args());
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        $name = snake_case($this->argument('name'));
        $type = snake_case($this->option('type'));
        if ($type == null) {
            throw new Exception("You have to provide option --type");
        } else {
            if ($type != 'api' && $type != 'basic') {
                throw new Exception("type must be basic or api");
            } else {
                $folder = "{$this->root_dir}/resources/{$name}/{$type}";
                if (!is_dir($folder)) {
                    throw new Exception("{$folder} not found", 1);
                }

                $array_folder = $this->getDirContents($folder);
                foreach ($array_folder as $value) {
                    $dest = str_replace("/vendor/vicodersvn/laravel-kit/src/resources/{$name}/{$type}", "", $value);
                    
                    if (!is_dir($value)) {
                        if (!file_exists($dest)) {
                            copy($value, $dest);
                        }
                    } else {
                        if (!is_dir($dest)) {
                            mkdir($dest, 0755, true);
                        }
                    }
                }
            }
        }
    }

    public function getDirContents($dir, &$results = array())
    {
        if (is_dir($dir)) {
            $files = scandir($dir);

            foreach ($files as $key => $value) {
                // $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
                $path = $dir . DIRECTORY_SEPARATOR . $value;
                if ($value != "." && $value != "..") {
                    $results[] = $path;
                    $this->getDirContents($path, $results);
                }
            }
        }

        return $results;
    }

    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of module is required.',
                null,
            ],
        ];
    }

    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            [
                'type',
                null,
                InputOption::VALUE_OPTIONAL,
                'The type of module.',
                null,
            ],
        ];
    }
}
