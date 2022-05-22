<?php

namespace App\DataFixtures;

use App\Entity\Aswer;
use App\Entity\Category;
use App\Entity\Question;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $user_danila = new User();
        $user_danila->setUsername('Danila');
        $user_danila->setApiToken(Uuid::v1()->toRfc4122());
        $user_danila->setPassword(password_hash('123456', PASSWORD_DEFAULT));
        $user_danila->setRoles(['ROLE_ADMIN']);
        $manager->persist($user_danila);

        $user_vlad = new User();
        $user_vlad->setUsername('Vlad');
        $user_vlad->setApiToken(Uuid::v1()->toRfc4122());
        $user_vlad->setPassword(password_hash('123456', PASSWORD_DEFAULT));
        $user_vlad->setRoles(['ROLE_ADMIN']);
        $manager->persist($user_vlad);

        $user_dima = new User();
        $user_dima->setUsername('Dima');
        $user_dima->setApiToken(Uuid::v1()->toRfc4122());
        $user_dima->setPassword(password_hash('123456', PASSWORD_DEFAULT));
        $manager->persist($user_dima);


        $category_study = new Category();
        $category_study->setName('Учеба');
        $category_study->setStatus(true);
        $manager->persist($category_study);

        $category_game = new Category();
        $category_game->setName('Игры');
        $category_game->setStatus(true);
        $manager->persist($category_game);

        $category_life = new Category();
        $category_life->setName('Быт');
        $category_life->setStatus(true);
        $manager->persist($category_life);


        $question_study_1 = new Question();
        $question_study_1->setStatus(True);
        $question_study_1->setTitle('Адаптация Winforms под экран C#');
        $question_study_1->setText('У меня монитор (16:9 - 1920/1080). Делал под своё разрешение.На монике (4:3 - 1280/1024) программа улетает за границы экрана. Как сделать адаптацию формы под разрешение экрана?');

        $question_study_1->setDate(new \DateTime('now'));
        $question_study_1->setUser($user_danila);
        $question_study_1->setCategory($category_study);
        $manager->persist($question_study_1);

        $answer_study_1 = new Aswer();
        $answer_study_1->setStatus(False);
        $answer_study_1->setText('Для того, чтобы программа "подстраивалась" под разрешение экрана, нужно воспользоваться контейнерами разметки.');
        $answer_study_1->setDate(new \DateTime('now'));
        $answer_study_1->setUser($user_vlad);
        $answer_study_1->setQuestion($question_study_1);
        $manager->persist($answer_study_1);

        $question_study_2 = new Question();
        $question_study_2->setStatus(False);
        $question_study_2->setTitle('Как подключить географические карты в своё приложение');
        $question_study_2->setText('Всем доброго времени суток. Вопрос такой: как подключить географические карты типа Google Maps или Open street maps в своё приложение? Какой инструментарий для этого требуется?');
        $question_study_2->setDate(new \DateTime('now'));
        $question_study_2->setUser($user_vlad);
        $question_study_2->setCategory($category_study);
        $manager->persist($question_study_2);


        $question_game_1 = new Question();
        $question_game_1->setStatus(True);
        $question_game_1->setTitle('Сбор Кувы');
        $question_game_1->setText('Всем доброго времени суток. Вопрос такой: как и где лучше фармить куву на просторах галктики?');
        $question_game_1->setDate(new \DateTime('now'));
        $question_game_1->setUser($user_danila);
        $question_game_1->setCategory($category_game);
        $manager->persist($question_game_1);

        $answer_game_1 = new Aswer();
        $answer_game_1->setStatus(True);
        $answer_game_1->setText('На звездной карте на планетах возле Крепости Кувы можно найти миссии с особым значком Кува. Миссии генерируются случайно в разных секторах на планетах возле крепости и существуют некоторое время, после чего исчезают и появляются в других секторах.');
        $answer_game_1->setDate(new \DateTime('now'));
        $answer_game_1->setUser($user_dima);
        $answer_game_1->setQuestion($question_game_1);
        $manager->persist($answer_game_1);


        $question_life_1 = new Question();
        $question_life_1->setStatus(True);
        $question_life_1->setTitle('Как сажать клубнику?');
        $question_life_1->setText('Правильная посадка клубники на дачном участке: что нельзя сажать рядом с грядкой?
            ');
        $question_life_1->setDate(new \DateTime('now'));
        $question_life_1->setUser($user_dima);
        $question_life_1->setCategory($category_life);
        $manager->persist($question_life_1);

        $manager->flush();
    }
}
