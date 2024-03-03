<?php

namespace App\Traits;

trait VisibilityOfWidget
{

    /**
     * Get the roles allowed to view the widget
     * @return array
     */
    protected static function getRolesAllowed(): array
    {
        return [];
    }

    /**
     * Check if the user can view the widget
     * @return bool
     */
    public static function canView(): bool
    {
        if (empty(static::getRolesAllowed())) return true;

        return auth()->user()->hasAnyRole(static::getRolesAllowed());
    }
}