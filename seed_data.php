<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;

try {
    DB::beginTransaction();

    $categories = [
        ['name' => 'Pain Relievers', 'description' => 'Medications for pain relief.'],
        ['name' => 'Antibiotics', 'description' => 'Medications that destroy or slow down the growth of bacteria.'],
        ['name' => 'Vitamins & Supplements', 'description' => 'Dietary supplements and daily vitamins.'],
        ['name' => 'Cold & Flu', 'description' => 'Remedies for common cold and flu symptoms.'],
        ['name' => 'Digestive Health', 'description' => 'Antacids, laxatives, and other digestive aids.'],
        ['name' => 'First Aid', 'description' => 'Bandages, antiseptics, and emergency wound care.'],
        ['name' => 'Allergy & Asthma', 'description' => 'Antihistamines and inhalers.'],
        ['name' => 'Skin Care', 'description' => 'Ointments, creams, and dermatological products.'],
        ['name' => 'Cardiovascular', 'description' => 'Blood pressure and heart medications.'],
        ['name' => 'Diabetes Care', 'description' => 'Insulin, test strips, and glucose management.']
    ];

    $catIds = [];
    foreach ($categories as $cat) {
        $c = Category::create($cat);
        $catIds[] = $c->id;
    }

    $medicines = [
        // Pain Relievers
        ['name' => 'Paracetamol 500mg', 'generic_name' => 'Acetaminophen', 'price' => 5.00, 'cat' => 0],
        ['name' => 'Ibuprofen 400mg', 'generic_name' => 'Ibuprofen', 'price' => 8.50, 'cat' => 0],
        ['name' => 'Aspirin 81mg', 'generic_name' => 'Acetylsalicylic acid', 'price' => 4.00, 'cat' => 0],
        ['name' => 'Naproxen 250mg', 'generic_name' => 'Naproxen Sodium', 'price' => 12.00, 'cat' => 0],
        ['name' => 'Diclofenac Gel', 'generic_name' => 'Diclofenac', 'price' => 15.00, 'cat' => 0],

        // Antibiotics
        ['name' => 'Amoxicillin 250mg', 'generic_name' => 'Amoxicillin', 'price' => 18.00, 'cat' => 1],
        ['name' => 'Azithromycin 500mg', 'generic_name' => 'Azithromycin', 'price' => 25.00, 'cat' => 1],
        ['name' => 'Ciprofloxacin 500mg', 'generic_name' => 'Ciprofloxacin', 'price' => 22.50, 'cat' => 1],
        ['name' => 'Doxycycline 100mg', 'generic_name' => 'Doxycycline', 'price' => 14.00, 'cat' => 1],
        ['name' => 'Cephalexin 500mg', 'generic_name' => 'Cephalexin', 'price' => 20.00, 'cat' => 1],

        // Vitamins & Supplements
        ['name' => 'Vitamin C 1000mg', 'generic_name' => 'Ascorbic Acid', 'price' => 10.00, 'cat' => 2],
        ['name' => 'Vitamin D3 5000 IU', 'generic_name' => 'Cholecalciferol', 'price' => 12.50, 'cat' => 2],
        ['name' => 'Multivitamin Once Daily', 'generic_name' => 'Multivitamin', 'price' => 28.00, 'cat' => 2],
        ['name' => 'Omega-3 Fish Oil', 'generic_name' => 'Omega-3 Fatty Acids', 'price' => 24.00, 'cat' => 2],
        ['name' => 'Calcium + D3', 'generic_name' => 'Calcium Carbonate', 'price' => 16.00, 'cat' => 2],

        // Cold & Flu
        ['name' => 'DayQuil Cold & Flu', 'generic_name' => 'Acetaminophen, Dextromethorphan', 'price' => 14.00, 'cat' => 3],
        ['name' => 'NyQuil Severe', 'generic_name' => 'Acetaminophen, Doxylamine', 'price' => 15.00, 'cat' => 3],
        ['name' => 'Sudafed PE', 'generic_name' => 'Phenylephrine', 'price' => 9.50, 'cat' => 3],
        ['name' => 'Robitussin DM', 'generic_name' => 'Guaifenesin, Dextromethorphan', 'price' => 11.00, 'cat' => 3],
        ['name' => 'Theraflu Nighttime', 'generic_name' => 'Acetaminophen, Diphenhydramine', 'price' => 13.00, 'cat' => 3],

        // Digestive Health
        ['name' => 'Tums Extra Strength', 'generic_name' => 'Calcium Carbonate', 'price' => 6.00, 'cat' => 4],
        ['name' => 'Omeprazole 20mg', 'generic_name' => 'Omeprazole', 'price' => 22.00, 'cat' => 4],
        ['name' => 'Pepto-Bismol', 'generic_name' => 'Bismuth Subsalicylate', 'price' => 8.00, 'cat' => 4],
        ['name' => 'Imodium A-D', 'generic_name' => 'Loperamide', 'price' => 10.50, 'cat' => 4],
        ['name' => 'Dulcolax Laxative', 'generic_name' => 'Bisacodyl', 'price' => 9.00, 'cat' => 4],

        // First Aid
        ['name' => 'Band-Aid Pack (100s)', 'generic_name' => 'Adhesive Bandages', 'price' => 5.50, 'cat' => 5],
        ['name' => 'Neosporin Ointment', 'generic_name' => 'Bacitracin, Neomycin', 'price' => 8.50, 'cat' => 5],
        ['name' => 'Hydrogen Peroxide 3%', 'generic_name' => 'Hydrogen Peroxide', 'price' => 3.00, 'cat' => 5],
        ['name' => 'Rubbing Alcohol 70%', 'generic_name' => 'Isopropyl Alcohol', 'price' => 4.50, 'cat' => 5],
        ['name' => 'Gauze Pads 4x4', 'generic_name' => 'Sterile Gauze', 'price' => 6.00, 'cat' => 5],

        // Allergy & Asthma
        ['name' => 'Claritin 24hr', 'generic_name' => 'Loratadine', 'price' => 19.00, 'cat' => 6],
        ['name' => 'Zyrtec Allergy', 'generic_name' => 'Cetirizine', 'price' => 21.00, 'cat' => 6],
        ['name' => 'Benadryl 25mg', 'generic_name' => 'Diphenhydramine', 'price' => 7.50, 'cat' => 6],
        ['name' => 'Flonase Nasal Spray', 'generic_name' => 'Fluticasone Propionate', 'price' => 26.00, 'cat' => 6],
        ['name' => 'Albuterol Inhaler', 'generic_name' => 'Albuterol Sulfate', 'price' => 45.00, 'cat' => 6],

        // Skin Care
        ['name' => 'Hydrocortisone 1%', 'generic_name' => 'Hydrocortisone', 'price' => 6.50, 'cat' => 7],
        ['name' => 'CeraVe Moisturizer', 'generic_name' => 'Ceramides', 'price' => 18.00, 'cat' => 7],
        ['name' => 'Acne Free BP 5%', 'generic_name' => 'Benzoyl Peroxide', 'price' => 12.00, 'cat' => 7],
        ['name' => 'Calamine Lotion', 'generic_name' => 'Calamine', 'price' => 5.00, 'cat' => 7],
        ['name' => 'Ketoconazole Cream', 'generic_name' => 'Ketoconazole', 'price' => 14.50, 'cat' => 7],

        // Cardiovascular
        ['name' => 'Lisinopril 10mg', 'generic_name' => 'Lisinopril', 'price' => 16.00, 'cat' => 8],
        ['name' => 'Amlodipine 5mg', 'generic_name' => 'Amlodipine Besylate', 'price' => 15.00, 'cat' => 8],
        ['name' => 'Atorvastatin 20mg', 'generic_name' => 'Atorvastatin', 'price' => 20.00, 'cat' => 8],
        ['name' => 'Losartan 50mg', 'generic_name' => 'Losartan Potassium', 'price' => 18.50, 'cat' => 8],
        ['name' => 'Metoprolol 25mg', 'generic_name' => 'Metoprolol Tartrate', 'price' => 17.00, 'cat' => 8],

        // Diabetes Care
        ['name' => 'Metformin 500mg', 'generic_name' => 'Metformin HCl', 'price' => 11.00, 'cat' => 9],
        ['name' => 'Glipizide 5mg', 'generic_name' => 'Glipizide', 'price' => 13.00, 'cat' => 9],
        ['name' => 'Insulin Glargine', 'generic_name' => 'Insulin Glargine', 'price' => 120.00, 'cat' => 9],
        ['name' => 'Glucose Test Strips (50)', 'generic_name' => 'Test Strips', 'price' => 35.00, 'cat' => 9],
        ['name' => 'Lancets 30G (100)', 'generic_name' => 'Lancets', 'price' => 9.00, 'cat' => 9],
    ];

    foreach ($medicines as $med) {
        Medicine::create([
            'category_id' => $catIds[$med['cat']],
            'supplier_id' => 1, // Assuming at least 1 supplier exists. Otherwise nullable? 
            'name' => $med['name'],
            'generic_name' => $med['generic_name'],
            'purchase_price' => $med['price'] * 0.7,
            'sale_price' => $med['price'],
            'stock_quantity' => rand(50, 500),
            'low_stock_level' => 20,
            'expiry_date' => date('Y-m-d', strtotime('+'.rand(12, 36).' months')),
            'mfg_date' => date('Y-m-d', strtotime('-'.rand(1, 12).' months'))
        ]);
    }

    DB::commit();
    echo "Successfully inserted 10 categories and 50 medicines!\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "ERROR: " . $e->getMessage() . "\n";
}
