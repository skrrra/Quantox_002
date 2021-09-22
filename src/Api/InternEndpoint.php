<?php

namespace App\Api;

use App\Database\DatabaseQueries;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use Pecee\SimpleRouter\SimpleRouter;


class InternEndpoint
{

    private $query;

    public function __construct()
    {
        $this->query = new DatabaseQueries();
    }

    public function getAllInterns()
    {
        try{
            $data = $this->query->processQuery('SELECT * FROM intern');
        } catch (PDOException $e){
            return $e->getCode();
        }

        if(empty($data)){
            return JsonResponse::requestFail(false, [], HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function getIntern($id)
    {
        if(!is_numeric($id)){
            return JsonResponse::requestFail(false, [], HttpResponse::HTTP_BAD_REQUEST);
        }

        try{
            $data = $this->query->processQuery('SELECT * FROM intern WHERE id = ' .$id);
        }catch(PDOException $e){
            return $e->getCode();
        }

        if(empty($data)){
            return JsonResponse::requestFail(false, [], HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function storeIntern()
    {
    //     if(!is_numeric($id)){
    //         return JsonResponse::requestFail(false, [], HttpResponse::HTTP_BAD_REQUEST);
    //     }
        
        $params = SimpleRouter::request()->getInputHandler()->all();

        $query = "INSERT INTO `intern` (`mentor_id`, `group_id`, `full_name`, `city`) VALUES ('0', '0', " ."'".$params['name']."'". ", "."'".$params['city']."'".");";
        
        $data = $this->query->processQuery($query);

        // $data = ['name' => $params['name'],
        //          'city' => $params['city']];
        
        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }
}