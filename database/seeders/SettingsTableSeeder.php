<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Backpack\Settings\app\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * The settings to add.
     *
     * php artisan db:seed --class=SettingsTableSeeder
     *
     */
    protected $settings = [
        'contact_email' => [
            'name'        => 'Contact form email address',
            'description' => 'The email address that all emails from the contact form will go to.',
            'value'       => 'lovsokheang@gamil.com',
            'field'       => '{"name":"value","label":"Value","type":"email"}',
            'active'      => 1,
        ],
        'project_name' => [
            'name' => 'Project Name',
            'description' => 'Naming the system.',
            'value' => 'BROBUG',
            'field' => '{"name":"value","label":"Value","type":"text"}',
            'active' => 1
        ],
        'project_logo' => [
            'name' => 'Project Logo',
            'description' => 'Logo or Text for project.',
            'value' => '<img alt="bugbro" src="http://127.0.0.1:8000/uploads/bugbro.png" style="width:110px" />',
            'field' => '{"name":"value","label":"Value","type":"wysiwyg","options":{"enterMode":"CKEDITOR.ENTER_BR","shiftEnterMode":"CKEDITOR.ENTER_P"}}',
            'active' => 1
        ],
        'browser_tab_logo' => [
            'name' => 'Browser Tab Logo',
            'description' => 'Logo for browser tab.',
            'value' => 'http://127.0.0.1:8000/uploads/b-logo.png',
            'field' => '{"name":"value","label":"Value","type":"wysiwyg","options":{"enterMode":"CKEDITOR.ENTER_BR","shiftEnterMode":"CKEDITOR.ENTER_P"}}',
            'active' => 1
        ],
        'feature_period' => [
            'name' => 'Feature period',
            'description' => 'Feature period.',
            'value' => 30,
            'field' => '{"name":"value","label":"Value","type":"number"}',
            'active' => 1
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect($this->settings)->each(function ($v, $k) {
            Setting::firstOrCreate(['key' => $k], $v);
        });
    }

}
