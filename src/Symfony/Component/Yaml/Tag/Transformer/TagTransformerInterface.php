<?php declare(strict_types=1);

namespace Symfony\Component\Yaml\Tag\Transformer;

use Symfony\Component\Yaml\Tag\TaggedValue;

interface TagTransformerInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param \Symfony\Component\Yaml\Tag\TaggedValue $tag
     * @param mixed $data
     * @param integer? $flags
     * @param string? $parsedFile
     * @throws \Symfony\Component\Yaml\Exception\TransformException
     * @return mixed
     */
    public function transform(TaggedValue $tag, $data, int $flags = 0, string $parsedFile = null);
}