<?php

namespace Reinink\Query;

use \Exception;

abstract class Table
{
	public static function select($id)
	{
		$class = get_called_class();

		$sql = sprintf('SELECT * FROM %s WHERE id = :id', static::$db_table);

		return DB::row($sql, array('id' => $id), $class);
	}

	public function insert()
	{
		$class = get_called_class();

		foreach ($class::$db_fields as $field)
		{
			if (isset($this->$field['name']))
			{
				$fields[] = $field['name'];
				$values[$field['name']] = (isset($field['null']) and $field['null'] === true and $this->$field['name'] === '') ? NULL : $this->$field['name'];
			}
		}

		$sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $class::$db_table, implode(', ', $fields), ':' . implode(', :', $fields));

		DB::query($sql, $values);

		$this->id = DB::connection()->lastInsertId();
	}

	public function update()
	{
		if (!isset($this->id))
		{
			throw new Exception('Primary key (id) not set.');
		}

		$class = get_called_class();

		foreach ($class::$db_fields as $field)
		{
			if (isset($this->$field['name']))
			{
				if ($field['name'] !== 'id')
				{
					$fields[] = $field['name'] . ' = :' . $field['name'];
				}

				if (isset($field['null']) and $field['null'] === true and $this->$field['name'] === '')
				{
					$values[$field['name']] = null;
				}
				else
				{
					$values[$field['name']] = $this->$field['name'];
				}
			}
		}

		$sql = sprintf('UPDATE %s SET %s WHERE id = :id', $class::$db_table, implode(', ', $fields));

		DB::query($sql, $values);
	}

	public function delete()
	{
		if (!isset($this->id))
		{
			throw new Exception('Primary key (id) not set.');
		}

		$class = get_called_class();

		$sql = sprintf('DELETE FROM %s WHERE id = :id', $class::$db_table);

		DB::query($sql, array('id' => $this->id));
	}
}