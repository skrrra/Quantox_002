<?php

namespace App\Api;

// require "vendor/pecee/simple-router/helpers.php";

use App\Database\DatabaseQueries;
use App\Database\QuerySyntax;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use Pecee\SimpleRouter\SimpleRouter;


class InternEndpoint
{

    private $query;

    public function __construct()
    {
        $this->query = new QuerySyntax();
    }

    public function getAllInterns()
    {
        try{
            $data = $this->query->getInternList();
        } catch (PDOException $e){
            return $e->getCode();
        }

        if(empty($data)){
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function getIntern($id)
    {
        if(!is_numeric($id)){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        try{
            $data = $this->query->getIntern($id);
        }catch(PDOException $e){
            throw $e->getCode();
        }

        if(empty($data)){
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function createIntern()
    {
        $data = SimpleRouter::request()->getInputHandler()->all();

        if(!isset($data['full_name'], $data['city'], $data['mentor_id'], $data['group_id'])){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }
    
        try{
            $data = $this->query->createIntern($data['mentor_id'], $data['group_id'], $data['full_name'], $data['city']);
            if(!$data){
                return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
            }
        }catch(\Exception $e){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function updateIntern($id)
    {
        if(!is_numeric($id)){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $data = SimpleRouter::request()->getInputHandler()->all();

        $params = $this->query->updateIntern($id, $data);
            
        if($params){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, [], HttpResponse::HTTP_OK);
    }

    public function deleteIntern($id)
    {
        if(!is_numeric($id)){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        try{
            $data = $this->query->deleteIntern($id);
        }catch(\Exception $e){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        if(!$data){
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, '{}', HttpResponse::HTTP_OK);
    }
}