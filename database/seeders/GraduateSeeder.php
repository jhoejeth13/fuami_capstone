<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Graduate;
use App\Models\Juniorhighschool;
use Carbon\Carbon;

class GraduateSeeder extends Seeder
{
    public function run()
    {
        // Filipino first names
        $firstNames = [
            'Maria', 'Juan', 'Jose', 'Pedro', 'Ana', 'Antonio', 'Manuel', 'Rosa', 'Francisco', 'Catalina',
            'Miguel', 'Isabel', 'Carlos', 'Carmen', 'Ramon', 'Teresa', 'Andres', 'Josefa', 'Pablo', 'Dolores',
            'Santiago', 'Concepcion', 'Felipe', 'Marcela', 'Gregorio', 'Francisca', 'Vicente', 'Margarita', 'Joaquin', 'Elena',
            'Fernando', 'Consuelo', 'Alfredo', 'Mercedes', 'Ricardo', 'Rosario', 'Eduardo', 'Beatriz', 'Alberto', 'Victoria',
            'Roberto', 'Lourdes', 'Enrique', 'Amparo', 'Jorge', 'Soledad', 'Arturo', 'Aurora', 'Rafael', 'Natividad'
        ];

        // Filipino middle names
        $middleNames = [
            'Santos', 'Reyes', 'Cruz', 'Bautista', 'Ocampo', 'Garcia', 'Mendoza', 'Torres', 'Andres', 'Dela Cruz',
            'Gonzales', 'Ramos', 'Aquino', 'Villanueva', 'Castillo', 'Fernandez', 'Rivera', 'Castro', 'Perez', 'Domingo',
            'Santiago', 'Lopez', 'Martinez', 'Sanchez', 'Romero', 'Flores', 'Morales', 'Gutierrez', 'Reyes', 'Diaz',
            'Vargas', 'Jimenez', 'Moreno', 'Herrera', 'Medina', 'Aguilar', 'Salazar', 'Guzman', 'Velasco', 'Molina',
            'Rojas', 'Ortega', 'Silva', 'Vega', 'Mendez', 'Carrillo', 'Ortiz', 'Delgado', 'Marquez', 'Leon'
        ];

        // Filipino last names
        $lastNames = [
            'Dela Cruz', 'Garcia', 'Reyes', 'Ramos', 'Mendoza', 'Santos', 'Flores', 'Gonzales', 'Bautista', 'Villanueva',
            'Fernandez', 'Cruz', 'Lopez', 'Martinez', 'Aquino', 'Castro', 'Perez', 'Romero', 'Domingo', 'Santiago',
            'Rivera', 'Torres', 'Andres', 'Ocampo', 'Castillo', 'Sanchez', 'Morales', 'Gutierrez', 'Diaz', 'Reyes',
            'Vargas', 'Jimenez', 'Moreno', 'Herrera', 'Medina', 'Aguilar', 'Salazar', 'Guzman', 'Velasco', 'Molina',
            'Rojas', 'Ortega', 'Silva', 'Vega', 'Mendez', 'Carrillo', 'Ortiz', 'Delgado', 'Marquez', 'Leon'
        ];

        // Magallanes, Agusan del Norte barangays
        $barangays = [
            'Poblacion', 'Caloc-an', 'Marcos', 'Taod-oy', 'Baliangao', 'Buhang', 'Calaitan', 'Guinabsan', 'Jagupit',
            'Mahayahay', 'Puting Balas', 'Santo Niño', 'Santo Rosario', 'Santo Tomas'
        ];

        // SHS strands
        $shsStrands = [
            'Science, Technology, Engineering, Mathematics(STEM)',
            'Accountancy, Business, and Management(ABM)',
            'Humanities and Social Sciences(HUMSS)',
            'General Academic Strand(GAS)',
            'ICT: Computer System Servicing',
            'HE: Food and Beverages Services, Bread and Pastry Production',
            'IA: Shielded Metal Arc Welding, Electrical Installation and Maintenance'
        ];

        // School years (2018-2024)
        $schoolYears = ['2018', '2019', '2020', '2021', '2022', '2023', '2024'];

        // Generate JHS students (150 records)
        for ($i = 0; $i < 150; $i++) {
            $gender = $i < 75 ? 'Male' : 'Female';
            $age = rand(15, 16);
            $birthdate = Carbon::now()->subYears($age)->subMonths(rand(0, 11))->subDays(rand(0, 30));
            
            // Generate 12-digit LRN number
            $lrn = str_pad(rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT);
            
            Juniorhighschool::create([
                'lrn_number' => $lrn,
                'first_name' => $firstNames[array_rand($firstNames)],
                'middle_name' => $middleNames[array_rand($middleNames)],
                'last_name' => $lastNames[array_rand($lastNames)],
                'gender' => $gender,
                'birthdate' => $birthdate,
                'address' => $barangays[array_rand($barangays)] . ', Magallanes, Agusan del Norte',
                'school_year' => $schoolYears[array_rand($schoolYears)]
            ]);
        }

        // Generate SHS graduates (150 records)
        for ($i = 0; $i < 150; $i++) {
            $gender = $i < 75 ? 'Male' : 'Female';
            $age = rand(17, 19);
            $birthdate = Carbon::now()->subYears($age)->subMonths(rand(0, 11))->subDays(rand(0, 30));
            
            // Generate 12-digit LRN number
            $lrn = str_pad(rand(100000000000, 999999999999), 12, '0', STR_PAD_LEFT);
            
            Graduate::create([
                'ID_student' => $lrn,
                'first_name' => $firstNames[array_rand($firstNames)],
                'middle_name' => $middleNames[array_rand($middleNames)],
                'last_name' => $lastNames[array_rand($lastNames)],
                'gender' => $gender,
                'birthdate' => $birthdate,
                'year_graduated' => $schoolYears[array_rand($schoolYears)],
                'strand' => $shsStrands[array_rand($shsStrands)],
                'address' => $barangays[array_rand($barangays)] . ', Magallanes, Agusan del Norte'
            ]);
        }
    }
} 