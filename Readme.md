# Project setup:

``` 
    1. Clone repository localy
    2. Use composer to install all dependencies
    3. Setup database ( database dump file: quantox.sql *in root directory*)
    4. Seed database ( -> php DatabaseSeeder.php *file is located in root directory*)
    5. Read API documentation below
````

# Quantox API Documentation

## Response codes
HTTP Code | Meaning
----------|--------
200       | Endpoint returned successfully
400       | Missing query parameters
404       | Query did not found anything / bad route

## __Interns Endpoint__

### List all interns
Requires no parameters, returns list of interns in database.

#### URL
``` GET http://localhost/interns ```

#### Return values

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | Intern ID
mentor_id  | integer | ID of mentor that intern belongs to / could be multiple mentors
group_id   | integer | ID of group that intern belongs to
full_name  | string  | Full name of intern
city       | string  | Name of the city intern is from
group_name | string  | Name of a group intern belongs to

### Get one intern

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | Intern ID

#### URL
``` GET http://localhost/intern/{id} ```

#### Return same values as /interns endpoint

### Create intern

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
group_id   | integer | ID of a group this intern belongs to
full_name  | string  | Full name of intern
city       | string  | Name of a city this intern is from

#### URL
``` POST http://localhost/intern/create ```

#### Return values

Parameter  | Type    | Description
-----------|---------|------------
group_id   | integer | ID of group that intern belongs to
full_name  | string  | Full name of intern
city       | string  | Name of the city intern is from

### Update existing intern

#### Required *ONE* parameter, rest is optional

Parameter  | Type    | Description
-----------|---------|------------
group_id   | integer | ID of a group this intern belongs to
full_name  | string  | Full name of intern
city       | string  | Name of a city this intern is from

#### URL
``` PATCH http://localhost/intern/update/{id} ```

#### Return updated values

### Delete existing intern

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | ID of intern in database

#### URL
``` DELETE http://localhost/intern/delete/{id} ```

#### Return no values

## __Intern comments Endpoint__

### List comments for one intern

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | Intern ID

#### URL
``` GET http://localhost/interns-comments/{id} ```

#### Return values

Parameter  | Type    | Description
-----------|---------|------------
intern_name| string  | Name of intern who comment is about
mentor_name| string  | Full name of the mentor who wrote comment
mentor_id  | integer | ID of mentor
comment_id | integer | ID of comment
comment    | string  | Content of comment

### Create a comment about intern

#### Required parameters

Parameter  | Type    | Description
-----------|---------|------------
intern_id  | integer | Intern ID who is comment about
mentor_id  | integer | Mentor ID who is writting the comment
comment    | text    | Comment content

#### URL
``` POST http://localhost/interns-comments/create ```

#### Return values

Parameter  | Type    | Description
-----------|---------|------------
intern_id  | integer | Intern ID
mentor_id  | integer | Mentor ID
comment    | string  | Content of comment

### Update existing comment

#### Required *ONE* parameter, rest is optional (Comment ID must be provided in URL)

Parameter  | Type    | Description
-----------|---------|------------
intern_id  | integer | Intern ID who is comment about
mentor_id  | integer | Mentor ID who is writting the comment
comment    | text    | Comment content

#### URL
``` PATCH http://localhost/interns-comments/update/{id} ```

#### Return updated values

### Delete existing comment

#### Requires ID of comment in url

#### URL
``` DELETE http://localhost/interns-comments/delete/{id} ```

#### Return no values

## __Mentors Endpoint__

### List all mentors
Requires no parameters, returns list of mentors in database.

#### URL
``` GET http://localhost/mentors ```

#### Return values

Parameter  | Type    | Description
-----------|---------|------------
mentor_id  | integer | ID of mentor in database
mentor_name| string  | Full name of the mentor
group_id   | integer | ID of group that mentor belongs to
group_name | string  | Name of the group mentor belongs to

### Get one mentor

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | Mentor ID

#### URL
``` GET http://localhost/mentor/{id} ```

#### Return same values as /mentors endpoint

### Create mentor

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
group_id   | integer | ID of a group this mentor belongs to
full_name  | string  | Full name of mentor

#### URL
``` POST http://localhost/mentor/create ```

#### Return values

Parameter  | Type    | Description
-----------|---------|------------
group_id   | integer | ID of group that mentor belongs to
name       | string  | Name of created mentor

### Update existing mentor

#### Required *ONE* parameter, rest is optional

Parameter  | Type    | Description
-----------|---------|------------
group_id   | integer | ID of a group this mentor belongs to
full_name  | string  | Full name of mentor

#### URL
``` PATCH http://localhost/mentor/update/{id} ```

#### Return updated values

