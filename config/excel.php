<?php
return [
    'exports' => ['chunk_size' => 1000,'pre_calculate_formulas' => false,'strict_null_comparison' => false],
    'imports' => ['read_only' => true,'ignore_empty' => false,'heading_row' => ['formatter' => 'slug']],
    'extension_detector' => [
        'xlsx' => \Maatwebsite\Excel\Excel::XLSX,
        'xlsm' => \Maatwebsite\Excel\Excel::XLSX,
        'xls'  => \Maatwebsite\Excel\Excel::XLS,
        'csv'  => \Maatwebsite\Excel\Excel::CSV,
        'tsv'  => \Maatwebsite\Excel\Excel::TSV,
    ],
    'value_binder' => ['default' => \Maatwebsite\Excel\DefaultValueBinder::class],
    'cache' => ['driver' => 'memory'],
    'transactions' => ['handler' => 'db'],
    'temporary_files' => ['local_path' => sys_get_temp_dir()],
];
