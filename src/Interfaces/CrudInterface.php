<?php

namespace App\Interfaces;

interface CrudInterface
{
    public function get(int $id);

    public function create();

    public function update(int $id);

    public function delete(int $id);
}