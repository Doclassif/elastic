<?php 

namespace Kali\Elastic;

use Monolog\LogRecord as DefaultLogRecord;
use Monolog\Level;

class LogRecord implements DefaultLogRecord
{
    private const MODIFIABLE_FIELDS = [
        'extra' => true,
        'formatted' => true,
        'meta' => true,
    ];

    public function __construct(
        public readonly \DateTimeImmutable $datetime,
        public readonly string $channel,
        public readonly Level $level,
        public readonly string $message,
        /** @var array<mixed> */
        public readonly array $context = [],
        /** @var array<mixed> */
        public array $extra = [],
        public mixed $formatted = null,
        public array $meta = [],
    ) {
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === 'extra') {
            if (!is_array($value)) {
                throw new \InvalidArgumentException('extra must be an array');
            }

            $this->extra = $value;

            return;
        }
        
        if ($offset === 'meta') {
            if (!is_array($value)) {
                throw new \InvalidArgumentException('meta must be an array');
            }

            $this->meta = $value;

            return;
        }

        if ($offset === 'formatted') {
            $this->formatted = $value;

            return;
        }

        throw new \LogicException('Unsupported operation: setting '.$offset);
    }

    public function offsetExists(mixed $offset): bool
    {
        if ($offset === 'level_name') {
            return true;
        }

        return isset($this->{$offset});
    }
    public function &offsetGet(mixed $offset): mixed
    {
        if ($offset === 'level_name' || $offset === 'level') {
            // avoid returning readonly props by ref as this is illegal
            if ($offset === 'level_name') {
                $copy = $this->level->getName();
            } else {
                $copy = $this->level->value;
            }

            return $copy;
        }

        if (isset(self::MODIFIABLE_FIELDS[$offset])) {
            return $this->{$offset};
        }

        // avoid returning readonly props by ref as this is illegal
        $copy = $this->{$offset};

        return $copy;
    }
    
    public function offsetUnset(mixed $offset): void
    {
        throw new \LogicException('Unsupported operation');
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'context' => $this->context,
            'level' => $this->level->value,
            'level_name' => $this->level->getName(),
            'channel' => $this->channel,
            'datetime' => $this->datetime,
            'extra' => $this->extra,
            'meta' => $this->meta,
        ];
    }

    public function with(mixed ...$args): self
    {
        foreach (['message', 'context', 'level', 'channel', 'datetime', 'extra', 'meta'] as $prop) {
            $args[$prop] ??= $this->{$prop};
        }

        return new self(...$args);
    }
}
