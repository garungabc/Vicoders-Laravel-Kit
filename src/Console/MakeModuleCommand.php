<?php

namespace Vicoders\LaravelKit\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeModuleCommand extends Command
{
    protected function configure()
    {
        $this->setName('make:module {name}')
            ->setDescription('Create a module')
            ->setHelp('php command make:module {{name}}')
            ->addArgument('name', InputArgument::REQUIRED, 'Name')
            ->addOption('type', null, InputOption::VALUE_OPTIONAL, 'Set type module');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('type') == null) {
            $output->writeln('<error>You have to provide option --type</error>');
            exit;
        } else {
            if ($input->getArgument('type') != 'api' && $input->getArgument('type') != 'basic') {
                $output->writeln('<error>type must be basic or api</error>');
                exit;
            } else {
                $name = snake_case($input->getArgument('name'));
                $type = snake_case($input->getArgument('type'));

                $folder = "resources/{$name}/{$type}";
                if (!is_dir($folder)) {
                    throw new Exception("{$folder} not found", 1);
                }

                $array_folder = $this->getDirContents($folder);
                foreach ($array_folder as $value) {
                    if (!file_exists('resources/views/vendor/option/admin.blade.php')) {
                        copy('vendor/nf/option/resources/views/admin.blade.php', 'resources/views/vendor/option/admin.blade.php');
                    }
                }
            }
        }
    }

    public function getDirContents($dir, &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            // $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            $path = $dir . DIRECTORY_SEPARATOR . $value;
            if ($value != "." && $value != "..") {
                $results[] = $path;
                getDirContents($path, $results);
            }
        }

        return $results;
    }
}
