<?php

namespace HistoryBundle\Controller;

use HistoryBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;


/**
 * Car controller.
 *
 * @Route("car")
 */
class CarController extends Controller
{

    /**
     * Lists all car entities for user.
     *
     * @Route("/all", name="car_index_all")
     * @Method("GET")
     */
    public function indexAllAction()
    {
        if ($this->isGranted('ROLE_ADMIN')) {

            $em = $this->getDoctrine()->getManager();


            $cars = $em->getRepository('HistoryBundle:Car')->findAll();

            return $this->render('car/index_admin.html.twig', array(
                'cars' => $cars,
            ));
        } else {
            return $this->redirectToRoute('history_default_index');
        }
    }


    /**
     * Lists all car entities for user.
     *
     * @Route("/", name="car_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if ($this->isGranted('ROLE_USER')) {

            $em = $this->getDoctrine()->getManager();

            $user = $this->get('security.token_storage')->getToken()->getUser();

            $cars = $em->getRepository('HistoryBundle:Car')->findByUser($user);

            return $this->render('car/index.html.twig', array(
                'cars' => $cars,
            ));
        } else {
            return $this->redirectToRoute('history_default_index');
        }
    }

    /**
     * Creates a new car entity.
     *
     * @Route("/new", name="car_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {

            $car = new Car();
            $form = $this->createForm('HistoryBundle\Form\CarType', $car);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                //setting the logged in user as car owner
                $car->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($car);
                $em->flush();

                return $this->redirectToRoute('car_show', array('id' => $car->getId()));
            }

            return $this->render('car/new.html.twig', array(
                'car' => $car,
                'form' => $form->createView(),
            ));
        } else {
            return $this->redirectToRoute('history_default_index');
        }
    }

    /**
     * Finds and displays a car entity.
     *
     * @Route("/{id}", name="car_show")
     * @Method("GET")
     */
    public function showAction(Car $car)
    {

        if ($user = $this->get('security.token_storage')->getToken()->getUser() == $car->getUser() || $this->isGranted('ROLE_ADMIN')) {

            $deleteForm = $this->createDeleteForm($car);

            return $this->render('car/show.html.twig', array(
                'car' => $car,
                'delete_form' => $deleteForm->createView(),
            ));

        } else {
            return $this->redirectToRoute('history_default_index');
        }
    }

    /**
     * Displays a form to edit an existing car entity.
     *
     * @Route("/{id}/edit", name="car_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Car $car)
    {
        if ($user = $this->get('security.token_storage')->getToken()->getUser() == $car->getUser() || $this->isGranted('ROLE_ADMIN')) {

            $deleteForm = $this->createDeleteForm($car);
            $editForm = $this->createForm('HistoryBundle\Form\CarType', $car);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('car_edit', array('id' => $car->getId()));
            }

            return $this->render('car/edit.html.twig', array(
                'car' => $car,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        } else {
            return $this->redirectToRoute('history_default_index');
        }
    }

    /**
     * Deletes a car entity.
     *
     * @Route("/{id}", name="car_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Car $car)
    {
        if ($user = $this->get('security.token_storage')->getToken()->getUser() == $car->getUser() || $this->isGranted('ROLE_ADMIN')) {

            $form = $this->createDeleteForm($car);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($car);
                $em->flush();
            }

            return $this->redirectToRoute('car_index');

        }else {
            return $this->redirectToRoute('history_default_index');
        }
    }

    /**
     * Creates a form to delete a car entity.
     *
     * @param Car $car The car entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Car $car)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('car_delete', array('id' => $car->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
