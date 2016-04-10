<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Target;
use AppBundle\Form\Type\TargetsType;
use AppBundle\Tools\Connections\TargetConnectionTester;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TargetsController extends Controller
{
    /**
     * @Route("/targets", name="targets_list")
     */
    public function listAction(Request $request)
    {
        $targets = $this->get('app.manager.targets')->findAll();

        return $this->render('AppBundle:targets:list.html.twig', array(
            'targets' => $targets
        ));
    }

    /**
     * @Route("/targets/add", name="targets_add")
     */
    public function addAction(Request $request)
    {
        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->clear();

        $form = $this->createForm(TargetsType::class);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /**
                 * @var Target $target
                 */
                $target = $form->getData();
                if (! $this->get('app.manager.targets')->save($target)) {
                    $flashBag->add('error', 'Une erreur s\'est produite lors de la sauvegarde. Veuillez contacter un administrateur.');
                } else {
                    $flashBag->add('success', 'La cible a bien été sauvegardée.');
                }
            } else {
                $flashBag->add('error', 'Le formulaire n\'est pas valide. Veuillez vérifier les valeurs rentrées.');
            }

            return $this->redirectToRoute('targets_list');
        }

        return $this->render('AppBundle:targets:form.html.twig', array(
            'form' => $form->createView(),
            'edit' => false
        ));
    }

    /**
     * @Route("/targets/edit/{id}", name="targets_edit")
     *
     * @ParamConverter("target", class="AppBundle:Target", )
     */
    public function editAction(Request $request, Target $target)
    {
        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->clear();

        $form = $this->createForm(TargetsType::class, $target);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /**
                 * @var Target $target
                 */
                $target = $form->getData();

                if (! $this->get('app.manager.targets')->save($target)) {
                    $flashBag->add('error', 'Une erreur s\'est produite lors de la sauvegarde. Veuillez contacter un administrateur.');
                } else {
                    $flashBag->add('success', 'La cible a bien été sauvegardée.');
                }
            } else {
                $flashBag->add('error', 'Le formulaire n\'est pas valide. Veuillez vérifier les valeurs rentrées.');
            }

            return $this->redirectToRoute('targets_list');
        }

        return $this->render('AppBundle:targets:form.html.twig', array(
            'form' => $form->createView(),
            'edit' => true
        ));
    }

    /**
     * @Route("/targets/delete/{id}", name="targets_delete")
     *
     * @ParamConverter("target", class="AppBundle:Target")
     */
    public function deleteAction(Request $request, Target $target)
    {
        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->clear();

        $targetName = $target->getName();

        if (! $this->get('app.manager.targets')->delete($target)) {
            $flashBag->add('error', 'Une erreur s\'est produite lors de la suppression de la source. Veuillez contacter un administrateur.');
        }

        $flashBag->add('success', sprintf('La cible [ %s ] a bien été supprimée.', $targetName));

        return $this->redirectToRoute('targets_list');
    }

    /**
     * @Route("/targets/test/{id}", name="targets_test")
     *
     * @ParamConverter("target", class="AppBundle:Target")
     */
    public function testAction(Request $request, Target $target)
    {
        try {
            $connectionTester = new TargetConnectionTester();
            $connectionTester->testConnection($target);
        } catch(\Exception $e) {
            var_dump($e->getMessage());die();
        }

        return $this->render('AppBundle:targets:test.html.twig', array(
            'result' =>  nl2br($connectionTester->getMessages())
        ));
    }
}
