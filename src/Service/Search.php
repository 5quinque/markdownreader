<?php
namespace App\Service;

class Search
{
    public function __construct()
    {
    }

    public function searchTitles(string $searchterm, array $files)
    {
        foreach ($files as $key => $value) {
            if (is_array($value)) {
                $returnValue = $this->searchTitles($searchterm, $value);
                if ($returnValue != false) {
                    return $returnValue;
                }
            } else {
                if ($value == $searchterm) {
                    return $value;
                }
            }
        }
    }
}
