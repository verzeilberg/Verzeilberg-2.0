<?php

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'datetime_functions' => [
                    'date' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'time' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'timestamp' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'convert_tz' => 'Oro\ORM\Query\AST\Functions\DateTime\ConvertTz',
                ],
                'numeric_functions' => [
                    'timestampdiff' => 'Oro\ORM\Query\AST\Functions\Numeric\TimestampDiff',
                    'dayofyear' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'dayofmonth' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'dayofweek' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'week' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'day' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'hour' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'minute' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'month' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'quarter' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'second' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'year' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'sign' => 'Oro\ORM\Query\AST\Functions\Numeric\Sign',
                    'pow' => 'Oro\ORM\Query\AST\Functions\Numeric\Pow',
                    'round' => 'Oro\ORM\Query\AST\Functions\Numeric\Round',
                ],
                'string_functions' => [
                    'md5' => 'Oro\ORM\Query\AST\Functions\SimpleFunction',
                    'group_concat' => 'Oro\ORM\Query\AST\Functions\String\GroupConcat',
                    'cast' => 'Oro\ORM\Query\AST\Functions\Cast',
                    'concat_ws' => 'Oro\ORM\Query\AST\Functions\String\ConcatWs',
                    'replace' => 'Oro\ORM\Query\AST\Functions\String\Replace',
                    'date_format' => 'Oro\ORM\Query\AST\Functions\String\DateFormat'
                ]
            ]
        ]
    ]
];