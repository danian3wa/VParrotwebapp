<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Service\NavType;
use App\Form\ContactType;
use App\Service\NavMarque;
use App\Service\NavCategorie;
use Symfony\Component\Mime\Email;
use App\Repository\TypeRepository;
use App\Repository\MarqueRepository;
use App\Repository\CategorieRepository;
use App\Repository\ExemplaireRepository;
use App\Repository\ExemplaireImageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class OccasionsPageController extends AbstractController
{
    private $navCategorie;
    private $navType;
    private $navMarque;
    public function __construct(NavMarque $navMarque, NavCategorie $navCategorie, NavType $navType)
    {
        $this->navMarque = $navMarque;
        $this->navCategorie = $navCategorie;
        $this->navType = $navType;
    }

    #[Route('/occasions', name: 'app_occasions_page')]
    public function index(ExemplaireRepository $exemplaireRepository, ExemplaireImageRepository $exemplaireImageRepository, Request $request): Response
    {   
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        [$prixmin, $prixmax] = $exemplaireRepository->findPrixMinMax($data);
        [$kmmin, $kmmax] = $exemplaireRepository->findKmMinMax($data);
        [$anneemin, $anneemax] = $exemplaireRepository->findAnneeMinMax($data);
        $occasions = $exemplaireRepository->findSearch($data);
        
        
        $exemplaires=$exemplaireRepository->findAll();
        $carImages = $exemplaireImageRepository->findBy(['exemplaire'=>$exemplaires],[]);
        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('occasions/_occasions.html.twig', ['occasions' => $occasions]),
                'sorting' => $this->renderView('occasions/_sorting.html.twig', ['occasions' => $occasions]),
                'pagination' => $this->renderView('occasions/_pagination.html.twig', ['occasions' => $occasions]),
                'pages' => ceil($occasions->getTotalItemCount() / $occasions->getItemNumberPerPage()),
                'prixmin' => $prixmin,
                'prixmax' => $prixmax,
                'kmmax' => $kmmax,
                'kmmin' => $kmmin,
                'anneemin' => $anneemin,
                'anneemax' => $anneemax
            ]);
        }
        return $this->render('occasions/index.html.twig', [
            'carImages' => $carImages,
            'occasions' => $occasions,
            'form' => $form->createView(),
            'prixmin' => $prixmin,
            'prixmax' => $prixmax,
            'kmmax' => $kmmax,
            'kmmin' => $kmmin,
            'anneemin' => $anneemin,
            'anneemax' => $anneemax,
            'marqueList' => $this->navMarque->marque(),
            'categorieList' => $this->navCategorie->categorie(),
            'typeList' => $this->navType->type(),
        ]);
    }

    #[Route('/occasions/exemplaire/{id}', name: 'app_exemplaire_show')]
    public function exemplaireShow(int $id, ExemplaireRepository $exemplaireRepository, MailerInterface $mailer, Request $request): Response
    {
        $exemplaireId = $exemplaireRepository->find($id);
        $emailSubject = $exemplaireId->getVehicule();

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            
            $message = (new Email())
                ->priority(Email::PRIORITY_HIGH)
                ->from($contactFormData['email'])
                ->to('test@gmail.com')
                ->subject($emailSubject)
                ->text('Expéditeur : '.$contactFormData['nom'].' '.$contactFormData['prenom'].\PHP_EOL.
                    'E-mail : '.$contactFormData['email'].\PHP_EOL.
                    'Téléphone : '.$contactFormData['tel'].\PHP_EOL.
                    'Message : '.$contactFormData['message'],
                    'text/plain');

            try {
                $mailer->send($message);
                $this->addFlash('success', 'Votre message a été envoyé.');
            } catch (TransportExceptionInterface $e) {
                echo $e->getDebug();

            }
        }

        return $this->render('occasions/exemplaire.html.twig', [
            'exemplaire' => $exemplaireId,
            'contact_form' => $form->createView(),
        ]);
    }

    #[Route('/occasions/categorie/{id}', name: 'app_occcasions_categorie_show')]
    public function ocassionsByCategorie(int $id, ExemplaireRepository $exemplaireRepository, CategorieRepository $categorieRepository):Response
    {
        $idCategorie = $categorieRepository->find($id);
        $categorieLibelle = $categorieRepository->findOneBy(['id'=>$idCategorie],[]);
        $exemplaireByCategorie = $exemplaireRepository->findBy(['categorie'=>$idCategorie],[]);

        return $this->render('occasions/exemplaireByCategorie.html.twig', [
            'occasions' => $exemplaireByCategorie,
            'categorieList' => $this->navCategorie->categorie(),
            'marqueList' => $this->navMarque->marque(),
            'categorie' => $categorieLibelle,
            'typeList' => $this->navType->type(),
        ]);
    }

    #[Route('/occasions/type/{id}', name: 'app_occcasions_type_show')]
    public function ocassionsByType(int $id, ExemplaireRepository $exemplaireRepository, TypeRepository $typeRepository):Response
    {
        $idType = $typeRepository->find($id);
        $typeLibelle = $typeRepository->findOneBy(['id'=>$idType],[]);
        $exemplaireByType = $exemplaireRepository->findBy(['type'=>$idType],[]);

        return $this->render('occasions/exemplaireByType.html.twig', [
            'occasions' => $exemplaireByType,
            'categorieList' => $this->navCategorie->categorie(),
            'marqueList' => $this->navMarque->marque(),
            'typeList' => $this->navType->type(),
            'type' => $typeLibelle,
            
        ]);
    }

    #[Route('/occasions/marque/{id}', name: 'app_occcasions_marque_show')]
    public function ocassionsByMarque(int $id, ExemplaireRepository $exemplaireRepository, MarqueRepository $marqueRepository):Response
    {
        $idMarque = $marqueRepository->find($id);
        $marqueNom = $marqueRepository->findOneBy(['id'=>$idMarque],[]);
        $exemplaireByMarque = $exemplaireRepository->findBy(['marque'=>$idMarque],[]);

        return $this->render('occasions/exemplaireByMarque.html.twig', [
            'occasions' => $exemplaireByMarque,
            'marqueList' => $this->navMarque->marque(),
            'categorieList' => $this->navCategorie->categorie(),
            'typeList' => $this->navType->type(),
            'marque' => $marqueNom,
            
        ]);
    }
}