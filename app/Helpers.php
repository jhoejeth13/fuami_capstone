<?php

if (!function_exists('professionalColor')) {
    function professionalColor($index) {
        $colors = [
            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
            '#858796', '#5a5c69', '#3a3b45', '#2e59d9', '#17a673',
            '#2c9faf', '#dda20a', '#be2617', '#6c757d', '#5a6268'
        ];
        return $colors[$index % count($colors)];
    }
}