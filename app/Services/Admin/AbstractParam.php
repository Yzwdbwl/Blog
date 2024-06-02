<?php namespace App\Services\Admin;

use ArrayAccess;

/**
 *     
 *
 *
 */
abstract class AbstractParam implements ArrayAccess
{
    /**
     *          
     * 
     * @var array
     */
    protected $attributes = [];

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
    
    /**
     *          
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Dynamically access container services.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this[$key];
    }

    /**
     * magic function
     */
    public function __isset($key)
    {
        return isset($this[$key]) and isset($this->attributes[$key]);
    }

    /**
     * magic function
     */
    public function __unset($key)
    {
        if(isset($this->attributes[$key])) unset($this->attributes[$key], $this[$key]);
    }

    /**
     *           
     * 
     * @param array $attributes       
     */
    public function setAttributes($attributes)
    {
        $reflection = new \ReflectionClass($this);
        $attributes = (array) $attributes;
        foreach($attributes as $key => $value)
        {
            if($reflection->hasProperty($key) and ! isset($this->attributes[$key]))
            {
                $this->$key = $this->attributes[$key] = $value;
            }
        }
        return $this;
    }

}
