<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\UserRepository;

class ApiTest extends ApiTestCase
{
    public function apiToken(): string
    {
        $user = static::getContainer()->get(UserRepository::class)->findOneBy(['email' => 'albert.e.m@mail.ru']);
        return $user->getApiToken();
    }

    public function testApiUsers()
    {
        $client = static::createClient();
        $client->request('GET', '/api/users');
        $this->assertResponseStatusCodeSame(401);
        $response = $client->withOptions([
            'headers' => ['x-auth-token' => $this->apiToken(), 'content-type' => 'application/json; charset=utf-8'],
        ])->request('GET', '/api/users');
        $this->assertResponseStatusCodeSame(200);
        $resultArray = $response->toArray();
        $this->assertJson($response->getContent());
        $this->assertIsArray($resultArray);
    }

    public function testQuestions(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/questions');
        $this->assertResponseStatusCodeSame(401);
        $response = $client->withOptions([
            'headers' => ['x-auth-token' => $this->apiToken(), 'content-type' => 'application/json; charset=utf-8'],
        ])->request('GET', '/api/questions');
        $this->assertResponseStatusCodeSame(200);
        $resultArray = $response->toArray();
        $this->assertJson($response->getContent());
        $this->assertIsArray($resultArray);
    }

    public function testAnswers(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/aswers');
        $this->assertResponseStatusCodeSame(401);
        $response = $client->withOptions([
            'headers' => ['x-auth-token' => $this->apiToken(), 'content-type' => 'application/json; charset=utf-8'],
        ])->request('GET', '/api/aswers');
        $this->assertResponseStatusCodeSame(200);
        $resultArray = $response->toArray();
        $this->assertJson($response->getContent());
        $this->assertIsArray($resultArray);
    }

    public function testCategories(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/categories');
        $this->assertResponseStatusCodeSame(401);
        $response = $client->withOptions([
            'headers' => ['x-auth-token' => $this->apiToken(), 'content-type' => 'application/json; charset=utf-8'],
        ])->request('GET', '/api/categories');
        $this->assertResponseStatusCodeSame(200);
        $resultArray = $response->toArray();
        $this->assertJson($response->getContent());
        $this->assertIsArray($resultArray);
    }
}
