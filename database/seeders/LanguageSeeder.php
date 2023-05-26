<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public $languages = [];
    public function getLanguages()
    {
        if (empty($this->languages)) {
            $enabled_languages = config('language.enabled_languages', []);
            $available_languages = config('language.available_languages', []);
            if (!empty($enabled_languages) && !empty($available_languages)) {
                foreach ($enabled_languages as $language) {
                    if (!empty($available_languages[$language])) {
                        $this->languages[] = $available_languages[$language];
                    }
                }
            }
        }
        return $this->languages;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // truncate not work with a foreign keys
        //Language::truncate();
        foreach ($this->getLanguages() as $language) {
            Language::create($language);
        }
    }
}
