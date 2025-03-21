<?php
namespace GdzieBusik\Gtfs\Files;

use GdzieBusik\Gtfs\FieldType;

class CalendarDateFile extends GtfsFile {
    public string $name = "calendar_dates.txt";
    protected array $fields = [
        "service_id" => [
            "field_type" => FieldType::FOREIGN,
            "required" => true,
        ],
        "date" => [
            "required" => true,
        ],
        "exception_type" => [
            "required" => true,
        ]
    ];
}