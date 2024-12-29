<?php

namespace App\Models\Block;

use App\Filament\Helpers\Translatable;
use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasSection;
use App\Helpers\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * App\Models\Block\BlockFeature
 *
 * @property int $id
 * @property int $user_id
 * @property int $block_id
 * @property int|null $parent_id
 * @property int $order
 * @property int $status
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature active()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature doesntHaveChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature listsTranslations(string $translationField)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature newModelQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature newQuery()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature notTranslatedIn(?string $locale = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature query()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature translated()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature translatedIn(?string $locale = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature translations()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereBlockId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereCreatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereOrder($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereParentId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereStatus($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereUpdatedAt($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature whereUserId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|BlockFeature withTranslation(?string $locale = null)
 * @property int $admin_id
 */
class BlockFeature extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \App\Helpers\Translatable, HasAuthor, Auditable, HasStatus, HasMedia, \App\Helpers\HasTranslations, HasRecursiveRelationships;


    public $translationModel = BlockFeatureLang::class;

    protected $guarded = [
        'id', 'created_at', 'updated_at',
    ];

    public array $translatedAttributes = [
        'image_id', 'title', 'second_title', 'description'
    ];

    public array $upload_attributes = [
        'image_id'
    ];


    public function block(){
        return $this->belongsTo(Block::class);
    }

    public function children(){
        return $this->hasMany(BlockFeature::class, 'parent_id', 'id')
            ->whereNotNull('parent_id')
            ->with('children');
    }
}
