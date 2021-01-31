<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Service;

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use LogicException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MigrationGenerator
 * @package BastSys\UtilsBundle\Service
 * @author mirkl
 */
class MigrationGenerator
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var DependencyFactory
     */
    private DependencyFactory $dependencyFactory;
    /**
     * @var ExecuteCommand
     */
    private ExecuteCommand $executeCommand;

    /**
     * @var string
     */
    private string $upSql = '';
    /**
     * @var string
     */
    private string $downSql = '';

    /**
     * @var string|null
     */
    private ?string $migrationId = null;

    /**
     * MigrationGenerator constructor.
     * @param EntityManagerInterface $entityManager
     * @param DependencyFactory $dependencyFactory
     * @param ExecuteCommand $executeCommand
     */
    public function __construct(EntityManagerInterface $entityManager, DependencyFactory $dependencyFactory, ExecuteCommand $executeCommand)
    {
        $this->entityManager = $entityManager;
        $this->dependencyFactory = $dependencyFactory;
        $this->executeCommand = $executeCommand;
    }

    /**
     * @param string $entityClass
     * @return string
     */
    public function getTableName(string $entityClass): string {
        return $this->entityManager->getClassMetadata($entityClass)->getTableName();
    }

    /**
     * @param string $sql
     */
    public function addUpSql(string $sql): void {
        if($this->migrationId) {
            throw new LogicException('Migration already generated');
        }

        $this->upSql .= '$this->addSql("' . $sql .'");' . "\n";
    }

    /**
     * @param string $sql
     */
    public function addDownSql(string $sql): void {
        if($this->migrationId) {
            throw new LogicException('Migration already generated');
        }

        $this->downSql .= '$this->addSql("' . $sql .'");' . "\n";
    }

    /**
     * @return string
     */
    public function generate(): string {
        if(!$this->upSql || !$this->downSql) {
            throw new LogicException('Cannot generate empty migration');
        }

        $fqcn = $this->dependencyFactory->getClassNameGenerator()->generateClassName(
            key($this->dependencyFactory->getConfiguration()->getMigrationDirectories())
        );

        $this->dependencyFactory->getMigrationGenerator()->generateMigration($fqcn, $this->upSql, $this->downSql);
        $this->migrationId = $fqcn;

        return $fqcn;
    }

    /**
     * @param OutputInterface|null $output
     * @throws Exception
     */
    public function execute(?OutputInterface $output = null) {
        if(!$this->migrationId) {
            throw new LogicException('Migration not generated yet');
        }

        $output = $output ?? new NullOutput();

        $executeInput = new ArrayInput([
            'versions' => [$this->migrationId],
            '--up' => true
        ]);
        $executeInput->setInteractive(false);
        $this->executeCommand->run($executeInput, $output);
    }

    /**
     *
     */
    public function reset() {
        $this->upSql = '';
        $this->downSql = '';
        $this->migrationId = null;
    }
}
