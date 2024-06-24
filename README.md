### This package is in development stage, please do not use it in production

### install
```bash
composer require joe.szeto/tablelite
```

update your ```app.php```  file to include the service provider
```php
\Tablelite\TablesliteServiceProvider::class
```


### Usage

```php
use Tablelite\Table as TableAlias;

class SomeComponent extends Component  {
    use \Tablelite\InteractsWithTablelite;
    
    public function table( TableAlias $table ){
        $table->schema([
            TextColumn::make('id'),
            TextColumn::make('name'),
        ])->records([
            [ 'id' => 1, 'name' => 'John'],
            [ 'id' => 2, 'name' => 'Doe'],
        ]);
    }
}
```

in view

```bladehtml

<div>
    {{ $this->getTable() }}
</div>
```

#### Actions
```php
 $table->schema([
    TextColumn::make('id'),
    TextColumn::make('name'),
])
    ->records([
        ['id' => 1, 'name' => 'John'],
        ['id' => 2, 'name' => 'Doe'],
    ])->actions(fn(ActionFactory $actionFactory) => [
        $actionFactory->make('some_action')
            ->label('Action Label')
            ->action(function ($record) {
                // do something here
             })
    ]);

```

#### pagination
```php
$table->schema([
    TextColumn::make('id'),
    TextColumn::make('name'),
])
    ->records(
        function ($page) {
            // fetch api here
        }
    )
    ->paginateUsing(
        function ($records, PaginatorBuilder $builder) {
            // records is the response of the fetching
            return $builder
                ->items($records['data']) // the items
                ->total($records['total']) // total items
                ->perPage($records['per_page'])
                ->currentPage($records['current_page']);
        }
    );
```

### Development in local

#### clone the repository to your local machine

#### add this to your composer.json file

```json
"repositories": [
    {
        "type": "path",
        "url": "path/to/tablelite"
    }
]
```

make sure update the path to the correct path

#### run
```php
composer require joe.szeto/tablelite
```
