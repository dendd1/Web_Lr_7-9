<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddQuestionController extends AbstractController
{
    #[Route('/add/question', name: 'app_add_question')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        if (!$this->getUser())
        {
            return $this->redirectToRoute('app_home');
        }
        $categories = $doctrine
            ->getRepository(Category::class)
            ->findAll();

        $question_for_form = new Question();

        $form = $this->createForm(QuestionType::class, $question_for_form, [
            'action' => $this->generateUrl('app_add_question')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $question_for_form->setDate(new \DateTime('now'));
            $question_for_form->setUser($this->getUser());
            $answer = $form->getData();
            $em = $doctrine->getManager();

            $category = $question_for_form->getCategory();

            $categoryCheck = $doctrine
                ->getRepository(Category::class)
                ->findOneBy(['name' => $category->getName()]);

            if (!$categoryCheck) {
                $em->persist($category);
            } else {
                $question_for_form->setCategory($categoryCheck);
            }
            $em->persist($question_for_form);

            $em->flush();


            $em->persist($answer);
            $em->flush();

            return $this->redirectToRoute('app_home');

        }


        return $this->render('add_question/index.html.twig', [
            'formQuestion' => $form->createView(),
            'categories' => $categories,
        ]);
    }
}
