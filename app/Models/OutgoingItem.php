<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingItem extends Model
{
    protected $table = 'outgoing_items';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;

    // public $fillable = [
    //     'item_id',
    //     'name',
    //     'description',
    //     'quantity',
    // ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
