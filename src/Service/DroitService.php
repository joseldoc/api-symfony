<?php
    namespace App\Service;

    use App\Entity\Droit;
    use FOS\RestBundle\Controller\AbstractFOSRestController;
    use FOS\RestBundle\Request\ParamFetcher;
    use FOS\RestBundle\View\View;
    use Symfony\Component\HttpFoundation\Response;

    use Symfony\Component\Serializer\Encoder\JsonEncoder;
    use Symfony\Component\Serializer\Serializer;

    class DroitService extends AbstractFOSRestController
    {

        public function getAll():View
        {
            $roles = $this->getDoctrine()->getRepository(Droit::class)->findAll();
            $_roles = array_map(function(Droit $role) {
                return self::getSerializer($role);
            }, $roles);
            return $this->view($_roles, Response::HTTP_OK);
        }

        public function add(ParamFetcher $params):View {
            $data = $params->all();

            if(self::handleParams($data)['isDone']) {
               return $this->view(self::handleParams($data)['message'], Response::HTTP_BAD_REQUEST);
            }

            $droit = $this->getDoctrine()->getRepository(Droit::class)->findOneBy(['name' => $data['name']]);
            if($droit instanceof Droit) {
                return $this->view(['message' => 'Role already exist'], Response::HTTP_CONFLICT);
            }
            // CREATE ROLE
            $data['createdAt'] = new \DateTime('now');

            /** @var Serializer */
            $serializer = new Serializer([CustomSerializationObject::denormalizeDateTime()], [new JsonEncoder()]);
            /** @var Droit $role */
            $role = $serializer->denormalize($data, Droit::class, 'json');
            try {
                $this->getDoctrine()->getRepository(Droit::class)->add($role);
                return $this->view(self::getSerializer($role), Response::HTTP_CREATED);
            }
            catch (\Exception $e) {
                return $this->view(['message' => 'Impossible to add role'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        public function getOne(Droit $role) {
            return $this->view(self::getSerializer($role), Response::HTTP_OK);
        }

        public function update(Droit $droit, ParamFetcher $params) {
            $data = $params->all();

            if(self::handleParams($data)['isDone']) {
                return $this->view(self::handleParams($data)['message'], Response::HTTP_BAD_REQUEST);
            }
            // VERIFY IF W UPDATE TO A ROLE EXIST
            if($this->getDoctrine()->getRepository(Droit::class)->existDroitUpdate($droit)) {
                return $this->view(['You want to update to role already exist'], Response::HTTP_NO_CONTENT);
            }

            $data['updatedAt'] = new \DateTime('now');

            /** @var Serializer */
            $serializer = new Serializer([CustomSerializationObject::denormalizeDateTime()], [new JsonEncoder()]);
            /** @var Droit $role */
            $role = $serializer->denormalize($data, Droit::class, 'json', ['object_to_populate' => $droit]);

            try {
                $this->getDoctrine()->getRepository(Droit::class)->add($role);
                return $this->view(self::getSerializer($role), Response::HTTP_CREATED);
            }
            catch (\Exception $e) {
                return $this->view(['message' => 'Impossible to update role'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        public function delete(Droit $droit) {
            try {
                $this->getDoctrine()->getRepository(Droit::class)->delete($droit);
                return $this->view([], Response::HTTP_NO_CONTENT);
            }
            catch (\Exception $e) {
                return $this->view(['message' => 'Impossible to update role'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        private static function handleParams(array $params) {
            if(!isset($params['name']) || !$params['name']) {
                return [
                    'message' => 'Information required',
                    'isDone' => true
                ];
            }
            return ['isDone' => false];
        }

        public static function getSerializer(Droit $role) {
            $serializer = new Serializer([CustomSerializationObject::denormalizeDateTime()], [new JsonEncoder()]);
            return $serializer->normalize($role, 'json', ['ignored_attributes' => ['users']]);
        }
    }
