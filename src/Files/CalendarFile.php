<?php
namespace GdzieBusik\Gtfs\Files;

use GdzieBusik\Gtfs\FieldType;

class CalendarFile extends GtfsFile {
    public string $name = "calendar.txt";
    protected array $fields = [
        "service_id" => [
            "field_type" => FieldType::ID,
            "constraint" => "CalendarFile.php:service_id",
            "required" => true
        ],
        "monday" => [
            "required" => true
        ],
        "tuesday" => [
            "required" => true
        ],
        "wednesday" => [
            "required" => true
        ],
        "thursday" => [
            "required" => true
        ],
        "friday" => [
            "required" => true
        ],
        "saturday" => [
            "required" => true
        ],
        "sunday" => [
            "required" => true
        ],
        "start_date" => [
            "required" => true
        ],
        "end_date" => [
            "required" => true
        ]
    ];
}