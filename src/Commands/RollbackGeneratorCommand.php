<?php

namespace aayaresko\Generator\Commands;

use Illuminate\Console\Command;
use aayaresko\Generator\Common\CommandData;
use aayaresko\Generator\Generators\API\APIControllerGenerator;
use aayaresko\Generator\Generators\API\APIRequestGenerator;
use aayaresko\Generator\Generators\API\APIRoutesGenerator;
use aayaresko\Generator\Generators\API\APITestGenerator;
use aayaresko\Generator\Generators\MigrationGenerator;
use aayaresko\Generator\Generators\ModelGenerator;
use aayaresko\Generator\Generators\RepositoryGenerator;
use aayaresko\Generator\Generators\RepositoryTestGenerator;
use aayaresko\Generator\Generators\Scaffold\ControllerGenerator;
use aayaresko\Generator\Generators\Scaffold\MenuGenerator;
use aayaresko\Generator\Generators\Scaffold\RequestGenerator;
use aayaresko\Generator\Generators\Scaffold\RoutesGenerator;
use aayaresko\Generator\Generators\Scaffold\ViewGenerator;
use aayaresko\Generator\Generators\TestTraitGenerator;
use aayaresko\Generator\Generators\VueJs\ControllerGenerator as VueJsControllerGenerator;
use aayaresko\Generator\Generators\VueJs\ModelJsConfigGenerator;
use aayaresko\Generator\Generators\VueJs\RoutesGenerator as VueJsRoutesGenerator;
use aayaresko\Generator\Generators\VueJs\ViewGenerator as VueJsViewGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RollbackGeneratorCommand extends Command
{
    /**
     * The command Data.
     *
     * @var CommandData
     */
    public $commandData;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'infyom:rollback';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback a full CRUD API and Scaffold for given model';

    /**
     * @var Composer
     */
    public $composer;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->composer = app()['composer'];
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        if (!in_array($this->argument('type'), [
            CommandData::$COMMAND_TYPE_API,
            CommandData::$COMMAND_TYPE_SCAFFOLD,
            CommandData::$COMMAND_TYPE_API_SCAFFOLD,
            CommandData::$COMMAND_TYPE_VUEJS,
        ])) {
            $this->error('invalid rollback type');
        }

        $this->commandData = new CommandData($this, $this->argument('type'));
        $this->commandData->config->mName = $this->commandData->modelName = $this->argument('model');

        $this->commandData->config->init($this->commandData, ['tableName', 'prefix']);

        $migrationGenerator = new MigrationGenerator($this->commandData);
        $migrationGenerator->rollback();

        $modelGenerator = new ModelGenerator($this->commandData);
        $modelGenerator->rollback();

        $repositoryGenerator = new RepositoryGenerator($this->commandData);
        $repositoryGenerator->rollback();

        $requestGenerator = new APIRequestGenerator($this->commandData);
        $requestGenerator->rollback();

        $controllerGenerator = new APIControllerGenerator($this->commandData);
        $controllerGenerator->rollback();

        $routesGenerator = new APIRoutesGenerator($this->commandData);
        $routesGenerator->rollback();

        $requestGenerator = new RequestGenerator($this->commandData);
        $requestGenerator->rollback();

        $controllerGenerator = new ControllerGenerator($this->commandData);
        $controllerGenerator->rollback();

        $viewGenerator = new ViewGenerator($this->commandData);
        $viewGenerator->rollback();

        $routeGenerator = new RoutesGenerator($this->commandData);
        $routeGenerator->rollback();

        $controllerGenerator = new VueJsControllerGenerator($this->commandData);
        $controllerGenerator->rollback();

        $routesGenerator = new VueJsRoutesGenerator($this->commandData);
        $routesGenerator->rollback();

        $viewGenerator = new VueJsViewGenerator($this->commandData);
        $viewGenerator->rollback();

        $modelJsConfigGenerator = new ModelJsConfigGenerator($this->commandData);
        $modelJsConfigGenerator->rollback();

        if ($this->commandData->getAddOn('tests')) {
            $repositoryTestGenerator = new RepositoryTestGenerator($this->commandData);
            $repositoryTestGenerator->rollback();

            $testTraitGenerator = new TestTraitGenerator($this->commandData);
            $testTraitGenerator->rollback();

            $apiTestGenerator = new APITestGenerator($this->commandData);
            $apiTestGenerator->rollback();
        }

        if ($this->commandData->config->getAddOn('menu.enabled')) {
            $menuGenerator = new MenuGenerator($this->commandData);
            $menuGenerator->rollback();
        }

        $this->info('Generating autoload files');
        $this->composer->dumpOptimized();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['tableName', null, InputOption::VALUE_REQUIRED, 'Table Name'],
            ['prefix', null, InputOption::VALUE_REQUIRED, 'Prefix for all files'],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'Singular Model name'],
            ['type', InputArgument::REQUIRED, 'Rollback type: (api / scaffold / scaffold_api)'],
        ];
    }
}
