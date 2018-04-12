<?php
namespace PM\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductForm;

class ApiController extends Controller
{
    public function getProducts()
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $products = $repo->findAll();
        
        return new JsonResponse(
            $this->get('serializer')->serialize(
                $products,
                'json',
                ['groups' => $this->getParameter('pm_api_groups')]
            ),
            200,
            [],
            true
        );
    }
    
    public function postProduct(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductForm::class, $product);
        
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();
            
            return new JsonResponse(
                $this->get('serializer')->serialize(
                    $product,
                    'json',
                    ['groups' => $this->getParameter('pm_api_groups')]
                    ),
                200,
                [],
                true
            );
        }
        
        return $this->json(['message' => 'nok']);
    }
}









