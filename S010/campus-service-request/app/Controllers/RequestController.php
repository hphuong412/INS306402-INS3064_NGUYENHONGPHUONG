<?php

class RequestController
{
    public function index(): void
    {
        echo "Request list page";
    }

    public function create(): void
    {
        echo "Create request form";
    }

    public function store(): void
    {
        echo "Store new request";
    }

    public function show(int $id): void
    {
        echo "Show request with ID: " . $id;
    }

    public function updateStatus(int $id): void
    {
        echo "Update status for request ID: " . $id;
    }

    public function staffIndex(): void
    {
        echo "Staff request list";
    }
}