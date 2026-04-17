<?php

class Request
{
    public int $id;
    public string $title;
    public string $description;
    public string $status;
    public string $createdBy;

    public function __construct(
        int $id,
        string $title,
        string $description,
        string $status,
        string $createdBy
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->createdBy = $createdBy;
    }
}