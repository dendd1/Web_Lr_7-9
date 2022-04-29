<?php

namespace App\Controller;

use App\Entity\Aswer;
use App\Entity\Question;
use App\Form\AnswerType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @param int $id
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @return Response
     */
    #[Route('/question/{id}', name: 'app_answer')]
    public function index(int $id, ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $question = $doctrine->getRepository(Question::class)->findOneBy(['id' => $id]);

        if (!$question->getStatus()) {
            return $this->redirectToRoute('app_home');
        }
        $answer_for_form = new Aswer();

        $form = $this->createForm(AnswerType::class, $answer_for_form, [
            'action' => $this->generateUrl('app_answer', ['id' => $id])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $answer_for_form->setQuestion($doctrine->getRepository(Question::class)->find($id));
            $answer_for_form->setDate(new \DateTime('now'));
            $answer_for_form->setUser($this->getUser());
            $answer_for_form = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($answer_for_form);
            $em->flush();
            return $this->redirectToRoute('app_answer', ['id' => $id]);
        }


        $question = $doctrine->getRepository(Question::class)->find($id);


        $answer = $doctrine->getRepository(Aswer::class)->getAnswersOnQuestion($id);
        $answers = $paginator->paginate(
        // Doctrine Query, not results
            $answer,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );

        return $this->render('question/index.html.twig', [
            'aswers' => $answers,
            'question' => $question,
            'formAswer' => $form->createView(),
        ]);
    }
}
