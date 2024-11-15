<?php

declare(strict_types=1);

namespace application\Controller\Api\V1;

use App\Repository\EmployeeRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeesControllerTest extends WebTestCase
{
    public function testShouldBeResponseWith401StatusCodeForCreateWhenSuccessfully(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();
        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($content);

        $decoded = json_decode($content, true);
        $this->assertArrayHasKey('data', $decoded);
        $this->assertArrayHasKey(0, $decoded['data']);
        $this->assertArrayHasKey('uuid', $decoded['data'][0]);
        $this->assertArrayHasKey('message', $decoded);
        $this->assertArrayHasKey('status', $decoded);
        $this->assertSame($decoded['status'], 201);
    }

    public function testShouldBeResponseWith422StatusCodeForCreateWhenFirstNameAndLastNameIsTooLength(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Q0IUnw0V7AH1iAcDItUtXvvfhyzsZna8aeB3PAJeEAAXBUmGVVQSFmXg8RA0b24TB37Etf70cQfJwSuwjCRecNW8s5tbllYWRsqBSGfFiuIrHduyHuAkXI6JFUf9IT2dvO2sz58Ylcy9p89voWiCOD9ctsfoPVGYlajHIxLLhWesf1aP1Q6cj5yxjqyxZNAq5YmojT5ihCjj8pOgARuFRJiAPzPmyDykSrywQqIatWU1jhF8TWuPtZRbVR2ZNqWxU2K1OUQb6XcN4mgF8BDKEctLyURpVBFGH79z5vgtVFKGzwcv8hCALHthapWKe7sl3lh9dyHRPXJ8TQNJpwAr7DilZIQXK3ovUUIwShUG2ViMTgcGOYDQLDiRDhh2LuVXmnZyCwjsQvN5MZLkkD1SHvnaxr2773PWF3ejMrxpvqgYxS83dWaeUNZWVgGTvIlhXwXxJ9oYewUYx0BW3Xvd3ZtCRl2AlJ6YHYXPoz6sbHTJ6Z1M5NUVE3k72VK1OM1mx6k'
        ]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testShouldBeResponseWith422StatusCodeForCreateWhenInvalidParameter(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNamedsaasAndLastName' => 'Q0IUnw0V7AH1iAcDItUtXvvfhyzsZna8aeB3PAJeEAAXBUmGVVQSFmXg8RA0b24TB37Etf70cQfJwSuwjCRecNW8s5tbllYWRsqBSGfFiuIrHduyHuAkXI6JFUf9IT2dvO2sz58Ylcy9p89voWiCOD9ctsfoPVGYlajHIxLLhWesf1aP1Q6cj5yxjqyxZNAq5YmojT5ihCjj8pOgARuFRJiAPzPmyDykSrywQqIatWU1jhF8TWuPtZRbVR2ZNqWxU2K1OUQb6XcN4mgF8BDKEctLyURpVBFGH79z5vgtVFKGzwcv8hCALHthapWKe7sl3lh9dyHRPXJ8TQNJpwAr7DilZIQXK3ovUUIwShUG2ViMTgcGOYDQLDiRDhh2LuVXmnZyCwjsQvN5MZLkkD1SHvnaxr2773PWF3ejMrxpvqgYxS83dWaeUNZWVgGTvIlhXwXxJ9oYewUYx0BW3Xvd3ZtCRl2AlJ6YHYXPoz6sbHTJ6Z1M5NUVE3k72VK1OM1mx6k'
        ]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testShouldBeResponseWith422StatusCodeForCreateWhenValueParameterIsNotString(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 1
        ]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testShouldBeResponseWith422StatusCodeForCreateWhenValueParameterIsEmpty(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => ''
        ]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testShouldBeResponseWith500StatusCodeForCreateWhenThrowException(): void
    {
        $client = static::createClient();
        $container = self::getContainer();
        $employeeRepositoryMock = $this->getMockBuilder(EmployeeRepository::class)->
        disableOriginalConstructor()
            ->onlyMethods(['store'])
            ->getMock();
        $employeeRepositoryMock->method('store')->willThrowException(new Exception());
        $container->set('App\Repository\EmployeeRepository', $employeeRepositoryMock);
        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();
        $this->assertResponseStatusCodeSame(500);
        $this->assertJson($content);
        $decoded = json_decode($content, true);
        $this->assertArrayHasKey('data', $decoded);
        $this->assertArrayHasKey('message', $decoded);
        $this->assertArrayHasKey('status', $decoded);
        $this->assertSame(500, $decoded['status']);
        $this->assertSame('SERVER_ERROR_WHEN_CREATING_AN_EMPLOYEE', $decoded['message']);
        $this->assertNull($decoded['data']);
    }

    public function testShouldBeResponseWith201StatusCodeForWorkingTimeRegisterSuccessfully(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();

        $decoded = json_decode($content, true);

        $client->jsonRequest('POST', sprintf('/api/v1/employees/%s/worktimes', $decoded['data'][0]['uuid']), [
            'startDateTime' => '19.11.2024 15:00',
            'endDateTime' => '20.11.2024 02:00'
        ]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testShouldBeResponseWith500StatusCodeForWorkingTimeRegisterWhenUuidInvalid(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', sprintf('/api/v1/employees/%s/worktimes', 'test'), [
            'startDateTime' => '19.11.2024 15:00',
            'endDateTime' => '20.11.2024 02:00'
        ]);

        $this->assertResponseStatusCodeSame(500);
    }

    public function testShouldBeResponseWith409StatusCodeWhenForWorkingTimeRegisterPeriodDatetimeAlreadyExists(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();

        $decoded = json_decode($content, true);

        $client->jsonRequest('POST', sprintf('/api/v1/employees/%s/worktimes', $decoded['data'][0]['uuid']), [
            'startDateTime' => '19.11.2024 15:00',
            'endDateTime' => '20.11.2024 02:00'
        ]);

        $client->jsonRequest('POST', sprintf('/api/v1/employees/%s/worktimes', $decoded['data'][0]['uuid']), [
            'startDateTime' => '19.11.2024 15:00',
            'endDateTime' => '20.11.2024 02:00'
        ]);

        $this->assertResponseStatusCodeSame(409);
    }

    public function testShouldBeResponseWith404StatusCodeForWorkingTimeRegisterWhenEmployeeNotExists(): void
    {
        $client = static::createClient();


        $client->jsonRequest('POST', sprintf('/api/v1/employees/%s/worktimes', '01932fdf-df04-7426-a017-5299f87122f7'), [
            'startDateTime' => '19.11.2024 15:00',
            'endDateTime' => '20.11.2024 02:00'
        ]);


        $this->assertResponseStatusCodeSame(404);
    }

    public function testShouldBeResponseWith422StatusCodeForWorkingTimeRegisterWhenStartDateTimeFormatInvalid(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();

        $decoded = json_decode($content, true);

        $client->jsonRequest('POST', sprintf('/api/v1/employees/%s/worktimes', $decoded['data'][0]['uuid']), [
            'startDateTime' => '2024-01-01 15:00',
            'endDateTime' => '20.11.2024 02:00'
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testShouldBeResponseWith422StatusCodeForWorkingTimeRegisterWhenEndDateTimeFormatInvalid(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();

        $decoded = json_decode($content, true);

        $client->jsonRequest('POST', sprintf('/api/v1/employees/%s/worktimes', $decoded['data'][0]['uuid']), [
            'startDateTime' => '19.11.2024 15:00',
            'endDateTime' => '2024-01-01 02:00'
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testShouldBeResponseWith422StatusCodeForWorkingTimeRegisterWhenDecriptionHoursLimitReached(): void
    {
        $client = static::createClient();
        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();

        $decoded = json_decode($content, true);

        $client->jsonRequest('POST', sprintf('/api/v1/employees/%s/worktimes', $decoded['data'][0]['uuid']), [
            'startDateTime' => '19.11.2024 15:00',
            'endDateTime' => '20.11.2024 05:00'
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testShouldBeResponseWith200StatusCodeForSummariseWhenYearMonthSucessfully(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();

        $decoded = json_decode($content, true);
        $decodedDataUuid = $decoded['data'][0]['uuid'];

        $client->jsonRequest('POST', sprintf('/api/v1/employees/%s/worktimes', $decodedDataUuid), [
            'startDateTime' => '19.11.2024 15:00',
            'endDateTime' => '20.11.2024 02:00'
        ]);

        $client->jsonRequest('GET', sprintf('/api/v1/employees/%s/worktimes/2024-11/summarise', $decodedDataUuid));

        $jsonContent = $client->getResponse()->getContent();
        $decoded = json_decode($jsonContent, true);
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($jsonContent);
        $this->assertArrayHasKey('data', $decoded);
        $this->assertArrayHasKey('message', $decoded);
        $this->assertArrayHasKey('status', $decoded);

        $data = $decoded['data'];
        $this->assertSame('employeeUuid', $data[0]['key']);
        $this->assertSame($decodedDataUuid, $data[0]['value']);
        $this->assertSame('totalHours', $data[1]['key']);
        $this->assertSame(11, $data[1]['value']);
        $this->assertSame('totalMinutes', $data[2]['key']);
        $this->assertSame(0, $data[2]['value']);
        $this->assertSame('totalHoursAndMinutes', $data[3]['key']);
        $this->assertSame('11:0', $data[3]['value']);
        $this->assertSame('standardHours', $data[4]['key']);
        $this->assertSame(11, $data[4]['value']);
        $this->assertSame('overtimeHours', $data[5]['key']);
        $this->assertSame(0, $data[5]['value']);
        $this->assertSame('standardRate', $data[6]['key']);
        $this->assertSame(20, $data[6]['value']);
        $this->assertSame('overtimeRate', $data[7]['key']);
        $this->assertSame(200, $data[7]['value']);
        $this->assertSame('standardPaymentForHours', $data[8]['key']);
        $this->assertSame(220, $data[8]['value']);
        $this->assertSame('overtimePaymentForHours', $data[9]['key']);
        $this->assertSame(0, $data[9]['value']);
        $this->assertSame('totalPaymentForHours', $data[10]['key']);
        $this->assertSame(220, $data[10]['value']);
    }

    public function testShouldBeResponseWith200StatusCodeForSummariseWhenYearMonthDaySucessfully(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();

        $decoded = json_decode($content, true);
        $decodedDataUuid = $decoded['data'][0]['uuid'];

        $client->jsonRequest('POST', sprintf('/api/v1/employees/%s/worktimes', $decodedDataUuid), [
            'startDateTime' => '19.11.2024 15:00',
            'endDateTime' => '20.11.2024 02:00'
        ]);
        $client->jsonRequest('GET', sprintf('/api/v1/employees/%s/worktimes/2024-11-19/summarise', $decodedDataUuid));

        $jsonContent = $client->getResponse()->getContent();
        $decoded = json_decode($jsonContent, true);
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($jsonContent);
        $this->assertArrayHasKey('data', $decoded);
        $this->assertArrayHasKey('message', $decoded);
        $this->assertArrayHasKey('status', $decoded);

        $data = $decoded['data'];
        $this->assertSame('employeeUuid', $data[0]['key']);
        $this->assertSame($decodedDataUuid, $data[0]['value']);
        $this->assertSame('totalHours', $data[1]['key']);
        $this->assertSame(11, $data[1]['value']);
        $this->assertSame('totalMinutes', $data[2]['key']);
        $this->assertSame(0, $data[2]['value']);
        $this->assertSame('totalHoursAndMinutes', $data[3]['key']);
        $this->assertSame('11:0', $data[3]['value']);
        $this->assertSame('standardHours', $data[4]['key']);
        $this->assertSame(11, $data[4]['value']);
        $this->assertSame('overtimeHours', $data[5]['key']);
        $this->assertSame(0, $data[5]['value']);
        $this->assertSame('standardRate', $data[6]['key']);
        $this->assertSame(20, $data[6]['value']);
        $this->assertSame('overtimeRate', $data[7]['key']);
        $this->assertSame(200, $data[7]['value']);
        $this->assertSame('standardPaymentForHours', $data[8]['key']);
        $this->assertSame(220, $data[8]['value']);
        $this->assertSame('overtimePaymentForHours', $data[9]['key']);
        $this->assertSame(0, $data[9]['value']);
        $this->assertSame('totalPaymentForHours', $data[10]['key']);
        $this->assertSame(220, $data[10]['value']);
    }

    public function testShouldBeResponseWith404StatusCodeForSummariseWhenYearMonthNotExists(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();

        $decoded = json_decode($content, true);

        $client->jsonRequest('GET', sprintf('/api/v1/employees/%s/worktimes/2024-11/summarise', $decoded['data'][0]['uuid']));

        $this->assertResponseStatusCodeSame(404);
    }

    public function testShouldBeResponseWith404StatusCodeForSummariseWhenYearMonthDayNotExists(): void
    {
        $client = static::createClient();

        $client->jsonRequest('POST', '/api/v1/employees', [
            'firstNameAndLastName' => 'Jan Kowalski'
        ]);

        $content = $client->getResponse()->getContent();

        $decoded = json_decode($content, true);

        $client->jsonRequest('GET', sprintf('/api/v1/employees/%s/worktimes/2024-11-19/summarise', $decoded['data'][0]['uuid']));

        $this->assertResponseStatusCodeSame(404);
    }

    public function testShouldBeResponseWith404StatusCodeForSummariseWhenUuidEmployeeNotExists(): void
    {
        $client = static::createClient();

        $client->jsonRequest('GET', sprintf('/api/v1/employees/%s/worktimes/2024-11-19/summarise', '01932fdf-df04-7426-a017-5299f87122f7'));

        $this->assertResponseStatusCodeSame(404);
    }

    public function testShouldBeResponseWith404StatusCodeForSummariseWhenUuidEmployeeInvalid(): void
    {
        $client = static::createClient();

        $client->jsonRequest('GET', sprintf('/api/v1/employees/%s/worktimes/2024-11-19/summarise', 'test'));

        $this->assertResponseStatusCodeSame(500);
    }

    public function testShouldBeResponseWith500StatusCodeForSummariseWhenThrowException(): void
    {
        $client = static::createClient();
        $container = self::getContainer();

        $employeeRepositoryMock = $this->getMockBuilder(EmployeeRepository::class)->
        disableOriginalConstructor()
            ->onlyMethods(['existsByUuid'])
            ->getMock();
        $employeeRepositoryMock->method('existsByUuid')->willThrowException(new Exception());
        $container->set('App\Repository\EmployeeRepository', $employeeRepositoryMock);

        $client->jsonRequest('GET', sprintf('/api/v1/employees/%s/worktimes/2024-11-19/summarise', 'test'));

        $this->assertResponseStatusCodeSame(500);
    }
}
