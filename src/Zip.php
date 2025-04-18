<?php

namespace Ameax\Datev;

use Spatie\TemporaryDirectory\Exceptions\PathAlreadyExists;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use ZipArchive;

class Zip
{
    public TemporaryDirectory $temporaryDirectory;

    public ZipArchive $zipArchive;

    protected string $zipPath;

    /**
     * @throws PathAlreadyExists
     */
    public function __construct(string $location)
    {
        $this->temporaryDirectory = new TemporaryDirectory($location);
        $this->temporaryDirectory->create(); // name('ameax-datev')->force()->

        $this->zipArchive = new ZipArchive;
        $this->zipPath = $this->temporaryDirectory->path('datev.zip');
        $this->zipArchive->open($this->zipPath, ZipArchive::CREATE);
    }

    public function __destruct()
    {
        // TODO
        // $this->temporaryDirectory->delete();
    }

    public function addFile(string $path, string $pathAndFilenameInZip): static
    {
        $this->zipArchive->addFile($path, $pathAndFilenameInZip);

        return $this;
    }

    public function addFromString(string $content, string $pathAndFilenameInZip): static
    {
        $this->zipArchive->addFromString($pathAndFilenameInZip, $content);

        return $this;
    }

    public function close(): static
    {
        $this->zipArchive->close();

        return $this;
    }

    public function getZipPath(): string
    {
        return $this->zipPath;
    }
}
