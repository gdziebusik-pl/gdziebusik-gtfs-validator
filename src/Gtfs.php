<?php

namespace GdzieBusik\Gtfs;

use GdzieBusik\Gtfs\Files\GtfsFile;
use ZipArchive;

class Gtfs {
    private const TEMP_ROOT = __DIR__."/tmp/gtfs/";

    private static string $temp;
    private static bool $deleteArchive = false;

    public static function tempPath($path) {
        self::$temp = $path;
    }
    public static function deleteArchive($deleteArchive) {
        self::$deleteArchive = $deleteArchive;
    }

    private string $root;
    public function __construct(string $zipFile) {
        $this->root = substr($zipFile, 0, strlen($zipFile) - 4) . '/';
        $this->extractFiles($zipFile);
        if (self::$deleteArchive and file_exists($zipFile)) {
            unlink($zipFile);
        }
    }

    public static function create(string $url): Gtfs {
        $temp_file = self::$temp . md5($url) . ".zip";
        if (!file_exists($temp_file)) {
            file_put_contents($temp_file, file_get_contents($url));
        }
        return new Gtfs($temp_file);
    }

    /**
     * @param class-string<GtfsFile> $className
     * @return GtfsFile
     */
    public function getFile(string $className) : GtfsFile {
        $instance = new $className();
        $items = $this->parseCsv($this->root . $instance->name);
        $instance->setItems($items);
        $instance->validate();
        return $instance;
    }

    private function extractFiles(string $zipPath) {
//        $zip = new ZipArchive();
//        if ($zip->open($zipPath) !== TRUE) {
//            throw new \Exception("Can't open zip file");
//        }
//        $zip->extractTo($this->root);
//        $zip->close();
    }

    private function parseCsv(string $fileName) {
        if (!file_exists($fileName)) return [];
        $data = [];
        if (($handle = fopen($fileName, 'r')) !== false) {
            $headers = fgetcsv($handle, 1000, ",");
            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                $data[] = array_combine($headers, $row);
            }
            fclose($handle);
        }
        return $data;
    }
}