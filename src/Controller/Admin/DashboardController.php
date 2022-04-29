<?php

namespace App\Controller\Admin;

use App\Entity\Aswer;
use App\Entity\Category;
use App\Entity\Question;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(AswerCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Панель Админа')
            ->renderContentMaximized()
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('На главную', 'fas fa-home', '/');
        yield MenuItem::linkToCrud('Вопросы', 'fas fa-question-circle', Question::class);
        yield MenuItem::linkToCrud('Категории', 'fas fa-info', Category::class);
        yield MenuItem::linkToCrud('Ответы', 'fas fa-comments', Aswer::class);
        yield MenuItem::linkToLogout('Выход', 'fas fa-sign-out');
    }
}
