# sqlgen
A php sql generator.

## Usage

```php
	
	$sqlgen = new sqlgen();
	$sql = $sqlgen->setTable("users_table")->select("*")->where("username=:username AND password=:password")->get();

```