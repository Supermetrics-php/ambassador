
# Ambassador

This is php package which can handle log into different Databases


## Up And Running

Clone the project

***you need to ask for access***
```bash
  git clone git@github.com:Supermetrics-php/ambassador.git
```

Go to the project directory

```bash
  cd ambassador
```

Install dependencies

```bash
  composer install
```

available scripts

```bash
  composer fix
```
```bash
  composer analyze
```
```bash
  composer tests
```


## Usage

```php
require_once 'vendor/autoload.php';

use Supermetrics\Ambassador\Ambassador;

//$ambassador = new Ambassador('mysql');
//$ambassador = new Ambassador('file');
$ambassador = new Ambassador('redis');

var_dump($ambassador->persist('users', [
    ['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8', 'name' => 'farshid boroomand'],
    ['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d9', 'name' => 'james hetfield'],
    ['id' => '60bb0ca5-25d1-43bd-98e5-6a878c00a0a8', 'name' => 'freddie mercury'],
]));

var_dump($ambassador->fetchById('users', '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8'));
var_dump($ambassador->fetchAll('users'))
```


## Documentation

[Documentation and developer guide](https://first-collard-80e.notion.site/Supermetrics-Ambassador-63bbec671d9b4c0ca44f4a498a9eed9e)


## License

[MIT](https://choosealicense.com/licenses/mit/)

