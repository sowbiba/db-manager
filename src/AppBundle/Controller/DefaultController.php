<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 09/04/16
 * Time: 16:33
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Source;
use AppBundle\Form\Type\SourcesType;
use AppBundle\Tools\Connections\SourceConnectionTester;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/operations", name="operations")
     */
    public function listAction(Request $request)
    {
//        $sources = $this->get('app.manager.sources')->findAll();
//        $targets = $this->get('app.manager.targets')->findAll();

        return $this->render('AppBundle:operations:home.html.twig', array());
    }

    /**
     * @Route("/operations/data", name="operations_data")
     */
    public function dataAction(Request $request)
    {
        return new JsonResponse([
            'sources' => $this->get('app.manager.sources')->findAll(),
            'targets' => $this->get('app.manager.targets')->findAll(),
        ]);
    }
} 