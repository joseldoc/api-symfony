<?php
    namespace App\Service;

    use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
    use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

    class CustomSerializationObject {

        public static function denormalizeDateTime()
        {

            $dateCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
                return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
            };
            $defaultContext = [
                AbstractNormalizer::CALLBACKS => [
                    'createdAt' => $dateCallback,
                    'updatedAt' => $dateCallback
                ],
            ];
            $normalizer = new GetSetMethodNormalizer(null, null, null, null, null, $defaultContext);
            return $normalizer;
        }

    }
