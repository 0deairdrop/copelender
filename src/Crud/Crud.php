<?php
namespace Src\Crud;

class Crud
{
    public static function insert($table, $data)
    {
        global $db;

        $cols = array_keys($data);
        $values = array_values($data);
        //generate the escaping ? based on the number of data keys
        $valString = str_repeat("?,", count($cols));
        //remove the last comma
        $valString = substr($valString, 0, -1);
        $cols = implode(',', $cols);
        $insert = "INSERT INTO ".$table." (".$cols.") VALUES(".$valString.")";
        $insert = $db->prepare($insert);
        $insert->execute($values);
        if($insert)
        {
            return true;
        }
        return false;
    }

    public static function select($table, $data = [])
    {
        global $db;
        
        $columns = self::buildColumns($data, $table);  // Updated function
        $join = self::buildJoin($data);
        $where = self::buildWhere($data);
        $having = self::buildHaving($data);
        $select = self::buildSelect($data, $columns);
        $order = self::buildOrder($data);
        $limit = self::buildLimit($data);
    
        //$sql = $select . " FROM " . $table . $join . $where . $having . $order . $limit;
        $sql = $select . " FROM " . $table . $join . $where . self::buildGroupBy($data) . $having . $order . $limit;

     
        $stmt = $db->prepare($sql);

        $stmt->execute(self::buildValues($data));
    
        return self::fetchResults($stmt, $data);
    }
    
    private static function buildColumns($data, $table)
    {
        $columns = [];
    
        // Handle base table columns with alias support
        if (array_key_exists('columns', $data) && !empty($data['columns'])) 
        {
            foreach ($data['columns'] as $col) 
            {
                // Handle aliasing using 'as' and make sure both parts are properly trimmed
                if (stripos($col, ' as ') !== false) 
                {
                    $parts = preg_split('/\s+as\s+/i', $col);
                    $columns[] = $table . '.' . trim($parts[0]) . ' AS ' . trim($parts[1]);
                } 
                else 
                {
                    $columns[] = $table . '.' . trim($col);
                }
            }
        }
    
        // Handle join table columns with alias support
        if (array_key_exists('join', $data) && !empty($data['join'])) 
        {
            foreach ($data['join'] as $join) 
            {
                $joinTable = $join['table'];
                
                // Check if join columns are specified and handle them
                if (array_key_exists('columns', $join) && !empty($join['columns'])) 
                {
                    foreach ($join['columns'] as $col) 
                    {
                        if (stripos($col, ' as ') !== false) 
                        {
                            $parts = preg_split('/\s+as\s+/i', $col);
                            $columns[] = $joinTable . '.' . trim($parts[0]) . ' AS ' . trim($parts[1]);
                        } 
                        else 
                        {
                            $columns[] = $joinTable . '.' . trim($col);
                        }
                    }
                }
            }
        }
    
        // Fallback to '*' if no columns are defined in both base and join tables
        return !empty($columns) ? implode(', ', $columns) : '*';
    }
    
    
    private static function buildJoin($data)
    {
        $joinClause = '';

        if (array_key_exists('join', $data)) 
        {
            foreach ($data['join'] as $join) 
            {
                $joinTable = $join['table'];
                $joinColumns = $join['columns'];
                $joinType = $join['type'];
                $joinOn = array_key_exists('on', $join) ? ' ON ' . $join['on'] : '';

                $joinCols = count($joinColumns) > 0 ? ', ' . implode(', ', array_map(function($col) use ($joinTable) {
                    return $joinTable . '.' . trim($col);
                }, $joinColumns)) : '';

                $joinClause .= ' ' . $joinType . ' ' . $joinTable . $joinOn;
            }
        }
        return $joinClause;
    }


