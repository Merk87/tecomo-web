<?php

namespace Tecomo\LandingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Tecomo\LandingBundle\Form\ContactType;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new ContactType());

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $message = \Swift_Message::newInstance()
                    ->setContentType('text/html')
                    ->setSubject($form->get('Asunto')->getData())
                    ->setFrom($form->get('Email')->getData())
                    ->setTo('marketing@tecomostudios.com')
                    ->setBody(
                        $this->renderView(
                            'TecomoLandingBundle:MailTemplates:contact.html.twig',
                            array(
                                'ip' => $request->getClientIp(),
                                'name' => $form->get('Nombre')->getData(),
                                'message' => $form->get('Mensaje')->getData()
                            )
                        )
                    );
            }
            $this->get('mailer')->send($message);
            $request->getSession()->getFlashBag()->add('notice', '¡Recibido, te contestaremos cuanto antes!');
            $form = $this->createForm(new ContactType());
          }

        return $this->render('TecomoLandingBundle:Default:index.html.twig', array('contactForm' => $form->createView()));
    }
}
