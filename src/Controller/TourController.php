<?php

namespace App\Controller;

use App\Entity\Tour;
use App\Entity\TouristRouteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TourController extends AbstractController
{
    /**
     * @Route("/tours", name="tours")
     */
    public function index(Request $request)
    {
        $typeFilter = $request->get('type');
        $seasonFilter = $request->get('season');
        $timeFilter = $request->get('time');
        $priceFilter = $request->get('price');

        $repositoryTour = $this->getDoctrine()->getRepository(Tour::class);
        $tours =  $repositoryTour->findCurrent();
        $routeTours = [];
        foreach ($tours as $tour) {
            $tourId     = $tour->getId();
            $routId     = $tour->getRoute()->getId();
            $routTypeId = $tour->getRoute()->getType()->getId();
            $routDays   = $tour->getRoute()->getDays();
            $tourDate   = $tour->getDate();
            $tourPrice  = $tour->getPrice();

            //filters
            if(($typeFilter !== null) && ($routTypeId != $typeFilter)) continue;
            if($seasonFilter !== null) {
                $tourMonth = $tourDate->format('m');
                if      ($seasonFilter == 1 && !($tourMonth < 3 || $tourMonth == 12) ) continue;
                else if ($seasonFilter == 2 && !($tourMonth >= 3 && $tourMonth < 6)) continue;
                else if ($seasonFilter == 3 && !($tourMonth >= 6 && $tourMonth < 9)) continue;
                else if ($seasonFilter == 4 && !($tourMonth >= 9 && $tourMonth < 12)) continue;
            }
            if($timeFilter !== null) {
                if      ($timeFilter == 1 && $routDays > 5) continue;
                else if ($timeFilter == 2 && ($routDays < 5 || $routDays > 10)) continue;
                else if ($timeFilter == 3 && $routDays < 11) continue;
            }
            if($priceFilter !== null) {
                if      ($priceFilter == 1 && $tourPrice > 10000) continue;
                else if ($priceFilter == 2 && ($tourPrice < 10000 || $tourPrice > 20000)) continue;
                else if ($priceFilter == 3 && ($tourPrice < 20000 || $tourPrice > 30000)) continue;
                else if ($priceFilter == 4 && ($tourPrice < 30000 || $tourPrice > 40000)) continue;
                else if ($priceFilter == 5 && $tourPrice < 40000) continue;
            }

            //results
            $routeTours[$routId]['tours'][$tourId] = array('date' => $tourDate->format('d.m.Y'), 'price' => $tourPrice);

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
        $routesDay = [];
        foreach ($routeTours as $key => $routeTour) {
            $routesDay[$routeTours[$key]['days']] = $routeTours[$key]['days'];
            $routeTours[$key]['minDate'] = $routeTours[$key]['minDate']->format('d.m.y');
            $routeTours[$key]['tours'] = json_encode($routeTours[$key]['tours']);
        }
        asort($routesDay);
        /**/
        $repositoryRouteType = $this->getDoctrine()->getRepository(TouristRouteType::class);
        $routeType =  $repositoryRouteType->findAll();
        return $this->render('tour/index.html.twig', [
            'tourist_routes' => $routeTours,
            'route_types' => $routeType,
            'route_days' => $routesDay,
        ]);
    }
}
