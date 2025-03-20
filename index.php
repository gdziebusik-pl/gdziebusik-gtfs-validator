<?php
require __DIR__ . '/vendor/autoload.php';

use GdzieBusik\Gtfs\Files\AgencyFile;
use GdzieBusik\Gtfs\Gtfs;

header('Content-type: application/json');
try {
    Gtfs::tempPath(__DIR__ . "/temp/");
    Gtfs::deleteArchive(true);
    $gtfs = Gtfs::create("https://otwartedane.erzeszow.pl/media/resources/gtfs-03-01-2025-28-02-2025-27-12-2024-14-07-46.zip");

    $agencies = $gtfs->getFile(AgencyFile::class);
    echo json_encode($agencies->getErrors());
} catch (exception $e) {
    die($e->getMessage());
}