    private static function buildWhere($data)
    {
        $where = '';
        $values = [];
        
        // Handle 'whereIn' clause
        if (array_key_exists('whereIn', $data) && count($data['whereIn']) > 0) 
        {
            foreach ($data['whereIn'] as $column => $val) 
            {
                if (count($val) > 0) 
                {
                    $placeholders = implode(',', array_fill(0, count($val), '?'));
                    $where .= (empty($where) ? " WHERE " : " AND ") . $column . " IN ($placeholders)";
                    $values = array_merge($values, $val);
                }
            }
        }

        // Handle 'whereNotIn' clause
        if (array_key_exists('whereNotIn', $data) && count($data['whereNotIn']) > 0) {
            foreach ($data['whereNotIn'] as $column => $val) {
                if (count($val) > 0) {
                    $placeholders = implode(',', array_fill(0, count($val), '?'));
                    $where .= (empty($where) ? " WHERE " : " AND ") . $column . " NOT IN ($placeholders)";
                    $values = array_merge($values, $val);
                }
            }
        }

        if (array_key_exists('searchIn', $data) && count($data['searchIn']) > 0) 
        {
            $i = 0;
            // Start the condition with an open parenthesis.
            $where .= empty($where) ? " WHERE (" : " AND (";
            
            foreach ($data['searchIn'] as $key => $value) 
            {
                $con = ($i > 0) ? " OR " : "";  // Use OR for multiple conditions within the parentheses
                $where .= $con . $key . " LIKE ?";
                $values[] = "%$value%";  // Ensure wildcards are added for LIKE
                $i++;
            }
            $where .= ")";  // Close the parentheses for the searchIn OR conditions
        }
        
        if (array_key_exists('orWhereIn', $data) && count($data['orWhereIn']) > 0) 
        {
            // If $where is empty, start with WHERE, otherwise start with OR.
            $where .= empty($where) ? " WHERE " : " OR (";
            $i = 0;
        
            foreach ($data['orWhereIn'] as $column => $val) 
            {
                if (count($val) > 0) 
                {
                    $placeholders = implode(',', array_fill(0, count($val), '?'));
                    $where .= ($i > 0 ? " OR " : "") . $column . " IN ($placeholders)";
                    $values = array_merge($values, $val);
                    $i++;
                }
            }
            if (array_key_exists('searchIn', $data))
            {
                $where .= ")";  // Close the parentheses for the orWhereIn conditions
            }
        } 
       
        // Handle 'where' clause
        if (array_key_exists('where', $data) && count($data['where']) > 0) 
        {
            $where .= empty($where) ? " WHERE " : " AND ";
            $i = 0;
            foreach ($data['where'] as $key => $value) 
            {
                $con = ($i > 0) ? " AND " : "";
                if ($key == 'expression') 
                {
                    $where .= $con . $value;
                }
                elseif ($key == 'isnull') 
                {
                    $where .= $con . $value . " IS NULL";
                } 
                elseif ($key == 'isnotnull') 
                {
                    $where .= $con . $value . " IS NOT NULL";
                } 
                else 
                {
                    $where .= $con . $key . " = ?";
                    $values[] = $value;
                }
                $i++;
            }
        }

        // Handle other conditions: 'greaterThan', 'lessThan', 'greaterThanOrEqual', 'lessThanOrEqual', 'between', 'equalTo'
        $conditions = [
            'greaterThan' => ' > ',
            'lessThan' => ' < ',
            'greaterThanOrEqual' => ' >= ',
            'lessThanOrEqual' => ' <= ',
            'between' => ' BETWEEN ',
            'equalTo' => ' = '
        ];

        foreach ($conditions as $conditionKey => $operator) 
        {
            if (array_key_exists($conditionKey, $data) && count($data[$conditionKey]) > 0) 
            {
                foreach ($data[$conditionKey] as $column => $val) 
                {
                    $con = empty($where) ? " WHERE " : " AND ";
                    if ($conditionKey == 'between') 
                    {
                        $where .= $con . $column . " BETWEEN ? AND ?";
                        $values[] = $val[0];
                        $values[] = $val[1];
                    } 
                    else 
                    {
                        $where .= $con . $column . $operator . "?";
                        $values[] = $val;
                    }
                }
            }
        }

        // Handle 'orWhere' clause
        if (array_key_exists('orWhere', $data) && count($data['orWhere']) > 0) 
        {
            $where .= empty($where) ? " WHERE " : " AND (";
            $i = 0;
            foreach ($data['orWhere'] as $key => $value) 
            {
                $con = ($i > 0) ? " OR " : "";
                if (is_array($value) && in_array('expression', $value)) 
                {
                    $where .= $con . $value[1];
                } 
                else 
                {
                    $where .= $con . $key . " = ?";
                    $values[] = $value;
                }
                $i++;
            }
            $where .= ")";
        }

        // Handle 'search' clause
        if (array_key_exists('search', $data)) 
        {
            $i = 0;
            $where .= empty($where) ? " WHERE " : " AND ";
            foreach ($data['search'] as $key => $value) 
            {
                $con = ($i > 0) ? " OR " : "";
                $where .= $con . $key . " LIKE ?";
                $values[] = $value;
                $i++;
            }
        }
        
        // Handle 'findInSet' clause
        if (array_key_exists('findInSet', $data)) {
            foreach ($data['findInSet'] as $column => $values) 
            {
                $placeholders = implode(',', array_fill(0, count($values), '?'));
                $where .= (empty($where) ? " WHERE " : " AND ") . "FIND_IN_SET(" . $column . ", ?) > 0";
                $values[] = implode(',', $values);
            }
        }
        
        return $where;
    }

