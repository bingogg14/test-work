<?php

namespace App\Controllers;

// Так как у нас один файл, то нам не нужна сущность файла, а все операции с документом можем производить в одном классе FileController
final class FileController {
    private static ?FileController $instance = null;

    private const FILE_NAME = 'peoples.csv';
    private const DELIMITER = ';';

    protected $fp;
    protected array $data;
    protected int $countRows;

    public function __construct() {
        $this->fp = null;
        $this->data = [];
        $this->countRows = 0;
        $this->getDataFile();
    }

    public static function getInstance(): FileController
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function openFile($mode = 'r'): void {
        if (!($this->fp = fopen(self::getPathFile(), $mode))) {
            if ($this->createFile()) {
                $this->closeFile();
                $this->openFile();
            } else {
                $this->fp = null;
            }
        }
    }

    private function createFile(): bool {
        return fopen(self::getPathFile(), 'w');
    }

    private function closeFile(): void {
        fclose($this->fp);
    }

    private function getDataFile(): void {
        $this->openFile();
        if ($this->getStatusOpenFile()) {
            while (!feof($this->fp)) {
                $data = fgetcsv($this->fp);
                if (is_array($data) && is_string($data[0])) {
                    $dataExplode = explode(self::DELIMITER, $data[0]);
                    $this->appendToData($dataExplode);
                    $this->countRows++;
                }
            }
            $this->closeFile();
        }
    }

    private function getStatusOpenFile(): bool {
        return !($this->fp === null);
    }

    private static function getPathFile(): string {
        return __DIR__ . '/../../' . self::FILE_NAME;
    }

    private function appendToData(array $data): void {
        $this->data[] = $data;
    }

    public function getData() {
        return $this->data;
    }

    public function getCountRows() {
        return $this->countRows;
    }

    public function appendRow(array $row): bool {
        $status = false;

        $this->openFile('a+');
        if (fputcsv($this->fp, $row, ';')) {
            $this->countRows++;
            $this->appendToData($row);
            $status = true;
        }

        $this->closeFile();
        return $status;
    }
}