<?php
namespace App\Service;

class Search
{
    public function __construct()
    {
        $this->results = [];
    }

    public function searchTitles(string $searchterm, array $files)
    {
        foreach ($files as $key => $value) {
            if (is_array($value)) {
                $this->searchTitles($searchterm, $value);
            } elseif (preg_match("/{$searchterm}/", $key)) {
                $this->results[] = [$value, $key];
            }
        }

        return $this->results;
    }
}
