<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingItem extends Model
{
    protected $table = 'incoming_items';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;

    public $fillable = [
        'item_id',
        'name',
        'description',
        'quantity',
        'created_by',
    ];
    
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id','id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }
}
