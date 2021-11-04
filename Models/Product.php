<?php

namespace App\Models;

use App\Core\Db\DbModel;

class Product extends DbModel
{
    public static function tableName(): string
    {
        return "products";
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return [
            'name',
            'description',
            'amount',
            'price',
            'currency_id',
            'average_rating',
            'image',
            'weight',
            'rating_count',
            'status',
        ];
    }

    /**
     * Average Rating formula
     * AR = 1*a+2*b+3*c+4*d+5*e/(R) 
     * Where AR is the average rating
     * a is the number of 1-star ratings
     * b is the number of 2-star ratings
     * c is the number of 3-star ratings
     * d is the number of 4-star ratings
     * e is the number of 5-star ratings
     * R is the total number of ratings
     *
     * @param int $id
     * @return array
     */
    public function getCalculatedRatings(int $id): array
    {
        //get all ratings by product id
        $ratings = ProductRating::findAll(['product_id' => $id]);

        //filter all rate by amount of rates. 
        $oneRatingCount = count(array_filter($ratings, function ($rate) {
            return ($rate['rating'] == 1);
        }));
        $twoRatingCount = count(array_filter($ratings, function ($rate) {
            return ($rate['rating'] == 2);
        }));

        $threeRatingCount = count(array_filter($ratings, function ($rate) {
            return ($rate['rating'] == 3);
        }));

        $fourRatingCount = count(array_filter($ratings, function ($rate) {
            return ($rate['rating'] == 4);
        }));

        $fiveRatingCount = count(array_filter($ratings, function ($rate) {
            return ($rate['rating'] == 5);
        }));

        //get all the total ratings by count all occurrences together
        $totalRatingCounts = $oneRatingCount + $twoRatingCount + $threeRatingCount + $fourRatingCount + $fiveRatingCount;
        //using the formula and rounding to keep float readable
        $averageRating = round((((1 * $oneRatingCount) + (2 * $twoRatingCount) + (3 * $threeRatingCount) + (4 * $fourRatingCount) + (5 * $fiveRatingCount)) / $totalRatingCounts), 1);
        return [
            'average_rating' => $averageRating,
            'rating_count' => $totalRatingCounts
        ];
    }
}
