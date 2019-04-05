# phpCompiler
The basic PHP Compiler for Python Cpp Java C11 C 

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.
### Prerequisites
What things you need to install the software and how to install them
```shell
apt-get install g++
```
```shell
apt-get install gcc
```
```shell
apt-get install clang
```
```shell
apt-get install javac
```
```shell
apt-get install python
```
|  | Languages | Command |
| -- | -- | -- |
| 1 | C++       | ```apt-get install g++```    |
| 2 | C11       | ```apt-get install clang```  |
| 3 | C         | ```apt-get install gcc```    |
| 4 | Python    | ```apt-get install python``` |
| 5 | Java      | ```apt-get install javac```  |
### Installing
Main source code is located in ```src/phpCompiler.php```. For using this class in project you need to set up:
```php
require_once 'vendor/autoload.php';
```
and Create new class using ```eminmuhammadi\phpCompiler() ```
```php
$COMPILER = new eminmuhammadi\phpCompiler();
```
#### Declare variables
|  | Variable | Command |
| -- | -- | -- |
| 1 | ```command``` | root software |
| 2 | ```executable``` | runner |
| 3 | ```runFile``` | run file |
| 4 | ```time```| time for running |
| 5 | ```code```| main code |
| 6 | ```input```| input for code |
| 7 | ```fnCode```| code file name |
| 8 | ```fnInput```| input file name |
| 9 | ```fnError```| error file name |

```php
  $env = [
   'command'    => 'g++ -std=c++11',
   'executable' => 'a.out',
   'runFile'    => './a.out' , //out
   'time'       => '1', //seconds
   'code'       => $_POST['code'] ,
   'input'      => $_POST['input'],
   'fnCode'     => 'main.cpp',
   'fnInput'    => 'input.txt',
   'fnError'    => 'error.txt'
  ];
```

```time``` makes executation against to looping

#### Set time for executation (Attention)
```php
  $COMPILER->setTimeOut($time);
```
This rule make php file against to looping.

## Run & Create JSON Service
Collect all datas for compile procession.
```php
  $RESULT = $COMPILER->Run(
                 $env['command'],
                 $env['time'],
                 $env['executable'],
                 $env['runFile'],
                 $env['code'],
                 $env['input'],
                 $env['fnCode'],
                 $env['fnInput'],
                 $env['fnError']
               );
```               
That's all and we need to create application service a json type.
```php
  header('Content-Type: application/json');
  
  $data = [
    'code'       => $env['code'] ,
    'time_limit' => $time,
    'input'      => $env['input'],
    'result'     => $RESULT
  ];
  
  echo json_encode($data,JSON_PRETTY_PRINT);
```
JSON shows like :
```json
{
    "code": "      #include <iostream>\r\n      #include <string>\r\n      using namespace std;\r\n\r\n      int main()\r\n      {\r\n\r\n        cout <<\"Hello World\"<<endl;\r\n        return 0;\r\n      }\r\n      ",
    "time_limit": 1000,
    "input": "",
    "result": {
        "output": "Hello World\n",
        "time": "0.01",
        "error": "",
        "verdict": "AC"
    }
}
```
## Verdicts
|  | Verdict | Explain |
| -- | -- | -- |
| 1 | ```CE```  | Compilation Error |
| 2 | ```TLE``` | Time Limit Exceed |
| 3 | ```RTE``` | Run Time Error |
| 4 | ```AC```  | Accepted |

## Authors

* **Emin Muhammadi** - *Initial work* - [eminmuhammadi](https://github.com/eminmuhammadi)
See also the list of [contributors](https://github.com/eminmuhammadi/phpCompiler/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://paypal.me/eminmuhammadi)
