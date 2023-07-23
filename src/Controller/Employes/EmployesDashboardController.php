<?php

namespace App\Controller\Employes;

use App\Entity\Type;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Vehicule;
use App\Entity\Categorie;
use App\Entity\Exemplaire;
use App\Entity\Temoignage;
use App\Entity\ExemplaireImage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class EmployesDashboardController extends AbstractDashboardController
{
    #[Route('/employes', name: 'employes')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');

        return $this->render('employes/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Vincent Parrot');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Marques', 'fas fa-list', Marque::class);
        yield MenuItem::linkToCrud('Modeles', 'fas fa-list', Modele::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Type Vehicule', 'fas fa-list', Type::class);
        yield MenuItem::linkToCrud('Vehicules', 'fas fa-list', Vehicule::class);
        yield MenuItem::linkToCrud('Exemplaires', 'fas fa-list', Exemplaire::class);
        //yield MenuItem::linkToCrud('Image Exemplaires', 'fas fa-image', ExemplaireImage::class);
        yield MenuItem::linkToCrud('Témoignages', 'fas fa-list', Temoignage::class);
    }
}
