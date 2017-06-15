<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $comments   = $em->getRepository('AppBundle:Comment')->findAll();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $em->persist($data);
            $em->flush();

            return $this->redirect("/");
        }

        return $this->render('AppBundle:Main:index.html.twig', [
            'form'      => $form->createView(),
            'comments'  => $comments
        ]);
    }
}