    private static function buildHaving($data)
    {
        if (array_key_exists('having', $data)) 
        {
            $having = " HAVING ";
            $i = 0;
            foreach ($data['having'] as $key => $value) 
            {
                $con = ($i > 0) ? " AND " : "";
                if ($key == 'expression') 
                {
                    $having .= $con . $value;
                } 
                else 
                {
                    $having .= $con . $key . " = ?";
                    $values[] = $value;
                }
                $i++;
            }
            return $having;
        }
        return '';
    }
    
    private static function buildSelect($data, $columns)
    {
        $selectParts = [];
        // Add aggregate functions if defined
        if (array_key_exists('sum', $data)) 
        {
            if (is_array($data['sum'])) 
            {
                foreach ($data['sum'] as $col => $alias) 
                {
                    $alias = is_string($alias) ? $alias : 'sum_' . $col;
                    $selectParts[] = "SUM(" . $col . ") AS " . $alias;
                }
            } 
            else 
            {
                $selectParts[] = "SUM(" . $data['sum'] . ") AS total";
            }
        }

        if (array_key_exists('count', $data)) 
        {
            if (is_array($data['count'])) 
            {
                foreach ($data['count'] as $col => $alias) 
                {
                    $alias = is_string($alias) ? $alias : 'count_' . $col;
                    $selectParts[] = "COUNT(" . $col . ") AS " . $alias;
                }
            } 
            else 
            {
                $selectParts[] = "COUNT(" . $data['count'] . ") AS total";
            }
        }

        if (array_key_exists('avg', $data)) 
        {
            if (is_array($data['avg'])) 
            {
                foreach ($data['avg'] as $col => $alias) {
                
                    $alias = is_string($alias) ? $alias : 'avg_' . $col;
                    $selectParts[] = "AVG(" . $col . ") AS " . $alias;
                }
            } 
            else 
            {
                $selectParts[] = "AVG(" . $data['avg'] . ") AS avg_value";
            }
        }

        // Add normal columns (if any were requested)
        if (!empty($columns) && $columns !== '*') 
        {
            $selectParts[] = $columns;
        }

        // If nothing provided, fallback to *
        if (empty($selectParts)) 
        {
            $selectParts[] = '*';
        }

        return "SELECT " . implode(', ', $selectParts);
    }


    private static function buildOrder($data)
    {
        return array_key_exists('order', $data) ? " ORDER BY " . $data['order'] : '';
    }

    private static function buildLimit($data)
    {
        $limit = '';
        if (array_key_exists('limit', $data)) 
        {
            $limit = " LIMIT " . $data['limit'];
        }
        
        if (array_key_exists('offset', $data)) 
        {
            $limit .= " OFFSET " . $data['offset'];
        }
        return $limit;
    }


