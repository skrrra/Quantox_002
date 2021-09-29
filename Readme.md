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
mentor_id  | integer | ID of mentor that intern belongs to
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

#### URL
``` POST http://localhost/intern/create ```

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
mentor_id  | integer | ID of mentor this intern is associated with
group_id   | integer | ID of a group this intern belongs to
full_name  | string  | Full name of intern
city       | string  | Name of a city this intern is from

#### Return values

Parameter  | Type    | Description
-----------|---------|------------
mentor_id  | integer | ID of mentor that intern belongs to
group_id   | integer | ID of group that intern belongs to
full_name  | string  | Full name of intern
city       | string  | Name of the city intern is from

### Update existing intern

#### URL
``` PATCH http://localhost/intern/update/{id} ```

#### Required *ONE* parameter, rest is optional

Parameter  | Type    | Description
-----------|---------|------------
mentor_id  | integer | ID of mentor this intern is associated with
group_id   | integer | ID of a group this intern belongs to
full_name  | string  | Full name of intern
city       | string  | Name of a city this intern is from

#### Return updated values

### Delete existing intern

#### URL
``` DELETE http://localhost/intern/delete/{id} ```

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | ID of intern in database

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

#### URL
``` POST http://localhost/mentor/create ```

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
group_id   | integer | ID of a group this mentor belongs to
full_name  | string  | Full name of mentor

#### Return values

Parameter  | Type    | Description
-----------|---------|------------
group_id   | integer | ID of group that mentor belongs to
name       | string  | Name of created mentor

### Update existing mentor

#### URL
``` PATCH http://localhost/mentor/update/{id} ```

#### Required *ONE* parameter, rest is optional

Parameter  | Type    | Description
-----------|---------|------------
group_id   | integer | ID of a group this mentor belongs to
full_name  | string  | Full name of mentor

#### Return updated values

### Delete existing intern

#### URL
``` DELETE http://localhost/mentor/delete/{id} ```

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | ID of mentor in database

#### Return no values


## __Groups Endpoint__


### List all groups
Requires no parameters, returns list of groups in database.

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

#### URL
``` PATCH http://localhost/group/update/{id} ```

#### Required *ONE* parameter group name

Parameter  | Type    | Description
-----------|---------|------------
group_name | string  | Name of created group

#### Return updated values

### Delete existing group

#### URL
``` DELETE http://localhost/group/delete/{id} ```

#### Required query parameters

Parameter  | Type    | Description
-----------|---------|------------
id         | integer | ID of the group in database

#### Return no values

