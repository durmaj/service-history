<?php


namespace HistoryBundle\Controller;

use HistoryBundle\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use HistoryBundle\Form\CommentType;
use HistoryBundle\Entity\Comment;
use HistoryBundle\Controller\CommentController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

/**
 * Service controller.
 *
 * @Route("service")
 */
class ServiceController extends Controller
{
    /**
     * Lists all service entities.
     *
     * @Route("/", name="service_index")
     */
    public function indexAction(Request $request)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();

            $services = $em->getRepository('HistoryBundle:Service')->findAll();


            //new comment form
            $newComment = new Comment();
            $commentForm = $this->createForm('HistoryBundle\Form\CommentType', $newComment)->add('service');
            $commentForm->handleRequest($request);

            if ($commentForm->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($newComment);
                $em->flush();

                return $this->redirectToRoute('service_index');
            }


            return $this->render('service/index.html.twig', array(
                'services' => $services, 'commentForm' => $commentForm->createView()
            ));

        } else {
            return $this->redirectToRoute('car_index');
        }
    }

    /**
     * Lists all service entities for a single car.
     *
     * @Route("/car/{id}/{pdf}", defaults={"pdf": 0}, name="service_car")
     */
    public function servicesForOneCar(Request $request, $id, $pdf)
    {
        $em = $this->getDoctrine()->getManager();

        $car = $em->getRepository('HistoryBundle:Car')->findOneById($id);


        if ($user = $this->get('security.token_storage')->getToken()->getUser() == $car->getUser() || $this->isGranted('ROLE_ADMIN')) {

            $services = $em->getRepository('HistoryBundle:Service')->findByCar($id);

            //new comment form
            $newComment = new Comment();
            $commentForm = $this->createForm('HistoryBundle\Form\CommentType', $newComment)->add('service');
            $commentForm->handleRequest($request);

            if ($commentForm->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($newComment);
                $em->flush();

                return $this->redirectToRoute('service_car');
            }


            if ($pdf == 0){
                return
                $this->render('service/services_for_car.html.twig', array(
                'services' => $services,
                'commentForm' => $commentForm->createView(),
                'car' => $id
            ));} elseif ($pdf ==1) {
                $html = $this->render('service/services_for_car.html.twig', array(
                    'services' => $services,
                    'commentForm' => $commentForm->createView(),
                    'car' => $id
                ));

                return new PdfResponse(
                    $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
                    'file.pdf'
                );

            }


        }else {
            return $this->redirectToRoute('history_default_index');
        }
    }


    /**
     * Creates a new service entity.
     *
     * @Route("/new/{id}", name="service_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        if ($this->isGranted('ROLE_USER')) {

            $service = new Service();
            $form = $this->createForm('HistoryBundle\Form\ServiceType', $service);
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();

            $car = $em->getRepository('HistoryBundle:Car')->findOneById($id);


            if ($form->isSubmitted() && $form->isValid()) {
                $service->setCar($car);
                $em->persist($service);
                $em->flush();

                return $this->redirectToRoute('service_show', array('id' => $service->getId()));
            }

            return $this->render('service/new.html.twig', array(
                'service' => $service,
                'form' => $form->createView(),
                'id' => $id
            ));
        } else {
            return $this->redirectToRoute('history_default_index');
        }
    }

    /**
     * Finds and displays a service entity.
     *
     * @Route("/{id}", name="service_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Service $service, Request $request)
    {

        $car = $service->getCar();

        if ($user = $this->get('security.token_storage')->getToken()->getUser() == $car->getUser() || $this->isGranted('ROLE_ADMIN')) {

            $deleteForm = $this->createDeleteForm($service);

            //new comment form
            $newComment = new Comment();
            $newComment->setService($service);
            $commentForm = $this->createForm('HistoryBundle\Form\CommentType', $newComment);
            $commentForm->handleRequest($request);

            if ($commentForm->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($newComment);
                $em->flush();

                return $this->redirectToRoute('service_show', array('id' => $service->getId()));
            }


            return $this->render('service/show.html.twig', array(
                'service' => $service,
                'delete_form' => $deleteForm->createView(),
                'commentForm' => $commentForm->createView(),
            ));
        } else {
            return $this->redirectToRoute('history_default_index');
        }
    }

    /**
     * Displays a form to edit an existing service entity.
     *
     * @Route("/{id}/edit", name="service_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Service $service)
    {
        $car = $service->getCar();

        if ($user = $this->get('security.token_storage')->getToken()->getUser() == $car->getUser() || $this->isGranted('ROLE_ADMIN')) {

            $deleteForm = $this->createDeleteForm($service);

            $editForm = $this->createForm('HistoryBundle\Form\ServiceType', $service);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('service_edit', array('id' => $service->getId()));
            }

            return $this->render('service/edit.html.twig', array(
                'service' => $service,
                'form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->redirectToRoute('history_default_index');
        }
    }

    /**
     * Deletes a service entity.
     *
     * @Route("/{id}", name="service_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Service $service)
    {
        $car = $service->getCar();

        if ($user = $this->get('security.token_storage')->getToken()->getUser() == $car->getUser() || $this->isGranted('ROLE_ADMIN')) {
            $form = $this->createDeleteForm($service);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($service);
                $em->flush();
            }

            return $this->redirectToRoute('service_index');
        } else {
            return $this->redirectToRoute('history_default_index');
        }
    }

    /**
     * Creates a form to delete a service entity.
     *
     * @param Service $service The service entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Service $service)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('service_delete', array('id' => $service->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
