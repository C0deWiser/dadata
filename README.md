# DaData

Laravel package.

Brings `DaData` data types.

For now supported search for taxpayers only.

Add to `config/services.php`:

```php
'dadata' => [
    'token' => env('DADATA_TOKEN'),
    'secret' => env('DADATA_SECRET'),
]
```

## Usage

### Taxpayer attribute

You may store `taxpayer` object in a model attribute.

```php
use Codewiser\Dadata\Taxpayer\Casts\AsTaxpayer;
use Codewiser\Dadata\Taxpayer\Taxpayer;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property null|Taxpayer $taxpayer 
 */
class Organization extends Model
{
    protected $casts = [
        'taxpayer' => AsTaxpayer::class,    
    ];
}
```

### Search for taxpayer

Inject dependency `TaxpayerServiceContract` wherever you need:

```php
use Codewiser\Dadata\Taxpayer\Contracts\TaxpayerServiceContract;
use Illuminate\Http\Request;

public function index(Request $request, TaxpayerServiceContract $taxpayers)
{
    $taxpayer = $taxpayers->search($request->input('inn'))->first();
    
    // ....
    
    $organization->taxpayer = $taxpayer;
    $organization->save();
}
```

