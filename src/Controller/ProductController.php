<?php
namespace App\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use App\Entity\Product;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Repository\ProductRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Dto\FileDto;
use App\Form\CommentFileType;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\CommentFile;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Manager\CommentManager;

class ProductController
{
    public function addProduct(
        Environment $twig, 
        FormFactoryInterface $factory, 
        Request $request,
        ObjectManager $manager,
        SessionInterface $session,
        UrlGeneratorInterface $urlGenerator
    ) {
        $product = new Product();
        $builder = $factory->createBuilder(FormType::class, $product);
        $builder->add(
                'name',
                TextType::class,
                [
                    'label' => 'FORM.PRODUCT.NAME',
                    'attr' => [
                        'placeholder' => 'FORM.PRODUCT.PLACEHOLDER.NAME'
                    ]
                ]
            )->add(
                'description', 
                TextareaType::class,
                [
                    'required' => false,
                    'label' => 'FORM.PRODUCT.DESCRIPTION',
                    'attr' => [
                        'placeholder' => 'FORM.PRODUCT.PLACEHOLDER.DESCRIPTION'
                    ]
                ]
            )
            ->add(
                'version',
                TextType::class,
                [
                    'label' => 'FORM.PRODUCT.VERSION',
                    'attr' => [
                        'placeholder' => 'FORM.PRODUCT.PLACEHOLDER.VERSION'
                    ]
                ]
            )->add(
                'submit', 
                SubmitType::class,
                [
                    'label' => 'FORM.PRODUCT.SUBMIT',
                    'attr' => [
                        'class' => 'btn-block btn-success'
                    ]
                ]
            );
        
        $form = $builder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($product);
            $manager->flush();
            
            $session->getFlashBag()->add('info', 'Your product was created');
            
            return new RedirectResponse($urlGenerator->generate('homepage'));
        }

        return new Response(
            $twig->render(
                'Product/addProduct.html.twig',
                [
                    'formular' => $form->createView()
                ]
            )
        );
    }
    
    public function listProduct(Environment $twig, ProductRepository $repository)
    {
        return new Response(
            $twig->render(
                'Product/listProducts.html.twig',
                [
                    'products' => $repository->findAll()
                ]
            )
        );
    }
    
    public function displayProduct(
        Environment $twig, 
        ProductRepository $repository,
        int $product,
        UrlGeneratorInterface $urlGenerator,
        CommentManager $commentManager, 
        Request $request
    ) {
        $product = $repository->find($product);
        if (!$product) {
            throw new NotFoundHttpException();
        }
        
        $comment = new Comment();
        $form = $commentManager->getBaseForm($comment);
        $commentManager->handleRequest($form, $request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $commentManager->processForm($comment, $product);
            
            return new RedirectResponse($urlGenerator->generate('product', ['product' => $product->getId()]));
        }
        
        return new Response(
            $twig->render(
                'Product/product.html.twig',
                [
                    'product' => $product,
                    'routeAttr' => ['product' => $product->getId()],
                    'form' => $form->createView()
                ]
            )
        );
    }
}

