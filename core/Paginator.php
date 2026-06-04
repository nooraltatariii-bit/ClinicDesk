<?php

class Paginator
{
    private $totalItems;

    private $perPage;

    private $currentPage;

    public function __construct(
        int $totalItems,
        int $perPage,
        int $currentPage
    ) {

        $this->totalItems = $totalItems;

        $this->perPage = $perPage;

        $this->currentPage = $currentPage;
    }

    public function offset()
    {
        return (
            ($this->currentPage - 1)
            * $this->perPage
        );
    }

    public function totalPages()
    {
        return (int) ceil(
            $this->totalItems
            / $this->perPage
        );
    }

    public function hasPrev()
    {
        return $this->currentPage > 1;
    }

    public function hasNext()
    {
        return (
            $this->currentPage
            < $this->totalPages()
        );
    }
}