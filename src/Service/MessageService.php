<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Exception;

class MessageService
{
    private MessageRepository $repository;
    private FileService $fileService;

    public function __construct(MessageRepository $repository, FileService $fileService)
    {
        $this->repository = $repository;
        $this->fileService = $fileService;
    }

    /**
     * @param Message $message
     * @param array|null $files
     *
     * @return Message|null
     */
    public function create(Message $message, ?array $files = null): ?Message
    {
        if (!empty($files)) {
            foreach ($files as $uploadedFile) {
                $file = $this->fileService->upload($message, $uploadedFile);

                if (null === $file) {
                    continue;
                }

                $message->addAttachment($file);
            }
        }

        try {
            $message = $this->repository->create($message);
        } catch (Exception $e) {
            return null;
        }

        return $message;
    }

    /**
     * @param int $page
     * @param int $count
     *
     * @return array
     */
    public function list(int $page, int $count): array
    {
        return $this->repository->listParents($page, $count);
    }
}
