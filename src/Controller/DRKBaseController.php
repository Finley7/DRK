<?php


namespace App\Controller;


use App\Entity\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class DRKBaseController
 * @package App\Controller
 */
class DRKBaseController extends AbstractController
{
    /**
     * @param $data
     * @param string $status
     * @param int $responseCode
     * @return JsonResponse
     */
    public function createApiResponse($data, string $status = 'ok', $responseCode = 200) {

        return new JsonResponse([
            'status' => $status,
            'data' => $data
        ], $responseCode);
    }

    /**
     * @param $data
     * @return string
     */
    public function serialize($data) {

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $this->getApiResponseContext())];

        $serializer = new Serializer($normalizers, $encoders);

        return json_decode($serializer->serialize($data, 'json'));
    }

    private function getApiResponseContext(): array {
        return [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
            AbstractNormalizer::CALLBACKS => [
                'created' => function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
                    return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
                },
                'dob' => function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
                    return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
                },
                'expires' => function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
                    return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
                },
                'userRoles' => function($userRoles) {
                    $roles = [];
                    foreach($userRoles as $userRole) {
                        $roles[] = [
                            'name' => $userRole->getName(),
                            'description' => $userRole->getDescription(),
                            'permissions' => $userRole->getPermissions()->map(function($permssion) {
                                return $permssion->getName();
                            })
                        ];
                    }

                    return $roles;
                }
            ],
        ];
    }

    protected function slugify(string $text): string
    {

        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;

    }
}
