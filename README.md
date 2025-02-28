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

### Search for taxpayer

Inject dependency `TaxpayerServiceContract` wherever you need:

```php
use Codewiser\Dadata\DaDataService;
use Illuminate\Http\Request;

public function index(Request $request, DaDataService $service)
{
    $taxpayer = $service->taxpayer($request->input('inn'))->first();
    
    // ....
    if ($taxpayer) {
        $organization->taxpayer = $taxpayer;
        $organization->save();
    }
}
```

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

Then you may access to the named attributes:

```php
/** @var \Codewiser\Dadata\Taxpayer\Taxpayer $taxpayer */
$taxpayer = $organization->taxpayer;

$taxpayer->type
```

