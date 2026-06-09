<?php

$migrationsPath = 'database/migrations/';
$modelsPath = 'app/Models/';
$controllersPath = 'app/Http/Controllers/';

// MIGRATIONS
$migrations = [
    'create_categories_table.php' => '<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create("categories", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->string("color_tag")->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists("categories");
    }
};',

    'create_suppliers_table.php' => '<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create("suppliers", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("company_name")->nullable();
            $table->string("phone");
            $table->string("email")->nullable();
            $table->text("address")->nullable();
            $table->text("notes")->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists("suppliers");
    }
};',

    'create_medicines_table.php' => '<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create("medicines", function (Blueprint $table) {
            $table->id();
            $table->foreignId("category_id")->constrained()->onDelete("cascade");
            $table->foreignId("supplier_id")->nullable()->constrained()->onDelete("set null");
            $table->string("name");
            $table->string("generic_name")->nullable();
            $table->string("company")->nullable();
            $table->string("batch_number")->nullable();
            $table->string("barcode")->nullable();
            $table->decimal("purchase_price", 10, 2)->default(0);
            $table->decimal("sale_price", 10, 2)->default(0);
            $table->integer("stock_quantity")->default(0);
            $table->integer("low_stock_level")->default(10);
            $table->date("expiry_date")->nullable();
            $table->date("mfg_date")->nullable();
            $table->string("rack")->nullable();
            $table->boolean("requires_prescription")->default(false);
            $table->text("description")->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists("medicines");
    }
};',

    'create_customers_table.php' => '<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create("customers", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("phone");
            $table->string("email")->nullable();
            $table->integer("age")->nullable();
            $table->string("gender")->nullable();
            $table->text("address")->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists("customers");
    }
};',

    'create_sales_table.php' => '<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create("sales", function (Blueprint $table) {
            $table->id();
            $table->foreignId("customer_id")->nullable()->constrained()->onDelete("set null");
            $table->string("invoice_number")->unique();
            $table->integer("total_items");
            $table->decimal("subtotal", 10, 2);
            $table->decimal("discount_percent", 5, 2)->default(0);
            $table->decimal("tax_percent", 5, 2)->default(0);
            $table->decimal("grand_total", 10, 2);
            $table->decimal("paid_amount", 10, 2)->default(0);
            $table->decimal("due_amount", 10, 2)->default(0);
            $table->decimal("return_amount", 10, 2)->default(0);
            $table->string("payment_method")->default("cash");
            $table->text("notes")->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists("sales");
    }
};',

    'create_sale_items_table.php' => '<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create("sale_items", function (Blueprint $table) {
            $table->id();
            $table->foreignId("sale_id")->constrained()->onDelete("cascade");
            $table->foreignId("medicine_id")->constrained()->onDelete("cascade");
            $table->integer("quantity");
            $table->decimal("unit_price", 10, 2);
            $table->decimal("subtotal", 10, 2);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists("sale_items");
    }
};'
];

// Update migration files
foreach(scandir($migrationsPath) as $file) {
    if(strpos($file, '.php') !== false) {
        foreach($migrations as $key => $content) {
            if(strpos($file, $key) !== false) {
                file_put_contents($migrationsPath . $file, $content);
            }
        }
    }
}

// MODELS
$models = [
    'Category.php' => '<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Category extends Model {
    protected $guarded = [];
    public function medicines() { return $this->hasMany(Medicine::class); }
}',
    'Supplier.php' => '<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Supplier extends Model {
    protected $guarded = [];
    public function medicines() { return $this->hasMany(Medicine::class); }
}',
    'Medicine.php' => '<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Medicine extends Model {
    protected $guarded = [];
    public function category() { return $this->belongsTo(Category::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
}',
    'Customer.php' => '<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Customer extends Model {
    protected $guarded = [];
    public function sales() { return $this->hasMany(Sale::class); }
}',
    'Sale.php' => '<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Sale extends Model {
    protected $guarded = [];
    public function customer() { return $this->belongsTo(Customer::class); }
    public function items() { return $this->hasMany(SaleItem::class); }
}',
    'SaleItem.php' => '<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SaleItem extends Model {
    protected $guarded = [];
    public function sale() { return $this->belongsTo(Sale::class); }
    public function medicine() { return $this->belongsTo(Medicine::class); }
}'
];

foreach($models as $file => $content) {
    file_put_contents($modelsPath . $file, $content);
}

// ROUTES
$routesContent = "<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AlertController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

    Route::resource('categories', CategoryController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customers', CustomerController::class);
    
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/invoices', [SaleController::class, 'invoices'])->name('invoices.index');
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
});

require __DIR__.'/auth.php';
";
file_put_contents('routes/web.php', $routesContent);

echo "Backend scaffolding updated successfully!\n";
