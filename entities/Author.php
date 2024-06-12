<?php

class Author
{
    private $author_id;
    private $author_name;

    public function __construct($author_id, $author_name)
    {
        $this->author_id = $author_id;
        $this->author_name = $author_name;
    }

    public function CreateAuthor()
    {
        $author_name = readline("Name of the Author: ");
        $author_id = readline("Author id: ");

        $author = [
            "Name" => $author_name,
            "ID" => $author_id
        ];

        $jsonData = file_get_contents("authors.json");
        $authors = json_decode($jsonData, true);

        $authors[] = $author;

        $jsonData = json_encode($authors, JSON_PRETTY_PRINT);

        file_put_contents("authors.json", $jsonData);

        echo "Author added: " . $author_name . "\n";
    }
}
