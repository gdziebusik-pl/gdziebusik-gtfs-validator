<?php
namespace GdzieBusik\Gtfs\Files;

use GdzieBusik\Gtfs\FieldType;

abstract class GtfsFile {
    protected bool $required = true;
    public string $name = "";
    protected array $fields = [];

    private array $items = [];
    private array $errors = [];

    public function setItems(array $items) {
        $this->items = $items;
    }

    public function getErrors() {
        return $this->errors;
    }
    public function get() {
        return $this->items;
    }

    private array $seenIds = [];

    public function validate() {
        foreach ($this->items as $index => $item) {
            $rowErrors = $this->validateRow($item);
            if (!empty($rowErrors)) {
                $this->errors[$index] = $rowErrors;
            }
        }
    }

    private function validateRow(array $item): array {
        $errors = [];
        foreach ($this->fields as $field => $rules) {
            if (!empty($rules['required']) && (!isset($item[$field]) || trim($item[$field]) === '')) {
                $errors[] = "Pole '$field' jest wymagane.";
                continue;
            }
            if (isset($item[$field]) && isset($rules['field_type'])) {
                if (!$this->validateFieldType($item[$field], $rules)) {
                    $errors[] = "Pole '$field' ma nieprawidłowy format ({$rules['field_type']->name}).";
                }
            }
        }

        return $errors;
    }

    private function validateFieldType($value, $rules): bool {
        return match ($rules['field_type']) {
            FieldType::ID => $this->validateUniqueID($value),
            FieldType::URL => empty($value) || filter_var($value, FILTER_VALIDATE_URL) !== false,
            FieldType::EMAIL => empty($value) || filter_var($value, FILTER_VALIDATE_EMAIL) !== false,
            FieldType::FOREIGN => ,
            default => true
        };
    }
    private function validateUniqueID($value): bool {
        if (in_array($value, $this->seenIds)) return false;

        if (in_array($value, $this->seenIds)) {
            $this->errors[] = "Duplikat!";
            return false;
        }

        $this->seenIds[] = $value;
        return true;
    }
}