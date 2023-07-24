<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            
            $message = (new Email())
                ->priority(Email::PRIORITY_HIGH)
                ->from($contactFormData['email'])
                ->to('test@gmail.com')
                ->subject('Formulaire contact V. Parrot')
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
                        // some error prevented the email sending; display an
                        // error message or try to resend the message

            }

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'contact_form' => $form->createView()
        ]);
    }
}
