<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionTest extends WebTestCase
{
    private array $trueCredentials = ['username' => 'danila', 'password' => '123456'];
    private array $falseCredentials = ['username' => 'root@mail.ru', 'password' => 'password'];

    public function testHomePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
        $this->assertPageTitleContains('QaA');
        $this->assertCount(3, $crawler->filter('.container-fluid'));
        $link = $crawler->selectLink('Ответы »')->link();
        $client->click($link);
        $this->assertResponseStatusCodeSame(200);
        $this->assertPageTitleContains('QaA');
    }

    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $link = $crawler->selectLink('Вход')->link();
        $client->click($link);
        $this->assertResponseStatusCodeSame(200);
        $this->assertPageTitleContains('Авторизация');
        $client->submitForm('Авторизоваться', $this->falseCredentials);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorTextContains('.alert.alert-danger', 'Invalid credentials.');
        $client->submitForm('Авторизоваться', $this->trueCredentials);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertPageTitleContains('QaA');
    }

    public function testAdding()
    {
        $client = static::createClient();
        $client->request('GET', '/add/question');
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertPageTitleContains('Авторизация');
        $client->submitForm('Авторизоваться', $this->trueCredentials);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $question = [
            'question[title]' => '      ',
            'question[text]' => '      ',
            'question[category][name]' => '      '
        ];
        $client->submitForm('Отправить на проверку', $question);
        $this->assertResponseStatusCodeSame(500);
        $client->request('GET', '/add/question');
        $question = [
            'question[title]' => 'Заголовок',
            'question[text]' => 'Текст',
            'question[category][name]' => 'Категория'
        ];
        $client->submitForm('Отправить на проверку', $question);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertPageTitleContains('QaA');
    }
}
