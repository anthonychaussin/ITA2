<?php

namespace App\DataFixtures;


use App\Entity\Post;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PostFixtures extends BaseFixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadData($manager);

        /** @var Post[] $type */
        $posts = [];
        /** @var User[] $type */
        $user = [];
        /** @var Type[] $type */
        $type = [];

        $video = ['https://www.youtube.com/watch?v=PIzDM5JXl9Q', 'https://www.youtube.com/watch?v=SPg7hOxFItI', 'https://www.youtube.com/watch?v=yuOsQEjqEP0', 'https://www.youtube.com/watch?v=gY3p2e1-kN4'];

        array_push($type, ((new Type())->setLabel('IMAGE')));
        array_push($type, ((new Type())->setLabel('VIDEO')));

        for ($i = 300; $i > 0; --$i) {
            $userTemp = (new User());
            $userTemp->setRoles(['ROLE_USER'])
                ->setEmail($this->faker->email)
                ->setPassword($this->encoder->encodePassword($userTemp, $this->faker->password()));
            array_push($user, ($userTemp));
        }

        for ($i = 1500; $i > 0; --$i) {
            $postsTemp = (new Post())
                ->setType($type[$this->faker->randomKey($type)])
                ->setTitle($this->faker->text(50))
                ->setUser($user[$this->faker->randomKey($user)])
                ->setDate($this->faker->dateTime);

            switch ($postsTemp->getType()->getLabel()) {
                case 'IMAGE':
                    $postsTemp->setRessource($this->faker->imageUrl());
                    break;
                case 'VIDEO':
                    $postsTemp->setRessource($video[$this->faker->randomKey($video)]);
                    break;
            }
            array_push($posts, ($postsTemp));
        }


        foreach ($user as $u) {
            $manager->persist($u);
        }
        foreach ($type as $t) {
            $manager->persist($t);
        }
        foreach ($posts as $p) {
            $manager->persist($p);
        }
        $manager->flush();

    }
}