<?php
declare(strict_types=1);

namespace WoohooLabs\Worm\Query;

use WoohooLabs\Larva\Query\Delete\DeleteQueryBuilder as LarvaDeleteQueryBuilder;
use WoohooLabs\Larva\Query\Delete\DeleteQueryBuilderInterface;
use WoohooLabs\Worm\Execution\QueryExecutor;
use WoohooLabs\Worm\Model\ModelInterface;

class DeleteQueryBuilder
{
    /**
     * @var ModelInterface
     */
    private $model;

    /**
     * @var QueryExecutor
     */
    private $queryExecutor;

    /**
     * @var LarvaDeleteQueryBuilder
     */
    private $queryBuilder;

    public function __construct(ModelInterface $model, QueryExecutor $executor)
    {
        $this->model = $model;
        $this->queryExecutor = $executor;
        $this->queryBuilder = new LarvaDeleteQueryBuilder();
        $this->queryBuilder->from($model->getTable());
    }

    public function where(ConditionBuilder $where): DeleteQueryBuilder
    {
        $this->queryBuilder->where($where->getConditionBuilder());

        return $this;
    }

    public function addWhereGroup(ConditionBuilder $where): DeleteQueryBuilder
    {
        $this->queryBuilder->addWhereGroup($where->getConditionBuilder());

        return $this;
    }

    public function getQueryBuilder(): DeleteQueryBuilderInterface
    {
        return $this->queryBuilder;
    }

    public function execute(): bool
    {
        return $this->queryExecutor->delete($this->queryBuilder);
    }

    /**
     * @param mixed $id
     */
    public function executeById($id): bool
    {
        $this->queryBuilder
            ->addWhereGroup($this->model->createConditionBuilder($id));

        return $this->queryExecutor->delete($this->queryBuilder);
    }

    public function getSql(): string
    {
        return $this->queryExecutor->getSql($this->queryBuilder);
    }

    public function getParams(): array
    {
        return $this->queryExecutor->getParams($this->queryBuilder);
    }

    public function __clone()
    {
        $this->queryBuilder = clone $this->queryBuilder;
    }
}
