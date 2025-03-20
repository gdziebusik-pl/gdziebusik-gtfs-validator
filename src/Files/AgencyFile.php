<?php
namespace GdzieBusik\Gtfs\Files;

use GdzieBusik\Gtfs\FieldType;

class AgencyFile extends GtfsFile {

    protected bool $required = false;
    public string $name = "agency.txt";

    protected array $fields = [
        "agency_id" => [
            "field_type" => FieldType::ID,
            "required" => true,
        ],
        "agency_name" => [
            "required" => true
        ],
        "agency_url" => [
            "required" => true,
            "field_type" => FieldType::URL,
        ],
        "agency_timezone" => [
            "required" => true,
        ],
        "agency_lang" => [],
        "agency_phone" => [],
        "agency_fare_url" => [
            "field_type" => FieldType::URL
        ],
        "agency_email" => [
            "field_type" => FieldType::EMAIL
        ]
    ];
}