### Delete existing intern

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | ID of mentor in databaseg

#### URL
``` DELETE http://localhost/mentor/delete/{id} ```

#### Return no values


## __Groups Endpoint__


### List all groups
Requires no parameters, returns list of groups in database.

#### Pagination (optional) parameters

Parameter  | Type    | Description
-----------|---------|------------
per_page   | integer | Number of records you want to fetch from database
page       | integer | Pagination page you want to view

#### URL
``` GET http://localhost/groups ```

#### Return values

## Group
Parameter  | Type    | Description
-----------|---------|------------
id         | integer | ID of group
name       | string  | Name of group
## Mentors
Parameter  | Type    | Description
-----------|---------|------------
id         | integer | ID of group
group_id   | integer | ID of group that mentor belongs to
full_name  | string  | Name of mentor
## Interns
Parameter  | Type    | Description
-----------|---------|------------
id         | integer | ID of intern
mentor_id  | integer | ID of a mentor
group_id   | integer | ID of group that mentor belongs to
full_name  | string  | Name of mentor
city       | string  | Name of a city intern is from

### Get one group

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | Group ID

#### URL
``` GET http://localhost/group/{id} ```

#### Return values
Parameter  | Type    | Description
-----------|---------|------------
group_id   | integer | ID of intern
group_name | string  | Name of the group
mentor_id  | integer | ID of a mentor
mentor_name| string  | Name of the mentor 
intern_id  | integer | ID of intern
full_name  | string  | Name of intern
city       | string  | Name of a city intern is from

### Create group

#### URL
``` POST http://localhost/group/create ```

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
name       | string  | Name of a group

#### Return values

Parameter  | Type    | Description
-----------|---------|------------
group_name | string  | Name of created group

### Update existing group

#### Required *ONE* parameter group name

Parameter  | Type    | Description
-----------|---------|------------
group_name | string  | Name of created group

#### URL
``` PATCH http://localhost/group/update/{id} ```

#### Return updated values

### Delete existing group

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | ID of the group in database

#### URL
``` DELETE http://localhost/group/delete/{id} ```

#### Return no values

# Assignment 

``` User storry:
Quantox organizuje praksu pa im je potreban neki sistem za pracenje grupa, mentora i praktikanata. 
Zadatak:
Napraviti API endpointe za mentore, praktikante i grupe.
- Svaki endpoint mora da ima CRUD operacije. 
- Svaki endpoint vraca iskljucivo JSON response, koji dalje mozemo da koristimo u nekom FE frameworku ili nekoj slicnoj app
- Group endpoint treba da ima i listing pored gore navedenog CRUD-a, koji ce ispisati mentore i praktikante. Endpoint mora da 
    podrzava sortiranje, kao i da podrzava paginaciju.
- Mentor pripada jednoj grupi. U read endpointu prikazati i kojoj grupi pirpada.
- Praktikant pripada jednoj grupi. U read endpointu napisati kojoj grupi pripada.
- Grupa ima jednog ili vise mentora, i vise praktikanata. U read endpointu napisati ko su mentori i praktikanti koji joj pripadaju.
Requirements:
- Obavezan OOP pristup - namespaces, nasledjivanje, interfejs(i)/abstrakcija
- Za rad na zadatku mozete koristiti composer, pakete i njegov autoloader da loadujete vase klase
- Kod zadatka hostovati na github-u, i koristite glit flow prilikom izrade samog zadatka. Ne brisati branch-eve koje merdzujete 
    jer je bitno da se vidi proces izrade zadatka
- U zadatku je potrebno da napravite zaseban fajl koji sadrzi SQL upit/strukturu za kreiranje vase baze u testnom okruzenju, 
    kao i php skriptu koja ce da popuni tu bazu sa podacima. Za PHP skriptu mozete koristiti Faker biblioteku za generisanje fake 
    imena, prezimena, malova, idr.
- U zadaktu je obavezno da se pisu raw SQL upiti bez obzira da li planirate da koristite neki ORM ili ne
Bonus points:
- Koriscenje adekvatnih HTTP request metoda
- Koriscenje odgovarajucih HTTP response status kodova
- Koriscenje routing biblioteke ili pisanje svoje router biblioteke 
- Adekvatno handlovanje errora i exceptiona u kodu i prikaz istih u responsu sa odgovarajucim HTTP status kodom
Bonus zadatak:
- Dodati endpoint da mentor moze da upise komentar za praktikanta. Prilikom ispisa informacija za praktikanta, ispisati i komentare 
    koje je mentor uneo koji su sortirani hronoloski. Samo mentori njegove grupe u kojoj se praktikant nalazi mogu da upisuju komentare ```