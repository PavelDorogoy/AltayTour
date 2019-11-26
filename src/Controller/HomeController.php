<?php

namespace App\Controller;

use App\Entity\Tour;
use App\Entity\TouristRoute;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(UserPasswordEncoderInterface $passwordEncoder)
    {
        $repositoryInstructors = $this->getDoctrine()->getRepository(User::class);
        $instructors = $repositoryInstructors->findUsersByRole("INSTRUCTOR");

        $repositoryTour = $this->getDoctrine()->getRepository(Tour::class);
        $repositoryTouristRoute = $this->getDoctrine()->getRepository(TouristRoute::class);
        $touristRoutes = $repositoryTouristRoute->findBy(array(),null,5,null);
        $tours =  $repositoryTour->findCurrent();
        $routeTours = [];
        foreach ($tours as $tour) {
            $tourId = $tour->getId();
            $routId = $tour->getRoute()->getId();
            $tourDate = $tour->getDate();
            $tourPrice = $tour->getPrice();

            $routeTours[$routId]['tours'][$tourId] = array('date' => $tourDate, 'price' => $tourPrice);

            if(empty($routeTours[$routId]['minPrice'])) $routeTours[$routId]['minPrice'] = $tourPrice;
            else if ($tourPrice < $routeTours[$routId]['minPrice']) $routeTours[$routId]['minPrice'] = $tourPrice;

            if(empty($routeTours[$routId]['minDate'])) $routeTours[$routId]['minDate'] = $tourDate;
            else if ($tourDate < $routeTours[$routId]['minDate']) $routeTours[$routId]['minDate'] = $tourDate;

            if(empty($routeTours[$routId]['logo'])) $routeTours[$routId]['logo'] = $tour->getRoute()->getLogo();
            if(empty($routeTours[$routId]['name'])) $routeTours[$routId]['name'] = $tour->getRoute()->getName();
            if(empty($routeTours[$routId]['days'])) $routeTours[$routId]['days'] = $tour->getRoute()->getDays();
            if(empty($routeTours[$routId]['distance'])) $routeTours[$routId]['distance'] = $tour->getRoute()->getDistance();
            if(empty($routeTours[$routId]['annotation'])) $routeTours[$routId]['annotation'] = $tour->getRoute()->getAnnotation();
        }
        foreach ($routeTours as $key => $routeTour) {
            $routeTours[$key]['minDate'] = $routeTours[$key]['minDate']->format('d.m.y');
        }
        $routeTours = array_slice($routeTours, 0, 5, TRUE);

        return $this->render("index.html.twig",[
            'tourist_routes' => $routeTours,
            'instructors' => $instructors
        ]);
    }

}
