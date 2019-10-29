<?php

namespace App\Service;

use App\Entity\Droit;
use App\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class UserService extends AbstractFOSRestController
{

    CONST PWD_REGEX = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&]).{8,10}$/';
    CONST TEL_REGEX = '/^((\+)33|0)[1-9](\d{2}){4}$/';

    private $_encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->_encoder = $encoder;
    }

    public function add(ParamFetcher $params)
    {
        $data = $params->all();
        if (self::isErrorHandleUser($data)['isDone']) {
            return $this->view(['message' => self::isErrorHandleUser($data)['message']], Response::HTTP_BAD_REQUEST);
        }
        // CHECK IF USER EXIST
        $ischeckUserByEmail = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if ($ischeckUserByEmail instanceof User) {
            return $this->view(['message' => 'User already exist'], response::HTTP_BAD_REQUEST);
        }

        /** @var Serializer */
        $serializer = new Serializer([CustomSerializationObject::denormalizeDateTime()], [new JsonEncoder()]);
        /** @var User $user */
        $user = $serializer->denormalize($data, User::class, 'json');

        $role = $this->getDoctrine()->getRepository(Droit::class)->findOneBy(['name' => $data['role']]);

        if (!$role instanceof Droit) {
            return $this->view(['message' => 'Not role defined'], Response::HTTP_BAD_REQUEST);
        }
        $user->setRoles([$role->getName()]);
//        $user->setIsActive(true);
        $user->setPassword($this->_encoder->encodePassword($user, $data['password']));
        try {
            $this->getDoctrine()->getRepository(User::class)->add($user);
            return $this->view($user, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->view(
                [
                    'message' => 'Impossible to add user',
                    'errorCode' => $e->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAll(): View
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $_users = array_map(function ($user) {
            return self::getSerializer($user);
        }, $users);
        return $this->view($_users, Response::HTTP_OK);
    }

    public function getOne(User $user): View
    {
        return $this->view($this->getSerializer($user), Response::HTTP_OK);
    }

    public function update(User $user, ParamFetcher $params)
    {
        $data = $params->all();

        if (self::isErrorHandleUser($data)['isDone']) {
            return $this->view(['message' => self::isErrorHandleUser($data)['message']], Response::HTTP_BAD_REQUEST);
        }

        // Verify if Role is definied
        if (!isset($data['role']) || is_numeric($data['role'])) {
            return $this->view(['message' => 'Role is not definied'], Response::HTTP_BAD_REQUEST);
        }
        // isEmailCheck
        if ($this->getDoctrine()->getRepository(User::class)->existUserUpdate($user)) {
            return $this->view(['message' => 'You want to update to an exist user'], Response::HTTP_CONFLICT);
        }

        $role = $this->getDoctrine()->getRepository(User::class)->findOneBy(is_numeric($data['role']) ? ['id' => $data['role']] : ['name' => $data['role']]);

        if ($role instanceof Droit) {
            $user->setRoles([$role->getName()]);
        } else {
            return $this->view(['message' => 'Role doesn\'t exist'], Response::HTTP_BAD_REQUEST);
        }
        /** @var Serializer */
        $serializer = new Serializer([CustomSerializationObject::denormalizeDateTime()], [new JsonEncoder()]);
        /** @var User $user */
        $userNormalizer = $serializer->denormalize($data, User::class, 'json', ['object_to_populate' => $user]);

        try {
            $this->getDoctrine()->getRepository(User::class)->add($userNormalizer);
            return $this->view($this->getSerializer($userNormalizer), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->view(['message' => 'Impossible to add user'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function delete(User $user)
    {
        try {
            $this->getDoctrine()->getRepository(User::class)->delete($user);
            return $this->view([], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->view(['message' => 'Impossible to deleted user'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private static function isErrorHandleUser(array $data): array
    {
        if (!isset($data['email']) || !isset($data['password']) || !isset($data['phone']) || !isset($data['name']) ||
            !isset($data['username']) || !isset($data['address']) || !isset($data['zipCode']) || !isset($data['city'])) {
            return [
                'message' => 'Information required',
                'isDone' => true
            ];
        }
        // CHECK IF EMAIL IS VALID
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'message' => 'Information required',
                'isDone' => true
            ];
        }
        // CHECK IF PASSWORD IS GOOD
        if (!self::isValidPassword($data['password'])) {
            return [
                'message' => 'The password must have at least 8 characters, 
                    at least 1 digit(s), at least 1 special chars and 1 uppercase',
                'isDone' => true
            ];
        }
        // CHECK IF PHONE IS CORRECT
        if (!filter_var($data['phone'], FILTER_VALIDATE_REGEXP, ["options" => ['regexp' => self::TEL_REGEX]])) {
            return [
                'message' => 'Phone is not correct',
                'isDone' => true
            ];
        }
        return ['isDone' => false];
    }

    public static function isValidPassword($password)
    {
        return filter_var($password, FILTER_VALIDATE_REGEXP, ["options" => ['regexp' => self::PWD_REGEX]]);
    }

    public function activeUser(User $user)
    {
        // Active or Desactive Role
        $user->getIsActive() ? $user->setIsActive(false) : $user->setIsActive(true);
        try {
            $this->getDoctrine()->getRepository(User::class)->add($user);
            return $this->view(['message' => $user->getIsActive() ? 'User is active' : 'User is desactive'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->view(['message' => 'operation impossible'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getSerializer(User $user)
    {
        $json = $this->get('serializer')->normalize(
            $user,
            'json', ['groups' => 'default']
        );
        return $json;
    }
}
