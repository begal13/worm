<?php
declare(strict_types=1);

namespace WoohooLabs\Worm\Examples\Infrastructure\Model;

use WoohooLabs\Worm\Model\AbstractModel;

class StudentModel extends AbstractModel
{
    public $id;
    public $first_name;
    public $last_name;
    public $birthday;
    public $gender;
    public $introduction;

    public function getTable(): string
    {
        return "students";
    }

    public function getPrimaryKey(): string
    {
        return $this->id;
    }

    protected function getRelationships(): array
    {
        return [];
    }
}
