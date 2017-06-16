<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
        $form    = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted()) {

            if ($form->isValid()) {
                $data = $form->getData();
                $em->persist($data);
                $em->flush();

                return $this->redirect("/");
            }else
                return new Response('error');
        }

        return $this->render('AppBundle:Main:index.html.twig', [
            'form'      => $form->createView(),
            'comments'  => $comments
        ]);
    }

    /**
     * @route("/comment/add", name="add_comment")
     * @Method("POST")
     */
    function addAction(Request $request)
    {
        $em      = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $comment->setOwner($request->request->get('owner'));
        $comment->setEmail($request->request->get('email'));
        $comment->setMsg($request->request->get('msg'));

        $em->persist($comment);
        $em->flush();

        return new Response($comment->getId());
    }

    /**
     * @route("/comment/del", name="del_comment")
     * @Method("POST")
     */
    function deleteAction(Request $request)
    {
        $commentId  = $request->request->get('commentId');
        $em         = $this->getDoctrine()->getManager();
        $comment    = $em->getRepository('AppBundle:Comment')->find((int)$commentId);

        if($comment){
            $em->remove($comment);
            $em->flush();
        }
        return new Response('ok');
    }
}
