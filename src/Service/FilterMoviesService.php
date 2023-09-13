<?php

namespace App\Service;

use App\Common\Const\MoviesList;
use InvalidArgumentException;
use SebastianBergmann\LinesOfCode\NegativeValueException;

class FilterMoviesService
{
    /**
     * @param int $count
     * @param array<string> $movies
     * @return array<string>
     */
    public function getRandomMovieTitles(
        int $count = 3,
        array $movies = MoviesList::ALL_MOVIES
    ): array {
        if ($count <= 0) {
            throw new InvalidArgumentException('Minimum number is: 1');
        }

        if ($count > count($movies)) {
            throw new InvalidArgumentException('Number is greater than number of array elements');
        }

        $indexes = array_rand(
            array_filter(
                $movies,
                fn(string $movie) => mb_strlen(trim($movie)) > 0
            ),
            $count
        );

        return array_map(fn ($index) => $movies[$index], $indexes);
    }

    /**
     * @param string $char
     * @param array<string> $movies
     * @return array<string>
     */
    public function getMoviesStartingWithCharWithEvenCharacterCount(
        string $char = 'W',
        array $movies = MoviesList::ALL_MOVIES
    ): array {
        $stringLength = mb_strlen($char);
        if ($stringLength > 1 || $stringLength == 0) {
            throw new InvalidArgumentException('You can only enter one character');
        }



        return array_filter(
            $movies,
            fn(string $movie) => strtolower(mb_substr(trim(trim($movie)), 0, 1)) == strtolower($char)
                && mb_strlen($movie) % 2 == 0
        );
    }

    /**
     * @param int $minimumCount
     * @param array<string> $movies
     * @return array<string>
     */
    public function getMoviesWithMinimumWordCount(
        int $minimumCount = 1,
        array $movies = MoviesList::ALL_MOVIES
    ): array {
        if ($minimumCount < 0) {
            throw new NegativeValueException('Minimum number is: 0');
        }

        return array_filter(
            $movies,
            fn(string $movie) => mb_strlen(trim($movie)) > 0 && count(explode(' ', trim($movie))) >= $minimumCount
        );
    }
}