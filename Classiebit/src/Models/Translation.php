<?php

namespace Classiebit\Eventmie\Models;

class translation extends \TCG\Voyager\Models\Translation
{
    protected $fillable = ['id', 'table_name', 'column_name', 'foreign_key', 'locale', 'value'];
}
