<?php

namespace UserBundle\Services;

use UserBundle\Entity\User;
use Symfony\component\Security\Core\Encoder\EncoderFactory;

/**
 * Class UserService
 */
class UserService
{
    /**
     * @var EncoderFactory
     */
    private $encoderFactory;

    /**
     * @param EncoderFactory $encoderFactory
     */
    public function __construct(EncoderFactory $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param User   $user
     * @param string $password
     *
     * @return bool
     */
    public function isPasswordCorrect(User $user, $password)
    {
        $encoder = $this->encoderFactory->getEncoder($user);

        if($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            return true;
        }

        return false;
    }

    /**
     * @param User   $user
     * @param string $password
     *
     * @return User
     */
    public function updatePassword(User $user, $password)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        $encodedPass = $encoder->encodePassword($password, $user->getSalt());

        $user->setPassword($encodedPass);

        return $user;
    }
}