<?php

namespace App\Core;

use App\Core\Contracts\DataStorage;
use App\Core\Enums\Operation;

class Model {
    protected $table_name;
    protected $columns;
    protected $attributes = [];
    protected $default = [];
    protected DataStorage $storage;
    protected $is_new;

    /**
     * Constructor to init the props
     *
     * @param array $data
     */
    public function __construct(array $data = [], bool $is_new = true)
    {
        $this->storage = container()->make(DataStorage::class);
        $this->attributes = array_merge($this->attributes, $data);
        $this->is_new = $is_new;
    }

    /**
     * Get the virtual property value
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        $accessor = strtolower('get'.$name.'attribute');
        if(method_exists($this, $accessor)){
            return $this->$accessor();
        }
        
        if(isset($this->attributes[$name])){
            return $this->attributes[$name];
        }

        return null;
    }

    /**
     * Set the virtual property value
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Get all the records
     *
     * @return array
     */
    public static function all(): array
    {
        $instance = new static();
        $records = $instance->storage->getAllRecords($instance->table_name);

        $collection = [];
        if($records){
            foreach($records as $record){
                $collection[] = new static($record, false);
            }
        }

        return $collection;
    }
    
    /**
     * Find the first value by column name and value
     *
     * @param string $column_name
     * @param mixed $value
     * @return Model|null
     */
    public static function find(string $column_name, mixed $value): Model|null
    {
        $records = self::all();

        if(!$records){
            return null;
        }

        foreach($records as $record){
            if($record->$column_name == $value){
                return $record;
            }
        }

        return null;

    }
    
    /**
     * Find all the records by column name and value
     *
     * @param array $conditions
     * @param Operation $operation
     * @return array
     */
    public static function findAll(array $conditions, Operation $operation = Operation::AND): array
    {
        $records = self::all();

        if(!$records){
            return [];
        }

        $filteredRecords = [];

        foreach($records as $record){
            $is_valid = true;

            foreach($conditions as $condition){
                $isMatch = dynamicCompare($record->{$condition[0]}, $condition[1], $condition[2]);
                if($isMatch){
                    $is_valid = true;
                    break;
                }

                if(!$isMatch){
                    $is_valid = false;
                }
            }

            if( $is_valid){
                $filteredRecords[] = $record;
               
            }
        }

        return $filteredRecords;

    }
    
    /**
     * Create a new record
     *
     * @param array $data
     * @return Model
     */
    public static function create(array $data): Model
    {
        $instance = new static($data);
        $instance->save();

        return $instance;
    }
    
    /**
     * Save the model to the storage
     *
     * @return boolean
     */
    public function save(): bool
    {
        $data = $this->getStoreableData();
        if($this->is_new){
            return $this->storage->addNewRecord($this->table_name, $data);
        }

        return $this->storage->updateRecord($this->table_name, $data, $this->id);
    }

    /**
     * Get the data that matched the table schema
     *
     * @return array
     */
    private function getStoreableData(): array
    {
        $data = [];
        $data['id'] = $this->is_new ? generateUniqueId() : $this->id;

        foreach($this->columns as $column){
            $data[$column] = $this->attributes[$column] ?? $this->default[$column] ?? '';
        }

        $data['created_at'] = $this->is_new ? date(DATETIME_FORMAT) : $this->id;

        return $data;
    }
}