<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.name' => 'ឈ្មោះ',
    'column.guard_name' => 'ឈ្មោះអ្នកមើល',
    'column.roles' => 'តួនាទី',
    'column.permissions' => 'ការអនុញ្ញាតិ',
    'column.updated_at' => 'បានធ្វើបច្ចុប្បន្នភាពនៅ',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'ឈ្មោះ',
    'field.guard_name' => 'ឈ្មោះអ្នកមើល',
    'field.permissions' => 'ការអនុញ្ញាតិ',
    'field.select_all.name' => 'ជ្រើសរើសទាំងអស់',
    'field.select_all.message' => 'បើកការអនុញ្ញាតទាំងអស់ដែលបច្ចុប្បន្នត្រូវបាន <span class="text-primary font-medium">បើកដំណើរការ</span> សម្រាប់តួនាទីនេះ។',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'Filament Shield',
    'nav.role.label' => 'តួនាទី',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'តួនាទី',
    'resource.label.roles' => 'តួនាទី',

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'អង្គភាព',
    'resources' => 'ប្រភព',
    'widgets' => 'តារាង',
    'pages' => 'ទំព័រ',
    'custom' => 'ការអនុញ្ញាតផ្ទាល់ខ្លួន',

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'forbidden' => 'អ្នកមិនមានសិទ្ធិចូលប្រើទេ។',

    /*
    |--------------------------------------------------------------------------
    | Resource Permissions' Labels
    |--------------------------------------------------------------------------
    */

    'resource_permission_prefixes_labels' => [
        'view' => 'មើល',
        'view_any' => 'មើលសន្ទស្សន៍',
        'create' => 'បង្កើត',
        'update' => 'ធ្វើបច្ចុប្បន្នភាព',
        'delete' => 'លុប',
        'delete_any' => 'លុបទាំងបាច់',
        'force_delete' => 'បង្ខំ​លុប',
        'force_delete_any' => 'បង្ខំលុបណាមួយ។',
        'restore' => 'ស្តារ',
        'restore_any' => 'ស្តារណាមួយ។',
        'reorder' => 'តម្រៀបឡើងវិញ',
        'replicate' => 'ចម្លង',
    ],
];