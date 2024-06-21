### This package is in development stage, please do not use it in production

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

```php
$table->schema([
    TextColumn::make('id'),
    TextColumn::make('name'),
])
    ->getTableAllIdsUsing([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
    ->records([
        ['id' => 1, 'name' => 'John'],
        ['id' => 2, 'name' => 'Doe'],
    ]);

```

```php
$table->schema([
    TextColumn::make('id'),
    TextColumn::make('name'),
])
    ->records([
        ['id' => 1, 'name' => 'John'],
        ['id' => 2, 'name' => 'Doe'],
    ]);

```

### Actions

#### Action usage

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
            ->slideover('your.livewire.component', [
                'foo' => 'bar'
            ])
    ]);

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
