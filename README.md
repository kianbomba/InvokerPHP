# *INVOKER*

Just an Utility Package that is helpful for your life's Project.

  
## Usage

Invoker is just a singleton that you can call it anywhere you want in your project without constructing it, as long as the package included
```php
    $email = "bomba@bolobala.com";
    $pass = Invoker::getInstance()->isEmail($email);
    
    if ($pass)
    {
        echo "It is a valid email " ;
    }
    else
    {
        echo "It is NOT a valid Email !!!" ;
    }
```

You just need to call it instance and use itself methods to perform things you would without rewriting the utility all over the time for every new projects.


## Download

```git
git clone https://github.com/kianbomba/InvokerPHP.git
```

```composer
composer require kianbomba/invoker
```

### Why Invoker ? 
It was because I Like DOTA 2 and this Utility Package has lots of pre-defined method just like the hero Invoker in Dota 2 
with lots of skils :D

![Invoker](https://i.redd.it/g8c6fr1uxg6x.png)