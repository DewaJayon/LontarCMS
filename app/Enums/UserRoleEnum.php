<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case STAFF = 'staff';
    case RESEARCHER = 'researcher';

    /**
     * Return the label of the user role.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN         => 'Admin',
            self::STAFF         => 'Staff',
            self::RESEARCHER    => 'Researcher',
        };
    }

    /**
     * Returns the value of the user role.
     *
     * @return string
     * @example 'admin', 'user', 'researcher'
     */
    public function value(): string
    {
        return match ($this) {
            self::ADMIN         => 'admin',
            self::STAFF         => 'staff',
            self::RESEARCHER    => 'researcher',
        };
    }

    /**
     * Returns an array of user role options with label and value.
     *
     * The returned array will contain the following format:
     * [
     *     [
     *         'label' => string,
     *         'value' => string,
     *     ],
     * ]
     *
     * @return array
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->map(fn($role) => [
                'label' => $role->label(),
                'value' => $role->value(),
            ])
            ->toArray();
    }
}
