<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    /**
     * @var UserPasswordEncoderInterface
     */
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr-FR');

        $users = [];
        $genres = ['male','female'];

        //Nous gérons les utilisateurs
        for($i=1; $i<=10; $i++){
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99).'.jpg';

            $picture .= ($genre == 'male' ? 'men/':'women/').$pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>'.join('</p><p>', $faker->paragraphs(3)).'</p>')
                ->setHash($hash)
                ->setEmail($faker->email)
                ->setPicture($picture);

            $manager->persist($user);
            $users[]=$user;
        }

        // Nous gérons les annonces
        for ($i=0; $i<=30; $i++) {
            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

            $user =$users[mt_rand(0,count($users)-1)];

            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40,250))
                ->setRooms(mt_rand(1,5))
                ->setAuthor($user);

            for($j = 1; $j <= mt_rand(2,5); $j++){
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
        }
        $manager->flush();
    }
}
