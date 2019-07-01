<?php

namespace App\Controller;

use App\Repository\PropertiesRepository;
use App\Services\Stats;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     * @IsGranted("ROLE_ADMIN")
     * @param Stats $stats
     * @param PropertiesRepository $repo
     * @return Response
     */
    public function index(Stats $stats, PropertiesRepository $repo)
    {
        $properties = $stats->getPropertiesCount();
        $users = $stats->getUserCount();
        $contactProperty = $stats->getContactPropertyCount();
        $contacts = $stats->getContactCount();
        $comments = $stats->getCommentCount();
        $propertiesNoApprovedCount = $stats->getPropertiesNoApprovedCount();
        $commentsNoApprovedCount = $stats->getCommentsNoApprovedCount();
        $contactPropertyNoAnsweredCount = $stats->getContactPropertyNoAnsweredCount();

        $lastProperties = $repo->findLastProperties(5, 1);

        $oldProperties = $repo->findOldProperties(5);

        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('properties', 'users', 'contactProperty', 'contacts', 'comments', 'propertiesNoApprovedCount', 'commentsNoApprovedCount', 'contactPropertyNoAnsweredCount'),
            'lastProperties' => $lastProperties,
            'oldProperties' => $oldProperties,
        ]);
    }
}