    private static function buildValues($data)
    {
        $values = [];

        if (array_key_exists('whereIn', $data)) 
        {
            foreach ($data['whereIn'] as $val) 
            {
                $values = array_merge($values, $val);
            }
        }

        if (array_key_exists('whereNotIn', $data)) 
        {
            foreach ($data['whereNotIn'] as $val) 
            {
                $values = array_merge($values, $val);
            }
        }

        // Handle 'searchIn' conditions
        if (array_key_exists('searchIn', $data)) 
        {
            foreach ($data['searchIn'] as $value) 
            {
                $values[] = $value;
            }
        }

            // Handle 'orWhereIn' conditions
        if (array_key_exists('orWhereIn', $data)) 
        {
            foreach ($data['orWhereIn'] as $val) 
            {
                $values = array_merge($values, $val);
            }
        }

        if (array_key_exists('where', $data)) 
        {
            foreach ($data['where'] as $value) 
            {
                $values[] = $value;
            }
        }

        foreach (['greaterThan', 'lessThan', 'greaterThanOrEqual', 'lessThanOrEqual', 'between', 'equalTo'] as $conditionKey) 
        {
            if (array_key_exists($conditionKey, $data)) 
            {
                foreach ($data[$conditionKey] as $val) 
                {
                    if ($conditionKey == 'between') 
                    {
                        $values[] = $val[0];
                        $values[] = $val[1];
                    } 
                    else 
                    {
                        $values[] = $val;
                    }
                }
            }
        }
        if (array_key_exists('search', $data)) {
            foreach ($data['search'] as $value) {
                $values[] = $value;
            }
        }

        if (array_key_exists('findInSet', $data)) {
            foreach ($data['findInSet'] as $values) {
                $values[] = implode(',', $values);
            }
        }
        
        return $values;
    }

    private static function buildGroupBy($data)
    {
        if (array_key_exists('groupBy', $data) && !empty($data['groupBy'])) 
        {
            if (is_array($data['groupBy'])) 
            {
                return " GROUP BY " . implode(', ', array_map('trim', $data['groupBy']));
            } 
            else 
            {
                return " GROUP BY " . trim($data['groupBy']);
            }
        }
        return '';
    }

    private static function fetchResults($stmt, $data)
    {
        $returnType = isset($data['returnType']) ? $data['returnType'] : 'all';
        if ($returnType == 'row') 
        {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private static function xfetchResults($stmt, $data)
    {
        $rs = [];
        $returnType = isset($data['returnType']) ? $data['returnType'] : 'all';

        switch ($returnType) {
            case 'row':
                $rs = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($rs === false) {
                    $rs = [];
                }
                break;

            default:
                $rs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                break;
        }

        return $rs;
    }



    public static function update($table, $data, $where)
    {
        global $db;

        $datax = "";
        $values = [];
        if(count($data) > 0)
        {
            $i = 0; 
            foreach($data as $key => $value)
            {
                $comma = ($i > 0) ? ", " : "";
                $datax .= $comma . $key . " = ?";
                $i++;
            }
            $values = array_values($data);
        }

        $whre = "";
        if (count($where) > 0)
        { 
            $whre .= " WHERE ";
            $i = 0; 
            foreach($where as $key => $value)
            {
                $and = ($i > 0) ? " AND " : "";
                $whre .= $and . $key . " = ?";
                $i++;
            }
            $valuesx = array_values($where);
            $values = array_merge($values, $valuesx);
        }
        
        $update = "UPDATE ".$table." SET ".$datax . $whre;
        $update = $db->prepare($update);
        $update->execute($values);
        if ($update)
        {
            return true;
        }
        return false;
    }

    public static function delete($table, $where=[])
    {
        global $db;

        $values = [];
        $whre = "";
        if(count($where) > 0)
        { 
            $whre .= " WHERE ";
            $i = 0; 
            foreach($where as $key => $value)
            {
                $and = ($i > 0) ? " AND " : "";
                $whre .= $and . $key . " = ?";
                $i++;
            }
            $values = array_values($where);
        }
        $delete = "DELETE FROM ".$table . $whre;
        $delete = $db->prepare($delete);
        $delete->execute($values);
        if($delete)
        {
            return true;
        }
        return false;
    }

    public static function checkDuplicate($table, $field, $value, $id='', $checkDeleted=false)
    {
        $arWhere = [
            $field => $value
        ];
        if ($checkDeleted)
        {
            $arWhere['deleted'] = 0;
        }
        $rs = Crud::select(
            $table,
            [
                'columns' => ['id'],
                'where' => $arWhere
            ]
        );
        if ($rs)
        {
            if ($id != '')
            {
                if (strlen($rs['id']) == 36 && $rs['id'] == $id)
                {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public static function checkDuplicateByArray($table, $arWhere)
    {
        $rs = Crud::select(
            $table,
            [
                'columns' => ['id'],
                'where' => $arWhere
            ]
        );
        if ($rs)
        {
            return true;
        }
        return false;
    }
}