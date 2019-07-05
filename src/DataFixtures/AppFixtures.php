<?php

namespace App\DataFixtures;

use App\Entity\Comments;
use App\Entity\ContactForProperty;
use App\Entity\Image;
use App\Entity\Properties;
use App\Entity\PropertyLike;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr-FR");

        $users = [];

        $adminUser = new User();
        $adminUser->setLastName('admin')
                  ->setFirstName('admin')
                  ->setEmail('naim@admin.com')
                  ->setAvatar("https://loremflickr.com/64/64")
                  ->setPassword($this->encoder->encodePassword($adminUser, 'password'))
                  ->setRoles(['ROLE_ADMIN'])
                  ->setActive(true);
        $manager->persist($adminUser);


        for($i = 0; $i < 15; $i++)
        {
            $user = new User();

            $user->setLastName($faker->lastName)
                 ->setFirstName($faker->firstName)
                 ->setEmail($faker->email)
                 ->setAvatar("https://loremflickr.com/64/64")
                 ->setPassword($this->encoder->encodePassword($user, 'password'))
                 ->setRoles(['ROLE_USER'])
                 ->setActive(true);

            $manager->persist($user);
            $manager->flush();

            $users[] = $user;
        }
        for($i = 0; $i <= 20; $i++)
        {
            $properties = new Properties();
            $types = ["Appartement", "Maison", "Villa"];
            $actions = ["louer", "vendre"];

            $properties->setType($faker->randomElement($types))
                       ->setCity($faker->city)
                       ->setAddress($faker->address)
                       ->setPostalCode($faker->postcode)
                       ->setPrice(mt_rand(700, 300000))
                       ->setArea(mt_rand(70, 250))
                       ->setBedrooms(mt_rand(2, 5))
                       ->setShower(mt_rand(1, 3))
                       ->setCoverImage("http://lorempixel.com/800/400")
                       ->setDescription("<p>" . join("</p><p>", $faker->paragraphs(4)) . "</p>")
                       ->setAction($faker->randomElement($actions))
                       ->setAuthor($faker->randomElement($users));

            for($j = 1; $j <= mt_rand(2, 5); $j++)
            {
                $image = new Image();

                $image->setPath("https://loremflickr.com/800/400")
                      ->setProperty($properties);

                $manager->persist($image);
            }
            for($j = 1; $j <= mt_rand(2, 4); $j++)
            {
                $contactForProperty = new ContactForProperty();
                $contactForProperty->setMessage($faker->sentence())
                                   ->setAuthor($faker->randomElement($users))
                                   ->setProperty($properties);

                $manager->persist($contactForProperty);
            }

            $manager->persist($properties);

            for($j = 0; $j < mt_rand(0, 10); $j++)
            {
                $like = new PropertyLike();
                $like->setProperty($properties)
                     ->setUser($faker->randomElement($users));

                $manager->persist($like);
            }
        }

        for($i = 0; $i < 10; $i++)
        {
            $comment = new Comments();
            $comment->setMessage($faker->paragraph())
                    ->setAuthor($faker->randomElement($users));

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
