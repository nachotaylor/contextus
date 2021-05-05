<?php

namespace App\Controllers;

use App\Models\Branch;

require_once "config.php";
require_once MODELS . "BranchModel.php";

class ShopController
{
    protected $branch;

    public function __construct()
    {
        $this->branch = new Branch();
    }

    public function getBranches($data)
    {
        try {
            return ['products' => $this->branch->getBranches($data), 'request' => $data];
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function buy($product)
    {
        try {
            $this->branch->buy($product);
            return ['message' => 'Product selled'];
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }
}