<?php

namespace App\Tests;

use App\Service\FilterMoviesService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\LinesOfCode\NegativeValueException;

class FilterMoviesServiceTest extends TestCase
{
    private FilterMoviesService $filterMoviesService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filterMoviesService = new FilterMoviesService();
    }

    /**
     * @test
     */
    public function givenNegativeNumber_whenGetRandomMovieTitles_shouldThrowException(): void
    {
        // given
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Minimum number is: 1');

        $count = -5;

        // when
        $this->filterMoviesService->getRandomMovies($count, $this->movies());

        // then
    }

    /**
     * @test
     */
    public function givenMinimumInt_whenGetRandomMovieTitles_shouldThrowException(): void
    {
        // given
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Minimum number is: 1');

        $count = PHP_INT_MIN;

        // when
        $this->filterMoviesService->getRandomMovies($count, $this->movies());

        // then
    }

    /**
     * @test
     */
    public function givenMaximumInt_whenGetRandomMovieTitles_shouldThrowException(): void
    {
        // given
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Number is greater than number of array elements');

        $count = PHP_INT_MAX;

        // when
        $this->filterMoviesService->getRandomMovies($count, $this->movies());

        // then
    }

    /**
     * @test
     */
    public function givenZero_whenGetRandomMovieTitles_shouldThrowException(): void
    {
        // given
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Minimum number is: 1');

        $count = 0;

        // when
        $this->filterMoviesService->getRandomMovies($count, $this->movies());

        // then
    }

    /**
     * @test
     */
    public function givenNumberGreaterThanArrayCount_whenGetRandomMovieTitles_shouldThrowException(): void
    {
        // given
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('Number is greater than number of array elements');

        $movies = $this->movies();
        $count = count($movies) + 1;

        // when
        $this->filterMoviesService->getRandomMovies($count, $movies);

        // then
    }

    /**
     * @test
     */
    public function givenNothingAsCount_whenGetRandomMovieTitles_shouldReturnArray(): void
    {
        // given
        $movies = $this->movies();

        // when
        $result = $this->filterMoviesService->getRandomMovies(movies: $movies);

        // then
        static::assertIsArray($result);
        static::assertCount(3, $result);
        static::assertContainsEquals($result[0], $movies);
        static::assertContainsEquals($result[1], $movies);
        static::assertContainsEquals($result[2], $movies);
    }

    /**
     * @test
     */
    public function givenValid_whenGetRandomMovieTitles_shouldReturnArray(): void
    {
        // given
        $count = 2;
        $movies = $this->movies();

        // when
        $result = $this->filterMoviesService->getRandomMovies($count, $movies);

        // then
        static::assertIsArray($result);
        static::assertCount($count, $result);
        static::assertContainsEquals($result[0], $movies);
        static::assertContainsEquals($result[1], $movies);
    }

    /**
     * @test
     */
    public function givenLongString_whenGetMoviesStartingWithCharWithEvenCharacterCount_shouldThrowException(): void
    {
        // given
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('You can only enter one character');

        $string = 'Long string';

        // when
        $this->filterMoviesService->getMoviesStartingWithCharWithEvenCharacterCount($string);

        //then
    }

    /**
     * @test
     */
    public function givenEmptyString_whenGetMoviesStartingWithCharWithEvenCharacterCount_shouldThrowException(): void
    {
        // given
        static::expectException(InvalidArgumentException::class);
        static::expectExceptionMessage('You can only enter one character');

        $string = '';

        // when
        $this->filterMoviesService->getMoviesStartingWithCharWithEvenCharacterCount($string, $this->movies());

        //then
    }

    /**
     * @test
     */
    public function givenCapitalChar_whenGetMoviesStartingWithCharWithEvenCharacterCount_shouldReturnArray(): void
    {
        // given
        $string = 'W';
        $expectedArray = [
            "Wanda i 123 smerfy",
            "worek ziemniaków",
            " wartość ze  spacjami "
        ];

        $expectedCount = count($expectedArray);

        // when
        $result = $this->filterMoviesService->getMoviesStartingWithCharWithEvenCharacterCount($string, $this->movies());

        //then
        static::assertIsArray($result);
        static::assertCount($expectedCount, $result);
        static::assertEquals($expectedArray, array_values($result));
    }

    /**
     * @test
     */
    public function givenCaseChar_whenGetMoviesStartingWithCharWithEvenCharacterCount_shouldReturnArray(): void
    {
        // given
        $string = 'w';
        $expectedArray = [
            "Wanda i 123 smerfy",
            "worek ziemniaków",
            ' wartość ze  spacjami '
        ];

        $expectedCount = count($expectedArray);

        // when
        $result = $this->filterMoviesService->getMoviesStartingWithCharWithEvenCharacterCount($string, $this->movies());

        //then
        static::assertIsArray($result);
        static::assertCount($expectedCount, $result);
        static::assertEquals($expectedArray, array_values($result));
    }

    /**
     * @test
     */
    public function givenNumberChar_whenGetMoviesStartingWithCharWithEvenCharacterCount_shouldReturnArray(): void
    {
        // given
        $string = '1';
        $expectedArray = [
            "123 powody, żeby się zakochać2"
        ];

        $expectedCount = count($expectedArray);

        // when
        $result = $this->filterMoviesService->getMoviesStartingWithCharWithEvenCharacterCount($string, $this->movies());

        //then
        static::assertIsArray($result);
        static::assertCount($expectedCount, $result);
        static::assertEquals($expectedArray, array_values($result));
    }

    /**
     * @test
     */
    public function givenSpaceChar_whenGetMoviesStartingWithCharWithEvenCharacterCount_shouldReturnEmptyArray(): void
    {
        // given
        $string = ' ';

        // when
        $result = $this->filterMoviesService->getMoviesStartingWithCharWithEvenCharacterCount($string, $this->movies());

        //then
        static::assertIsArray($result);
        static::assertEmpty($result);
    }

    /**
     * @test
     */
    public function givenSpecialChar_whenGetMoviesStartingWithCharWithEvenCharacterCount_shouldReturnArray(): void
    {
        // given
        $string = '&';
        $expectedArray = [
            '&& w programowaniu'
        ];

        $expectedCount = count($expectedArray);

        // when
        $result = $this->filterMoviesService->getMoviesStartingWithCharWithEvenCharacterCount($string, $this->movies());

        //then
        static::assertIsArray($result);
        static::assertCount($expectedCount, $result);
        static::assertEquals($expectedArray, array_values($result));
    }

    /**
     * @test
     */
    public function givenEmptyMoviesArray_whenGetMoviesStartingWithCharWithEvenCharacterCount_shouldReturnEmptyArray(
    ): void
    {
        // given
        $string = 'W';
        $movies = [];

        // when
        $result = $this->filterMoviesService->getMoviesStartingWithCharWithEvenCharacterCount($string, $movies);

        //then
        static::assertIsArray($result);
        static::assertEmpty($result);
    }

    /**
     * @test
     */
    public function givenNegativeNumber_whenGetMoviesWithMinimumWordCount_shouldThrowException(): void
    {
        // given
        static::expectException(NegativeValueException::class);
        static::expectExceptionMessage('Minimum number is: 0');

        $count = -5;

        // when
        $this->filterMoviesService->getMoviesWithMinimumWordCount($count, $this->movies());

        // then
    }

    /**
     * @test
     */
    public function givenZero_whenGetMoviesWithMinimumWordCount_shouldReturnEmptyArray(): void
    {
        // given
        $count = 0;
        $expectedArray = [
            "Pulp Fiction",
            "Incepcja",
            "Skazani na Shawshank",
            "Dwunastu gniewnych ludzi & ja",
            "Wanda i 123 smerfy",
            "Wrotkowe szaleństwa",
            "worek ziemniaków",
            "worek ziemniaków2",
            " wartość ze  spacjami ",
            " wartość z wieloma  spacjami ",
            "123 powody, żeby się zakochać",
            "123 powody, żeby się zakochać2",
            "Pachnidło: Historia mordercy",
            "&& w programowaniu",
            "&& w programowaniu2",
        ];

        $expectedCount = count($expectedArray);

        // when
        $result = $this->filterMoviesService->getMoviesWithMinimumWordCount($count, $this->movies());

        // then
        static::assertIsArray($result);
        static::assertCount($expectedCount, $result);
        static::assertEquals($expectedArray, $result);
    }

    /**
     * @test
     */
    public function givenMinimumInt_whenGetMoviesWithMinimumWordCount_shouldThrowException(): void
    {
        // given
        static::expectException(NegativeValueException::class);
        static::expectExceptionMessage('Minimum number is: 0');

        $count = PHP_INT_MIN;

        // when
        $this->filterMoviesService->getMoviesWithMinimumWordCount($count, $this->movies());

        // then
    }

    /**
     * @test
     */
    public function givenMaximumInt_whenGetMoviesWithMinimumWordCount_shouldReturnEmptyArray(): void
    {
        // given
        $count = PHP_INT_MAX;

        // when
        $result = $this->filterMoviesService->getMoviesWithMinimumWordCount($count, $this->movies());

        // then
        static::assertIsArray($result);
        static::assertEmpty($result);
    }

    /**
     * @test
     */
    public function givenValid_whenGetMoviesWithMinimumWordCount_shouldReturnArray(): void
    {
        // given
        $count = 2;

        $expectedArray = [
            "Pulp Fiction",
            "Skazani na Shawshank",
            "Dwunastu gniewnych ludzi & ja",
            "Wanda i 123 smerfy",
            "Wrotkowe szaleństwa",
            "worek ziemniaków",
            "worek ziemniaków2",
            " wartość ze  spacjami ",
            " wartość z wieloma  spacjami ",
            "123 powody, żeby się zakochać",
            "123 powody, żeby się zakochać2",
            "Pachnidło: Historia mordercy",
            "&& w programowaniu",
            "&& w programowaniu2",
        ];

        $expectedCount = count($expectedArray);

        // when
        $result = $this->filterMoviesService->getMoviesWithMinimumWordCount($count, $this->movies());

        // then
        static::assertIsArray($result);
        static::assertCount($expectedCount, $result);
        static::assertEquals($expectedArray, array_values($result));
    }

    /**
     * @return array<string>
     */
    private function movies(): array
    {
        return [
            "Pulp Fiction",
            "Incepcja",
            "Skazani na Shawshank",
            "Dwunastu gniewnych ludzi & ja",
            "Wanda i 123 smerfy",
            "Wrotkowe szaleństwa",
            "worek ziemniaków",
            "worek ziemniaków2",
            " wartość ze  spacjami ",
            " wartość z wieloma  spacjami ",
            "123 powody, żeby się zakochać",
            "123 powody, żeby się zakochać2",
            "Pachnidło: Historia mordercy",
            "&& w programowaniu",
            "&& w programowaniu2",
            ' ',
            ''
        ];
    }
}