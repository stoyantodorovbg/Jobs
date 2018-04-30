<?php

namespace App\Http\Models;

use GeometryLibrary\PolyUtil;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_name',
        'author_email',
        'title',
        'description',
        'content',
        'preferred_area'
    ];

    /**
     * Get the preferred area coordinates.
     *
     * @return array
     */
    public function getAreaCoordinates()
    {
        // clear special chars
        $value = preg_replace('/[\s\r\n]/', '', $this->preferred_area);

        // separate each coordinate by ";" and remove empty values
        $coordinates = array_filter(explode(';', $value));

        $area_coordinates = [];

        foreach ($coordinates as $string) {
            $coordinate = explode(',', $string);

            array_push($area_coordinates, ['lat' => (float) $coordinate[0], 'lng' => (float) $coordinate[1]]);
        }

        return $area_coordinates;
    }

    /**
     * Find the advertisements, by preferred area
     *
     * @param array $location
     * @return array
     */
    public function findByPreferredLocation (array $location)
    {
        return $this->filterAdvertisements($location);
    }

    /**
     * Filter advertisements by the check if the preferred area covers a location
     *
     * @param array $location
     * @return array
     */
    protected function filterAdvertisements(array $location)
    {
        $distributors = $this->all();
        $found_distributors = [];

        foreach ($distributors as $distributor) {
            if (PolyUtil::containsLocation($location, $distributor->getAreaCoordinates())) {
                $found_distributors[] = $distributor;
            }
        }

        return $found_distributors;
    }
}
