<?php

namespace App\Controller\Api;


use JMS\Serializer\SerializerInterface;
use App\Repository\ExemplaireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    #[Route(path:'api/products', name:"api_products_index", methods:['GET'])]
    public function index(ExemplaireRepository $exemplaireRepository, SerializerInterface $serializer):JsonResponse
    {
        $exemplaires = $exemplaireRepository->findAll();
        $jsonExamplaires = $serializer->serialize($exemplaires,'json');

        return new JsonResponse($jsonExamplaires, Response::HTTP_OK,[],true);

    }

    #[Route(path:'api/productsby', name:"api_productsby_index", methods:['GET'])]
    public function productsBy(ExemplaireRepository $exemplaireRepository, SerializerInterface $serializer, PaginatorInterface $paginator, Request $request):JsonResponse
    {
        $exemplaires = $exemplaireRepository->findBy([],[]);
        $exemplairesPager = $paginator->paginate(
            $exemplaires,
            $request->query->getInt('page',1),3
        );

        $data = [];
        foreach ($exemplairesPager->getItems() as $key=>$value){
            $dataItem = [
                'exemplaires'=>$value
            ];
            $data[] = $dataItem;
        }

        $getData = [
            'data' => $data,
            'curent_page_number'=>$exemplairesPager->getCurrentPageNumber(),
            'number_per_page'=>$exemplairesPager->getItemNumberPerPage(),
            'total_count'=>$exemplairesPager->getTotalItemCount()
        ];

        
        $jsonExamplaires = $serializer->serialize($getData,'json');

        return new JsonResponse($jsonExamplaires, Response::HTTP_OK,[],true);

    }

    #[Route(path:'api/products/{id}', name:"api_product_show", methods:['GET'])]
    public function showProduct(int $id, ExemplaireRepository $exemplaireRepository, SerializerInterface $serializer):JsonResponse
    {
        $exemplaires = $exemplaireRepository->find($id);
        $jsonExamplaires = $serializer->serialize($exemplaires,'json');

        return new JsonResponse($jsonExamplaires, Response::HTTP_OK,[],true);

    }

    //#[Route(path:'api/products/{id}', name:"api_product_show", methods:['GET'])]
   //public function showProduct(int $id, ExemplaireRepository $exemplaireRepository, SerializerInterface $serializer):JsonResponse
    //{
    //    $exemplaires = $exemplaireRepository->findAll();
    //    $jsonExamplaires = $serializer->serialize($exemplaires,'json');

    //    return new JsonResponse($jsonExamplaires, Response::HTTP_OK,[],true);

    //}
}