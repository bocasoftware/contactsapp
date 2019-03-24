<?php
/**
 * Created by PhpStorm.
 * User: WunderGalley
 * Date: 3/15/2019
 * Time: 6:12 PM
 */

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\File\File;





class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     * Method({"GET"})
     */
    public function homepage()
    {
       // return new Response('page');

        $names = $this->getDoctrine()->getRepository(Contact::class)->findAll();

        return $this->render('article/show.html.twig', array('names' => $names));
    }










/**
 * @Route ("/article/add" , name="add_new_contact")
 * Method({"GET","POST"})
 */
public function new (Request $request){

    $contact = new Contact();

    $form =$this->createFormBuilder($contact)
        ->add('picture', FileType::class, [ 'label' => 'Add Profile picture (jpg file)'])

        ->add('firstname', TextType::class, array('attr'=>
            array('class' => 'form-control'))
        )

        ->add('lastname', TextType::class, array
            ('attr'=> array('class' => 'form-control'))
        )
        ->add('street', TextType::class, array('attr'=>
            array('class' => 'form-control'))
        )
        ->add('zip', TextType::class, array('attr'=>
            array('class' => 'form-control'))
        )
        ->add('city', TextType::class, array('attr'=>
            array('class' => 'form-control'))
        )
        ->add('country', TextType::class, array('attr'=>
            array('class' => 'form-control'))
        )
        ->add('phonenumber', TextType::class, array('attr'=>
            array('class' => 'form-control'))
        )
        ->add('birthday', TextType::class, array('attr'=>
            array('class' => 'form-control'))
        )
        ->add('email', TextType::class, array('attr'=>
            array('class' => 'form-control'))
        )
        ->add('save', SubmitType::class, array( 'label' => '+ Add contact',
            'attr' => array('class'=>'btn btn-primary mt-3')))
        ->getForm();


    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){


        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $contact->getPicture();

        $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

        try {

            $file->move(
                $this->getParameter('images_directory'),
                $fileName

            );
        }catch (FileException $e){

        }

        $contact->setPicture($fileName);



        $contact = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($contact);
        $entityManager->flush();

        return $this->redirect('/');
    }

    return $this->render('article/new.html.twig', array(
        'form' => $form->createView()
    ));


}











    /**
     * @Route("/contact/{id}",name="contact_edit")
     *Method({"GET","POST"})
     */
    public function change (Request $request,$id){


        $contact = new Contact();
        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

        $form =$this->createFormBuilder($contact)
            ->add('picture', FileType::class, [ 'label' => 'Change Profile picture (jpg file)', "data_class"=> null])

            ->add('firstname', TextType::class, array('attr'=>
                    array('class' => 'form-control', "data_class"=> null))
            )

            ->add('lastname', TextType::class, array
                ('attr'=> array('class' => 'form-control', "data_class"=> null))
            )
            ->add('street', TextType::class, array('attr'=>
                    array('class' => 'form-control', "data_class"=> null))
            )
            ->add('zip', TextType::class, array('attr'=>
                    array('class' => 'form-control', "data_class"=> null))
            )
            ->add('city', TextType::class, array('attr'=>
                    array('class' => 'form-control', "data_class"=> null))
            )
            ->add('country', TextType::class, array('attr'=>
                    array('class' => 'form-control', "data_class"=> null))
            )
            ->add('phonenumber', TextType::class, array('attr'=>
                    array('class' => 'form-control', "data_class"=> null))
            )
            ->add('birthday', TextType::class, array('attr'=>
                    array('class' => 'form-control', "data_class"=> null))
            )
            ->add('email', TextType::class, array('attr'=>
                    array('class' => 'form-control', "data_class"=> null))
            )
            ->add('save', SubmitType::class, array( 'label' => 'Save Changes',
                'attr' => array('class'=>'btn btn-success mt-3')))
            ->getForm();



        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $contact->getPicture();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            try {

                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName

                );
            }catch (FileException $e){

            }

            $contact->setPicture($fileName);






            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirect('/');
        }

        return $this->render('article/show_contact.html.twig', array(
            'form' => $form->createView(), 'contact' => $contact
        ));



    }



    /**
     * @return string
     */
    private function generateUniqueFileName()
    {

        return md5(uniqid());
    }





    /**
 * @Route("/contact_delete/delete/{id}")
 *Method({"POST","DELETE"})
 */
public function delete(Request $request, $id){

    $contact = $this->getDoctrine()->getRepository
    (Contact::class)->find($id);



    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($contact);
    $entityManager->flush();

    $response = new Response();
    $response->send();



    return $this->render('article/delete_contact.html.twig');



}






}














































