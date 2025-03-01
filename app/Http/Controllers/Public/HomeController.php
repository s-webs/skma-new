<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announce;
use App\Models\Counter;
use App\Models\News;
use App\Models\OrgNode;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $counters = Counter::take(4)->get();
        $services = Service::query()->where('active', '=', 1)->orderBy('order')->get();
        $announcements = Announce::query()
            ->where('is_published', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($announcement) {
                return [
                    'title' => $announcement->getProperty('title'),
                    'description' => $announcement->getProperty('description'),
                    'link' => $announcement->getProperty('link'),
                    'image' => $announcement->getProperty('image'),
                ];
            });
        $news = News::query()
            ->where('published', '=', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(6)
            ->map(function ($newsItem) {
                // Обрезаем заголовки
                $newsItem->title_ru = Str::limit($newsItem->title_ru, 60, '...');
                $newsItem->title_kz = Str::limit($newsItem->title_kz, 60, '...');
                $newsItem->title_en = Str::limit($newsItem->title_en, 60, '...');
                return $newsItem;
            });

        return view('pages.home.index', compact('counters', 'services', 'news', 'announcements'));
    }

    public function academyStructure()
    {
        $nodes = OrgNode::all(); // Загружаем все узлы
        $data = $this->buildTree($nodes);

        return view('pages.about.structure', compact('data'));
    }

    private function buildTree($nodes, $parentId = null)
    {
        return $nodes->where('parent_id', $parentId)->map(function ($node) use ($nodes) {
            return [
                'id' => $node->id,
                'name' => $node->name_ru,
                'description' => $node->description_ru,
                'children' => $this->buildTree($nodes, $node->id),
            ];
        });
    }
}
