# DaData

DaData api в виде сервиса Laravel. Предоставляет документированные объекты, 
представляющие ответы DaData.

В текущей версии содержатся сервисы:

* [организация по ИНН или ОГРН](https://dadata.ru/api/find-party/)
* [стандартизация ФИО](https://dadata.ru/api/clean/name/)

Добавьте креды в `config/services.php`:

```php
'dadata' => [
    'token'  => env('DADATA_TOKEN'),
    'secret' => env('DADATA_SECRET'),
]
```

## Использование

Для использования сервиса внедрите класс `DaDataService` куда вам будет нужно.

### Поиск налогоплательщика

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

### Taxpayer атрибут

Объект `Taxpayer` можно кастовать в атрибут.

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
