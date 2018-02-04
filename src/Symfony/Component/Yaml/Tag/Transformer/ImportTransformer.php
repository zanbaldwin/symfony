<?php declare(strict_types=1);

namespace Symfony\Component\Yaml\Tag\Transformer;

use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Yaml\Exception\TransformException;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Tag\TaggedValue;

class ImportTransformer implements TagTransformerInterface
{
    private $parser;
    private $fileLocator;

    public function __construct(Parser $parser, FileLocatorInterface $fileLocator = null)
    {
        $this->parser = $parser;
        $this->fileLocator = $fileLocator ?: new FileLocator;
    }

    /** {@inheritDoc} */
    public function getName(): string
    {
        return 'yaml/import';
    }

    /** {@inheritDoc} */
    public function transform(TaggedValue $tag, $data, int $flags = 0, string $parsedFile = null)
    {
        try {
            $importFile = $this->fileLocator->locate(
                $tag->getValue(),
                is_string($parsedFile) ? dirname(realpath($parsedFile)) : null
            );
            return $this->parser->parseFile($importFile, $flags);
        } catch (FileLocatorFileNotFoundException $e) {
            throw new TransformException(
                'Could not locate YAML file to import.',
                $this->getName(),
                $parsedFile,
                0,
                $e
            );
        }
    }
}