<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\File;
use App\Entity\Message;
use App\Repository\FileRepository;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;

class FileService
{
    private FileRepository $repository;
    protected string $baseDir;

    public function __construct(FileRepository$repository, KernelInterface $kernel)
    {
        $this->repository = $repository;
        $this->baseDir = $kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;
    }

    /**
     * @param File $file
     *
     * @return File|null
     */
    public function create(File $file): ?File
    {
        try {
            return $this->repository->create($file);
        } catch (Exception $e) {}

        return null;
    }

    /**
     * @param Message $message
     * @param UploadedFile $uploadedFile
     *
     * @return File|null
     */
    public function upload(Message $message, UploadedFile $uploadedFile): ?File
    {
        $relativePath = 'files' . DIRECTORY_SEPARATOR . date('Y-m-d') . DIRECTORY_SEPARATOR;
        $path = $this->baseDir . $relativePath;
        $extension = '.' . $uploadedFile->guessExtension();
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME) . $extension;
        $safeFilename = md5($originalFilename . microtime()) . $extension;

        try {
            $uploadedFile->move($path, $safeFilename);
        } catch (Exception $e) {
            return null;
        }

        $file = (new File())
            ->setMessage($message)
            ->setFileName($originalFilename)
            ->setPath($relativePath . $safeFilename);

        return $this->create($file);
    }
}
