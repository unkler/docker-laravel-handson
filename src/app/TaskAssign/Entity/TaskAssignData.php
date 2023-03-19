<?php
namespace App\TaskAssign\Entity;

final class TaskAssignData
{
    public function __construct(
        private ?int $id,
        private int $workplace_id,
        private array $employee_ids,
        private string $implementation_date,

    ) {
        $this->id = $id;
        $this->workplace_id = $workplace_id;
        $this->employee_ids = $employee_ids;
        $this->implementation_date = $implementation_date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getWorkplaceId()
    {
        return $this->workplace_id;
    }

    public function getEmployeeIds()
    {
        return $this->employee_ids;
    }

    public function getImplementationDate()
    {
        return $this->implementation_date;
    }
}