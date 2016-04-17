<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Source;
use AppBundle\Form\Type\SourcesType;
use AppBundle\Tools\Connections\SourceConnection;
use AppBundle\Tools\Connections\TargetConnection;
use AppBundle\Tools\Tasks\MysqlTasks;
use AppBundle\Tools\Tasks\SshTasks;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SourcesController extends Controller
{
    /**
     * @Route("/sources", name="sources_list")
     */
    public function listAction(Request $request)
    {
        $sources = $this->get('app.manager.sources')->findAll();

        return $this->render('AppBundle:sources:list.html.twig', array(
            'sources' => $sources
        ));
    }

    /**
     * @Route("/sources/add", name="sources_add")
     */
    public function addAction(Request $request)
    {
        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->clear();

        //var_dump(SourcesType::class);
        $form = $this->createForm('AppBundle\Form\Type\SourcesType');

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /**
                 * @var Source $source
                 */
                $source = $form->getData();
                if (! $this->get('app.manager.sources')->save($source)) {
                    $flashBag->add('error', 'Une erreur s\'est produite lors de la sauvegarde. Veuillez contacter un administrateur.');
                } else {
                    $flashBag->add('success', 'La source a bien été sauvegardée.');
                }
            } else {
                $flashBag->add('error', 'Le formulaire n\'est pas valide. Veuillez vérifier les valeurs rentrées.');
            }

            return $this->redirectToRoute('sources_list');
        }

        return $this->render('AppBundle:sources:form.html.twig', array(
            'form' => $form->createView(),
            'edit' => false
        ));
    }

    /**
     * @Route("/sources/edit/{id}", name="sources_edit")
     *
     * @ParamConverter("source", class="AppBundle:Source", )
     */
    public function editAction(Request $request, Source $source)
    {
        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->clear();

        $form = $this->createForm("AppBundle\Form\Type\SourcesType", $source);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /**
                 * @var Source $source
                 */
                $source = $form->getData();

                if (! $this->get('app.manager.sources')->save($source)) {
                    $flashBag->add('error', 'Une erreur s\'est produite lors de la sauvegarde. Veuillez contacter un administrateur.');
                } else {
                    $flashBag->add('success', 'La source a bien été sauvegardée.');
                }
            } else {
                $flashBag->add('error', 'Le formulaire n\'est pas valide. Veuillez vérifier les valeurs rentrées.');
            }

            return $this->redirectToRoute('sources_list');
        }

        return $this->render('AppBundle:sources:form.html.twig', array(
            'form' => $form->createView(),
            'edit' => true
        ));
    }

    /**
     * @Route("/sources/delete/{id}", name="sources_delete")
     *
     * @ParamConverter("source", class="AppBundle:Source")
     */
    public function deleteAction(Request $request, Source $source)
    {
        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->clear();

        $sourceName = $source->getName();

        if (! $this->get('app.manager.sources')->delete($source)) {
            $flashBag->add('error', 'Une erreur s\'est produite lors de la suppression de la source. Veuillez contacter un administrateur.');
        }

        $flashBag->add('success', sprintf('La source [ %s ] a bien été supprimée.', $sourceName));

        return $this->redirectToRoute('sources_list');
    }

    /**
     * @Route("/sources/test/{id}", name="sources_test")
     *
     * @ParamConverter("source", class="AppBundle:Source")
     */
    public function testAction(Request $request, Source $source)
    {
        try {
            $connectionTester = new SourceConnection();
            $connectionTester->testConnection($source);

            $sshTask = new SshTasks($connectionTester->getSshConnection($source));
            $sshTask->transferFile($source->getFilepath(), 'toto1.sql');

            $target = $this->get('app.manager.targets')->find(1);
            $targetConnection = new TargetConnection();
            $conn = $targetConnection->getConnection($target);
            $mysqlTask = new MysqlTasks($conn);
            $mysqlTask->import('/tmp/toto1.sql', 'toto');
        } catch(\Exception $e) {
            var_dump($e->getMessage());die();
        }

        return $this->render('AppBundle:sources:test.html.twig', array(
            'result' =>  nl2br($connectionTester->getMessages())
        ));
    }

    /**
     * @Route("/source/data/{id}", name="source_data", options={"expose": true})
     *
     * @ParamConverter("source", class="AppBundle:Source")
     */
    public function dataAction(Request $request, Source $source)
    {
        $connection = new SourceConnection();
        $content = $connection->getContent($source);

        return new JsonResponse([
            'success' => false !== $content,
            'response' => false === $content ? [] : ['files' => $content]
        ]);
    }
}
