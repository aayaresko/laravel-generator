<?php

namespace aayaresko\Generator\Commands\API;

use aayaresko\Generator\Commands\BaseCommand;
use aayaresko\Generator\Common\CommandData;
use aayaresko\Generator\Generators\API\APITestGenerator;
use aayaresko\Generator\Generators\RepositoryTestGenerator;
use aayaresko\Generator\Generators\TestTraitGenerator;

class TestsGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'infyom.api:tests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create tests command';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_API);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        $repositoryTestGenerator = new RepositoryTestGenerator($this->commandData);
        $repositoryTestGenerator->generate();

        $testTraitGenerator = new TestTraitGenerator($this->commandData);
        $testTraitGenerator->generate();

        $apiTestGenerator = new APITestGenerator($this->commandData);
        $apiTestGenerator->generate();

        $this->performPostActions();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge(parent::getOptions(), []);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array_merge(parent::getArguments(), []);
    }
}
