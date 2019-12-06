<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Entity\EquipmentReservation;
use App\Entity\Tour;
use App\Entity\TourEquipment;
use App\Entity\TouristRoute;
use App\Entity\TouristRoutePhotoAlbum;
use App\Entity\TouristRoutePoint;
use App\Entity\TouristRouteType;
use App\Entity\TourReservation;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TourController extends AbstractController
{
    /**
     * @Route("/tours", name="tours")
     * @param Request $request
     * @return Response
     * @throws Exception
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
        }
        asort($routesDay);

        $repositoryRouteType = $this->getDoctrine()->getRepository(TouristRouteType::class);
        $routeType =  $repositoryRouteType->findAll();
        return $this->render('tour/index.html.twig', [
            'tourist_routes' => $routeTours,
            'route_types' => $routeType,
            'route_days' => $routesDay,
        ]);
    }

    /**
     * Param TouristRoute $touristRoute
     * @param TouristRoute $touristRoute
     * @return Response
     * @Route("/tours/{id}", name="tour")
     * @throws Exception
     */
    public function actionTour(TouristRoute $touristRoute)
    {
        $touristRouteID = $touristRoute->getId();
        $repositoryTour = $this->getDoctrine()->getRepository(Tour::class);
        $tours = $repositoryTour->findCurrentByRoute($touristRouteID);

        //get tours of tourist route
        $toursInfo = [];
        $repositoryEquipment = $this->getDoctrine()->getRepository(TourEquipment::class);
        $repositoryTourReservation = $this->getDoctrine()->getRepository(TourReservation::class);
        $repositoryEquipmentReservation = $this->getDoctrine()->getRepository(EquipmentReservation::class);

        foreach ($tours as $tour) {
            $user = $this->getUser();
            $tourId = $tour->getId();
            $toursInfo[$tourId]['price'] = $tour->getPrice();
            $toursInfo[$tourId]['date'] = $tour->getDate();
            $toursInfo[$tourId]['count_person'] = $tour->getCountPerson();
            $toursInfo[$tourId]['id'] = $tourId;
            $toursInfo[$tourId]['isBooked'] = false;
            if(!empty($user) && !empty($repositoryTourReservation->findBy(['tour' => $tourId, 'user' => $user->getID()]))) {
                $toursInfo[$tourId]['isBooked'] = true;
            }
            $toursInfo[$tourId]['reservation'] = $repositoryTourReservation->findBy(['tour' => $tourId]);
            $toursInfo[$tourId]['reservation_count'] = count($toursInfo[$tourId]['reservation']);

            $toursInfo[$tourId]['equipments'] = $repositoryEquipment->findBy( ['tour' => $tourId] );

            if(!empty($user)) $userReservation = $repositoryTourReservation->findBy(['tour' => $tourId, 'user' => $user->getID()]);
            $toursInfo[$tourId]['equipment_reservations'] = [];
            foreach($toursInfo[$tourId]['equipments'] as $equipment) {
                $toursInfo[$tourId]['equipment_reservations'][$equipment->getEquipment()->getId()] = '';
            }

            if(!empty($userReservation)) {
                $equipmentReservations = $repositoryEquipmentReservation->findBy(['reservation_tour' => $userReservation[0]->getId()]);
                if(!empty($equipmentReservations)) {
                    foreach($equipmentReservations as $equipmentReservation) {
                        $toursInfo[$tourId]['equipment_reservations'][$equipmentReservation->getEquipment()->getId()] = 'checked';
                    }
                }
            }
        }
        array_multisort(array_column($toursInfo, 'date'), SORT_ASC, $toursInfo);
        foreach ($toursInfo as $key => $tourInfo) {
            $toursInfo[$key]['date'] = $toursInfo[$key]['date']->format('d.m').' - '.$toursInfo[$key]['date']->modify('+'.$touristRoute->getDays().' days')->format('d.m');
        }
        //get photos
        $repositoryPhotos = $this->getDoctrine()->getRepository(TouristRoutePhotoAlbum::class);
        $photoAlbums = $repositoryPhotos->findBy( ['route' => $touristRouteID] );
        $photos = [];
        if(!empty($photoAlbums)) {
            $photos = $photoAlbums[0]->getPhotosJSON();
        }
        //get day points
        $repositoryPoints = $this->getDoctrine()->getRepository(TouristRoutePoint::class);
        $routePoints = $repositoryPoints->findBy( ['route' => $touristRouteID] );

        return $this->render('tour/tour.html.twig', [
            'tourist_route' => $touristRoute,
            'tours' => $toursInfo,
            'photos' => $photos,
            'days' => $routePoints
        ]);
    }
    /**
     * @Route("/tour-booking", name="tour_booking")
     */
    public function bookTour(Request $request)
    {
        if($request->getRealMethod() == 'POST') {
            $tourId = $request->get('tour');
            $equipments = $request->get('equipments');
            $submittedToken = $request->request->get('token');
            if ($this->isCsrfTokenValid('tour_booking', $submittedToken)) {
                $user = $this->getUser();
                $em = $this->getDoctrine()->getManager();
                $repositoryTour = $em->getRepository(Tour::class);
                $repositoryEquipment = $em->getRepository(Equipment::class);
                $repositoryTourReservation = $em->getRepository(TourReservation::class);
                $repositoryEquipmentReservation = $em->getRepository(EquipmentReservation::class);
                //check reservation
                $tourReservation = $repositoryTourReservation->findBy(['tour' => $tourId, 'user' => $user->getID()]);
                if(empty($tourReservation)) {
                    $tourReservation = new TourReservation();
                    $tourReservation->setTour($repositoryTour->find($tourId));
                    $tourReservation->setUser($user);
                    $em->persist($tourReservation);
                    $em->flush();
                    //update reservation info (id)
                    $tourReservation = $repositoryTourReservation->findBy(['tour' => $tourId, 'user' => $user->getID()])[0];
                }
                else {
                    $tourReservation = $tourReservation[0];
                    $equipmentReservations = $repositoryEquipmentReservation->findBy( ['reservation_tour' => $tourReservation->getId()] );
                    //remove unused reservation equipments
                    foreach ($equipmentReservations as $equipmentReservation) {
                        if (isset($equipments) && (($key = array_search($equipmentReservation->getEquipment()->getId(), $equipments)) !== FALSE)) {
                            unset($equipments[$key]);
                        }
                        else {
                            $em->remove($equipmentReservation);
                            $em->flush();
                        }
                    }
                }
                //add reservation equipments
                if (isset($equipments)) {
                    foreach ($equipments as $equipment) {
                        $equipment = $repositoryEquipment->find($equipment);
                        $equipmentReservation = new EquipmentReservation();
                        $equipmentReservation->setCount(1);
                        $equipmentReservation->setEquipment($equipment);
                        $equipmentReservation->setReservationTour($tourReservation);
                        $em->persist($equipmentReservation);
                        $em->flush();
                    }
                }
            }
            else return new Response('Invalid token');
        }
        else return new Response('Dont use GET method');
        return new Response('booked');
    }

    /**
     * @Route("/tour-unbooking", name="tour_unbooking")
     */
    public function unbookTour(Request $request)
    {
        if($request->getRealMethod() == 'POST') {
            $tourId = $request->get('tour');
            $reservationId = $request->get('reservation_id');
            $submittedToken = $request->get('token');
            if ($this->isCsrfTokenValid('tour_booking', $submittedToken)) {
                $em = $this->getDoctrine()->getManager();
                $repositoryTourReservation = $em->getRepository(TourReservation::class);
                if(isset($reservationId)) {
                    if($this->isGranted('ROLE_ADMIN') or $this->isGranted('ROLE_INSTRUCTOR')) {
                        $tourReservation = $repositoryTourReservation->find($reservationId);
                        if(!empty($tourReservation)) {
                            $em->remove($tourReservation);
                            $em->flush();
                        }
                    }
                }
                else {
                    $tourReservation = $repositoryTourReservation->findBy(['tour' => $tourId, 'user' =>  $this->getUser()->getID()]);
                    if(!empty($tourReservation)) {
                        $em->remove($tourReservation[0]);
                        $em->flush();
                    }
                }
            }
        }
        return new Response('unbooked');
    }
}
