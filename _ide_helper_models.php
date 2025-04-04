<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title_ru
 * @property string $title_kz
 * @property string $title_en
 * @property string $description_ru
 * @property string $description_kz
 * @property string $description_en
 * @property string $slug_ru
 * @property string $slug_kz
 * @property string $slug_en
 * @property int $views_ru
 * @property int $views_kz
 * @property int $views_en
 * @property int $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereDescriptionKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereDescriptionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereSlugEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereSlugKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereSlugRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereTitleKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereTitleRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereViewsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereViewsKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Advert whereViewsRu($value)
 */
	class Advert extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title_ru
 * @property string $title_kz
 * @property string $title_en
 * @property string|null $description_ru
 * @property string|null $description_kz
 * @property string|null $description_en
 * @property string|null $link_ru
 * @property string|null $link_kz
 * @property string|null $link_en
 * @property string $image_ru
 * @property string $image_kz
 * @property string $image_en
 * @property int $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereDescriptionKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereDescriptionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereImageEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereImageKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereImageRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereLinkEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereLinkKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereLinkRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereTitleKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereTitleRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announce whereUpdatedAt($value)
 */
	class Announce extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_kz
 * @property string|null $name_en
 * @property string $image_kz
 * @property string $image_ru
 * @property string $image_en
 * @property int $sort_order
 * @property int $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereImageEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereImageKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereImageRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereNameKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereUpdatedAt($value)
 */
	class Award extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel query()
 */
	class BaseModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $news_id
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\News $news
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereNewsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUserId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name_ru
 * @property string $name_kz
 * @property string $name_en
 * @property int $count
 * @property string|null $image
 * @property string|null $link_ru
 * @property string|null $link_kz
 * @property string|null $link_en
 * @property int $link_external
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereLinkEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereLinkExternal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereLinkKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereLinkRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereNameKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Counter whereUpdatedAt($value)
 */
	class Counter extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $preview
 * @property string $name_ru
 * @property string $name_kz
 * @property string $name_en
 * @property string $description_ru
 * @property string $description_kz
 * @property string $description_en
 * @property array<array-key, mixed>|null $staff
 * @property \Illuminate\Support\Collection<array-key, mixed>|null $umkd
 * @property string|null $portfolio
 * @property array<array-key, mixed>|null $documents_en
 * @property array<array-key, mixed>|null $documents_kz
 * @property array<array-key, mixed>|null $documents_ru
 * @property array<array-key, mixed>|null $contacts_ru
 * @property array<array-key, mixed>|null $contacts_kz
 * @property array<array-key, mixed>|null $contacts_en
 * @property int|null $parent_id
 * @property string|null $slug_en
 * @property string|null $slug_kz
 * @property string|null $slug_ru
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Faculty|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereContactsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereContactsKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereContactsRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereDescriptionKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereDescriptionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereDocumentsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereDocumentsKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereDocumentsRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereNameKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department wherePortfolio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereSlugEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereSlugKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereSlugRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereStaff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereUmkd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereUpdatedAt($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $preview
 * @property string $name_ru
 * @property string $name_kz
 * @property string $name_en
 * @property string $description_ru
 * @property string $description_kz
 * @property string $description_en
 * @property array<array-key, mixed>|null $staff_ru
 * @property array<array-key, mixed>|null $staff_kz
 * @property array<array-key, mixed>|null $staff_en
 * @property array<array-key, mixed>|null $documents_ru
 * @property array<array-key, mixed>|null $documents_kz
 * @property array<array-key, mixed>|null $documents_en
 * @property array<array-key, mixed>|null $contacts_ru
 * @property array<array-key, mixed>|null $contacts_kz
 * @property array<array-key, mixed>|null $contacts_en
 * @property string|null $slug_en
 * @property string|null $slug_kz
 * @property string|null $slug_ru
 * @property int|null $parent_id
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Division> $children
 * @property-read int|null $children_count
 * @property-read Division|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereContactsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereContactsKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereContactsRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereDescriptionKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereDescriptionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereDocumentsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereDocumentsKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereDocumentsRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereNameKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereSlugEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereSlugKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereSlugRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereStaffEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereStaffKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereStaffRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereUpdatedAt($value)
 */
	class Division extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $preview
 * @property string $name_ru
 * @property string $name_kz
 * @property string $name_en
 * @property string $description_ru
 * @property string $description_kz
 * @property string $description_en
 * @property array<array-key, mixed>|null $staff_ru
 * @property array<array-key, mixed>|null $staff_kz
 * @property array<array-key, mixed>|null $staff_en
 * @property array<array-key, mixed>|null $documents_ru
 * @property array<array-key, mixed>|null $documents_kz
 * @property array<array-key, mixed>|null $documents_en
 * @property array<array-key, mixed>|null $contacts_ru
 * @property array<array-key, mixed>|null $contacts_kz
 * @property array<array-key, mixed>|null $contacts_en
 * @property string|null $slug_ru
 * @property string|null $slug_kz
 * @property string|null $slug_en
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $children
 * @property-read int|null $children_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereContactsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereContactsKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereContactsRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereDescriptionKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereDescriptionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereDocumentsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereDocumentsKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereDocumentsRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereNameKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereSlugEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereSlugKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereSlugRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereStaffEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereStaffKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereStaffRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereUpdatedAt($value)
 */
	class Faculty extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $image
 * @property string $name
 * @property string $about
 * @property string $message
 * @property string $language
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Feedback whereUpdatedAt($value)
 */
	class Feedback extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title_ru
 * @property string $title_kz
 * @property string $title_en
 * @property string|null $description_ru
 * @property string|null $description_kz
 * @property string|null $description_en
 * @property array<array-key, mixed>|null $cards_ru
 * @property array<array-key, mixed>|null $cards_kz
 * @property array<array-key, mixed>|null $cards_en
 * @property \Illuminate\Support\Collection<array-key, mixed>|null $schedule_lesson
 * @property \Illuminate\Support\Collection<array-key, mixed>|null $schedule_exam
 * @property string $slug_ru
 * @property string $slug_kz
 * @property string $slug_en
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereCardsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereCardsKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereCardsRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereDescriptionKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereDescriptionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereScheduleExam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereScheduleLesson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereSlugEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereSlugKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereSlugRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereTitleKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereTitleRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ForStudent whereUpdatedAt($value)
 */
	class ForStudent extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gallery whereUpdatedAt($value)
 */
	class Gallery extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $news_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\News $news
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereNewsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Like whereUserId($value)
 */
	class Like extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name_ru
 * @property string $name_kz
 * @property string $name_en
 * @property string|null $link_ru
 * @property string|null $link_kz
 * @property string|null $link_en
 * @property int|null $sort_order
 * @property int|null $parent_id
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Menu> $children
 * @property-read int|null $children_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereLinkEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereLinkKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereLinkRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereNameKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereUpdatedAt($value)
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title_ru
 * @property string $title_kz
 * @property string $title_en
 * @property string $text_ru
 * @property string $text_kz
 * @property string $text_en
 * @property int $views_ru
 * @property int $views_kz
 * @property int $views_en
 * @property string $slug_ru
 * @property string $slug_kz
 * @property string $slug_en
 * @property string $preview_ru
 * @property string|null $preview_kz
 * @property string|null $preview_en
 * @property array<array-key, mixed>|null $images
 * @property string|null $author
 * @property string|null $department
 * @property string|null $tags
 * @property int $published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News wherePreviewEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News wherePreviewKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News wherePreviewRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereSlugEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereSlugKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereSlugRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereTextEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereTextKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereTextRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereTitleKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereTitleRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereViewsEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereViewsKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|News whereViewsRu($value)
 */
	class News extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $image
 * @property string $name_ru
 * @property string $name_kz
 * @property string $name_en
 * @property string|null $description_ru
 * @property string|null $description_kz
 * @property string|null $description_en
 * @property int $sort_order
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OrgNode> $children
 * @property-read int|null $children_count
 * @property-read OrgNode|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereDescriptionKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereDescriptionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereNameKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrgNode whereUpdatedAt($value)
 */
	class OrgNode extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_kz
 * @property string|null $name_en
 * @property string|null $logo
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereNameKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereUpdatedAt($value)
 */
	class Partner extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name_ru
 * @property string $name_kz
 * @property string $name_en
 * @property string|null $link_ru
 * @property string|null $link_kz
 * @property string|null $link_en
 * @property string|null $image_ru
 * @property string|null $image_kz
 * @property string|null $image_en
 * @property int $order
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereImageEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereImageKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereImageRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereLinkEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereLinkKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereLinkRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereNameKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property string $code
 * @property string|null $extra
 * @property string|null $pattern_02
 * @property string|null $pattern_01
 * @property string|null $heading
 * @property string|null $primary
 * @property string|null $secondary
 * @property string|null $main
 * @property string|null $halftone
 * @property string|null $dark
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereDark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereHalftone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme wherePattern01($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme wherePattern02($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme wherePrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Theme whereUpdatedAt($value)
 */
	class Theme extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $avatar
 * @property string $name
 * @property string|null $gender
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $department
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $ip_address
 * @property string|null $country_code
 * @property string $viewable_type
 * @property string $viewable_id
 * @property string $locale
 * @property int $viewed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $cookie_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog whereCookieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog whereViewableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog whereViewableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ViewLog whereViewed($value)
 */
	class ViewLog extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $ip_address
 * @property string|null $country_code
 * @property string|null $cookie_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereCookieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Visitor whereUpdatedAt($value)
 */
	class Visitor extends \Eloquent {}
}

