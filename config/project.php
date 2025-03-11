<?php

return [
    'welcome' => [
        'max_columns' => 2,
        'max_tasks_per_scope' => 10,
    ],
    'project' => [
        'view' => [
            'task_detail_type_id_for_code_snippet' => 3,
            'task_chunk_size' => 500,
            'task_paginate' => 15,
            'default' => [
                'max' => 30,
            ],
            'byscope' => [
                'max' => 0,
            ],
            'latest' => [
                'max' => 5,
            ],
            'latesttask' => [
                'max' => 1,
            ],
            'chronological' => [
                'max' => 0,
            ],
            'withalldetails' => [
                'max' => 0,
            ],
        ],
    ],
];
