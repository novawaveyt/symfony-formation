<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;    
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        
        $users =[] ;
        $genres = ['male','female'];

        for ($i = 1; $i<=10; $i++) {
            $user = new User();

            $genre = $faker->randomElement($genres);

            $pic="https://randomuser.me/portraits/";            
            $pic .= ($genre == 'male' ? 'men/' : 'women/') . mt_rand(1,99) . '.jpg';

            $content='<p>'.join('</p><p>',$faker->paragraphs(3)).'</p>';

            $hash = $this->encoder->encodePassword($user, 'password');

            $user ->setFirstname($faker->firstname($genre))
                    ->setLastname($faker->lastname)
                    ->setEmail($faker->email)
                    ->setPicture($pic)
                    ->setIntroduction($faker->sentence())
                    ->setHash($hash)
                    ->setDescription($content);

            $manager->persist($user);
            $users[] = $user;
        }

        for ($i = 1; $i<=30; $i++) {
            $ad = new Ad;
            
            $title = $faker->sentence();
            $coverimage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            $content = '<p>'.join('</p><p>',$faker->paragraphs(5)).'</p>';
            
            $user = $users[mt_rand(0, count($users)-1 )];
            
            $ad ->setTitle($title)
                ->setCoverImage($coverimage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40,200))
                ->setRooms(mt_rand(1,5))
                ->setAuthor($user);

            for ($j = 1; $j<=mt_rand(2,5); $j++) {
                $image = new Image();

                $image  ->setUrl($faker->imageUrl())
                        ->setCaption($faker->sentence())
                        ->setAd($ad);

                $manager->persist($image);

            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
