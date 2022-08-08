<?php


namespace App\Traits;


namespace App\Traits;

trait QueryLimit
{

    public $max_limit = 100;
    public $min_limit = 10;


    public function getQueryLimit()
    {
        $request_limit = request("limit");
        $limit = "";
        if ($request_limit)
        {
            if ($request_limit >= $this->min_limit && $request_limit <= $this->max_limit)
                $limit = $request_limit;
            elseif ($request_limit > $this->max_limit)
                $limit = $this->max_limit;
            elseif ($request_limit > 0 && $request_limit < $this->min_limit)
                $limit = $this->min_limit;
        }
        else
            $limit = $this->min_limit;
        return $limit;
    }

}