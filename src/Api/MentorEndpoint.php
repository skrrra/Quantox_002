<?php

namespace App\Api;

use App\Database\DatabaseQueries;
use App\Http\JsonResponse;
use App\Http\HttpResponse;
use Pecee\SimpleRouter\SimpleRouter;

class MentorEndpoint
{

    private $query;

    public function __construct()
    {
        $this->query = new DatabaseQueries();
    }

    public function getMentorList()
    {
        try{
            $data = $this->query->getMentorList();
        } catch (PDOException $e){
            return $e->getCode();
        }

        if(empty($data)){
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function getMentor($id)
    {
        if(!is_numeric($id)){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        try{
            $data = $this->query->getMentor($id);
        }catch(PDOException $e){
            throw $e->getCode();
        }

        if(empty($data)){
            return JsonResponse::requestFail(HttpResponse::HTTP_NOT_FOUND);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function createMentor()
    {
        $data = SimpleRouter::request()->getInputHandler()->all();

        if(!isset($data['full_name'], $data['group_id'])){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }
    
        try{
            $data = $this->query->createMentor($data['full_name'], $data['group_id']);
            if(!$data){
                return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
            }
        }catch(\Exception $e){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function updateMentor($id)
    {
        if(!is_numeric($id)){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        $data = SimpleRouter::request()->getInputHandler()->getOriginalParams();

        if(empty($data)){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        try{
            $query = $this->query->updateMentor($data, $id);
        }catch(\Exception $e){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, $data, HttpResponse::HTTP_OK);
    }

    public function deleteMentor($id)
    {
        if(!is_numeric($id)){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        try{
            $query = $this->query->deleteMentor($id);
        }catch(\Exception $e){
            return JsonResponse::requestFail(HttpResponse::HTTP_BAD_REQUEST);
        }

        return JsonResponse::requestSuccess(true, '{}', HttpResponse::HTTP_OK);
    }
}