<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleSetting extends Model
{
    public const array MODULES = [
        'dashboard' => 'Dashboard',
        'leads' => 'Leads',
        'contacts' => 'Contacts',
        'companies' => 'Companies',
        'deals' => 'Deals',
        'pipeline' => 'Pipeline',
        'tasks' => 'Tasks',
        'calendar' => 'Calendar',
        'activities' => 'Activities',
        'reports' => 'Reports',
        'expenses' => 'Expenses',
        'automation' => 'Automation',
        'team' => 'Team',
        'settings' => 'Settings',
    ];

    protected $fillable = ['module', 'admin_enabled', 'demo_enabled'];

    protected function casts(): array
    {
        return [
            'admin_enabled' => 'boolean',
            'demo_enabled' => 'boolean',
        ];
    }

    /**
     * @return array<string, bool>
     */
    public static function enabledFor(string $audience): array
    {
        $column = $audience === 'demo' ? 'demo_enabled' : 'admin_enabled';
        $settings = static::query()
            ->whereIn('module', array_keys(self::MODULES))
            ->pluck($column, 'module');

        return collect(self::MODULES)
            ->mapWithKeys(fn (string $label, string $module): array => [$module => (bool) ($settings[$module] ?? true)])
            ->all();
    }
}
