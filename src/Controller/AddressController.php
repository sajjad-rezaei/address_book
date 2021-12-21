<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\ZipCode;
use App\Form\AddressType;

use App\Repository\AddressRepository;
use App\Repository\CountryRepository;

use App\Services\FileUploader;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\PDOException;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/address", name="address.")
 */
class AddressController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function list(AddressRepository $addressRepository): Response
    {
        //get all addresses
        $data = $addressRepository->findAll();

        return $this->render('address/index.html.twig', [
            'addresses' => $data,
        ]);
    }
    /**
     * @Route("/show/{id}", name="show")
     */
    //use the param convertor to get the desire address
    public function show(Address $address): Response
    {


        return $this->render('address/show.html.twig', [
            "address" => $address
        ]);
    }
    /**
     * @Route("/add", name="add")
     */
    public function add(FileUploader $fileUploader , Request $request): Response
    {

        $address = new Address();
        //create form from the Address entity to have form
        $form = $this->createForm(AddressType::class,$address);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            //check if country is exist
            $countryRepository = $em->getRepository(Country::class);
            $country = $countryRepository->findOneBy(["name" => $address->getZipCode()->getCity()->getCountry()->getName()]);
            if(!$country){
                //lets add country
                $country = new Country();
                $country->setName($address->getZipCode()->getCity()->getCountry()->getName());
                $country->setSlug($address->getZipCode()->getCity()->getCountry()->getSlug());
            }
            //check if city is exist
            $cityRepository = $em->getRepository(City::class);
            $city = $cityRepository->findOneBy(["name" => $address->getZipCode()->getCity()->getName()]);
            if(!$city){
                //lets add the city
                $city = new City();
                $city->setName($address->getZipCode()->getCity()->getName());
                $city->setCountry($country);
            }

            //do file upload
            /** @var UploadedFile $file */
            $file = $request->files->get("address")['pic'];
            //if file attached
            if($file){
                //upload the file using file uploader
                $fileName = $fileUploader->uploadFile($file);
                //check if file uploads
                if($fileName)
                    //set the file name to the address object to save in db
                    $address->setPic($fileName);
            }


            try {
                $address->getZipCode()->setCity($city);

                //persist country
                $em->persist($country);
                //persist city
                $em->persist($city);
                //persist address that contain zipcode
                $em->persist($address);
                $em->flush();
                $this->addFlash("success" , "Address added successfully :=)");
                return $this->redirectToRoute("address.list");
            }catch(DBALException $e)
            {
                //there was and error so lets remove the file
                if(isset($fileName) and $fileName){
                    $fileUploader->removeFile($fileName);
                }
                //maybe the zip code and city are duplicated
                if( $e->getPrevious()->getCode() === '23000' )
                {
                    $this->addFlash("success" , "There was an error adding address, maybe your trying to duplicate zipcode!!");
                    return $this->redirectToRoute("address.list");
                }
                throw $e;

            }



        }
        return $this->render('address/add.html.twig' , [ "form" => $form->createView() ]);
    }
    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(FileUploader $fileUploader , Request $request , int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $addressRepositry = $em->getRepository(Address::class);
        $address = $addressRepositry->find($id);

        //we dont want the form handler handle our form cuz we want to persist and bind the objecthandy
        if( $request->getRealMethod() == "POST"){
            //dont pass the $address object to make things handy
            $form = $this->createForm(AddressType::class);
        }else
            $form = $this->createForm(AddressType::class,$address);


        $form->handleRequest($request);


        if($form->isSubmitted() AND $form->isValid()) {


            $requestAddress = $form->getData();
            $address->bindParam($requestAddress);


            //check if country is exist
            $countryRepository = $em->getRepository(Country::class);
            $country = $countryRepository->findOneBy(["name" => $requestAddress->getZipCode()->getCity()->getCountry()->getName()]);
            if (!$country) {
                //lets add country
                $country = new Country();
                $country->setName($requestAddress->getZipCode()->getCity()->getCountry()->getName());
                $country->setSlug($requestAddress->getZipCode()->getCity()->getCountry()->getSlug());


            }
            //check if city is exist
            $cityRepository = $em->getRepository(City::class);
            $city = $cityRepository->findOneBy(["name" => $requestAddress->getZipCode()->getCity()->getName()]);
            if (!$city) {
                //lets add the city
                $city = new City();
                $city->setName($requestAddress->getZipCode()->getCity()->getName());
                $city->setCountry($country);
            }

            //do file upload
            /** @var UploadedFile $file */
            $file = $request->files->get("address")['pic'];
            //if file attached
            if ($file) {
                //upload the file using file uploader
                $fileName = $fileUploader->uploadFile($file);
                //check if file uploads
                if ($fileName) {
                    //TODO remove the last file if exist
                    //set the file name to the address object to save in db
                    $address->setPic($fileName);
                }
            }


            try {
                //Add the country and city object to Address
                $address->getZipCode()->setCity($city);

                //persist country cuz maybe its a new object
                $em->persist($country);
                //persist city cuz maybe its a new object
                $em->persist($city);

                // dont what to persist address Doctrine is watching it and waiting for changes
                $em->flush();

                $this->addFlash("success" , "Address edited successfully :=)");
                return $this->redirectToRoute("address.list");
            } catch (DBALException $e) {

                //there was and error so lets remove the file
                if(isset($fileName) and $fileName){
                    $fileUploader->removeFile($fileName);
                }
                //maybe the zip code and city are duplicated
                if( $e->getPrevious()->getCode() === '23000' )
                {
                    $this->addFlash("success" , "There was an error adding address, maybe your trying to duplicate zipcode!!");
                    return $this->redirectToRoute("address.list");
                }
                throw $e;
            }
        }


        return $this->render('address/edit.html.twig', [ "form" => $form->createView() ]);
    }
    /**
     * @Route("/remove/{id}", name="remove", methods={"POST"})
     */
    //use the param convertor to get the desire address
    public function remove(Address  $address): Response
    {
        $success =true;
        $message = "The address deleted successfully!";
        $messageType= "success";
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($address);
            $em->flush();


        } catch (DBALException $e) {
            $success =false;
            $message = "There Was an error deleting the Address";
            $messageType= "error";

        }
        // add message to show to user in address list
        //can also use js to display message but prefer to reload page fot demonstrate purpose
        $this->addFlash($messageType , $message);

        return new JsonResponse(array('success' => $success));


    }

}
