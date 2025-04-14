<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'country_code',
        'cookie_id',
        'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];


    /**
     * Возвращает список доступных периодов.
     * Здесь ключ 'all' означает выборку за всё время.
     */
    public static function periodOptions(): array
    {
        return [
            'today' => Carbon::today(),
            'month' => Carbon::today()->subMonth(),
            'all'   => null, // null – без ограничений по дате
        ];
    }

    /**
     * Скоуп для выборки визитов по указанному периоду.
     * Возможные значения параметра:
     *  - 'today': последние 24 часа (от текущего момента)
     *  - 'month': последние 30 дней (месяц)
     *  - 'all': все записи (без фильтра по дате)
     *
     * Пример использования:
     * Visitor::byPeriod('today')->get();
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $period
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPeriod($query, string $period): \Illuminate\Database\Eloquent\Builder
    {
        switch ($period) {
            case 'today':
                // Выбираем визиты за последние 24 часа
                return $query->where('created_at', '>=', Carbon::now()->subDay());
            case 'month':
                // Выбираем визиты за последний месяц (30 дней)
                return $query->where('created_at', '>=', Carbon::now()->subMonth());
            case 'all':
            default:
                // Все визиты без ограничения по дате
                return $query;
        }
    }

    /**
     * (Опционально) Метод для получения статистики визитов сгруппированных по коду страны.
     *
     * @param string $period Ключ периода ('today', 'month' или 'all')
     * @return \Illuminate\Support\Collection
     */
    public static function getVisitsGroupedByCountry(string $period)
    {
        return self::byPeriod($period)
            ->select('country_code', DB::raw('count(*) as count'))
            ->groupBy('country_code')
            ->orderByDesc('count')
            ->get();
    }
}
