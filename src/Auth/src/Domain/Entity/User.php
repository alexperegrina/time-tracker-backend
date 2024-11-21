<?php
declare(strict_types=1);

namespace DegustaBox\Auth\Domain\Entity;

use DegustaBox\Auth\Domain\ValueObject\Enum\Role;
use DegustaBox\Core\Domain\ValueObject\Enum\Gender;
use DegustaBox\Core\Domain\ValueObject\Name;
use DegustaBox\Core\Domain\ValueObject\Uuid;

class User
{
    protected function __construct(
        public readonly Uuid $id,
        public readonly string $email,
        private string $password,
        private ?Name $name = null,
        private ?Gender $gender = null,
        private array $roles = [],
        private bool $isVerified = false,
    ) {}

    public static function create(Uuid $id, string $email, string $password): self
    {
        return new self($id, $email, $password);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = [Role::USER->value];
        foreach ($this->roles as $role) {
            $roles[] = $role->value;
        }

        return array_unique($roles);
    }

    public function addRole(Role $role): void
    {
        $this->roles[] = $role;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function verify(): void
    {
        $this->isVerified = true;
    }

    public function name(): ?Name
    {
        return $this->name;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function gender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

//    public function setIsVerified(bool $isVerified): void
//    {
//        $this->isVerified = $isVerified;
//    }
}