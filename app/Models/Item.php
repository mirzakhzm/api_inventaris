<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;

    // public $fillable = [
    //     'name',
    //     'description',
    //     'quantity',
    // ];

    public function incomingItems()
    {
        return $this->hasMany(IncomingItem::class, 'item_id', 'id');
    }
    public function outgoingItems()
    {
        return $this->hasMany(OutgoingItem::class, 'item_id', 'id');
    }
}
