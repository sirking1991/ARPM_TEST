<?php
$employees = [
    ['name' => 'John', 'city' => 'Dallas'],
    ['name' => 'Jane', 'city' => 'Austin'],
    ['name' => 'Jake', 'city' => 'Dallas'],
    ['name' => 'Jill', 'city' => 'Dallas'],
];

$offices = [
    ['office' => 'Dallas HQ', 'city' => 'Dallas'],
    ['office' => 'Dallas South', 'city' => 'Dallas'],
    ['office' => 'Austin Branch', 'city' => 'Austin'],
];

$output = [
    "Dallas" => [
        "Dallas HQ" => ["John", "Jake", "Jill"],
        "Dallas South" => ["John", "Jake", "Jill"],
    ],
    "Austin" => [
        "Austin Branch" => ["Jane"],
    ],
];

// write elegant code using collections to generate the $output array. 
$output = collect($employees)
    ->groupBy('city')
    ->map(function ($cityEmployees, $city) use ($offices) {
        $cityOffices = collect($offices)
            ->where('city', $city)
            ->pluck('office');

        return $cityOffices->mapWithKeys(function ($office) use ($cityEmployees) {
            return [
                $office => $cityEmployees->pluck('name')->values()->all()
            ];
        })->all();
    })
    ->all();

