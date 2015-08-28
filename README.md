# _Shoe Stores_

##### _Allows users to add stores and the brands they carry, 8-28-2015_

#### By _**Jeff Austin**_

## Description

_This application allows users to add stores and add the brands that the stores carry. User can also edit and delete stores, delete brands associated with a specific store. No edit functionality on brands._

## Setup

* _This set up is for Mac_
* _Clone this repo to your computer_
* _Download [MAMP](https://www.mamp.info/en/) in order to run a local apache server and work with MySQL_
* _Once MAMP is installed, open MAMP and click start servers_

#### Database Setup

* _In your terminal follow the below commands to set up your database_

```
$ /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot;

$ CREATE DATABASE shoes;

$ USE shoes;

$ CREATE TABLE stores (name varchar (255), id serial PRIMARY KEY);

$ CREATE TABLE brands (name varchar (255), id serial PRIMARY KEY);

$ CREATE TABLE stores_brands (store_id int, brand_id int, id serial PRIMARY KEY);

```

* _Install [composer](https://getcomposer.org/)_
* _Run composer install from the root folder of this clone in your terminal_
* _Navigate to the web folder in the terminal_
* _Run php -S localhost:8000_
* _Enter http://localhost:8000 in your browser and enjoy!_

## Technologies Used

_PHP, Silex, Twig, PHP Unit, MAMP (Apache, MySQL)_

### Legal

Copyright (c) 2015 **_Jeff Austin_**

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.