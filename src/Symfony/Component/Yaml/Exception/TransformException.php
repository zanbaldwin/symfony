<?php declare(strict_types=1);

namespace Symfony\Component\Yaml\Exception;

class TransformException extends RuntimeException
{
    private $tagName;
    private $parsedFile;

    public function __construct(string $message, string $tagName, string $parsedFile = null, int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->tagName = $tagName;
        $this->parsedFile = $parsedFile;
    }

    public function getTagName(): string
    {
        return $this->tagName;
    }

    public function getParsedFile(): ?string
    {
        return $this->parsedFile;
    }
}