<?php

namespace Application\FormsBundle\Controller;

use Application\FormsBundle\Entity\Category;
use Application\FormsBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            dump($form->getData());
            die();
        }

        return $this->render('ApplicationFormsBundle:Default:index.html.twig',array(
            "form" => $form->createView()
        ));
    }

    public function chatAction(Request $request)
    {
        return $this->render("ApplicationFormsBundle:Default:chat.html.twig");
    }
}
