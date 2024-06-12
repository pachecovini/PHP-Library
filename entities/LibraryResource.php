<?php

class LibraryResource
{
    private $resourceCategory;

    public function __construct($resourceCategory)
    {
        $this->resourceCategory = $resourceCategory;
    }

    public function getResourceInfo($name, $id)
    {
        return "Default resource information";
    }
}
