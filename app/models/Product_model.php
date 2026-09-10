<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Product_model extends Model
{
    protected $table = 'products';
    protected $fillable = ['product_name', 'description', 'price', 'quantity'];
    protected $timestamps = false;

    public function newest()
    {
        return $this->_query()->order_by('created_at', 'DESC')->get_all() ?: [];
    }
}