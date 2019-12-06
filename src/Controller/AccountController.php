<?php

namespace App\Controller;

use App\Entity\EquipmentReservation;
use App\Entity\Tour;
use App\Entity\TourReservation;
use App\Entity\User;
use App\Form\UserChangeType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     * @throws \Exception
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, FileUploader $fileUploader)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw $this->createNotFoundException('Вы не авторизованы');
        }
        $curUser = $this->getUser();
        $user = new User;

        //form section
        $user->setName($curUser->getName());
        $user->setPhone($curUser->getPhone());
        $form = $this->createForm(UserChangeType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            if($form->get("plainPassword")->isValid()) {
                $password = $user->getPlainPassword();
                if(!empty($password)) {
                    $password = $passwordEncoder->encodePassword($user, $password);
                    $curUser->setPassword($password);
                }
            }
            if($form->get("image")->isValid()) {
                $image = $user->getImage();
                if(!empty($image)) {
                    $filesystem = new Filesystem();
                    $path = $this->getParameter('kernel.project_dir')."/public".$curUser->getPhoto();
                    $filesystem->remove($path);

                    $pathPackage = new PathPackage('/uploads', new EmptyVersionStrategy());
                    $imageFileName = $fileUploader->upload($image);
                    $curUser->setPhoto($pathPackage->getUrl($imageFileName));
                }
            }
            if($form->get("name")->isValid()) {
                $curUser->setName($user->getName());
            }
            if($form->get("phone")->isValid()) {
                $curUser->setPhone($user->getPhone());
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($curUser);
            $em->flush();
        }

        //tour section
        $em = $this->getDoctrine()->getManager();
        $repositoryTour = $em->getRepository(Tour::class);
        $repositoryTourReservation = $em->getRepository(TourReservation::class);
        $repositoryEquipmentReservation = $em->getRepository(EquipmentReservation::class);

        $reservations = null;
        $equipmentReservations = null;
        $instructorsTours = null;
        if($this->isGranted('ROLE_USER')) {
            $reservations = $repositoryTourReservation->findBy(['user' => $curUser->getID()]);
            $equipmentReservations = $repositoryEquipmentReservation->findBy(['reservation_tour' => $reservations]);
        }
        if($this->isGranted('ROLE_INSTRUCTOR')) {
            $instructorsTours = $repositoryTour->findCurrentByInstructor($curUser->getID());
        }

        return $this->render(
            'account/index.html.twig', [
                'form' => $form->createView(),
                'reservations' => $reservations,
                'equipment_reservations' => $equipmentReservations,
                'instructors_tours' => $instructorsTours
            ]
        );
    }
}
