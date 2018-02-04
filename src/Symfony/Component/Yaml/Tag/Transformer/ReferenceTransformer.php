<?php declare(strict_types=1);

namespace Symfony\Component\Yaml\Tag\Transformer;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Yaml\Exception\TransformException;
use Symfony\Component\Yaml\Tag\TaggedValue;

class ReferenceTransformer implements TagTransformerInterface
{
    private $accessor;

    public function __construct(PropertyAccessor $accessor = null)
    {
        $this->accessor = $accessor ?: PropertyAccess::createPropertyAccessor();
    }

    /** {@inheritDoc} */
    public function getName(): string
    {
        return 'yaml/ref';
    }

    /** {@inheritDoc} */
    public function transform(TaggedValue $tag, $data, int $flags = 0, string $parsedFile = null)
    {
        try {
            // Simple for now, next step would be to resolve other references if needed, then
            // after that detect cyclic references.
            return $this->accessor->getValue($data, $tag->getValue());
        } catch (ExceptionInterface $e) {
            throw new TransformException(
                sprintf('Could not resolve reference "%s".', $tag->getValue()),
                $this->getName(),
                $parsedFile,
                0,
                $e
            );
        }
    }
}