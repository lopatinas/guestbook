<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageForm;
use App\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    const PER_PAGE = 10;

    /**
     * @Route("/", name="home")
     *
     * @param Request $request
     * @param MessageService $service
     *
     * @return Response
     */
    public function home(Request $request, MessageService $service): Response
    {
        $page = (int) $request->get('page', 1);
        $messages = $service->list($page, self::PER_PAGE);

        return $this->render('message/list.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/message/new", name="message_new")
     * @Route("/message/{id}/new", name="message_reply")
     *
     * @param Request $request
     * @param Message|null $parent
     * @param MessageService $service
     *
     * @return Response
     */
    public function new(Request $request, MessageService $service, ?Message $parent = null): Response
    {
        $message = (new Message())
            ->setParent($parent)
            ->setAuthor($this->getUser());
        $form = $this->createForm(MessageForm::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $service->create($message, $form->get('files')->getData());

            if (null === $message) {
                $this->addFlash('error', 'Message creation failed. Please, try again later.');
            } else {
                $this->addFlash('success', 'Message successfully created.');
            }

            return $this->redirectToRoute('home');
        }

        return $this->render('message/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
