<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public final function getImageForArray($items)
    {
        $results = [];
        if($items) {
            foreach ($items as $item) {
                if(!empty($item->image_id)) {
                    $item->image = (new Images)->getImage($item->image_id);
                }
                $results[] = $item;
            }
        }

        return $results;
    }

    public final function getImageForObject($item)
    {
        $result = [];
        if($item) {
            if(!empty($item['image_id'])) {
                $item['image_id'] = (new Images)->getImage($item['image_id']);
            }

            $result = $item;
        }

        return $result;
    }
}
