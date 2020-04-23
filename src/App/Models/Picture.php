<?php

namespace LaravelEnso\Products\App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Files\App\Contracts\Attachable;
use LaravelEnso\Files\App\Traits\HasFile;

class Picture extends Model implements Attachable
{
    use HasFile;

    public const Width = 1000;
    public const Height = 1000;

    protected $table = 'product_pictures';

    protected $fillable = ['product_id', 'order_index'];

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
        $this->update(['order_index' => $newIndex]);

        $this->product->pictures()
            ->orderBy('order_index')
            ->orderByDesc('updated_at')
            ->get()
            ->each(fn ($picture, $index) => $picture
                ->update(['order_index' => $index + 1]));
    }
}
