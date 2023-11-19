<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct(
        private $model = new Locations(),
        private $prefix = 'admin'
    )
    {}

    public function validateLocation(array $params): array
    {
        $error = [];

        if(empty($params['name'])) {
            $error['name'] = __('Nazwa lokalizacji nie może być pusta!');
        }

        if(empty($params['x'])) {
            $error['x'] = __('Pozycja x lokalizacji nie może być pusta!');
        }

        if(empty($params['x'])) {
            $error['y'] = __('Pozycja y lokalizacji nie może być pusta!');
        }

        if(
            !empty($params['name'])
            && $this->model->getLocationByNameAndId($params['name'], $params['id'])
        ) {
            $error['name'] = __('Lokalizacja o takiej nazwie już występuje w systemie');
        }

        return $error;
    }

    final public function editLocation(Request $request, int $id = null)
    {
        $params = $request->all();
        $error = [];

        // dd($params);

        if(isset($params['submit'])) {
            if(!$params['id']) {
                $location['id'] = $params['id'];
            }
            $location['name'] = $params['name'];
            $location['X'] = $params['x'];
            $location['Y'] = $params['y'];

            $error = $this->validateLocation($params);

            if(empty($error)) {
                $result = $this->model->addUpdateLocation($location);

                $message['success'] = __('Dodano pomyślnie');
                if($params['id']) {
                    $message['success'] = __('Zedytowano pomyślnie');
                }

                return redirect('/' . $this->prefix . '/location')->with($message);
            }
        } else {
            $location = [];
            if($id) {
                $location = $this->model->getLocationById($id);
            }
        }

        return view($this->prefix . '/editlocation', ['location' => $location, 'error'=> $error]);
    }


    final public function showLocations()
    {
        $locations = $this->model->getLocations();

        return view($this->prefix . '/locationlist', ['locations' => $locations]);
    }

    final public function deleteLocation(Request $request)
    {
        $id = $request->input('id');

        if($id) {
            $book = $this->model->getLocationById($id);
            $book['deleted'] = 1;

            $result = $this->model->addUpdateLocation($book);
        }

        $message['success'] = __('Usunięto pomyślnie');

        return redirect($this->prefix . '/locationlist')->with($message);
    }

    final public function nearestLocation(int $x, int $y)
    {
        return $this->model->getNearestLocationForUser($x, $y);
    }
}
