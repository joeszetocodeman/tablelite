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