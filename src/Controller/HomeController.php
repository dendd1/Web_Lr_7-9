<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {





        $question = $doctrine->getRepository(Question::class)->getQuestionWithApproveAnswer();
        $topQuestion = $doctrine->getRepository(Question::class)->getTopQuestion();

        $appointments = $paginator->paginate(
        // Doctrine Query, not results
            $question,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        return $this->render('home/index.html.twig', [
            'questions' => $appointments,
            'topQuestion' => $topQuestion,
            'appointments' => $appointments,
        ]);
    }
}
