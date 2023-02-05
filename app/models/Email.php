<?php

namespace app\models;

class Email
{
    protected $dbc;
    protected $tableName;
    protected $fields;

    public function __construct($dbc, $tableName) {
        $this->dbc = $dbc;
        $this->tableName = $tableName;
        $this->initFields();
    }

    public function initFields()
    {
        $this->fields = [
            'email'
        ];
    }

    public function findBy($fieldName, $fieldValue): bool
    {
        $sql = "SELECT * FROM $this->tableName WHERE $fieldName = '$fieldValue'";
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute();
        $databaseData = $stmt->fetch();

        if ($databaseData) {
            return true;
        }
        return false;
    }

    public function setValues($values, $object = null)
    {
        if (is_null($object)) {
            $object = $this;
        }

        foreach ($object->fields as $fieldName) {
            if (isset($values[$fieldName])) {
                $object->$fieldName = $values[$fieldName];
            }
        }

        return $object;
    }

    public function insert()
    {
        $fieldBindingsString = join(', ', $this->fields);
        $preparedFields = [];

        foreach ($this->fields as $fieldName) {
            $preparedFields[] = '"' . $this->$fieldName . '"';
        }

        $valuesString = join(', ', $preparedFields);

        $sql = "INSERT INTO $this->tableName ($fieldBindingsString) VALUES ($valuesString)";

        $stmt = $this->dbc->prepare($sql);
        $stmt->execute();
    }
}