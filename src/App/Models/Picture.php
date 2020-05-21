<?php

namespace LaravelEnso\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Core\App\Models\User;
use LaravelEnso\Files\App\Contracts\Attachable;
use LaravelEnso\Files\App\Contracts\AuthorizesFileAccess;
use LaravelEnso\Files\App\Traits\HasFile;

class Picture extends Model implements Attachable, AuthorizesFileAccess
{
    use HasFile;

    public const Width = 1000;
    public const Height = 1000;
    public const DefaultPicture = 'default-picture.png';

    protected $table = 'product_pictures';

    protected $fillable = ['product_id', 'order_index'];

    protected $touches = ['product'];

    protected $folder = 'pictures';

    protected $optimizeImages = true;

    protected $resizeImages = [
        'width' => self::Width,
        'height' => self::Height,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function reorder(int $newIndex)
    {
        $order = $newIndex >= $this->order_index ? 'asc' : 'desc';

        $this->update(['order_index' => $newIndex]);

        $this->product->pictures()
            ->orderBy('updated_at', $order)
            ->get()
            ->each(fn ($picture, $index) => $picture
                ->update(['order_index' => $index + 1]));
    }

    public function url()
    {
        $appUrl = Config::get('app.url');

        return "{$appUrl}/{$this->folder()}/{$this->file->saved_name}";
    }

    public static function defaultUrl()
    {
        $appUrl = Config::get('app.url');
        $fileName = self::DefaultPicture;

        return "{$appUrl}/images/{$fileName}";
    }

    public function viewableBy(User $user): bool
    {
        return true;
    }

    public function shareableBy(User $user): bool
    {
        return true;
    }

    public function destroyableBy(User $user): bool
    {
        return true;
    }
}
