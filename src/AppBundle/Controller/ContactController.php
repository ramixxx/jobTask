<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Gedmo\Sluggable\Util\Urlizer;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ContactController extends Controller
{
    /**
     * @Route("/", name="contact_list")
     * @Method({"GET"})
     */
    public function list(Request $request)
    {
        // $contacts = $this->getDoctrine()
        //     ->getRepository(Contact::class)
        //     ->findAll();
        $em = $this->getDoctrine()->getManager();
        $query = "SELECT c FROM AppBundle:Contact c";
        $contactList = $em->createQuery($query);

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $contactList,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render('contacts/index.html.twig', [
            'contacts' => $result,
        ]);
    }

    /**
     * @Route("/contact/new", name="new_contact")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
      $contact = new Contact();

      $form = $this->createFormBuilder($contact)
        ->add('firstName', TextType::class, array('attr' => array('class' => 'form-control mb-2')))
        ->add('lastName', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('streetAndNumber', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('zip', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('city', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('country', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('phoneNumber', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('birthday', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('email', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('picture', FileType::class, array('data_class' => null))
        ->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary mt-3 mb-3')))
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
        $contact = $form->getData();

        $uploadedFile = $form['picture']->getData();
        if ($uploadedFile) {
            $destination = $this->getParameter('kernel.project_dir').'/web/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = rand(1, 99999).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $contact->setPicture($newFilename);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($contact);
        $entityManager->flush();

        return $this->redirectToRoute('contact_list');
      }

      return $this->render('contacts/new.html.twig', array(
        'form' => $form->createView()
      ));
    }

    /**
     * @Route("/contact/edit/{id}", name="edit_contact")
     * Method({"GET", "POST"})
     */
    public function edit(Contact $contact, Request $request, $id) {
      $contact = new Contact();
      $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

      $form = $this->createFormBuilder($contact)
        ->add('firstName', TextType::class, array('attr' => array('class' => 'form-control mb-2')))
        ->add('lastName', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('streetAndNumber', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('zip', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('city', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('country', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('phoneNumber', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('birthday', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('email', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control mb-2')))
        ->add('picture', FileType::class, array('data_class' => null))
        ->add('save', SubmitType::class, array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary mt-3 mb-3')))
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $form['picture']->getData();
        if ($uploadedFile) {
            $destination = $this->getParameter('kernel.project_dir').'/web/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = rand(1, 99999).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $contact->setPicture($newFilename);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('contact_list');
      }

      return $this->render('contacts/edit.html.twig', array(
        'form' => $form->createView()
      ));
    }

    /**
     * @Route("/contact/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
      $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($contact);
      $entityManager->flush();

      $response = new Response();
      $response->send();
    }
}
