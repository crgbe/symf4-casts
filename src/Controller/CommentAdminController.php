<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN_COMMENT")
 */
class CommentAdminController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="comment_admin")
     */
    public function index(CommentRepository $commentRepository, Request $request, PaginatorInterface $paginator)
    {
//        You can either use this, or the annotation form @IsGranted("ROLE_ADMIN")
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');

//        $q = $request->query->get('q');
//        $comments = $commentRepository->findBy([], ['createdAt' => 'DESC']);
//        if($request->query->get('q')){
//            $comments = $commentRepository->findAllWithSearch($request->query->get('q'));
//        }

        $pagination = $paginator->paginate(
            $commentRepository->getQueryBuilderWithSearch($request->query->get('q')), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('comment_admin/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
