<?php
declare(strict_types=1);

namespace DegustaBox\Core\Infrastructure\Validator;

use DegustaBox\Core\Domain\Exception\InvalidPathException;
use DegustaBox\Core\Domain\Exception\SchemaValidatorException;
use DegustaBox\Core\Domain\Validator\SchemaValidator;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;
use Symfony\Component\HttpKernel\KernelInterface;

class OpisSchemaValidator implements SchemaValidator
{
    private Validator $validator;

    /**
     * @throws InvalidPathException
     */
    public function __construct(private readonly KernelInterface $kernel, private readonly array $config)
    {
        $this->init();
        $this->declareResources();
    }

    private function init(): void
    {
        $this->validator = new Validator();
        $this->configure();
    }

    private function configure(): void
    {
        $this->validator->setMaxErrors(10);
        $this->validator->parser()->setOption('defaultDraft', '07');
    }

    /**
     * @throws InvalidPathException
     */
    private function declareResources(): void
    {
        $resolver = $this->validator->resolver();

        foreach ($this->config['declare'] as $item) {
            $path = $this->realPath($item['path']);
            $resolver->registerPrefix($item['prefix'], $path);
        }
    }

    /**
     * @throws InvalidPathException
     */
    private function realPath(string $path): string
    {
        if ($path[0] === '@') {
            $newPath = $this->kernel->locateResource($path);
        } else {
            $newPath = realpath($path);
            if (!$newPath) {
                throw new InvalidPathException($path);
            }
        }

        return $newPath;
    }

    public function validate(object|array $data, string $pathSchema, bool $exception = true): object|array
    {
        $newData = $data;
        $isArray = is_array($newData);

        if (is_array($newData)) {
            $newData = json_decode(json_encode($newData));
        }

        $path = $this->realPath($pathSchema);
        $schema = file_get_contents($path);

        $result = $this->validator->validate($newData, $schema);

        if ($result->hasError() && $exception) {
            $error = $result->error();
            $formatter = new ErrorFormatter();

            throw new SchemaValidatorException($formatter->format($error, false), $data);
        }

        if ($isArray) {
            $newData = json_decode(json_encode($newData), true);
        }

        return $newData;
    }
}