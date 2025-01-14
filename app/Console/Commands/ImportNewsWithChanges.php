<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportNewsWithChanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импортирует новости из старой базы с преобразованием структуры';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Получаем данные из старой таблицы
        $oldNews = DB::connection('old_database')->table('news')->get();

        foreach ($oldNews as $item) {
            DB::table('news')->insert([
                'title_ru' => $item->ru_title,
                'title_kz' => $item->kk_title,
                'title_en' => $item->en_title,

                'text_ru' => $item->ru_content,
                'text_kz' => $item->kk_content,
                'text_en' => $item->en_content,

                'views_ru' => $item->ru_views,
                'views_kz' => $item->kk_views,
                'views_en' => $item->en_views,

                'preview' => $item->image,
                'published' => $item->published,

                'author' => 'admin', // Пример заполнения нового столбца
                'department' => 'skma', // Пример заполнения нового столбца

                'slug_ru' => $item->ru_slug,
                'slug_kz' => $item->kk_slug,
                'slug_en' => $item->en_slug,

                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ]);

            $this->info("Новость \"{$item->ru_title}\" успешно импортирована.");
        }

        $this->info('Импорт завершён!');
    }
}
