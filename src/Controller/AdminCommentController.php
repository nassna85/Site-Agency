<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\AdminCommentType;
use App\Repository\CommentsRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments", name="admin_comments_index")
     * @IsGranted("ROLE_ADMIN")
     * @param CommentsRepository $repo
     * @return Response
     */
    public function index(CommentsRepository $repo)
    {
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $repo->findAll()
        ]);
    }

    /**
     * Edit comment
     * @Route("/admin/comment/{id}/edit", name="admin_comments_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param Comments $comment
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Comments $comment, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(AdminCommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le message a bien été modifié."
            );

            return $this->redirectToRoute('admin_comments_index');
        }


        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView()
        ]);
    }

    /**
     * Delete comment
     * @Route("/admin/comment/{id}/delete", name="admin_comments_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param Comments $comment
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Comments $comment, ObjectManager $manager)
    {
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le commentaire a bien été supprimé"
        );

        return $this->redirectToRoute('admin_comments_index');
    }
}
